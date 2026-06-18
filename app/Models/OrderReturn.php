<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderReturn extends Model
{


    use SoftDeletes;

    protected $table = 'order_returns';

    protected $guarded = [];

    protected $casts = [
    'status' => 'integer',
];
}


