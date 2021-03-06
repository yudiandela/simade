<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'estimated_time' => 'date',
        'verificator_1_date' => 'date',
        'verificator_2_date' => 'date',
        'manager_1_date' => 'date',
        'manager_2_date' => 'date',
        'deployment_1_date' => 'date',
        'deployment_2_date' => 'date',
        'work_date' => 'date',
    ];

    public function getPriceAttribute()
    {
        if ($this->price_to == null) {
            return '> ' . $this->checkPrice($this->price_from);
        }

        return $this->checkPrice($this->price_from) . ' - ' . $this->checkPrice($this->price_to);
    }

    private function checkPrice($value)
    {
        if ($value / 1000 == 1) {
            return '1 juta';
        }

        return $value . ' rb';
    }
}
