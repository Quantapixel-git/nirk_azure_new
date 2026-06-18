<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PTValue extends Model
{


    use SoftDeletes;

    protected $table = 'ptcoins_value';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
