<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMlmPrize extends Model
{


    use SoftDeletes;

    protected $table = 'product_mlm_prize';

    protected $guarded = [];
}
