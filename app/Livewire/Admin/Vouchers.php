<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

#[Layout('layouts.admin')]
class Vouchers extends Component
{
    use WithPagination;

    // ===== VIEW MODES =====
    public $viewMode = 'list'; // list, create, edit

    // ===== FORM FIELDS =====
    public $voucherId;
    public $code;
    public $name;
    public $description;
    public $type = 'percentage';
    public $value = 0;
    public $min_order = 0;
    public $max_discount;
    public $usage_limit;
    public $user_usage_limit;
    public $start_date;
    public $end_date;
    public $is_active = true;
    public $show_in_dashboard = false;

    // ===== FILTERS & SEARCH =====
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';

    // ===== STATISTICS =====
    public $stats = [
        'total' => 0,
        'active' => 0,
        'expired' => 0,
        'scheduled' => 0,
        'total_redemptions' => 0,
        'total_discount_given' => 0,
    ];

    // ===== LIFECYCLE HOOKS =====
    public function mount()
    {
        $this->loadStatistics();
    }

    // ===== VALIDATION RULES =====
    protected function rules()
    {
        $rules = [
            'code' => 'required|string|max:50|unique:vouchers,code,' . ($this->voucherId ?? 'NULL'),
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed,bonus',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'user_usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'show_in_dashboard' => 'boolean',
        ];

        // Conditional validation
        if ($this->type === 'percentage') {
            $rules['value'] = 'required|numeric|min:1|max:100';
        }

        return $rules;
    }

    protected $messages = [
        'code.unique' => 'Voucher code already exists.',
        'start_date.required' => 'Start date is required.',
        'end_date.required' => 'End date is required.',
        'end_date.after_or_equal' => 'End date must be after or equal to start date.',
    ];

    // ===== VIEW SWITCHING =====
    public function switchToList()
    {
        $this->viewMode = 'list';
        $this->resetForm();
        $this->resetPage();
    }

    public function switchToCreate()
    {
        $this->resetForm();
        $this->viewMode = 'create';
        $this->generateCode();
    }

    public function switchToEdit($id)
    {
        $this->resetForm();
        $voucher = Voucher::findOrFail($id);

        $this->voucherId = $voucher->id;
        $this->code = $voucher->code;
        $this->name = $voucher->name;
        $this->description = $voucher->description;
        $this->type = $voucher->type;
        $this->value = $voucher->value;
        $this->min_order = $voucher->min_order;
        $this->max_discount = $voucher->max_discount;
        $this->usage_limit = $voucher->usage_limit;
        $this->user_usage_limit = $voucher->user_usage_limit;
        $this->start_date = $voucher->start_date ? $voucher->start_date->format('Y-m-d\TH:i') : null;
        $this->end_date = $voucher->end_date ? $voucher->end_date->format('Y-m-d\TH:i') : null;
        $this->is_active = $voucher->is_active;
        $this->show_in_dashboard = $voucher->show_in_dashboard;

        $this->viewMode = 'edit';
    }

    private function resetForm()
    {
        $this->reset([
            'voucherId',
            'code',
            'name',
            'description',
            'type',
            'value',
            'min_order',
            'max_discount',
            'usage_limit',
            'user_usage_limit',
            'start_date',
            'end_date',
            'is_active',
            'show_in_dashboard',
        ]);

        $this->type = 'percentage';
        $this->value = 0;
        $this->min_order = 0;
        $this->is_active = true;
        $this->show_in_dashboard = false;
    }

    // ===== CODE GENERATION =====
    public function generateCode()
    {
        do {
            $this->code = 'PROMO-' . strtoupper(Str::random(6));
        } while (Voucher::where('code', $this->code)->exists());
    }

    // ===== CRUD OPERATIONS =====

    public function createVoucher()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            Voucher::create([
                'code' => strtoupper($this->code),
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->type,
                'value' => $this->value,
                'min_order' => $this->min_order ?: 0,
                'max_discount' => $this->max_discount,
                'usage_limit' => $this->usage_limit,
                'user_usage_limit' => $this->user_usage_limit,
                'start_date' => Carbon::parse($this->start_date),
                'end_date' => Carbon::parse($this->end_date),
                'is_active' => $this->is_active,
                'show_in_dashboard' => $this->show_in_dashboard,
            ]);

            DB::commit();

            session()->flash('success', 'Voucher created successfully!');
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create voucher: ' . $e->getMessage());
            session()->flash('error', 'Failed to create voucher: ' . $e->getMessage());
        }
    }

    public function updateVoucher()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $voucher = Voucher::findOrFail($this->voucherId);

            // Check if reducing usage limit below current usage
            if ($this->usage_limit && $voucher->redemptions()->count() > $this->usage_limit) {
                session()->flash('error', 'Cannot set usage limit below current redemption count.');
                return;
            }

            $voucher->update([
                'code' => strtoupper($this->code),
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->type,
                'value' => $this->value,
                'min_order' => $this->min_order ?: 0,
                'max_discount' => $this->max_discount,
                'usage_limit' => $this->usage_limit,
                'user_usage_limit' => $this->user_usage_limit,
                'start_date' => Carbon::parse($this->start_date),
                'end_date' => Carbon::parse($this->end_date),
                'is_active' => $this->is_active,
                'show_in_dashboard' => $this->show_in_dashboard,
            ]);

            DB::commit();

            session()->flash('success', 'Voucher updated successfully!');
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update voucher: ' . $e->getMessage());
            session()->flash('error', 'Failed to update voucher: ' . $e->getMessage());
        }
    }

    public function deleteVoucher($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);

            // Check if voucher has redemptions
            if ($voucher->redemptions()->count() > 0) {
                session()->flash('error', 'Cannot delete voucher with existing redemptions. Deactivate instead.');
                return;
            }

            $voucher->delete();

            session()->flash('success', 'Voucher deleted successfully!');
            $this->loadStatistics();
        } catch (\Exception $e) {
            Log::error('Failed to delete voucher: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete voucher: ' . $e->getMessage());
        }
    }

    // ===== QUICK ACTIONS =====

    public function toggleStatus($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->update(['is_active' => !$voucher->is_active]);

            session()->flash('success', 'Voucher status updated!');
            $this->loadStatistics();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update status.');
        }
    }

    public function duplicateVoucher($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);

            // Generate new unique code
            do {
                $newCode = 'PROMO-' . strtoupper(Str::random(6));
            } while (Voucher::where('code', $newCode)->exists());

            $newVoucher = $voucher->replicate();
            $newVoucher->code = $newCode;
            $newVoucher->name = $voucher->name . ' (Copy)';
            $newVoucher->save();

            session()->flash('success', 'Voucher duplicated successfully!');
            $this->loadStatistics();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate voucher.');
        }
    }

    // ===== FILTERS =====

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    // ===== STATISTICS =====

    private function loadStatistics()
    {
        $this->stats = [
            'total' => Voucher::count(),
            'active' => Voucher::valid()->count(),
            'expired' => Voucher::expired()->count(),
            'scheduled' => Voucher::scheduled()->count(),
            'total_redemptions' => \App\Models\VoucherRedemption::count(),
            'total_discount_given' => \App\Models\VoucherRedemption::sum('discount_amount'),
        ];
    }

    // ===== RENDER =====

    public function render()
    {
        $query = Voucher::query()->withCount('redemptions');

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply type filter
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        // Apply status filter
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'expired') {
            $query->expired();
        } elseif ($this->statusFilter === 'scheduled') {
            $query->scheduled();
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $vouchers = $query->latest()->paginate(10);

        return view('livewire.admin.vouchers', [
            'vouchers' => $vouchers,
        ]);
    }
}
