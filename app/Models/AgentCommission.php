<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class AgentCommission extends Model
{


    use SoftDeletes;

    protected $table = 'agent_commission';

    protected $guarded = [];

   
}
