<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateProductAvailability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'availability:generate 
                            {--months=2 : Number of months to generate}
                            {--product= : Specific product ID}
                            {--force : Force regenerate existing dates}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Generate availability for products for the next X months';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $months = (int) $this->option('months');
        $productId = $this->option('product');
        $force = $this->option('force');

        $this->info("Starting availability generation for next {$months} months...");

        try {
            DB::beginTransaction();

            // Get products
            $products = $productId
                ? Product::where('id', $productId)->where('is_active', true)->get()
                : Product::where('is_active', true)->get();

            if ($products->isEmpty()) {
                $this->error('No active products found.');
                return 1;
            }

            $startDate = Carbon::today();
            $endDate = Carbon::today()->addMonths($months);

            $totalGenerated = 0;
            $totalSkipped = 0;

            $progressBar = $this->output->createProgressBar($products->count());
            $progressBar->start();

            foreach ($products as $product) {
                $result = $this->generateForProduct($product, $startDate, $endDate, $force);
                $totalGenerated += $result['generated'];
                $totalSkipped += $result['skipped'];

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine(2);

            DB::commit();

            $this->info("Availability generation completed!");
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Products Processed', $products->count()],
                    ['Records Generated', $totalGenerated],
                    ['Records Skipped', $totalSkipped],
                    ['Date Range', $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d')],
                ]
            );

            Log::info('Availability generation completed', [
                'products' => $products->count(),
                'generated' => $totalGenerated,
                'skipped' => $totalSkipped,
            ]);

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            Log::error('Availability generation failed: ' . $e->getMessage());
            return 1;
        }
    }

    private function generateForProduct(Product $product, Carbon $startDate, Carbon $endDate, bool $force = false)
    {
        $generated = 0;
        $skipped = 0;

        // ✅ Get default stock values from product settings
        $defaultUnits = $product->default_units ?? ($product->type === 'touring' ? 0 : 10);
        $defaultSeats = $product->default_seats ?? ($product->type === 'touring' ? 20 : 0);

        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dateString = $current->format('Y-m-d');

            $exists = Availability::where('product_id', $product->id)
                ->whereDate('date', $dateString)
                ->exists();

            if ($exists && !$force) {
                $skipped++;
            } else {
                if ($exists && $force) {
                    $availability = Availability::where('product_id', $product->id)
                        ->whereDate('date', $dateString)
                        ->where('is_overridden', false)
                        ->first();

                    if ($availability) {
                        $availability->update([
                            'available_unit' => $defaultUnits,
                            'available_seat' => $defaultSeats,
                        ]);
                        $generated++;
                    } else {
                        $skipped++;
                    }
                } else {
                    Availability::create([
                        'product_id' => $product->id,
                        'date' => $dateString . ' 00:00:00',
                        'available_unit' => $defaultUnits,
                        'available_seat' => $defaultSeats,
                        'is_overridden' => false,
                    ]);
                    $generated++;
                }
            }

            $current->addDay();
        }

        return [
            'generated' => $generated,
            'skipped' => $skipped,
        ];
    }
}
