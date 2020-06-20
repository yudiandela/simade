<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odb extends Model
{
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'locn_x' => 'float',
        'locn_y' => 'float',
    ];
}
