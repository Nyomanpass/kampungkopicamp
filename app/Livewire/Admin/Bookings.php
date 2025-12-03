<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Addon;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Availability;
use App\Models\BookingItem;
use App\Models\BookingAddon;
use App\Services\VoucherService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCompleted;
use App\Mail\BookingRefunded;

class Bookings extends Component
{
    use WithPagination;

    public $viewMode = 'list';

    public $search = '';
    public $statusFilter = '';
    public $productTypeFilter = '';
    public $startDate = '';
    public $endDate = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    //modals
    public $showStatusModal = false;
    public $showAddonsModal = false;
    public $showDeleteModal = false;

    //selected booking
    public $selectedBookingId = null;
    public $selectedBooking = null;

    // ============================================
    // CREATE MANUAL BOOKING
    // ============================================
    //customer
    public $customerName = '';
    public $customerPhone = '';
    public $customerEmail = '';
    public $linkToUser = false;
    public $linkedUserId = null;

    //booking
    public $productType = 'accommodation';
    public $productId = null;
    public $checkInDate = '';
    public $checkOutDate = '';
    public $peopleCount = 1;
    public $unitCount = 0;
    public $nightCount = 1;

    //addons
    public $selectedAddons = [];
    public $addonsTotal = 0;

    //pricing
    public $productPrice = 0;
    public $subtotal = 0;
    public $discountAmount = 0;
    public $totalPrice = 0;

    //Voucher
    public $voucherCode = '';
    public $appliedVoucher = null;

    //payment
    public $paymentMethod = 'cash';
    public $paymentStatus = 'paid';
    public $amountReceived = 0;
    public $paymentDate = '';
    public $paymentNotes = '';

    // other
    public $specialRequests = '';
    public $stockAvailable = true;
    public $stockMessage = '';

    // ============================================
    // CHANGE STATUS
    // ============================================
    public $newStatus = '';
    public $statusNotes = '';

    // ============================================
    // EDIT ADDONS
    // ============================================
    public $editableAddons = [];
    public $newAddons = [];
    public $addonNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'productTypeFilter' => ['except' => ''],
    ];

    //cancel & refund
    public $showCancelModal = false;
    public $showRefundModal = false;
    public $cancelReason = '';
    public $refundAmount = 0;
    public $refundReason = '';
    public $refundType = 'full';

    // no-show status
    public $showNoShowModal = false;
    public $noShowNotes = '';


    // ============================================
    // Others properties
    // ============================================

    // pay now
    public $showPayNowModal = false;
    public $payNowMethod = 'cash';
    public $payNowAmount = 0;
    public $payNowNotes = '';

    // pay addon
    public $showPayAddonModal = false;
    public $payAddonMethod = 'cash';
    public $payAddonAmount = 0;
    public $payAddonNotes = '';

    // ============================================
    // LIFECYCLE HOOKS
    // ============================================

    public function mount()
    {
        $this->paymentDate = Carbon::now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // ============================================
    // VIEW MODE SWITCHERS
    // ============================================

    public function switchToList()
    {
        $this->viewMode = 'list';
        $this->resetCreateForm();
    }

    public function switchToCreate()
    {
        $this->viewMode = 'create';
        $this->resetCreateForm();
    }

    public function switchToDetail($bookingId)
    {
        $this->selectedBookingId = $bookingId;

        $this->selectedBooking = Booking::with([
            'items' => function ($query) {
                $query->with(['product', 'addon']); // Load both relations
            },
            'payments',
            'user',
            'voucher'
        ])->findOrFail($bookingId);

        $this->viewMode = 'detail';
    }

    // ============================================
    // FILTERS
    // ============================================

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'productTypeFilter', 'startDate', 'endDate']);
        $this->resetPage();
    }

    // ============================================
    // CREATE MANUAL BOOKING METHODS
    // ============================================

    public function updatedProductType()
    {
        $this->reset(['productId', 'productPrice', 'unitCount']);
        $this->checkStock();
    }

    public function updatedProductId()
    {
        $this->calculateUnits();
        $this->calculatePrice();
        $this->checkStock();
    }

    public function updatedCheckInDate()
    {
        $this->calculateNights();
        $this->calculatePrice();
        $this->checkStock();
    }

    public function updatedCheckOutDate()
    {
        $this->calculateNights();
        $this->calculatePrice();
        $this->checkStock();
    }
    public function updatedPeopleCount()
    {
        $this->calculateUnits();
        $this->calculatePrice();
        $this->checkStock();
    }

    private function calculateNights()
    {
        if ($this->checkInDate && $this->checkOutDate) {
            $start = Carbon::parse($this->checkInDate);
            $end = Carbon::parse($this->checkOutDate);
            $this->nightCount = $start->diffInDays($end);
        }
    }

    private function calculateUnits()
    {
        if (!$this->productId || !$this->peopleCount) {
            $this->unitCount = 0;
            return;
        }

        $product = Product::find($this->productId);

        if (!$product) {
            $this->unitCount = 0;
            return;
        }

        if ($product->type === 'touring') {
            // Touring doesn't need unit calculation, use seat instead
            $this->unitCount = 0;
        } elseif ($product->type === 'accommodation' || $product->type === 'area_rental') {
            // ✅ Calculate required units based on capacity
            if ($product->capacity_per_unit && $product->capacity_per_unit > 0) {
                $this->unitCount = (int) ceil($this->peopleCount / $product->capacity_per_unit);
            } else {
                // Default to 1 unit if no capacity set
                $this->unitCount = 1;
            }
        } else {
            $this->unitCount = 1;
        }
    }

    private function calculatePrice()
    {
        if (!$this->productId || !$this->checkInDate || !$this->checkOutDate) {
            return;
        }

        $product = Product::find($this->productId);
        if (!$product) {
            return;
        }

        $start = Carbon::parse($this->checkInDate);
        $end = Carbon::parse($this->checkOutDate);

        $this->productPrice = $product->calculatePrice($start, $end, $this->unitCount ?: 1);
        $this->calculateTotals();
    }

    public function calculateAddonsTotal()
    {
        $this->addonsTotal = 0;

        foreach ($this->selectedAddons as $addonId => $data) {
            $addon = Addon::find($addonId);
            if ($addon) {
                $subtotal = $addon->calculatePrice(
                    $data['qty'] ?? 1,
                    $this->nightCount,
                    $this->peopleCount,
                    $data['hours'] ?? 0,
                    $data['slots'] ?? 0
                );
                $this->addonsTotal += $subtotal;
            }
        }

        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $this->subtotal = $this->productPrice + $this->addonsTotal;
        $this->totalPrice = $this->subtotal - $this->discountAmount;
        $this->amountReceived = $this->totalPrice;
    }

    private function checkStock()
    {

        $this->stockAvailable = true;
        $this->stockMessage = '';

        if (!$this->productId || !$this->checkInDate || !$this->checkOutDate) {
            $this->stockMessage = '';
            return;
        }

        $product = Product::find($this->productId);
        if (!$product) {
            $this->stockAvailable = false;
            $this->stockMessage = "Product tidak ditemukan";
            return;
        }

        try {
            $start = Carbon::parse($this->checkInDate);
            $end = Carbon::parse($this->checkOutDate);

            // Build date range (exclude end date for accommodation, include for touring)
            $dateRange = [];
            $current = $start->copy();

            if ($product->type === 'touring') {
                // For touring, check only start date
                $dateRange[] = $start->format('Y-m-d');
            } else {
                // For accommodation, check all nights (start to end - 1)
                while ($current->lt($end)) {
                    $dateRange[] = $current->format('Y-m-d');
                    $current->addDay();
                }
            }

            if (empty($dateRange)) {
                $this->stockAvailable = false;
                $this->stockMessage = "Tanggal tidak valid";
                return;
            }

            // Get availabilities for date range
            $availabilities = Availability::where('product_id', $this->productId)
                ->whereIn(DB::raw('DATE(date)'), $dateRange) // ✅ Compare only date part
                ->get()
                ->keyBy(function ($item) {
                    return Carbon::parse($item->date)->format('Y-m-d'); // ✅ Format ke Y-m-d untuk key
                }); // Key by date for easier lookup

            // Check each date
            foreach ($dateRange as $date) {
                $avail = $availabilities->get($date);

                // Check if availability exists
                if (!$avail) {
                    $this->stockAvailable = false;
                    $this->stockMessage = "Tidak ada data availability untuk tanggal " . Carbon::parse($date)->format('d M Y');
                    return;
                }

                // Check stock based on product type
                if ($product->type === 'touring') {
                    $required = $this->peopleCount;
                    $available = $avail->available_seat;

                    if ($available < $required) {
                        $this->stockAvailable = false;
                        $this->stockMessage = "Stock tidak cukup pada " . Carbon::parse($date)->format('d M Y') . ". Tersedia: {$available} seat(s), Dibutuhkan: {$required}";
                        return;
                    }
                } else {
                    // For accommodation & area_rental
                    $required = $this->unitCount ?: 1;
                    $available = $avail->available_unit;

                    if ($available < $required) {
                        $this->stockAvailable = false;
                        $this->stockMessage = "Stock tidak cukup pada " . Carbon::parse($date)->format('d M Y') . ". Tersedia: {$available} unit(s), Dibutuhkan: {$required}";
                        return;
                    }
                }
            }

            // All checks passed
            $this->stockAvailable = true;
            $this->stockMessage = "Stock tersedia untuk semua tanggal";
        } catch (\Exception $e) {
            Log::error('Stock check error: ' . $e->getMessage());
            $this->stockAvailable = false;
            $this->stockMessage = "Error checking stock: " . $e->getMessage();
        }
    }

    public function addAddon($addonId)
    {
        if (!isset($this->selectedAddons[$addonId])) {
            $this->selectedAddons[$addonId] = [
                'qty' => 1,
                'hours' => 0,
                'slots' => 0,
            ];
        }
        $this->calculateAddonsTotal();
    }

    public function removeAddon($addonId)
    {
        unset($this->selectedAddons[$addonId]);
        $this->calculateAddonsTotal();
    }

    public function updateAddonQty($addonId, $action)
    {
        if ($action === 'increment') {
            $this->selectedAddons[$addonId]['qty']++;
        } elseif ($action === 'decrement' && $this->selectedAddons[$addonId]['qty'] > 1) {
            $this->selectedAddons[$addonId]['qty']--;
        }
        $this->calculateAddonsTotal();
    }

    public function applyVoucher()
    {
        if (empty($this->voucherCode)) {
            session()->flash('error', 'Masukkan kode voucher.');
            return;
        }

        $voucherService = new VoucherService();
        $result = $voucherService->validateVoucher(
            $this->voucherCode,
            $this->linkedUserId,
            $this->subtotal
        );

        if (!$result['valid']) {
            session()->flash('error', $result['message']);
            return;
        }

        $this->appliedVoucher = $result['voucher'];
        $this->discountAmount = $result['discount'];
        $this->calculateTotals();

        session()->flash('success', 'Voucher berhasil diterapkan!');
    }

    public function createBooking()
    {
        $this->validate([
            'customerName' => 'required|string|min:3|max:255',
            'customerPhone' => 'required|string|max:20',
            'customerEmail' => 'nullable|email|max:255',
            'productId' => 'required|exists:products,id',
            'checkInDate' => 'required|date|after_or_equal:today',
            'checkOutDate' => 'required|date|after:checkInDate',
            'peopleCount' => 'required|integer|min:1',
            'paymentMethod' => 'required|in:cash,transfer,edc,qris',
            'paymentStatus' => 'required|in:paid,pending_payment',
            'amountReceived' => 'required_if:paymentStatus,paid|numeric|min:0',
        ]);

        if (!$this->stockAvailable) {
            session()->flash('error', 'Stock tidak tersedia untuk tanggal yang dipilih.');
            return;
        }

        try {
            DB::beginTransaction();

            // Generate walk-in token
            $latestWalkIn = Booking::where('booking_token', 'like', 'BK-WALK%')
                ->orderByRaw('CAST(SUBSTRING(booking_token, 8) AS UNSIGNED) DESC')
                ->first();

            if ($latestWalkIn) {
                // Extract numeric part after "BK-WALK"
                $lastNumber = (int) substr($latestWalkIn->booking_token, 7);
                $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '000001';
            }

            $bookingToken = 'BK-WALK' . $newNumber;

            // Create booking
            $booking = Booking::create([
                'booking_token' => $bookingToken,
                'user_id' => $this->linkedUserId,
                'product_type' => $this->productType,
                'start_date' => $this->checkInDate,
                'end_date' => $this->checkOutDate,
                'people_count' => $this->peopleCount,
                'unit_count' => $this->unitCount,
                'seat_count' => $this->productType === 'touring' ? $this->peopleCount : null,
                'subtotal' => $this->subtotal,
                'discount_total' => $this->discountAmount,
                'total_price' => $this->totalPrice,
                'status' => $this->paymentStatus === 'paid' ? 'paid' : 'pending_payment',
                'booking_source' => 'walk-in',
                'payment_method' => $this->paymentMethod,
                'payment_notes' => $this->paymentNotes,
                'customer_name' => $this->customerName,
                'customer_email' => $this->customerEmail,
                'customer_phone' => $this->customerPhone,
                'special_requests' => $this->specialRequests,
            ]);

            $product = Product::find($this->productId);
            BookingItem::create([
                'booking_id' => $booking->id,
                'product_id' => $product->id,
                'addon_id' => null,
                'item_type' => 'product', // ✅ Set type
                'name_snapshot' => $product->name,
                'pricing_type_snapshot' => $product->pricing_type,
                'qty' => $this->unitCount ?: 1,
                'unit_price' => $this->productPrice / ($this->unitCount ?: 1),
                'subtotal' => $this->productPrice,
                'notes' => json_encode([
                    'nights' => $this->nightCount,
                    'people' => $this->peopleCount,
                ]),
            ]);

            foreach ($this->selectedAddons as $addonId => $data) {
                $addon = Addon::find($addonId);
                if ($addon) {
                    $addonSubtotal = $addon->calculatePrice(
                        $data['qty'],
                        $this->nightCount,
                        $this->peopleCount,
                        $data['hours'] ?? 0,
                        $data['slots'] ?? 0
                    );

                    BookingItem::create([
                        'booking_id' => $booking->id,
                        'product_id' => null,
                        'addon_id' => $addon->id,
                        'item_type' => 'addon',
                        'name_snapshot' => $addon->name,
                        'pricing_type_snapshot' => $addon->pricing_type,
                        'qty' => $data['qty'],
                        'unit_price' => $addon->price,
                        'subtotal' => $addonSubtotal,
                        'notes' => json_encode([
                            'hours' => $data['hours'] ?? 0,
                            'slots' => $data['slots'] ?? 0,
                            'nights' => $this->nightCount,
                            'people' => $this->peopleCount,
                        ]),
                    ]);
                }
            }

            // create invoice
            $invoice = \App\Models\Invoice::create([
                'booking_id' => $booking->id,
                'parent_invoice_id' => null,
                'type' => 'primary',
                'amount' => $this->totalPrice,
                'status' => $this->paymentStatus === 'paid' ? 'paid' : 'pending',

            ]);

            foreach ($booking->items as $bookingItem) {
                \App\Models\InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'booking_item_id' => $bookingItem->id,
                    'name' => $bookingItem->name_snapshot,
                    'qty' => $bookingItem->qty,
                    'unit_price' => $bookingItem->unit_price,
                    'subtotal' => $bookingItem->subtotal,
                    'meta' => [
                        'item_type' => $bookingItem->item_type,
                        'product_id' => $bookingItem->product_id,
                        'addon_id' => $bookingItem->addon_id,
                        'pricing_type' => $bookingItem->pricing_type_snapshot,
                    ],
                ]);
            };

            $orderIdLatest = \App\Models\Payment::where('order_id', 'like', 'ORD-WALK%')
                ->orderBy('order_id', 'desc')
                ->first();

            if ($orderIdLatest) {
                $lastOrderNumber = (int) substr($orderIdLatest->order_id, 9);
                $newOrderNumber = str_pad($lastOrderNumber + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newOrderNumber = '00001';
            }

            $orderId = 'ORD-WALK' . $newOrderNumber;

            $payment = \App\Models\Payment::create([
                'booking_id' => $booking->id,
                'provider' => $this->paymentStatus === 'paid' ? $this->paymentMethod : 'cash',
                'order_id' => $orderId,
                'payment_code_or_url' => null,
                'amount' => $this->totalPrice,
                'status' => $this->paymentStatus === 'paid' ? 'settlement' : 'pending', // 
                'expired_at' => null,
                'paid_at' => $this->paymentStatus === 'paid' ? now() : null,
                'raw_payload' => json_encode([
                    'payment_method' => $this->paymentMethod,
                    'amount_received' => $this->paymentStatus === 'paid' ? $this->amountReceived : 0,
                    'payment_date' => $this->paymentStatus === 'paid' ? $this->paymentDate : null,
                    'notes' => $this->paymentNotes,
                    'source' => 'walk-in',
                    'created_by' => Auth::user()->name ?? 'Admin',
                ]),
            ]);

            // Hold availability
            $this->holdAvailability($booking);

            // Apply voucher
            if ($this->appliedVoucher && $this->linkedUserId) {
                $voucherService = new VoucherService();
                $voucherService->applyVoucher($booking, $this->appliedVoucher, $this->linkedUserId);
            }

            DB::commit();

            session()->flash('success', 'Booking berhasil dibuat dengan token: ' . $bookingToken);

            $this->switchToDetail($booking->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create manual booking: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuat booking: ' . $e->getMessage());
        }
    }

    private function holdAvailability($booking)
    {
        $start = Carbon::parse($booking->start_date);
        $end = Carbon::parse($booking->end_date);

        for ($date = $start->copy(); $date->lt($end); $date->addDay()) {
            $availability = Availability::where('product_id', $this->productId)
                ->where('date', $date->format('Y-m-d'))
                ->first();

            if ($availability) {
                if ($booking->product_type === 'touring') {
                    $availability->decrement('available_seat', $booking->seat_count);
                } else {
                    $availability->decrement('available_unit', $booking->unit_count);
                }
            }
        }
    }

    private function resetCreateForm()
    {
        $this->reset([
            'customerName',
            'customerPhone',
            'customerEmail',
            'linkToUser',
            'linkedUserId',
            'productType',
            'productId',
            'checkInDate',
            'checkOutDate',
            'peopleCount',
            'unitCount',
            'nightCount',
            'selectedAddons',
            'addonsTotal',
            'productPrice',
            'subtotal',
            'discountAmount',
            'totalPrice',
            'voucherCode',
            'appliedVoucher',
            'paymentMethod',
            'paymentStatus',
            'amountReceived',
            'paymentNotes',
            'specialRequests',
            'stockAvailable',
            'stockMessage'
        ]);
        $this->paymentDate = now()->format('Y-m-d');
    }

    // ============================================
    // COMPUTED PROPERTIES
    // ============================================
    public function getStatsProperty()
    {
        return [
            'total' => Booking::count(),
            'revenue' => Booking::whereIn('status', ['paid', 'checked_in', 'completed'])->sum('total_price'),
            'pending' => Booking::where('status', 'pending_payment')->count(),
            'paid' => Booking::where('status', 'paid')->count(),
            'checkin_today' => Booking::where('status', 'checked_in')
                ->whereDate('start_date', today())
                ->count(),
            'completed_today' => Booking::where('status', 'completed')
                ->whereDate('end_date', today())
                ->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];
    }

    public function openStatusModal()
    {
        $this->showStatusModal = true;
        $this->newStatus = '';
        $this->statusNotes = '';
    }

    public function updateStatus()
    {
        if (empty($this->newStatus)) {
            session()->flash('error', 'Please select a status.');
            return;
        }

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($this->selectedBookingId);
            $oldStatus = $booking->status;

            // Update status
            $booking->update([
                'status' => $this->newStatus,
            ]);

            // ✅ Send email if status changed to completed for online bookings
            if ($this->newStatus === 'completed' && $booking->booking_source !== 'walk-in' && $booking->customer_email) {
                try {
                    Mail::to($booking->customer_email)->send(new BookingCompleted($booking));
                    Log::info("Booking completed email sent to {$booking->customer_email}", [
                        'booking_token' => $booking->booking_token,
                    ]);
                } catch (\Exception $mailError) {
                    Log::error("Failed to send booking completed email: " . $mailError->getMessage(), [
                        'booking_token' => $booking->booking_token,
                        'email' => $booking->customer_email,
                    ]);
                }
            }

            // Log status change (optional: buat table booking_logs)
            Log::info("Booking {$booking->booking_token} status changed from {$oldStatus} to {$this->newStatus}", [
                'notes' => $this->statusNotes,
                'admin' => Auth::user()->name ?? 'System',
            ]);

            DB::commit();

            $this->showStatusModal = false;
            $this->selectedBooking->refresh(); // Refresh data

            session()->flash('success', 'Booking status updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update booking status: ' . $e->getMessage());
            session()->flash('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    public function checkIn()
    {
        try {
            $booking = Booking::findOrFail($this->selectedBookingId);
            $booking->update(['status' => 'checked_in']);
            $this->selectedBooking->refresh();
            session()->flash('success', 'Guest checked in successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to check in: ' . $e->getMessage());
        }
    }

    public function complete()
    {
        try {
            $booking = Booking::findOrFail($this->selectedBookingId);
            $booking->update(['status' => 'completed']);

            // ✅ Send email if booking is from online source (not walk-in)
            if ($booking->booking_source !== 'walk-in' && $booking->customer_email) {
                try {
                    Mail::to($booking->customer_email)->send(new BookingCompleted($booking));
                    Log::info("Booking completed email sent to {$booking->customer_email}", [
                        'booking_token' => $booking->booking_token,
                    ]);
                } catch (\Exception $mailError) {
                    Log::error("Failed to send booking completed email: " . $mailError->getMessage(), [
                        'booking_token' => $booking->booking_token,
                        'email' => $booking->customer_email,
                    ]);
                }
            }

            $this->selectedBooking->refresh();
            session()->flash('success', 'Booking completed successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to complete: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($this->selectedBookingId);
            $booking->update(['status' => 'cancelled']);

            // Release availability
            $this->releaseAvailability($booking);

            DB::commit();

            $this->selectedBooking->refresh();
            session()->flash('success', 'Booking cancelled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to cancel: ' . $e->getMessage());
        }
    }

    private function releaseAvailability($booking)
    {
        $start = Carbon::parse($booking->start_date);
        $end = Carbon::parse($booking->end_date);
        $current = $start->copy();

        $product = Product::find($booking->items->where('item_type', 'product')->first()?->product_id);

        if (!$product) return;

        if ($product->type === 'touring') {
            $this->incrementAvailability($booking, $start->format('Y-m-d'), $product);
        } else {
            while ($current->lt($end)) {
                $this->incrementAvailability($booking, $current->format('Y-m-d'), $product);
                $current->addDay();
            }
        }
    }

    private function incrementAvailability($booking, $date, $product)
    {
        $availability = Availability::where('product_id', $product->id)
            ->whereDate('date', $date)
            ->first();

        if ($availability) {
            if ($booking->product_type === 'touring') {
                $availability->increment('available_seat', $booking->seat_count);
            } else {
                $availability->increment('available_unit', $booking->unit_count);
            }
        }
    }

    // ============================================
    // EDIT ADDONS METHODS
    // ============================================

    public function openAddonsModal()
    {
        $this->showAddonsModal = true;

        // Load existing addons
        $this->editableAddons = [];
        foreach ($this->selectedBooking->items->where('item_type', 'addon') as $item) {
            $this->editableAddons[$item->id] = [
                'addon_id' => $item->addon_id,
                'name' => $item->name_snapshot,
                'qty' => $item->qty,
                'unit_price' => $item->unit_price,
                'subtotal' => $item->subtotal,
                'notes' => is_string($item->notes) ? json_decode($item->notes, true) : $item->notes,
                'action' => 'keep', // keep, update, delete
            ];
        }

        // Reset new addons
        $this->newAddons = [];
        $this->addonNotes = '';
    }

    public function addNewAddon($addonId)
    {
        $addon = Addon::find($addonId);
        if (!$addon) return;

        if (!isset($this->newAddons[$addonId])) {
            $this->newAddons[$addonId] = [
                'addon_id' => $addon->id,
                'name' => $addon->name,
                'pricing_type' => $addon->pricing_type,
                'qty' => 1,
                'unit_price' => $addon->price,
                'hours' => 0,
                'slots' => 0,
            ];
        }
    }

    public function removeNewAddon($addonId)
    {
        unset($this->newAddons[$addonId]);
    }

    public function markAddonForDeletion($itemId)
    {
        $this->editableAddons[$itemId]['action'] = 'delete';
    }

    public function restoreAddon($itemId)
    {
        $this->editableAddons[$itemId]['action'] = 'keep';
    }

    public function updateAddonQtyInEdit($itemId, $action)
    {
        if ($action === 'increment') {
            $this->editableAddons[$itemId]['qty']++;
            $this->editableAddons[$itemId]['action'] = 'update';
        } elseif ($action === 'decrement' && $this->editableAddons[$itemId]['qty'] > 1) {
            $this->editableAddons[$itemId]['qty']--;
            $this->editableAddons[$itemId]['action'] = 'update';
        }
    }

    public function updateNewAddonQty($addonId, $action)
    {
        if ($action === 'increment') {
            $this->newAddons[$addonId]['qty']++;
        } elseif ($action === 'decrement' && $this->newAddons[$addonId]['qty'] > 1) {
            $this->newAddons[$addonId]['qty']--;
        }
    }

    public function saveAddons()
    {
        try {
            DB::beginTransaction();

            $booking = Booking::with(['invoices', 'payments'])->findOrFail($this->selectedBookingId);

            // ✅ Check if status is checked_in
            $isCheckedIn = $booking->status === 'checked_in';

            $oldSubtotal = $booking->subtotal;
            $addonsTotal = 0;
            $newAddonsTotal = 0; // ✅ Track only new addons for addon_onsite invoice

            // Process existing addons
            foreach ($this->editableAddons as $itemId => $data) {
                $item = BookingItem::find($itemId);

                if ($data['action'] === 'delete') {
                    $item->delete();
                } elseif ($data['action'] === 'update') {
                    $addon = Addon::find($item->addon_id);
                    $nights = Carbon::parse($booking->start_date)->diffInDays($booking->end_date);

                    $newSubtotal = $addon->calculatePrice(
                        $data['qty'],
                        $nights,
                        $booking->people_count,
                        $data['notes']['hours'] ?? 0,
                        $data['notes']['slots'] ?? 0
                    );

                    $item->update([
                        'qty' => $data['qty'],
                        'subtotal' => $newSubtotal,
                    ]);

                    $addonsTotal += $newSubtotal;
                } else {
                    $addonsTotal += $item->subtotal;
                }
            }

            // ✅ Add new addons
            $newAddonItems = []; // Store new addon items for invoice
            foreach ($this->newAddons as $addonId => $data) {
                $addon = Addon::find($addonId);
                $nights = Carbon::parse($booking->start_date)->diffInDays($booking->end_date);

                $subtotal = $addon->calculatePrice(
                    $data['qty'],
                    $nights,
                    $booking->people_count,
                    $data['hours'],
                    $data['slots']
                );

                $bookingItem = BookingItem::create([
                    'booking_id' => $booking->id,
                    'product_id' => null,
                    'addon_id' => $addon->id,
                    'item_type' => 'addon',
                    'name_snapshot' => $addon->name,
                    'pricing_type_snapshot' => $addon->pricing_type,
                    'qty' => $data['qty'],
                    'unit_price' => $addon->price,
                    'subtotal' => $subtotal,
                    'notes' => json_encode([
                        'hours' => $data['hours'],
                        'slots' => $data['slots'],
                        'nights' => $nights,
                        'people' => $booking->people_count,
                        'added_onsite' => $isCheckedIn, // ✅ Mark if added on-site
                    ]),
                ]);

                $addonsTotal += $subtotal;
                $newAddonsTotal += $subtotal;
                $newAddonItems[] = $bookingItem; // ✅ Store for invoice
            }

            // Recalculate booking totals
            $productTotal = $booking->items()->where('item_type', 'product')->sum('subtotal');
            $newSubtotal = $productTotal + $addonsTotal;
            $newTotal = $newSubtotal - $booking->discount_total;

            $booking->update([
                'subtotal' => $newSubtotal,
                'total_price' => $newTotal,
            ]);

            // ✅ If checked-in AND new addons were added, create addon_onsite invoice & pending payment
            if ($isCheckedIn && $newAddonsTotal > 0) {
                // Get primary invoice
                $primaryInvoice = $booking->invoices()->where('type', 'primary')->first();

                // Create addon_onsite invoice
                $addonInvoice = Invoice::create([
                    'booking_id' => $booking->id,
                    'parent_invoice_id' => $primaryInvoice->id,
                    'type' => 'addon_onsite',
                    'amount' => $newAddonsTotal,
                    'status' => 'pending',

                ]);

                // Add invoice items for new addons
                foreach ($newAddonItems as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $addonInvoice->id,
                        'booking_item_id' => $item->id,
                        'name' => $item->name_snapshot,
                        'qty' => $item->qty,
                        'unit_price' => $item->unit_price,
                        'subtotal' => $item->subtotal,
                        'meta' => [
                            'item_type' => 'addon',
                            'addon_id' => $item->addon_id,
                            'pricing_type' => $item->pricing_type_snapshot,
                            'added_onsite' => true,
                        ],
                    ]);
                }

                // Create pending payment for addon
                $orderIdLatest = \App\Models\Payment::where('order_id', 'like', 'ORD-ADDON%')
                    ->orderBy('order_id', 'desc')
                    ->first();

                if ($orderIdLatest) {
                    $lastOrderNumber = (int) substr($orderIdLatest->order_id, 10);
                    $newOrderNumber = str_pad($lastOrderNumber + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    $newOrderNumber = '00001';
                }

                $orderId = 'ORD-ADDON' . $newOrderNumber;

                \App\Models\Payment::create([
                    'booking_id' => $booking->id,
                    'provider' => 'cash', // ✅ Will be set when paid
                    'order_id' => $orderId,
                    'payment_code_or_url' => null,
                    'amount' => $newAddonsTotal,
                    'status' => 'pending',
                    'expired_at' => null,
                    'paid_at' => null,
                    'raw_payload' => json_encode([
                        'type' => 'addon_onsite',
                        'invoice_id' => $addonInvoice->id,
                        'notes' => $this->addonNotes,
                        'created_by' => Auth::user()->name ?? 'Admin',
                        'created_at' => now()->toDateTimeString(),
                    ]),
                ]);

                Log::info('Addon on-site invoice created', [
                    'booking_id' => $booking->id,
                    'invoice_id' => $addonInvoice->id,
                    'amount' => $newAddonsTotal,
                    'addons_count' => count($newAddonItems),
                ]);
            }

            DB::commit();

            $this->showAddonsModal = false;
            $this->selectedBooking = Booking::with(['items', 'payments', 'invoices', 'user'])->find($this->selectedBookingId);

            if ($isCheckedIn && $newAddonsTotal > 0) {
                session()->flash('success', 'Add-ons berhasil ditambahkan! Invoice addon on-site telah dibuat. Silakan lakukan pembayaran addon.');
            } else {
                session()->flash('success', 'Add-ons updated successfully!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update addons: ' . $e->getMessage());
            session()->flash('error', 'Failed to update add-ons: ' . $e->getMessage());
        }
    }

    // ============================================
    // BONUS REDEMPTION
    // ============================================

    public function redeemBonus()
    {
        if (!$this->selectedBooking->user_id) {
            session()->flash('error', 'Customer must be linked to a user account to redeem bonus.');
            return;
        }

        $user = User::find($this->selectedBooking->user_id);

        if (!$user || $user->bonus_points < 100) {
            session()->flash('error', 'Insufficient bonus points. Minimum 100 points required.');
            return;
        }

        try {
            DB::beginTransaction();

            // Calculate discount (100 points = Rp 10,000)
            $pointsToRedeem = min($user->bonus_points, 1000); // Max 1000 points per transaction
            $discount = $pointsToRedeem * 100; // 1 point = Rp 100

            // Update booking
            $booking = Booking::findOrFail($this->selectedBookingId);
            $newTotal = max(0, $booking->total_price - $discount);

            $booking->update([
                'discount_total' => $booking->discount_total + $discount,
                'total_price' => $newTotal,
            ]);

            // Deduct user bonus points
            $user->decrement('bonus_points', $pointsToRedeem);

            // Log bonus usage
            Log::info("Bonus redeemed for booking {$booking->booking_token}", [
                'user_id' => $user->id,
                'points_used' => $pointsToRedeem,
                'discount' => $discount,
            ]);

            DB::commit();

            $this->selectedBooking->refresh();
            session()->flash('success', "Successfully redeemed {$pointsToRedeem} bonus points (Rp " . number_format($discount, 0, ',', '.') . " discount)!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to redeem bonus: ' . $e->getMessage());
            session()->flash('error', 'Failed to redeem bonus: ' . $e->getMessage());
        }
    }

    // ============================================
    // CANCEL & REFUND
    // ============================================
    public function openCancelModal()
    {
        if (!in_array($this->selectedBooking->status, ['draft', 'pending_payment'])) {
            session()->flash('error', 'Hanya booking dengan status draft atau pending_payment yang dapat dibatalkan.');
            return;
        }

        $this->showCancelModal = true;
        $this->cancelReason = '';
    }

    public function cancelBooking()
    {
        $this->validate([
            'cancelReason' => 'required|string|min:5',
        ]);

        try {

            DB::beginTransaction();

            $booking = Booking::with(['payments', 'invoices'])->findOrFail($this->selectedBookingId);

            $booking->update([
                'status' => 'cancelled',
            ]);

            foreach ($booking->payments as $payment) {
                if (in_array($payment->status, ['initiated', 'pending'])) {
                    $payment->update([
                        'status' => 'cancel',
                        'raw_payload' => json_encode([
                            'cancelled_at' => now()->toDateTimeString(),
                            'cancel_reason' => $this->cancelReason,
                            'cancelled_by' => Auth::user()->name ?? 'Admin',
                        ])
                    ]);
                }
            }

            foreach ($booking->invoices as $invoice) {
                if ($invoice->status === 'draft') {
                    $invoice->update([
                        'status' => 'void',
                    ]);
                }
            }

            $this->releaseAvailability($booking);

            Log::info('Booking cancelled', [
                'booking_id' => $booking->id,
                'token' => $booking->booking_token,
                'reason' => $this->cancelReason,
                'cancelled_by' => Auth::user()->name ?? 'Admin',
            ]);

            DB::commit();

            $this->showCancelModal = false;

            session()->flash('success', 'Booking berhasil dibatalkan!');

            $this->selectedBooking = Booking::with(['items', 'payments', 'invoices', 'user'])->find($this->selectedBookingId);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to cancel booking: ' . $e->getMessage());
            session()->flash('error', 'Gagal membatalkan booking: ' . $e->getMessage());
        }
    }

    public function openRefundModal()
    {
        if (!in_array($this->selectedBooking->status, ['paid', 'checked_in', 'completed'])) {
            session()->flash('error', 'Hanya booking dengan status paid, checked_in, atau completed yang dapat direfund.');
            return;
        }

        $totalPaid = $this->selectedBooking->payments()
            ->where('status', 'settlement')
            ->sum('amount');

        $totalRefunded = $this->selectedBooking->invoices()
            ->where('type', 'credit_note')
            ->sum('amount');

        $this->refundAmount = $totalPaid - $totalRefunded;
        $this->refundType = 'full';
        $this->refundReason = '';

        $this->showRefundModal = true;
    }

    public function processRefund()
    {
        $this->validate([
            'refundType' => 'required|in:full,partial',
            'refundAmount' => 'required|numeric|min:1',
            'refundReason' => 'required|string|min:5',
        ]);

        try {

            DB::beginTransaction();

            $booking = Booking::with(['payments', 'invoices', 'items'])->find($this->selectedBookingId);

            $totalPaid = $booking->payments()->where('status', 'settlement')->sum('amount');
            $totalRefunded = $booking->invoices()->where('type', 'credit_note')->sum('amount');
            $maxRefundable = $totalPaid - $totalRefunded;

            if ($this->refundAmount > $maxRefundable) {
                throw new \Exception('Jumlah refund melebihi batas yang dapat direfund!');
            }

            $primaryInvoice = $booking->invoices()->where('type', 'primary')->first();

            $creditNote = Invoice::create([
                'booking_id' => $booking->id,
                'parent_invoice_id' => $primaryInvoice->id,
                'type' => 'credit_note',
                'amount' => $this->refundAmount,
                'status' => 'paid',

            ]);

            if ($this->refundType === 'full') {
                foreach ($primaryInvoice->items as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $creditNote->id,
                        'name' => $item->name . ' (Refund)',
                        'qty' => $item->qty,
                        'unit_price' => $item->unit_price,
                        'subtotal' => $item->subtotal,
                        'meta' => array_merge($item->meta ?? [], [
                            'refund_type' => 'full',
                            'original_item_id' => $item->id,
                        ]),
                    ]);
                }
            } else {
                InvoiceItem::create([
                    'invoice_id' => $creditNote->id,
                    'name' => 'Partial Refund',
                    'qty' => 1,
                    'unit_price' => $this->refundAmount,
                    'subtotal' => $this->refundAmount,
                    'meta' => [
                        'refund_type' => 'partial',
                        'reason' => $this->refundReason,
                    ],
                ]);
            }

            $settlementPayment = $booking->payments()->where('status', 'settlement')->first();

            if ($settlementPayment) {
                if ($this->refundType === 'full') {
                    $settlementPayment->update([
                        'status' => 'refund',

                        'raw_payload' => json_encode([
                            'refunded_at' => now()->toDateTimeString(),
                            'refund_amount' => $this->refundAmount,
                            'refund_reason' => $this->refundReason,
                            'refunded_by' => Auth::user()->name ?? 'Admin',
                            'credit_note_id' => $creditNote->id,
                        ]),

                    ]);
                } else {
                    $settlementPayment->update([
                        'status' => 'partial_refund',
                        'raw_payload' => array_merge($settlementPayment->raw_payload ?? [], [
                            'partial_refunds' => array_merge(
                                $settlementPayment->raw_payload['partial_refunds'] ?? [],
                                [[
                                    'refunded_at' => now()->toDateTimeString(),
                                    'amount' => $this->refundAmount,
                                    'reason' => $this->refundReason,
                                    'refunded_by' => Auth::user()->name ?? 'Admin',
                                    'credit_note_id' => $creditNote->id,
                                ]]
                            ),
                        ]),
                    ]);
                }
            }

            if ($this->refundType === 'full') {
                $booking->update(['status' => 'refunded']);

                $this->releaseAvailability($booking);
            }

            Log::info('Booking refunded', [
                'booking_id' => $booking->id,
                'token' => $booking->booking_token,
                'type' => $this->refundType,
                'amount' => $this->refundAmount,
                'reason' => $this->refundReason,
                'credit_note_id' => $creditNote->id,
                'refunded_by' => Auth::user()->name ?? 'Admin',
            ]);

            DB::commit();

            // Send refund email
            if ($booking->customer_email) {
                try {
                    Mail::to($booking->customer_email)->send(
                        new BookingRefunded($booking, $creditNote, $this->refundType, $this->refundAmount, $this->refundReason)
                    );
                    Log::info("Refund email sent to {$booking->customer_email}", [
                        'booking_token' => $booking->booking_token,
                        'refund_type' => $this->refundType,
                        'amount' => $this->refundAmount,
                        'credit_note_id' => $creditNote->id,
                    ]);
                } catch (\Exception $mailError) {
                    Log::error("Failed to send refund email: " . $mailError->getMessage(), [
                        'booking_token' => $booking->booking_token,
                        'email' => $booking->customer_email,
                        'error' => $mailError->getMessage(),
                    ]);
                }
            }

            $this->showRefundModal = false;
            session()->flash('success', ucfirst($this->refundType) . ' Refund berhasil diproses! Credit Note: ' . $creditNote->id);

            $this->selectedBooking = Booking::with(['items', 'payments', 'invoices', 'user'])->find($this->selectedBookingId);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process refund: ' . $e->getMessage());
            session()->flash('error', 'Gagal memproses refund: ' . $e->getMessage());
        }
    }

    public function openNoShowModal()
    {
        // Validate: only paid bookings that are past checkout date
        if ($this->selectedBooking->status !== 'paid') {
            session()->flash('error', 'Only paid bookings can be marked as no-show!');
            return;
        }

        $checkoutDate = Carbon::parse($this->selectedBooking->end_date);
        if ($checkoutDate->isFuture()) {
            session()->flash('error', 'Cannot mark as no-show before checkout date!');
            return;
        }

        $this->showNoShowModal = true;
        $this->noShowNotes = '';
    }

    public function markAsNoShow()
    {
        $this->validate([
            'noShowNotes' => 'required|string|min:10',
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::with(['payments', 'invoices'])->findOrFail($this->selectedBookingId);

            // ✅ Update booking status to no_show
            $booking->update([
                'status' => 'no_show',
            ]);

            // ✅ Keep payment status as settlement (already paid)
            // ✅ Keep invoice status as paid (already invoiced)
            // Note: No refund, no cancellation - customer simply didn't show up

            // ✅ Release availability (since customer didn't use the booking)
            $this->releaseAvailability($booking);

            // Log no-show event
            Log::info('Booking marked as no-show', [
                'booking_id' => $booking->id,
                'token' => $booking->booking_token,
                'notes' => $this->noShowNotes,
                'marked_by' => Auth::user()->name ?? 'Admin',
                'checkout_date' => $booking->end_date,
            ]);

            DB::commit();

            $this->showNoShowModal = false;
            session()->flash('success', 'Booking successfully marked as No-Show. Availability has been released.');

            // Refresh data
            $this->selectedBooking = Booking::with(['items', 'payments', 'invoices', 'user'])->find($this->selectedBookingId);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to mark as no-show: ' . $e->getMessage());
            session()->flash('error', 'Failed to mark as no-show: ' . $e->getMessage());
        }
    }


    // ============================================
    // Pay Now
    // ============================================

    public function openPayNowModal()
    {
        if ($this->selectedBooking->booking_source !== 'walk-in') {
            session()->flash('error', 'Fitur ini hanya untuk booking walk-in!');
            return;
        }

        if ($this->selectedBooking->status !== 'pending_payment') {
            session()->flash('error', 'Booking sudah dibayar atau tidak dalam status pending!');
            return;
        }

        $pendingPayment = $this->selectedBooking->payments()
            ->where('status', 'pending')
            ->first();

        if (!$pendingPayment) {
            session()->flash('error', 'Tidak ada payment pending untuk booking ini!');
            return;
        }

        $this->payNowAmount = $pendingPayment->amount;
        $this->payNowMethod = 'cash';
        $this->payNowNotes = '';
        $this->showPayNowModal = true;
    }

    public function processPayNow()
    {
        $this->validate([
            'payNowMethod' => 'required|in:cash,qris,transfer',
            'payNowAmount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::with(['payments', 'invoices'])->findOrFail($this->selectedBookingId);

            // ✅ Get pending payment
            $payment = $booking->payments()->where('status', 'pending')->first();

            if (!$payment) {
                throw new \Exception('Payment pending tidak ditemukan!');
            }

            if ($this->payNowAmount < $payment->amount) {
                throw new \Exception('Jumlah pembayaran kurang dari total tagihan!');
            }

            // ✅ Update payment status
            $payment->update([
                'provider' => $this->payNowMethod,
                'status' => 'settlement',
                'paid_at' => now(),

                'raw_payload' => json_encode([
                    'paid_by' => Auth::user()->name ?? 'Admin',
                    'payment_method' => $this->payNowMethod,
                    'amount_received' => $this->payNowAmount,
                    'change' => $this->payNowAmount - $payment->amount,
                    'payment_date' => now()->toDateTimeString(),
                    'notes' => $this->payNowNotes,
                    'created_at' => now()->toDateTimeString(),
                ]),
            ]);

            // ✅ Update invoice status
            $invoice = $booking->invoices()->where('status', 'pending')->first();
            if ($invoice) {
                $invoice->update(['status' => 'paid']);
            }

            // ✅ Update booking status
            $booking->update(['status' => 'paid']);

            Log::info('Pending payment settled', [
                'booking_id' => $booking->id,
                'token' => $booking->booking_token,
                'payment_id' => $payment->id,
                'method' => $this->payNowMethod,
                'amount' => $this->payNowAmount,
                'processed_by' => Auth::user()->name ?? 'Admin',
            ]);

            DB::commit();

            $this->showPayNowModal = false;
            session()->flash('success', 'Pembayaran berhasil dicatat! Booking sekarang berstatus PAID.');

            // Refresh data
            $this->selectedBooking = Booking::with(['items', 'payments', 'invoices', 'user'])->find($this->selectedBookingId);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process refund: ' . $e->getMessage());
            session()->flash('error', 'Gagal memproses refund: ' . $e->getMessage());
        }
    }



    // ============================================
    // Pay Addons
    // ============================================
    public function openPayAddonModal()
    {
        // ✅ Check if there's pending addon payment
        $pendingAddonPayment = $this->selectedBooking->payments()
            ->where('order_id', 'like', 'ORD-ADDON%')
            ->where('status', 'pending')
            ->first();

        if (!$pendingAddonPayment) {
            session()->flash('error', 'Tidak ada pembayaran addon pending!');
            return;
        }

        $this->payAddonAmount = $pendingAddonPayment->amount;
        $this->payAddonMethod = 'cash';
        $this->payAddonNotes = '';
        $this->showPayAddonModal = true;
    }


    public function processPayAddon()
    {
        $this->validate([
            'payAddonMethod' => 'required|in:cash,qris',
            'payAddonAmount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::with(['payments', 'invoices'])->findOrFail($this->selectedBookingId);

            // ✅ Get pending addon payment
            $payment = $booking->payments()
                ->where('status', 'pending')
                ->whereJsonContains('raw_payload->type', 'addon_onsite')
                ->first();

            if (!$payment) {
                throw new \Exception('Pending addon payment tidak ditemukan!');
            }

            if ($this->payAddonAmount < $payment->amount) {
                throw new \Exception('Jumlah pembayaran kurang dari total addon!');
            }

            // ✅ Update payment
            $payment->update([
                'provider' => $this->payAddonMethod,
                'status' => 'settlement',
                'paid_at' => now(),

                'raw_payload' => json_encode([
                    'paid_by' => Auth::user()->name ?? 'Admin',
                    'payment_method' => $this->payAddonMethod,
                    'amount_received' => $this->payAddonAmount,
                    'change' => $this->payAddonAmount - $payment->amount,
                    'payment_date' => now()->toDateTimeString(),
                    'notes' => $this->payAddonNotes,
                ]),
            ]);

            // ✅ Update addon_onsite invoice
            $addonInvoice = $booking->invoices()
                ->where('type', 'addon_onsite')
                ->where('status', 'pending')
                ->first();

            if ($addonInvoice) {
                $addonInvoice->update(['status' => 'paid']);
            }

            Log::info('Addon on-site payment settled', [
                'booking_id' => $booking->id,
                'token' => $booking->booking_token,
                'payment_id' => $payment->id,
                'invoice_id' => $addonInvoice->id ?? null,
                'method' => $this->payAddonMethod,
                'amount' => $this->payAddonAmount,
                'processed_by' => Auth::user()->name ?? 'Admin',
            ]);

            DB::commit();

            $this->showPayAddonModal = false;
            session()->flash('success', 'Pembayaran addon berhasil dicatat!');

            // Refresh data
            $this->selectedBooking = Booking::with(['items', 'payments', 'invoices', 'user'])->find($this->selectedBookingId);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process addon payment: ' . $e->getMessage());
            session()->flash('error', 'Gagal memproses pembayaran addon: ' . $e->getMessage());
        }
    }


    // ============================================
    // RENDER
    // ============================================
    #[Layout('layouts.admin')]

    public function render()
    {
        $bookings = Booking::query() // ✅ FIX: $booking → $bookings
            ->with(['items.product', 'items.addon', 'user']) // ✅ Add items.addon
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('booking_token', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->productTypeFilter, function ($query) { // ✅ FIX: -> when
                $query->where('product_type', $this->productTypeFilter);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('start_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('end_date', '<=', $this->endDate);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10)->onEachSide(1);

        $products = Product::where('type', $this->productType)
            ->where('is_active', true)
            ->get();

        $addons = Addon::where('is_active', true)->get();

        return view('livewire.admin.bookings', [
            'bookings' => $bookings,
            'stats' => $this->stats,
            'products' => $products,
            'addons' => $addons,
        ]);
    }
}
