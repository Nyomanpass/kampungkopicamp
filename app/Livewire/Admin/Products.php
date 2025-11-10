<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Availability;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Products extends Component
{
    use WithPagination, WithFileUploads;


    // ============================================
    // PROPERTIES
    // ============================================

    // view mode
    public $viewMode = 'list';

    //filters
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    //form properties
    public $productId;
    public $name = '';
    public $type = 'accommodation';
    public $description;
    public $price;
    public $capacity_per_unit = 2;
    public $max_participant = 10;
    public $duration_type = 'daily';
    public $default_units = 20;
    public $default_seats = 20;
    public $facilities = [];
    public $is_active = true;

    // image upload
    public $images = [];
    public $existingImages = [];
    public $imagesToDelete = [];

    // modals
    public $showDeleteModal = false;
    public $productToDelete;

    // statistics
    public $stats = [
        'total' => 0,
        'active' => 0,
        'inactive' => 0,
        'accommodation' => 0,
        'touring' => 0,
        'area_rental' => 0,
    ];

    //facilities management
    public $facilityInput = '';
    public $availableFacilities = [
        'WiFi',
        'Air Conditioner',
        'Bathroom',
        'Kitchen',
        'Parking',
        'BBQ Area',
        'Fire Pit',
        'Electricity',
        'Water Supply',
        'Tent Equipment',
        'Sleeping Bag',
        'Mattress',
    ];

    //quick availability override
    public $showQuickOverrideModal = false;
    public $overrideProductId;
    public $overrideDateRange = [];
    public $overrideStartDate;
    public $overrideEndDate;
    public $overrideUnits;
    public $overrideSeats;
    public $overrideReason;

    // validation rules
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:accommodation,touring,area_rental',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_type' => 'required|in:daily,hourly,multi_day',
            'images.*' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'default_units' => 'nullable|integer|min:0',
            'default_seats' => 'nullable|integer|min:0',
        ];

        if ($this->type === 'touring') {
            $rules['max_participant'] = 'required|integer|min:1';
            $rules['capacity_per_unit'] = 'nullable'; // Not needed for touring
        } else {
            // accommodation or area_rental
            $rules['capacity_per_unit'] = 'required|integer|min:1';
            $rules['max_participant'] = 'nullable'; // Not needed
        }

        return $rules;
    }
    protected $messages = [
        'capacity_per_unit.required' => 'Capacity per unit is required for accommodation and area rental.',
        'max_participant.required' => 'Max participant is required for touring products.',
    ];


    // ============================================
    // LIFECYCLE HOOKS
    // ============================================

    public function mount()
    {
        $this->loadStatistics();
    }

    public function updatingSearch()
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

    // load statistics
    private function loadStatistics()
    {
        $this->stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'accommodation' => Product::where('type', 'accommodation')->count(),
            'touring' => Product::where('type', 'touring')->count(),
            'area_rental' => Product::where('type', 'area_rental')->count(),
        ];
    }

    // view mode switching
    public function switchToList()
    {
        $this->viewMode = 'list';
        $this->resetForm();
    }

    public function switchToCreate()
    {
        $this->resetForm();
        $this->viewMode = 'create';
    }

    public function switchToEdit($id)
    {
        $this->resetForm();
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->type = $product->type;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->duration_type = $product->duration_type;
        $this->facilities = $product->facilities ?? [];
        $this->is_active = $product->is_active;
        $this->existingImages = $product->images ?? [];

        // ✅ Load conditional fields based on type
        if ($product->type === 'touring') {
            $this->max_participant = $product->max_participant ?? 10;
            $this->capacity_per_unit = null; // Not used for touring
        } else {
            $this->capacity_per_unit = $product->capacity_per_unit ?? 2;
            $this->max_participant = null; // Not used for accommodation/area_rental
        }

        $this->viewMode = 'edit';
    }

    // reset form
    private function resetForm()
    {
        $this->reset([
            'productId',
            'name',
            'type',
            'description',
            'price',
            'capacity_per_unit',
            'max_participant',
            'duration_type',
            'default_units',
            'default_seats',
            'facilities',
            'facilityInput',
            'is_active',
            'images',
            'existingImages',
            'imagesToDelete',
        ]);

        $this->type = 'accommodation';
        $this->duration_type = 'daily';
        $this->is_active = true;

        $this->capacity_per_unit = 2;
        $this->max_participant = null;
        $this->default_units = 20;
        $this->default_seats = 20;
        $this->facilities = [];
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'typeFilter']);
        $this->resetPage();
    }


    // ============================================
    // CREATE PRODUCT
    // ============================================

    public function createProduct()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Upload images
            $imageUrls = $this->uploadImages();

            $productData = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'type' => $this->type,
                'description' => $this->description,
                'price' => $this->price,
                'duration_type' => $this->duration_type,
                'facilities' => $this->facilities,
                'images' => $imageUrls,
                'is_active' => $this->is_active,
            ];

            if ($this->type === 'touring') {
                $productData['max_participant'] = $this->max_participant;
                $productData['capacity_per_unit'] = null; // Not applicable
            } else {
                // accommodation or area_rental
                $productData['capacity_per_unit'] = $this->capacity_per_unit;
                $productData['max_participant'] = null; // Not applicable
            }

            // Create product
            $product = Product::create($productData);

            $this->generateInitialAvailability(
                $product,
                $this->type === 'touring' ? 0 : $this->default_units,  // units hanya untuk non-touring
                $this->type === 'touring' ? $this->default_seats : 0   // seats hanya untuk touring
            );

            DB::commit();

            session()->flash('success', 'Produk berhasil dibuat!');
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat produk: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuat produk: ' . $e->getMessage());
        }
    }


    // ============================================
    // UPDATE PRODUCT
    // ============================================

    public function updateProduct()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($this->productId);

            // Handle image deletions
            if (!empty($this->imagesToDelete)) {
                foreach ($this->imagesToDelete as $imageUrl) {
                    $imagePath = str_replace('/storage/', '', $imageUrl);
                    Storage::disk('public')->delete($imagePath);

                    $this->existingImages = array_values(
                        array_filter($this->existingImages, fn($img) => $img !== $imageUrl)
                    );
                }
            }

            // Upload new images
            $newImageUrls = $this->uploadImages();

            // Merge existing + new images
            $allImages = array_merge($this->existingImages, $newImageUrls);

            // ✅ Prepare update data based on type
            $updateData = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'type' => $this->type,
                'description' => $this->description,
                'price' => $this->price,
                'duration_type' => $this->duration_type,
                'facilities' => $this->facilities,
                'images' => $allImages,
                'is_active' => $this->is_active,
            ];

            // ✅ Conditional fields based on type
            if ($this->type === 'touring') {
                $updateData['max_participant'] = $this->max_participant;
                $updateData['capacity_per_unit'] = null;
            } else {
                // accommodation or area_rental
                $updateData['capacity_per_unit'] = $this->capacity_per_unit;
                $updateData['max_participant'] = null;
            }

            // Update product
            $product->update($updateData);

            DB::commit();

            session()->flash('success', 'Produk berhasil diperbarui!');
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui produk: ' . $e->getMessage());
            session()->flash('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }



    // ============================================
    // UPLOAD IMAGES
    // ============================================

    private function uploadImages()
    {
        $imageUrls = [];

        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                // Store with unique name
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');
                $imageUrls[] = '/storage/' . $path;
            }
        }

        return $imageUrls;
    }

    public function markImageForDeletion($imageUrl)
    {
        $this->imagesToDelete[] = $imageUrl;
        $this->existingImages = array_values(
            array_filter($this->existingImages, fn($img) => $img !== $imageUrl)
        );
    }

    public function setMainImage($imageUrl)
    {
        // Remove from current position
        $this->existingImages = array_values(
            array_filter($this->existingImages, fn($img) => $img !== $imageUrl)
        );

        // Add to beginning (index 0 = main image)
        array_unshift($this->existingImages, $imageUrl);
    }

    public function toggleActive($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update(['is_active' => !$product->is_active]);

            session()->flash('success', 'Product status updated successfully!');
            $this->loadStatistics();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update product status.');
        }
    }


    // ============================================
    // DELETE PRODUCT
    // ============================================

    public function confirmDelete($id)
    {
        $this->productToDelete = Product::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($this->productToDelete->id);

            // Delete images from storage
            if (!empty($product->images)) {
                foreach ($product->images as $imageUrl) {
                    $imagePath = str_replace('/storage/', '', $imageUrl);
                    Storage::disk('public')->delete($imagePath);
                }
            }

            // Delete related availability (optional - or keep for history)
            // $product->availability()->delete();

            // Delete product
            $product->delete();

            DB::commit();

            session()->flash('success', 'Product deleted successfully!');
            $this->showDeleteModal = false;
            $this->switchToList();
            $this->loadStatistics();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete product: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete product.');
        }
    }


    // ============================================
    // GENERATE INITIAL AVAILABILITY
    // ============================================

    private function generateInitialAvailability(Product $product, int $defaultUnits = 10, int $defaultSeats = 20)
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addMonths(2);
        $current = $startDate->copy();

        // Determine stock based on product type
        $availableUnit = $product->type === 'touring' ? 0 : $defaultUnits;
        $availableSeat = $product->type === 'touring' ? $defaultSeats : 0;

        while ($current->lte($endDate)) {
            Availability::create([
                'product_id' => $product->id,
                'date' => $current->format('Y-m-d') . ' 00:00:00',
                'available_unit' => $availableUnit,
                'available_seat' => $availableSeat,
                'is_overridden' => false,
            ]);

            $current->addDay();
        }

        Log::info("Initial availability generated for product: {$product->name}", [
            'product_id' => $product->id,
            'type' => $product->type,
            'default_units' => $availableUnit,
            'default_seats' => $availableSeat,
            'date_range' => $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'),
        ]);
    }

    // ============================================
    // FACLITIES
    // ============================================


    public function addFacility($facility)
    {
        if (!in_array($facility, $this->facilities)) {
            $this->facilities[] = $facility;
        }
    }

    public function addCustomFacility()
    {
        if (!empty($this->facilityInput)) {
            $facility = trim($this->facilityInput);

            if (!in_array($facility, $this->facilities)) {
                $this->facilities[] = $facility;

                // Also add to available facilities for future use
                if (!in_array($facility, $this->availableFacilities)) {
                    $this->availableFacilities[] = $facility;
                }
            }

            $this->facilityInput = '';
        }
    }

    public function removeFacility($index)
    {
        unset($this->facilities[$index]);
        $this->facilities = array_values($this->facilities);
    }


    // ============================================
    // QUICK AVAILABILITY OVERRIDE
    // ============================================

    public function openQuickOverride($productId)
    {
        $this->resetOverrideForm();
        $this->overrideProductId = $productId;

        $product = Product::findOrFail($productId);

        // Set default values based on product type
        if ($product->type === 'touring') {
            $this->overrideUnits = 0;
            $this->overrideSeats = $this->default_seats;
        } else {
            $this->overrideUnits = $this->default_units;
            $this->overrideSeats = 0;
        }

        // Set default date range (today + 7 days)
        $this->overrideStartDate = Carbon::today()->format('Y-m-d');
        $this->overrideEndDate = Carbon::today()->addDays(7)->format('Y-m-d');

        $this->showQuickOverrideModal = true;
    }

    private function resetOverrideForm()
    {
        $this->reset([
            'overrideProductId',
            'overrideStartDate',
            'overrideEndDate',
            'overrideUnits',
            'overrideSeats',
            'overrideReason',
        ]);
    }

    public function applyQuickOverride()
    {
        $this->validate([
            'overrideStartDate' => 'required|date',
            'overrideEndDate' => 'required|date|after_or_equal:overrideStartDate',
            'overrideUnits' => 'nullable|integer|min:0',
            'overrideSeats' => 'nullable|integer|min:0',
            'overrideReason' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($this->overrideProductId);
            $startDate = Carbon::parse($this->overrideStartDate);
            $endDate = Carbon::parse($this->overrideEndDate);
            $current = $startDate->copy();

            $overriddenCount = 0;

            while ($current->lte($endDate)) {
                $dateString = $current->format('Y-m-d');

                // Find or create availability
                $availability = Availability::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'date' => $dateString . ' 00:00:00',
                    ],
                    [
                        'available_unit' => $this->overrideUnits ?? 0,
                        'available_seat' => $this->overrideSeats ?? 0,
                        'is_overridden' => false,
                    ]
                );

                // Update with override
                $availability->update([
                    'available_unit' => $this->overrideUnits ?? $availability->available_unit,
                    'available_seat' => $this->overrideSeats ?? $availability->available_seat,
                    'is_overridden' => true,
                    'override_reason' => $this->overrideReason,
                    'overridden_by' => auth()->id(),
                    'overridden_at' => now(),
                ]);

                $overriddenCount++;
                $current->addDay();
            }

            DB::commit();

            Log::info("Quick availability override applied", [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'date_range' => $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'),
                'units' => $this->overrideUnits,
                'seats' => $this->overrideSeats,
                'total_days' => $overriddenCount,
                'reason' => $this->overrideReason,
            ]);

            session()->flash('success', "Availability overridden for {$overriddenCount} days successfully!");
            $this->showQuickOverrideModal = false;
            $this->resetOverrideForm();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to apply quick override: ' . $e->getMessage());
            session()->flash('error', 'Failed to override availability: ' . $e->getMessage());
        }
    }



    // ============================================
    // RENDER
    // ============================================


    #[Layout('layouts.admin')]

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === '1');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        return view('livewire.admin.products', [
            'products' => $products,
        ]);
    }
}
