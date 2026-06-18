<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class MLMWallet extends Model
{


    use SoftDeletes;

    protected $table = 'mlm_wallet';

    protected $guarded = [];
}


