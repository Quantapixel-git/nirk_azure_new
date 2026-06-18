<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PTRange extends Model
{


    use SoftDeletes;

    protected $table = 'ptcoins_ranges';

    protected $guarded = [];
}
