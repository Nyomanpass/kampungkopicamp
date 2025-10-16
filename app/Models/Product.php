<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    protected $fillable = [
        'name',
        'type',
        'price',
        'capacity_per_unit',
        'max_participant',
        'duration_type',
        'images',
        'facilities',
        'is_active',
    ];


    // ====== relationship ====
    public function availability(){
        return $this->hasMany(Availability::class, 'product_id');
    }

    public function getAvailabilityForDate($date)
    {
        return $this->availability()->onDate($date)->first();
    }

    public function isAvailableForDateRange($startDate, $endDate, $unitsNeeded = 1, $seatsNeeded = 1){
        
        $dates = $this->availability()
        ->dateRange($startDate, $endDate)
        ->get();

        foreach($dates as $availability){
            if($this->type === 'accomodation'){
                if(!$availability->hasAvailableUnits($unitsNeeded)){
                    return false;
                }
            } elseif($this->type === 'touring'){
                if(!$availability->hasAvailableSeats($seatsNeeded)){
                    return false;
                }
            }
        }

        return true;
    }


}
