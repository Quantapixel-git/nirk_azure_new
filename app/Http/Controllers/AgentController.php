<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AgentCommission;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Str;




class AgentController extends Controller
{

public function agentDashboard()
{
    $totalUsers = User::where('referred_by', Auth::id())
        ->where('user_type', 'customer')
        ->count();

    $totalVendors = User::where('referred_by', Auth::id())
        ->where('user_type', 'seller')
        ->count();

    $todayUsers = User::where('referred_by', Auth::id())
        ->where('user_type', 'customer')
        ->whereDate('created_at', today())
        ->count();

    $todayVendors = User::where('referred_by', Auth::id())
        ->where('user_type', 'seller')
        ->whereDate('created_at', today())
        ->count();


        $target = DB::table('agent_targets')
            ->where('agent_id',Auth::id())
            ->first();

$userTarget = $target->user_target ?? 0;
$vendorTarget = $target->vendor_target ?? 0;

$totalUsers = User::where('referred_by', Auth::id())
    ->where('user_type','customer')
    ->count();

$totalVendors = User::where('referred_by', Auth::id())
    ->where('user_type','seller')
    ->count();

$userTargetCompleted =
    $userTarget > 0 &&
    $totalUsers >= $userTarget;

$vendorTargetCompleted =
    $vendorTarget > 0 &&
    $totalVendors >= $vendorTarget;

    $totalUsersCreated = User::where('referred_by', Auth::id())
    ->where('user_type', 'customer')
    ->count();

$totalVendorsCreated = User::where('referred_by', Auth::id())
    ->where('user_type', 'seller')
    ->count();

    return view('agent.dashboard', compact(
        'totalUsers',
        'totalVendors',
        'todayUsers',
        'todayVendors',
        'userTarget',
       
        'vendorTarget',
        'target',
        'userTargetCompleted',
        'vendorTargetCompleted',
        'totalUsersCreated',
'totalVendorsCreated',
    ));
}


public function profile()
{
    $user = Auth::user();

    return view('agent.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = User::where('id', Auth::id())
                ->where('user_type', 'agent')
                ->firstOrFail();

    $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email|unique:users,email,' . $user->id,
        'phone'            => 'required',
        'password'          => 'nullable|min:6|same:confirm_password',
        'confirm_password'  => 'nullable|min:6'
    ]);

    $user->name   = $request->name;
    $user->email  = $request->email;
    $user->phone = $request->phone;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with([
        'flash_notification' => collect([
            [
                'level' => 'success',
                'message' => 'Profile updated successfully'
            ]
        ])
    ]);
}


public function users(Request $request)
{
    $status = $request->status ?? 'active';

    $users = User::where('referred_by', Auth::id())
        ->where('user_type', 'customer');

    if ($status == 'active') {
        $users->where('is_active', 1);
    } else {
        $users->where('is_active', 2);
    }

    $users = $users->latest()->paginate(20);

    return view('agent.users.index', compact('users', 'status'));
}

public function createUser()
{
    return view('agent.users.create');
}

public function storeUser(Request $request)
{
    $request->validate([
        'name'              => 'required',
        'email'             => 'required|email|unique:users,email',
        'phone'             => 'required|unique:users,phone',
        'password'          => 'required|min:6',
        'confirm_password'  => 'required|same:password',
    ]);

    do {

        $referralCode = strtoupper(
            substr(md5(time().rand()),0,8)
        );

    } while (
        User::where('referral_code',$referralCode)->exists()
    );

    User::create([

        'name'          => $request->name,
        'email'         => $request->email,
        'phone'         => $request->phone,

        'password'      => Hash::make($request->password),

        'user_type'     => 'customer',

        'referred_by'   => Auth::id(),

        'referral_code' => $referralCode,

        'email_verified_at' => now()
    ]);

    flash(translate('User Created Successfully'))->success();

    return redirect()->route('agent.users');
}




public function userOrders($id)
{
    $userId = decrypt($id);

    $user = User::where('id',$userId)
                ->where('referred_by',Auth::id())
                ->firstOrFail();

    $orders = Order::where('user_id',$user->id)
                    ->latest()
                    ->paginate(20);

    return view(
        'agent.users.orders',
        compact('user','orders')
    );
}

public function orderDetails($id)
{
    $order = Order::findOrFail(decrypt($id));

    $customer = User::where('id', $order->user_id)
                    ->where('referred_by', Auth::id())
                    ->first();

    if (!$customer) {
        abort(403);
    }

    return view(
        'agent.orders.details',
        compact('order', 'customer')
    );
}


public function vendors()
{
    $vendors = User::where('referred_by', Auth::id())
                    ->where('user_type', 'seller')
                    ->latest()
                    ->paginate(20);

    return view(
        'agent.vendors.index',
        compact('vendors')
    );
}

public function createVendor()
{
    return view('agent.vendors.create');
}

public function storeVendor(Request $request)
{
    $request->validate([
        'name'              => 'required',
        'email'             => 'required|email|unique:users,email',
        'phone'             => 'required|unique:users,phone',
        'password'          => 'required|min:6',
        'confirm_password'  => 'required|same:password',

        'shop_name'         => 'required',
        'address'           => 'required',
    ]);

    do {

        $referralCode = strtoupper(
            substr(md5(time().rand()), 0, 8)
        );

    } while (
        User::where('referral_code', $referralCode)->exists()
    );

   $vendor = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'password' => Hash::make($request->password),

    'referred_by' => Auth::id(),
    'referral_code' => $referralCode,
    'email_verified_at' => now()
]);

$vendor->user_type = 'seller';
$vendor->save();

    DB::table('shops')->insert([

    'user_id' => $vendor->id,

    'name' => $request->shop_name,

    'address' => $request->address,

    'created_at' => now(),

    'updated_at' => now()
]);

    flash(translate('Vendor Created Successfully'))->success();

    return redirect()->route('agent.vendors');
}
}
