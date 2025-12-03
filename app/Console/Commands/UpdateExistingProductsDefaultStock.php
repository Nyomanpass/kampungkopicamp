<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Availability;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateExistingProductsDefaultStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-default-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing products with default stock values based on their current availability';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update existing products with default stock values...');

        try {
            DB::beginTransaction();

            $products = Product::all();
            $updatedCount = 0;

            $progressBar = $this->output->createProgressBar($products->count());
            $progressBar->start();

            foreach ($products as $product) {
                // Get most common non-overridden availability values
                $avgAvailability = Availability::where('product_id', $product->id)
                    ->where('is_overridden', false)
                    ->selectRaw('ROUND(AVG(available_unit)) as avg_units, ROUND(AVG(available_seat)) as avg_seats')
                    ->first();

                if ($product->type === 'touring') {
                    $defaultSeats = $avgAvailability->avg_seats ?? 20;
                    $product->update([
                        'default_seats' => $defaultSeats,
                        'default_units' => 0,
                    ]);
                } else {
                    $defaultUnits = $avgAvailability->avg_units ?? 10;
                    $product->update([
                        'default_units' => $defaultUnits,
                        'default_seats' => 0,
                    ]);
                }

                $updatedCount++;
                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine(2);

            DB::commit();

            $this->info("Successfully updated {$updatedCount} products with default stock values!");
            $this->table(
                ['Product Type', 'Default Units', 'Default Seats'],
                [
                    ['accommodation', '10 (avg)', '0'],
                    ['area_rental', '10 (avg)', '0'],
                    ['touring', '0', '20 (avg)'],
                ]
            );

            Log::info('Products default stock update completed', [
                'updated_count' => $updatedCount,
            ]);

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            Log::error('Products default stock update failed: ' . $e->getMessage());
            return 1;
        }
    }
}
