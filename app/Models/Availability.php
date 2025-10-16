<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Availability extends Model
{
    protected $table = 'availability';

    protected $fillable = [
        'product_id',
        'date',
        'available_units',
        'availability_unit',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // ===== relationships =======
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    // ===== scope =======
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
    public function scopeOnDate($query, $date)
    {
        return $query->where('date', Carbon::parse($date)->toDateString());
    }
    public function scopeAvailable($query)
    {
        return $query
            ->whereNotNull('available_units')
            ->where('available_units', '>', 0);
    }

    // ========== methods ==========
    public function hasAvailableUnits($needed = 1)
    {
        return $this->available_unit !== null && $this->available_units >= $needed;
    }

    public function hasAvailableSeats($needed = 1)
    {
        return $this->availability_seat !== null && $this->availability_seat >= $needed;
    }

    public function decreaseUnits($qty)
    {
        if ($this->available_unit !== null) {
            $this->available_unit = max(0, $this->available_unit - $qty);
            $this->save();
        }
    }

    public function decreaseSeats($qty)
    {
        if ($this->availability_seat !== null) {
            $this->availability_seat = max(0, $this->availability_seat - $qty);
            $this->save();
        }
    }

    public function increaseUnits($qty)
    {
        if ($this->available_unit !== null) {
            $this->available_unit += $qty;
            $this->save();
        }
    }

    public function increaseSeats($qty)
    {
        if ($this->availability_seat !== null) {
            $this->availability_seat += $qty;
            $this->save();
        }
    }
}
