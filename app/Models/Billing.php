<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Billing extends Model
{


    protected $fillable = [
        'type',
        'reference_id',
        'sqft',
        'qty',
        'rate',
        'total',
        'wages',
        'material_type',
        'food',
        'transport',
        'no_of_days',
        'work_dates',  // Add work_dates to the fillable attributes
    ];

    // Optionally, you can create an accessor to parse the work_dates column if needed.
    // public function getWorkDatesAttribute($value)
    // {
    //     Log::Channel('query_log')->info('work_dates', ['value' => $value]);
    //     return explode(',', $value);
    // }

    public function material() {
        return $this->belongsTo(Material::class, 'reference_id');
    }

    public function worker() {
        return $this->belongsTo(Worker::class, 'reference_id');
    }

}
