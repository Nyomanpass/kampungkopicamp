<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'booking_id',
        'parent_invoice_id',
        'type',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // ===== relationships =======
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function parentInvoice()
    {
        return $this->belongsTo(Invoice::class, 'parent_invoice_id');
    }

    public function childInvoices()
    {
        return $this->hasMany(Invoice::class, 'parent_invoice_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // ========== scope ==========
    public function scopePrimary($query)
    {
        return $query->where('type', 'primary');
    }

    public function scopeAddonOnsite($query)
    {
        return $query->where('type', 'addon_onsite');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ========== methods ==========
    public function calculateAmount()
    {
        $this->amount = $this->items->sum('subtotal');
        $this->save();

        return $this->amount;
    }

    public function markAsPaid()
    {
        $this->update(['status' => 'paid']);
    }

    public function markAsVoid()
    {
        $this->update(['status' => 'void']);
    }

    public static function createFromBooking(Booking $booking)
    {
        $invoice = self::create([
            'booking_id' => $booking->id,
            'type' => 'primary',
            'amount' => $booking->total_price,
            'status' => 'pending',
        ]);

        // Create invoice items from booking items
        foreach ($booking->bookingItems as $bookingItem) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'name' => $bookingItem->getDisplayName(),
                'qty' => $bookingItem->qty,
                'unit_price' => $bookingItem->unit_price,
                'subtotal' => $bookingItem->subtotal,
                'meta' => [
                    'item_type' => $bookingItem->item_type,
                    'product_id' => $bookingItem->product_id,
                    'addon_id' => $bookingItem->addon_id,
                ],
            ]);
        }

        return $invoice;
    }

    public static function createOnsiteAddon(Booking $booking, array $items)
    {
        // Get primary invoice as parent
        $primaryInvoice = $booking->invoices()->primary()->first();

        $invoice = self::create([
            'booking_id' => $booking->id,
            'parent_invoice_id' => $primaryInvoice?->id,
            'type' => 'addon_onsite',
            'status' => 'pending',
        ]);

        // Create invoice items
        foreach ($items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'name' => $item['name'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['qty'] * $item['unit_price'],
                'meta' => $item['meta'] ?? null,
            ]);
        }

        $invoice->calculateAmount();

        return $invoice;
    }

    public function getInvoiceNumber()
    {
        return 'INV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
