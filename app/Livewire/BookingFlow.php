<?php

namespace App\Livewire;

use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\VoucherService;
use Livewire\Component;
use App\Models\Product;
use App\Models\Availability;
use App\Models\Voucher;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Addon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingFlow extends Component
{
    #[\Livewire\Attributes\Layout('components.layouts.detailProduct')]
    // Product
    public $product;
    public $productSlug;

    // Step tracking
    public $currentStep = 1;

    // Step 1: Input data
    public $peopleCount = 1;
    public $nightCount = 1;

    // Step 2: Date selection
    public $selectedStartDate = null;
    public $selectedDates = [];
    public $currentMonth;
    public $currentYear;
    public $availabilityData = [];

    // Step 3: add-ons
    public $selectedAddons = [];
    public $addonsTotal = 0;

    // step 3: summary
    public $customerName = '';
    public $customerEmail = '';
    public $customerPhone = '';
    public $specialRequest = '';

    // voucher properties
    public $voucherCode = '';
    public $appliedVoucher = null;
    public $voucherDiscount = 0;
    public $voucherBonusMeta = null;
    public $voucherMessage = '';
    public $voucherError = '';

    // Calculated
    public $requiredUnits = 0;
    public $estimatedPrice = 0;
    public $totalPrice = 0;

    //modal properties
    public $showLoginModal = false;
    public $modalView = 'login';

    public $loginEmail = '';
    public $loginPassword = '';

    public $registerName = '';
    public $registerEmail = '';
    public $registerPhone = '';
    public $registerPassword = '';
    public $registerPasswordConfirmation = '';

    //email checking properties
    public $emailExists = false;
    public $existingUserEmail = null;
    public $showEmailConfirmModal = false;



    protected $rules = [
        'peopleCount' => 'required|integer|min:1',
        'nightCount' => 'required|integer|min:1',
    ];

    protected function rules()
    {
        $baseRules = [
            'peopleCount' => 'required|integer|min:1',
            'nightCount' => 'required|integer|min:1',
        ];

        if ($this->currentStep === 4) {
            return array_merge($baseRules, [
                'customerName' => 'required|string|min:3|max:255',
                'customerEmail' => 'required|email|max:255',
                'customerPhone' => 'required|string|max:20',
                'specialRequest' => 'nullable|string|max:255',
            ]);
        }

        return $baseRules;
    }

    public function mount($slug)
    {
        $this->productSlug = $slug;
        $this->product = Product::where('slug', $slug)->firstOrFail();

        // Set current month for calendar
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->currentDate = now()->toDateString();


        if (Auth::check()) {
            $user = Auth::user();
            $this->customerName = $user->name ?? '';
            $this->customerEmail = $user->email ?? '';
            $this->customerPhone = $user->phone ?? '';
        }
        // Load availability for current month
        $this->loadAvailability();
    }

    // ============================================
    // MODAL AUTHENTICATION
    // ============================================

    public function openLoginModal()
    {
        $this->showLoginModal = true;
        $this->modalView = 'login';
        $this->resetAuthForms();
    }

    public function closeLoginModal()
    {
        $this->showLoginModal = false;
        $this->resetAuthForms();
    }

    public function switchToRegister()
    {
        $this->modalView = 'register';
        $this->resetAuthForms();
    }

    public function switchToLogin()
    {
        $this->modalView = 'login';
        $this->resetAuthForms();
    }

    public function resetAuthForms()
    {
        $this->loginEmail = '';
        $this->loginPassword = '';
        $this->registerName = '';
        $this->registerEmail = '';
        $this->registerPhone = '';
        $this->registerPassword = '';
        $this->registerPasswordConfirmation = '';
        $this->resetErrorBag();
    }

    public function login()
    {
        $this->validate([
            'loginEmail' => 'required|email',
            'loginPassword' => 'required|min:6',
        ], [
            'loginEmail.required' => 'Email wajib diisi',
            'loginEmail.email' => 'Format email tidak valid',
            'loginPassword.required' => 'Password wajib diisi',
            'loginPassword.min' => 'Password minimal 6 karakter',
        ]);

        if (Auth::attempt(['email' => $this->loginEmail, 'password' => $this->loginPassword])) {
            $user = Auth::user();

            // ✅ Update customer info dengan data user
            $this->customerName = $user->name;
            $this->customerEmail = $user->email;
            $this->customerPhone = $user->phone ?? $this->customerPhone;

            // ✅ Close modal dan stay di step 4
            $this->showLoginModal = false;
            $this->resetAuthForms();

            Log::info('User logged in via booking flow', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            session()->flash('success', 'Login berhasil! Sekarang Anda bisa menggunakan voucher.');

            return;
        }

        $this->addError('loginEmail', 'Email atau password salah.');
    }

    public function register()
    {

        $this->validate([
            'registerName' => 'required|string|min:3|max:255',
            'registerEmail' => 'required|email|unique:users,email',
            'registerPhone' => 'required|string|max:20',
            'registerPassword' => 'required|min:6',
        ], [
            'registerName.required' => 'Nama wajib diisi',
            'registerName.min' => 'Nama minimal 3 karakter',
            'registerEmail.required' => 'Email wajib diisi',
            'registerEmail.email' => 'Format email tidak valid',
            'registerEmail.unique' => 'Email sudah terdaftar',
            'registerPhone.required' => 'Nomor telepon wajib diisi',
            'registerPassword.required' => 'Password wajib diisi',
            'registerPassword.min' => 'Password minimal 6 karakter',
        ]);

        try {
            // Create user
            $user = User::create([
                'name' => $this->registerName,
                'email' => $this->registerEmail,
                'phone' => $this->registerPhone,
                'password' => Hash::make($this->registerPassword),
            ]);

            // Auto login
            Auth::login($user);

            $this->customerName = $user->name;
            $this->customerEmail = $user->email;
            $this->customerPhone = $user->phone;

            $this->showLoginModal = false;
            $this->resetAuthForms();

            Log::info('User registered via booking flow', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            session()->flash('success', 'Registrasi berhasil! Sekarang Anda bisa menggunakan voucher.');

            return;
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            $this->addError('registerEmail', 'Registrasi gagal. Silakan coba lagi.');
        }
    }

    // ============================================
    // EMAIL CHECKING
    // ============================================

    public function updatedCustomerEmail($value){
        if(Auth::check()){
            return;
        }

        $this->emailExists = false;
        $this->existingUserEmail = null;

        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            return;
        }

         if (empty($value) || strlen($value) < 5) {
        return;
    }

        $user = User::where('email', $value)->first();

        if($user){
            $this->emailExists = true;
            $this->existingUserEmail = $value;
            $this->showEmailConfirmModal = true;

            Log::info('Email exists in database', [
                'email' => $value,
                'user_id' => $user->id,
            ]);
        }
    }

    public function continueAsGuest()
    {
        $this->showEmailConfirmModal = false;
        $this->emailExists = false;

         Log::info('User chose to continue as guest', [
            'email' => $this->existingUserEmail,
        ]);
    }

    public function switchToLoginFromEmail()
    {
        $this->loginEmail = $this->existingUserEmail;

        $this->showEmailConfirmModal = false;

        $this->openLoginModal();

        Log::info('User redirected to login from email check', [
            'email' => $this->existingUserEmail,
        ]);
    }

    // ============================================
    // STEP 1: Input People & Nights
    // ============================================

    public function nextToCalendar()
    {
        $this->validate();

        // Calculate required units
        if ($this->product->type === 'accommodation') {
            $this->requiredUnits = $this->product->calculateRequiredUnits($this->peopleCount);
        } else {
            $this->requiredUnits = 1; // touring/area_rental
        }

        $this->currentStep = 2;
        $this->loadAvailability();
    }

    // ============================================
    // STEP 2: Calendar & Date Selection
    // ============================================

    public function loadAvailability()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Get availability data for current month
        $availability = Availability::where('product_id', $this->product->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        $this->availabilityData = $availability->map(function ($item) {
            return [
                'available_unit' => $item->available_unit,
                'available_seat' => $item->available_seat,
            ];
        })->toArray();
    }

    public function selectDate($date)
    {
        $selectedDate = Carbon::parse($date);

        // Tidak bisa pilih tanggal yang sudah lewat
        if ($selectedDate->isPast()) {
            return;
        }

        // Check availability untuk date range
        $endDate = $selectedDate->copy()->addDays((int)$this->nightCount);
        $dateRange = CarbonPeriod::create($selectedDate, $endDate->subDay());

        $allAvailable = true;
        $tempDates = [];

        foreach ($dateRange as $checkDate) {
            $dateStr = $checkDate->format('Y-m-d');

            // Check if date has availability data
            if (!isset($this->availabilityData[$dateStr])) {
                $allAvailable = false;
                break;
            }

            $avail = $this->availabilityData[$dateStr];

            // Check stock
            if ($this->product->type === 'touring') {
                if ($avail['available_seat'] < $this->peopleCount) {
                    $allAvailable = false;
                    break;
                }
            } else {
                if ($avail['available_unit'] < $this->requiredUnits) {
                    $allAvailable = false;
                    break;
                }
            }

            $tempDates[] = $dateStr;
        }

        if ($allAvailable) {
            $this->selectedStartDate = $selectedDate->format('Y-m-d');
            $this->selectedDates = $tempDates;

            // Calculate estimated price
            $this->calculatePrice();
        } else {
            session()->flash('error', 'Tanggal yang dipilih tidak tersedia. Silakan pilih tanggal lain.');
        }
    }

    public function calculatePrice()
    {
        if (!$this->selectedStartDate) {
            return;
        }

        $startDate = Carbon::parse($this->selectedStartDate);
        $endDate = $startDate->copy()->addDays((int)$this->nightCount);

        $this->estimatedPrice = $this->product->calculatePrice(
            $startDate,
            $endDate,
            $this->requiredUnits
        );
    }

    // Navigate calendar
    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();

        // Tidak bisa navigate ke bulan yang sudah lewat
        if ($date->isFuture() || $date->isCurrentMonth()) {
            $this->currentMonth = $date->month;
            $this->currentYear = $date->year;
            $this->loadAvailability();
        }
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadAvailability();
    }


    // ============================================
    // STEP 3: Add-ons Selection
    // ============================================

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

    public function updateAddonQty($addonId, $field, $value)
    {
        if (isset($this->selectedAddons[$addonId])) {
            $this->selectedAddons[$addonId][$field] = max(0, (int)$value);
            $this->calculateAddonsTotal();
        }
    }

    public function calculateAddonsTotal()
    {
        $this->addonsTotal = 0;

        foreach ($this->selectedAddons as $addonId => $data) {
            $addon = Addon::find($addonId);

            if ($addon) {
                $subtotal = $addon->calculatePrice(
                    $data['qty'],
                    $this->nightCount,
                    $this->peopleCount,
                    $data['hours'],
                    $data['slots']
                );

                $this->addonsTotal += $subtotal;
            }
        }

        $this->calculateTotals();
    }

    // ============================================
    // STEP 4: Summary & Customer Info & voucher
    // ============================================

    public function calculateTotals()
    {
        // Base total = product price + addons
        $subtotal = $this->estimatedPrice + $this->addonsTotal;

        // Apply voucher discount
        $this->totalPrice = $subtotal - $this->voucherDiscount;
    }


    public function applyVoucher()
    {
        // Reset messages
        $this->voucherMessage = '';
        $this->voucherError = '';

        // Check if user logged in
        if (!Auth::check()) {
            $this->voucherError = 'Anda harus login untuk menggunakan voucher.';
            return;
        }

        // Validate voucher code input
        if (empty($this->voucherCode)) {
            $this->voucherError = 'Masukkan kode voucher.';
            return;
        }

        $subtotal = $this->estimatedPrice + $this->addonsTotal;

        // Validate voucher
        $voucherService = new VoucherService();
        $result = $voucherService->validateVoucher(
            $this->voucherCode,
            Auth::id(),
            $subtotal
        );

        if (!$result['valid']) {
            $this->voucherError = $result['message'];
            return;
        }

        // Apply voucher
        $this->appliedVoucher = $result['voucher'];
        $this->voucherDiscount = $result['discount'];
        $this->voucherBonusMeta = $result['bonus_meta'];
        $this->voucherMessage = $result['message'];

        // Recalculate total
        $this->calculateTotals();

        Log::info('Voucher applied in booking flow', [
            'voucher_code' => $this->voucherCode,
            'discount' => $this->voucherDiscount,
            'has_bonus' => !empty($this->voucherBonusMeta),
        ]);
    }

    public function removeVoucher()
    {
        $this->voucherCode = '';
        $this->appliedVoucher = null;
        $this->voucherDiscount = 0;
        $this->voucherBonusMeta = null;
        $this->voucherMessage = '';
        $this->voucherError = '';

        $this->calculateTotals();

        Log::info('Voucher removed in booking flow');
    }

    public function getSelectedAddonsDetails()
    {
        $details = [];

        foreach ($this->selectedAddons as $addonId => $data) {
            $addon = Addon::find($addonId);

            if ($addon) {
                $subtotal = $addon->calculatePrice(
                    $data['qty'],
                    $this->nightCount,
                    $this->peopleCount,
                    $data['hours'],
                    $data['slots']
                );

                $details[] = [
                    'addon' => $addon,
                    'data' => $data,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return $details;
    }


    // ============================================
    // STEP 5: payment
    // ============================================

    public function proceedToPayment()
    {
        $this->validate();

        try {
            // ✅ Check jika guest user sudah punya pending booking
            if (!auth()->check()) {
                // ✅ FIX: Gunakan where dengan closure untuk grouping OR condition
                $existingPendingBooking = Booking::where(function ($query) {
                    $query->where('customer_email', $this->customerEmail)
                        ->orWhere('customer_phone', $this->customerPhone);
                })
                    ->whereIn('status', ['draft', 'pending_payment'])
                    ->where('created_at', '>=', Carbon::now()->subHours(2))
                    ->first();

                if ($existingPendingBooking) {
                    // Cek apakah payment sudah expired
                    $payment = $existingPendingBooking->payments()->latest()->first();

                    if ($payment && $payment->expired_at && Carbon::parse($payment->expired_at)->isFuture()) {
                        // ✅ Gunakan Livewire flash dan stay di page
                        session()->flash('error', 'Anda masih memiliki booking yang belum dibayar dengan kode: ' . $existingPendingBooking->booking_token . '. Silakan selesaikan pembayaran terlebih dahulu.');

                        // ✅ Log untuk debugging
                        Log::warning('Duplicate booking attempt blocked', [
                            'email' => $this->customerEmail,
                            'phone' => $this->customerPhone,
                            'existing_booking' => $existingPendingBooking->booking_token,
                            'payment_expires_at' => $payment->expired_at,
                        ]);

                        // ✅ Jangan redirect, stay di current step dengan error message
                        return;
                    } else {
                        // Jika sudah expired, update status dan lanjutkan
                        Log::info('Auto-expiring old booking', [
                            'booking_token' => $existingPendingBooking->booking_token,
                        ]);

                        app(BookingService::class)->updateBookingStatus($existingPendingBooking, 'expired');
                    }
                }
            }

            DB::beginTransaction();

            $subtotal = $this->estimatedPrice + $this->addonsTotal;

            // Prepare booking data
            $bookingData = [
                'product_id' => $this->product->id,
                'product_name' => $this->product->name,
                'product_type' => $this->product->type,
                'pricing_type' => $this->product->type,
                'start_date' => $this->selectedStartDate,
                'end_date' => Carbon::parse($this->selectedStartDate)->addDays($this->nightCount)->format('Y-m-d'),
                'people_count' => $this->peopleCount,
                'unit_count' => $this->product->type !== 'touring' ? $this->requiredUnits : null,
                'seat_count' => $this->product->type === 'touring' ? $this->peopleCount : null,
                'product_unit_price' => $this->estimatedPrice / ($this->requiredUnits ?: 1),
                'subtotal' => $subtotal,
                'total_price' => $this->totalPrice,
                'customer_name' => $this->customerName,
                'customer_email' => $this->customerEmail,
                'customer_phone' => $this->customerPhone,
                'special_requests' => $this->specialRequest,

                'voucher_id' => $this->appliedVoucher?->id,
                'discount_amount' => $this->voucherDiscount,
                'bonus_meta' => $this->voucherBonusMeta,
                'addons' => [],
            ];

            // Add selected add-ons
            foreach ($this->selectedAddons as $addonId => $data) {
                $addon = Addon::find($addonId);
                if ($addon) {
                    $subtotal = $addon->calculatePrice(
                        $data['qty'],
                        $this->nightCount,
                        $this->peopleCount,
                        $data['hours'],
                        $data['slots']
                    );

                    $bookingData['addons'][] = [
                        'addon_id' => $addon->id,
                        'name' => $addon->name,
                        'pricing_type' => $addon->pricing_type,
                        'qty' => $data['qty'],
                        'unit_price' => $addon->price,
                        'subtotal' => $subtotal,
                        'notes' => json_encode($data),
                    ];
                }
            }

            // Create booking
            $bookingService = new BookingService();
            $booking = $bookingService->createBooking($bookingData);

            // Apply voucher
            if ($this->appliedVoucher && Auth::check()) {
                $voucherService = new VoucherService();
                $applyResult = $voucherService->applyVoucher($booking, $this->appliedVoucher, Auth::id());

                if (!$applyResult['success']) {
                    throw new \Exception('Gagal menerapkan voucher: ' . $applyResult['message']);
                }
            }

            $paymentService = new PaymentService();
            $paymentResult = $paymentService->createPayment($booking);

            if (!$paymentResult['success']) {
                throw new \Exception($paymentResult['message']);
            }

            DB::commit();

            Log::info('Booking and payment created successfully', [
                'booking_token' => $booking->booking_token,
                'voucher_applied' => $this->appliedVoucher !== null,
            ]);

            // Redirect to payment page
            return redirect()->route('payment.show', [
                'token' => $booking->booking_token,
                'snap_token' => $paymentResult['snap_token'],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Booking creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'voucher_code' => $this->voucherCode,
                'customer_email' => $this->customerEmail,
            ]);

            // ✅ User-friendly error message
            if (strpos($e->getMessage(), 'Could not resolve host') !== false) {
                session()->flash('error', 'Koneksi ke server pembayaran gagal. Silakan cek koneksi internet dan coba lagi.');
            } elseif (strpos($e->getMessage(), 'SSL certificate') !== false) {
                session()->flash('error', 'Terjadi masalah sertifikat keamanan. Silakan hubungi admin.');
            } else {
                session()->flash('error', 'Gagal membuat booking: ' . $e->getMessage());
            }
        }
    }


    // ============================================
    // STEP NAVIGATION
    // ============================================

    public function goToStep($step)
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    public function nextToAddons()
    {
        if (!$this->selectedStartDate) {
            session()->flash('error', 'Silakan pilih tanggal terlebih dahulu.');
            return;
        }

        $this->currentStep = 3;
    }

    public function nextToSummary()
    {
        $this->calculateAddonsTotal();
        $this->currentStep = 4;
    }

    // ============================================
    // RENDER
    // ============================================

    public function render()
    {
        // Generate calendar days
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Get day of week for first day (0 = Sunday, 6 = Saturday)
        $startDayOfWeek = $startOfMonth->dayOfWeek;

        // Generate calendar grid
        $calendarDays = [];

        // Add empty cells for days before month starts
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $calendarDays[] = null;
        }

        // Add days of month
        for ($day = 1; $day <= $endOfMonth->day; $day++) {
            $calendarDays[] = Carbon::create($this->currentYear, $this->currentMonth, $day);
        }

        $addons = Addon::active()->get();

        return view('livewire.booking-flow', [
            'calendarDays' => $calendarDays,
            'monthName' => $startOfMonth->format('F Y'),
            'addons' => $addons,
        ]);
    }
}
