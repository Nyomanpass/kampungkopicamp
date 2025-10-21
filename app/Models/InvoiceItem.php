<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'qty',
        'unit_price',
        'subtotal',
        'meta',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'meta' => 'array',
    ];

    // ===== relationships =======
      public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // ========== methods ==========
    public function calculateSubtotal()
    {
        $this->subtotal = $this->qty * $this->unit_price;
        $this->save();

        return $this->subtotal;
    }
}
