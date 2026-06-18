<?php

namespace App\Http\Controllers;

use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Str;



class AgentTargetController extends Controller
{

public function index()
{
    $agents = User::where('user_type', 'agent')->get();

    $targets = DB::table('agent_targets')
        ->join('users', 'agent_targets.agent_id', '=', 'users.id')
        ->select(
            'agent_targets.*',
            'users.name as agent_name'
        )
        ->get();

    foreach ($targets as $target) {

        $target->created_users = User::where('referred_by', $target->agent_id)
            ->where('user_type', 'customer')
            ->count();

        $target->created_vendors = User::where('referred_by', $target->agent_id)
            ->where('user_type', 'seller')
            ->count();

        $target->user_completed =
            $target->created_users >= $target->user_target;

        $target->vendor_completed =
            $target->created_vendors >= $target->vendor_target;
    }

    return view(
        'backend.agent_targets.index',
        compact('agents', 'targets')
    );
}

public function store(Request $request)
{
    $request->validate([
        'agent_id'      => 'required',
        'user_target'   => 'required|integer|min:0',
        'vendor_target' => 'required|integer|min:0',
    ]);

    DB::table('agent_targets')->updateOrInsert(
        [
            'agent_id' => $request->agent_id
        ],
        [
            'user_target'   => $request->user_target,
            'vendor_target' => $request->vendor_target,
            'updated_at'    => now(),
            'created_at'    => now()
        ]
    );

    flash('Target Assigned Successfully')->success();

    return back();
}
}
