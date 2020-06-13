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

    public function getPriceAttribute()
    {
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
