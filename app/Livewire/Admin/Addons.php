<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Addon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Addons extends Component
{
    use WithPagination, WithFileUploads;

    // ===== VIEW MODES =====
    public $viewMode = 'list'; // list, create, edit

    // ===== FORM FIELDS =====
    public $addonId;
    public $name;
    public $pricing_type = 'per_booking';
    public $price = 0;
    public $description;
    public $image;
    public $existingImage;
    public $has_inventory = false;
    public $stock_quantity;
    public $low_stock_threshold = 5;
    public $min_quantity = 1;
    public $max_quantity;
    public $is_active = true;

    // ===== FILTERS & SEARCH =====
    public $search = '';
    public $pricingTypeFilter = '';
    public $statusFilter = '';
    public $inventoryFilter = '';
    public $stockFilter = '';

    // ===== STOCK ADJUSTMENT MODAL =====
    public $showStockModal = false;
    public $stockAddonId;
    public $stockAdjustmentType = 'add'; // add, reduce
    public $stockAdjustmentQuantity;
    public $stockAdjustmentReason;

    // ===== STATISTICS =====
    public $stats = [
        'total' => 0,
        'active' => 0,
        'inactive' => 0,
        'with_inventory' => 0,
        'low_stock' => 0,
        'out_of_stock' => 0,
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
            'name' => 'required|string|max:255',
            'pricing_type' => 'required|in:per_booking,per_unit_per_night,per_person,per_hour,per_slot',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'has_inventory' => 'boolean',
            'min_quantity' => 'required|integer|min:1',
            'max_quantity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ];

        // Conditional validation for inventory
        if ($this->has_inventory) {
            $rules['stock_quantity'] = 'required|integer|min:0';
            $rules['low_stock_threshold'] = 'required|integer|min:0';
        }

        return $rules;
    }

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
    }

    public function switchToEdit($id)
    {
        $this->resetForm();
        $addon = Addon::findOrFail($id);

        $this->addonId = $addon->id;
        $this->name = $addon->name;
        $this->pricing_type = $addon->pricing_type;
        $this->price = $addon->price;
        $this->description = $addon->description;
        $this->existingImage = $addon->image;
        $this->has_inventory = $addon->has_inventory;
        $this->stock_quantity = $addon->stock_quantity;
        $this->low_stock_threshold = $addon->low_stock_threshold;
        $this->min_quantity = $addon->min_quantity;
        $this->max_quantity = $addon->max_quantity;
        $this->is_active = $addon->is_active;

        $this->viewMode = 'edit';
    }

    private function resetForm()
    {
        $this->reset(['addonId', 'name', 'pricing_type', 'price', 'description', 'image', 'existingImage', 'has_inventory', 'stock_quantity', 'low_stock_threshold', 'min_quantity', 'max_quantity', 'is_active']);

        $this->pricing_type = 'per_booking';
        $this->price = 0;
        $this->low_stock_threshold = 5;
        $this->min_quantity = 1;
        $this->is_active = true;
    }

    // ===== CRUD OPERATIONS =====

    public function createAddon()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Upload image
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('addons', 'public');
                $imagePath = '/storage/' . $imagePath;
            }

            // Create addon
            Addon::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'pricing_type' => $this->pricing_type,
                'price' => $this->price,
                'description' => $this->description,
                'image' => $imagePath,
                'has_inventory' => $this->has_inventory,
                'stock_quantity' => $this->has_inventory ? $this->stock_quantity : null,
                'low_stock_threshold' => $this->has_inventory ? $this->low_stock_threshold : 5,
                'min_quantity' => $this->min_quantity,
                'max_quantity' => $this->max_quantity,
                'is_active' => $this->is_active,
            ]);

            DB::commit();

            session()->flash('success', 'Addon created successfully!');
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create addon: ' . $e->getMessage());
            session()->flash('error', 'Failed to create addon: ' . $e->getMessage());
        }
    }

    public function updateAddon()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $addon = Addon::findOrFail($this->addonId);

            // Handle image upload
            $imagePath = $this->existingImage;
            if ($this->image) {
                // Delete old image
                if ($addon->image) {
                    $oldImagePath = str_replace('/storage/', '', $addon->image);
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Upload new image
                $imagePath = $this->image->store('addons', 'public');
                $imagePath = '/storage/' . $imagePath;
            }

            // Update addon
            $addon->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'pricing_type' => $this->pricing_type,
                'price' => $this->price,
                'description' => $this->description,
                'image' => $imagePath,
                'has_inventory' => $this->has_inventory,
                'stock_quantity' => $this->has_inventory ? $this->stock_quantity : null,
                'low_stock_threshold' => $this->has_inventory ? $this->low_stock_threshold : 5,
                'min_quantity' => $this->min_quantity,
                'max_quantity' => $this->max_quantity,
                'is_active' => $this->is_active,
            ]);

            DB::commit();

            session()->flash('success', 'Addon updated successfully!');
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update addon: ' . $e->getMessage());
            session()->flash('error', 'Failed to update addon: ' . $e->getMessage());
        }
    }

    public function deleteAddon($id)
    {
        try {
            $addon = Addon::findOrFail($id);

            // Check if addon has bookings
            // if ($addon->bookingAddons()->count() > 0) {
            //     session()->flash('error', 'Cannot delete addon with existing bookings. Deactivate instead.');
            //     return;
            // }

            // Delete image
            if ($addon->image) {
                $imagePath = str_replace('/storage/', '', $addon->image);
                Storage::disk('public')->delete($imagePath);
            }

            $addon->delete();

            session()->flash('success', 'Addon deleted successfully!');
            $this->loadStatistics();
        } catch (\Exception $e) {
            Log::error('Failed to delete addon: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete addon: ' . $e->getMessage());
        }
    }

    // ===== QUICK ACTIONS =====

    public function toggleStatus($id)
    {
        try {
            $addon = Addon::findOrFail($id);
            $addon->update(['is_active' => !$addon->is_active]);

            session()->flash('success', 'Addon status updated!');
            $this->loadStatistics();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update status.');
        }
    }

    // ===== STOCK MANAGEMENT =====

    public function openStockModal($id)
    {
        $this->stockAddonId = $id;
        $this->stockAdjustmentType = 'add';
        $this->stockAdjustmentQuantity = null;
        $this->stockAdjustmentReason = null;
        $this->showStockModal = true;
    }

    public function adjustStock()
    {
        $this->validate([
            'stockAdjustmentQuantity' => 'required|integer|min:1',
            'stockAdjustmentReason' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $addon = Addon::findOrFail($this->stockAddonId);

            if ($this->stockAdjustmentType === 'add') {
                $addon->increaseStock($this->stockAdjustmentQuantity);
                $message = "Added {$this->stockAdjustmentQuantity} units to stock";
            } else {
                if (!$addon->decreaseStock($this->stockAdjustmentQuantity)) {
                    session()->flash('error', 'Insufficient stock to reduce.');
                    return;
                }
                $message = "Reduced {$this->stockAdjustmentQuantity} units from stock";
            }

            // TODO: Log stock adjustment history

            DB::commit();

            session()->flash('success', $message);
            $this->showStockModal = false;
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to adjust stock: ' . $e->getMessage());
            session()->flash('error', 'Failed to adjust stock.');
        }
    }

    // ===== FILTERS =====

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPricingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedInventoryFilter()
    {
        $this->resetPage();
    }

    public function updatedStockFilter()
    {
        $this->resetPage();
    }

    // ===== STATISTICS =====

    private function loadStatistics()
    {
        $this->stats = [
            'total' => Addon::count(),
            'active' => Addon::where('is_active', true)->count(),
            'inactive' => Addon::where('is_active', false)->count(),
            'with_inventory' => Addon::where('has_inventory', true)->count(),
            'low_stock' => Addon::lowStock()->count(),
            'out_of_stock' => Addon::outOfStock()->count(),
        ];
    }

    // ===== RENDER =====

    public function render()
    {
        $query = Addon::query();

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filters
        if ($this->pricingTypeFilter) {
            $query->where('pricing_type', $this->pricingTypeFilter);
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->inventoryFilter === 'yes') {
            $query->where('has_inventory', true);
        } elseif ($this->inventoryFilter === 'no') {
            $query->where('has_inventory', false);
        }

        if ($this->stockFilter === 'low') {
            $query->lowStock();
        } elseif ($this->stockFilter === 'out') {
            $query->outOfStock();
        } elseif ($this->stockFilter === 'in') {
            $query->inStock();
        }

        $addons = $query->latest()->paginate(10);

        return view('livewire.admin.addons', [
            'addons' => $addons,
        ]);
    }
}
