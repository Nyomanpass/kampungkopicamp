<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Availability;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
class Availabilities extends Component
{
    // ===== VIEW STATE =====
    public $currentMonth;
    public $currentYear;
    public $calendarDates = [];

    // ===== FILTERS =====
    public $selectedProductId = '';
    public $selectedProductType = '';
    public $statusFilter = '';

    // ===== MODALS =====
    public $showDateModal = false;
    public $showBulkModal = false;
    public $showHistoryModal = false;

    // ===== DATE EDIT MODAL =====
    public $selectedDate;
    public $dateAvailabilities = [];
    public $editingAvailability = [];

    // ===== BULK OVERRIDE MODAL =====
    public $bulkStartDate;
    public $bulkEndDate;
    public $bulkProductId;
    public $bulkUnits;
    public $bulkSeats;
    public $bulkReason;
    public $bulkAction = 'set'; // set, increase, decrease, block, unblock

    // ===== STATISTICS =====
    public $stats = [
        'total_products' => 0,
        'available_dates' => 0,
        'low_stock_dates' => 0,
        'fully_booked_dates' => 0,
        'overridden_dates' => 0,
    ];

    // ===== LIFECYCLE HOOKS =====
    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->generateCalendar();
        $this->loadStatistics();
    }

    // ===== CALENDAR GENERATION =====
    public function generateCalendar()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // Start from Sunday of the first week
        $startDate = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);

        // End on Saturday of the last week
        $endDate = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $this->calendarDates = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $weekDates = [];

            for ($i = 0; $i < 7; $i++) {
                $dateString = $current->format('Y-m-d');

                // Get availability summary for this date
                $summary = $this->getDateAvailabilitySummary($current);

                $weekDates[] = [
                    'date' => $current->copy(),
                    'day' => $current->day,
                    'is_current_month' => $current->month == $this->currentMonth,
                    'is_today' => $current->isToday(),
                    'is_past' => $current->isPast() && !$current->isToday(),
                    'summary' => $summary,
                ];

                $current->addDay();
            }

            $this->calendarDates[] = $weekDates;
        }
    }

    // ===== GET DATE AVAILABILITY SUMMARY =====
    private function getDateAvailabilitySummary($date)
    {
        // ✅ Use forDate scope instead of whereDate
        $query = Availability::forDate($date->format('Y-m-d'));

        // Apply product filter
        if ($this->selectedProductId) {
            $query->where('product_id', $this->selectedProductId);
        } elseif ($this->selectedProductType) {
            $query->whereHas('product', function ($q) {
                $q->where('type', $this->selectedProductType);
            });
        }

        $availabilities = $query->with('product')->get();

        if ($availabilities->isEmpty()) {
            return [
                'status' => 'no-data',
                'color' => 'gray',
                'label' => 'No Data',
                'products' => [],
            ];
        }

        $statusCounts = [
            'available' => 0,
            'low' => 0,
            'full' => 0,
            'blocked' => 0,
            'overridden' => 0,
        ];

        $products = [];

        foreach ($availabilities as $availability) {
            // Determine status
            if ($availability->is_overridden && ($availability->available_unit == 0 && $availability->available_seat == 0)) {
                $status = 'blocked';
            } elseif ($availability->isFullyBooked()) {
                $status = 'full';
            } elseif ($availability->isLowStock()) {
                $status = 'low';
            } else {
                $status = 'available';
            }

            if ($availability->is_overridden) {
                $statusCounts['overridden']++;
            }

            $statusCounts[$status]++;

            $products[] = [
                'id' => $availability->product->id,
                'name' => $availability->product->name,
                'type' => $availability->product->type,
                'status' => $status,
                'available_unit' => $availability->available_unit,
                'available_seat' => $availability->available_seat,
                'is_overridden' => $availability->is_overridden,
                'percentage' => $availability->getStockPercentage(),
            ];
        }

        // Determine overall status (priority: blocked > full > low > available)
        if ($statusCounts['blocked'] > 0) {
            $overallStatus = 'blocked';
            $color = 'gray';
            $label = 'Blocked';
        } elseif ($statusCounts['full'] > 0) {
            $overallStatus = 'full';
            $color = 'red';
            $label = 'Full';
        } elseif ($statusCounts['low'] > 0) {
            $overallStatus = 'low';
            $color = 'yellow';
            $label = 'Low Stock';
        } else {
            $overallStatus = 'available';
            $color = 'green';
            $label = 'Available';
        }

        return [
            'status' => $overallStatus,
            'color' => $color,
            'label' => $label,
            'products' => $products,
            'counts' => $statusCounts,
        ];
    }

    // ===== NAVIGATION =====
    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->generateCalendar();
    }

    public function goToToday()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->generateCalendar();
    }

    // ===== FILTERS =====
    public function updatedSelectedProductId()
    {
        $this->generateCalendar();
        $this->loadStatistics();
    }

    public function updatedSelectedProductType()
    {
        $this->selectedProductId = ''; // Reset specific product when type changes
        $this->generateCalendar();
        $this->loadStatistics();
    }

    public function updatedStatusFilter()
    {
        $this->generateCalendar();
    }

    // ===== LOAD STATISTICS =====
    private function loadStatistics()
    {
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();

        // ✅ Use dateBetween scope
        $query = Availability::dateBetween($startOfMonth, $endOfMonth);

        if ($this->selectedProductId) {
            $query->where('product_id', $this->selectedProductId);
        } elseif ($this->selectedProductType) {
            $query->whereHas('product', function ($q) {
                $q->where('type', $this->selectedProductType);
            });
        }

        $availabilities = $query->with('product')->get();

        $this->stats = [
            'total_products' => $this->selectedProductId
                ? 1
                : ($this->selectedProductType
                    ? Product::where('type', $this->selectedProductType)->count()
                    : Product::count()),
            'available_dates' => $availabilities->filter(fn($a) => !$a->isFullyBooked() && !$a->isLowStock())->count(),
            'low_stock_dates' => $availabilities->filter(fn($a) => $a->isLowStock())->count(),
            'fully_booked_dates' => $availabilities->filter(fn($a) => $a->isFullyBooked())->count(),
            'overridden_dates' => $availabilities->where('is_overridden', true)->count(),
        ];
    }

    // ===== OPEN DATE MODAL =====
    public function openDateModal($dateString)
    {
        $this->selectedDate = $dateString;

        // ✅ Use forDate scope
        $query = Availability::forDate($dateString)
            ->with(['product', 'overriddenByUser']);

        if ($this->selectedProductId) {
            $query->where('product_id', $this->selectedProductId);
        } elseif ($this->selectedProductType) {
            $query->whereHas('product', function ($q) {
                $q->where('type', $this->selectedProductType);
            });
        }

        $this->dateAvailabilities = $query->get()->toArray();

        // Initialize editing array
        $this->editingAvailability = [];
        foreach ($this->dateAvailabilities as $avail) {
            $this->editingAvailability[$avail['id']] = [
                'available_unit' => $avail['available_unit'],
                'available_seat' => $avail['available_seat'],
                'is_overridden' => $avail['is_overridden'],
                'override_reason' => $avail['override_reason'] ?? '',
            ];
        }

        // dd($this->editingAvailability);

        $this->showDateModal = true;
    }

    // ===== SAVE DATE CHANGES =====
    public function saveDateChanges()
    {
        try {
            DB::beginTransaction();

            foreach ($this->editingAvailability as $availId => $data) {
                $availability = Availability::find($availId);

                if (!$availability) continue;

                // Check if values changed
                $hasChanged = $availability->available_unit != $data['available_unit']
                    || $availability->available_seat != $data['available_seat'];

                if ($hasChanged) {
                    $availability->update([
                        'available_unit' => $data['available_unit'],
                        'available_seat' => $data['available_seat'],
                        'is_overridden' => true,
                        'override_reason' => $data['override_reason'],
                        'overridden_by' => Auth::id(),
                        'overridden_at' => now(),
                    ]);

                    Log::info("Availability updated manually", [
                        'availability_id' => $availId,
                        'product_id' => $availability->product_id,
                        'date' => $availability->date,
                        'new_units' => $data['available_unit'],
                        'new_seats' => $data['available_seat'],
                    ]);
                }
            }

            DB::commit();

            session()->flash('success', 'Availability updated successfully!');
            $this->showDateModal = false;
            $this->generateCalendar();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update availability: ' . $e->getMessage());
            session()->flash('error', 'Failed to update availability: ' . $e->getMessage());
        }
    }

    // ===== RESET OVERRIDE =====
    public function resetOverride($availId)
    {
        try {
            $availability = Availability::find($availId);

            if ($availability) {
                $availability->resetOverride();

                session()->flash('success', 'Override reset successfully!');
                $this->openDateModal($this->selectedDate); // Refresh modal data
                $this->generateCalendar();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reset override.');
        }
    }

    // ===== OPEN BULK MODAL =====
    public function openBulkModal()
    {
        $this->reset([
            'bulkStartDate',
            'bulkEndDate',
            'bulkProductId',
            'bulkUnits',
            'bulkSeats',
            'bulkReason',
            'bulkAction',
        ]);

        $this->bulkStartDate = Carbon::today()->format('Y-m-d');
        $this->bulkEndDate = Carbon::today()->addDays(7)->format('Y-m-d');
        $this->bulkAction = 'set';

        $this->showBulkModal = true;
    }

    // ===== APPLY BULK OVERRIDE =====
    public function applyBulkOverride()
    {
        // Basic validation
        $rules = [
            'bulkStartDate' => 'required|date|after_or_equal:today',
            'bulkEndDate' => 'required|date|after_or_equal:bulkStartDate',
            'bulkProductId' => 'required|exists:products,id',
            'bulkAction' => 'required|in:set,increase,decrease,block,unblock',
            'bulkReason' => 'nullable|string|max:255',
        ];

        // Conditional validation for values
        if (in_array($this->bulkAction, ['set', 'increase', 'decrease'])) {
            $product = Product::find($this->bulkProductId);

            if ($product && $product->type === 'touring') {
                $rules['bulkSeats'] = 'required|integer|min:1';
            } else {
                $rules['bulkUnits'] = 'required|integer|min:1';
            }
        }

        $this->validate($rules, [
            'bulkSeats.required' => 'Number of seats is required for touring products',
            'bulkUnits.required' => 'Number of units is required for accommodation/area rental',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($this->bulkProductId);
            $startDate = Carbon::parse($this->bulkStartDate);
            $endDate = Carbon::parse($this->bulkEndDate);
            $current = $startDate->copy();

            $affectedCount = 0;
            $createdCount = 0;
            $updatedCount = 0;

            while ($current->lte($endDate)) {
                // ✅ FIX: Use proper date format for query
                $dateString = $current->format('Y-m-d');

                // ✅ Find existing availability with proper date query
                $availability = Availability::where('product_id', $product->id)
                    ->whereDate('date', $dateString)
                    ->first();

                // ✅ Create if not exists
                if (!$availability) {
                    $availability = Availability::create([
                        'product_id' => $product->id,
                        'date' => $dateString, // Model mutator will handle normalization
                        'available_unit' => $product->type === 'touring' ? 0 : 10,
                        'available_seat' => $product->type === 'touring' ? 20 : 0,
                        'is_overridden' => false,
                    ]);
                    $createdCount++;
                } else {
                    $updatedCount++;
                }

                // ✅ Apply action based on type
                $updateData = [];

                switch ($this->bulkAction) {
                    case 'set':
                        if ($product->type === 'touring') {
                            $updateData = [
                                'available_seat' => $this->bulkSeats,
                                'available_unit' => 0, // Ensure unit is 0 for touring
                                'is_overridden' => true,
                                'override_reason' => $this->bulkReason,
                                'overridden_by' => Auth::id(),
                                'overridden_at' => now(),
                            ];
                        } else {
                            $updateData = [
                                'available_unit' => $this->bulkUnits,
                                'available_seat' => 0, // Ensure seat is 0 for non-touring
                                'is_overridden' => true,
                                'override_reason' => $this->bulkReason,
                                'overridden_by' => Auth::id(),
                                'overridden_at' => now(),
                            ];
                        }
                        break;

                    case 'increase':
                        if ($product->type === 'touring') {
                            $updateData = [
                                'available_seat' => $availability->available_seat + $this->bulkSeats,
                                'is_overridden' => true,
                                'override_reason' => $this->bulkReason,
                                'overridden_by' => Auth::id(),
                                'overridden_at' => now(),
                            ];
                        } else {
                            $updateData = [
                                'available_unit' => $availability->available_unit + $this->bulkUnits,
                                'is_overridden' => true,
                                'override_reason' => $this->bulkReason,
                                'overridden_by' => Auth::id(),
                                'overridden_at' => now(),
                            ];
                        }
                        break;

                    case 'decrease':
                        if ($product->type === 'touring') {
                            $updateData = [
                                'available_seat' => max(0, $availability->available_seat - $this->bulkSeats),
                                'is_overridden' => true,
                                'override_reason' => $this->bulkReason,
                                'overridden_by' => Auth::id(),
                                'overridden_at' => now(),
                            ];
                        } else {
                            $updateData = [
                                'available_unit' => max(0, $availability->available_unit - $this->bulkUnits),
                                'is_overridden' => true,
                                'override_reason' => $this->bulkReason,
                                'overridden_by' => Auth::id(),
                                'overridden_at' => now(),
                            ];
                        }
                        break;

                    case 'block':
                        $updateData = [
                            'available_unit' => 0,
                            'available_seat' => 0,
                            'is_overridden' => true,
                            'override_reason' => $this->bulkReason ?: 'Blocked for maintenance',
                            'overridden_by' => Auth::id(),
                            'overridden_at' => now(),
                        ];
                        break;

                    case 'unblock':
                        // Reset to default values
                        $updateData = [
                            'available_unit' => $product->type === 'touring' ? 0 : 10,
                            'available_seat' => $product->type === 'touring' ? 20 : 0,
                            'is_overridden' => false,
                            'override_reason' => null,
                            'overridden_by' => null,
                            'overridden_at' => null,
                        ];
                        break;
                }

                // ✅ Update availability
                $availability->update($updateData);
                $affectedCount++;

                $current->addDay();
            }

            DB::commit();

            Log::info("Bulk availability override applied", [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'action' => $this->bulkAction,
                'date_range' => $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'),
                'total_days' => $affectedCount,
                'created' => $createdCount,
                'updated' => $updatedCount,
                'values' => [
                    'units' => $this->bulkUnits,
                    'seats' => $this->bulkSeats,
                ],
            ]);

            $message = "Bulk override applied successfully! ";
            $message .= "Affected {$affectedCount} days";
            if ($createdCount > 0 || $updatedCount > 0) {
                $message .= " ({$createdCount} created, {$updatedCount} updated)";
            }

            session()->flash('success', $message);
            $this->showBulkModal = false;
            $this->reset(['bulkStartDate', 'bulkEndDate', 'bulkProductId', 'bulkUnits', 'bulkSeats', 'bulkReason', 'bulkAction']);
            $this->generateCalendar();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to apply bulk override: ' . $e->getMessage());
            session()->flash('error', 'Failed to apply bulk override: ' . $e->getMessage());
        }
    }

    // ===== RENDER =====
    public function render()
    {
        $products = Product::where('is_active', true)->get();

        return view('livewire.admin.availabilities', [
            'products' => $products,
        ]);
    }
}
