<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PTRange;
use App\Models\PTValue;
use App\Models\Product;
use App\Models\MLMWallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;













class MLMUserController extends Controller
{

public function userwallet()
{
   $user = User::find(auth()->id());

    /*
    |--------------------------------------------------------------------------
    | MLM BLOCK CHECK
    |--------------------------------------------------------------------------
    */
    if ($user->mlm_status == 'blocked') {

        return view(
            'frontend.user.mlm_wallet',
            [
                'isBlocked' => true,
                'blockedAt' => $user->mlm_blocked_at
            ]
        );
    }

    $user_id = auth()->id();

    $user = User::find($user_id);

$refundedAmount = $user->mlm_wallet ?? 0;


    

    /* =========================
       WALLET TOTALS
    ========================= */
  $totalEarning = DB::table('mlm_wallet')
    ->where('user_id', $user_id)
    ->where('wallet_status', 1)
    ->sum('pt_value');

$totalWithdrawn = DB::table('mlm_withdraw_requests')
    ->where('user_id', $user_id)
    ->where('status', 'approved')
    ->sum('amount');

$totalWalletUsed = DB::table('orders')
    ->where('user_id', $user_id)
    ->sum('mlm_wallet_used');

$confirmedAmount =
    $totalEarning
    - $totalWithdrawn
    - $totalWalletUsed
    + $refundedAmount;

if ($confirmedAmount < 0) {
    $confirmedAmount = 0;
}

if($confirmedAmount < 0){
    $confirmedAmount = 0;
}

    $holdAmount = DB::table('mlm_wallet')
        ->where('user_id', $user_id)
        ->where('wallet_status', 2)
        ->sum('pt_value');
$earning = DB::table('mlm_wallet')
    ->where('user_id', $user_id)
    ->where('wallet_status', 1)
    ->sum('pt_value');

$withdrawn = DB::table('mlm_withdraw_requests')
    ->where('user_id', $user_id)
    ->whereIn('status', ['pending','approved'])
    ->sum('amount');

$totalWalletUsed = DB::table('orders')
    ->where('user_id', $user_id)
    ->sum('mlm_wallet_used');

$withdrawableAmount =
    $earning
    - $withdrawn
    - $totalWalletUsed
    + $refundedAmount;

if ($withdrawableAmount < 0) {
    $withdrawableAmount = 0;
}




// =========================
// MY NETWORK STATISTICS
// =========================

$networkStats = [];

for ($level = 1; $level <= 6; $level++) {

    if ($level == 1) {

        $users = User::where('referred_by', auth()->id())->get();

    } else {

        $parentIds = User::where('referred_by', auth()->id())
            ->pluck('id')
            ->toArray();

        for ($i = 2; $i <= $level; $i++) {
            $parentIds = User::whereIn('referred_by', $parentIds)
                ->pluck('id')
                ->toArray();
        }

        $users = User::whereIn('id', $parentIds)->get();
    }

   $orderCount = 0;

if ($level == 1) {

    foreach ($users as $u) {

        $u->level1_orders = DB::table('mlm_wallet')
            ->where('user_id', $u->id)
            ->where('level', 1)
            ->whereNotNull('order_id')
            ->distinct()
            ->count('order_id');
    }

    $orderCount = $users->sum('level1_orders');
}

    $networkStats[] = [
        'level' => 'Level '.$level,
        'count' => $users->count(),
        'orders' => $orderCount,
        'users' => $users
    ];

    $networkStats = collect($networkStats)
    ->filter(function ($item) {
        return $item['count'] > 0;
    })
    ->values()
    ->toArray();
}
    /* =========================
       FETCH MLM TRANSACTIONS
    ========================= */
    $transactions = DB::table('mlm_wallet as mw')

        ->leftJoin('users as wallet_user', 'wallet_user.id', '=', 'mw.user_id')

        ->leftJoin('users as ref1', 'ref1.referred_by', '=', 'wallet_user.id')
        ->leftJoin('users as ref2', 'ref2.referred_by', '=', 'ref1.id')
        ->leftJoin('users as ref3', 'ref3.referred_by', '=', 'ref2.id')
        ->leftJoin('users as ref4', 'ref4.referred_by', '=', 'ref3.id')
        ->leftJoin('users as ref5', 'ref5.referred_by', '=', 'ref4.id')
        ->leftJoin('users as ref6', 'ref6.referred_by', '=', 'ref5.id')

        ->leftJoin('orders as o', function ($join) {

            $join->on('o.user_id', '=', 'wallet_user.id')
                ->orOn('o.user_id', '=', 'ref1.id')
                ->orOn('o.user_id', '=', 'ref2.id')
                ->orOn('o.user_id', '=', 'ref3.id')
                ->orOn('o.user_id', '=', 'ref4.id')
                ->orOn('o.user_id', '=', 'ref5.id')
                ->orOn('o.user_id', '=', 'ref6.id');
        })

        ->leftJoin('order_details as od', 'od.order_id', '=', 'o.id')

        ->leftJoin('products as p', 'p.id', '=', 'od.product_id')

        ->leftJoin('product_mlm_prize as pmp', 'pmp.product_id', '=', 'p.id')

        ->select(
            'mw.id',
            'mw.user_id',
            'mw.pt_coins',
            'mw.pt_value',
            'mw.wallet_status',
            'mw.created_at',

            'o.id as order_id',

            'p.name as product_name',

            'wallet_user.name as wallet_name',

            'ref1.name as level1_name',
            'ref2.name as level2_name',
            'ref3.name as level3_name',
            'ref4.name as level4_name',
            'ref5.name as level5_name',
            'ref6.name as level6_name',

            'pmp.level0',
            'pmp.level1',
            'pmp.level2',
            'pmp.level3',
            'pmp.level4',
            'pmp.level5',
            'pmp.level6'
        )

        ->where('mw.user_id', $user_id)

        ->orderBy('mw.id', 'desc')

        ->get();

     /* =========================
   LEVEL DETECTION
========================= */
$levels = [];

/*
|--------------------------------------------------------------------------
| REMOVE DUPLICATE MLM RECORDS
|--------------------------------------------------------------------------
*/
$uniqueTransactions = [];

foreach ($transactions as $trx) {

    $levelName = null;

    if ((float)$trx->pt_value == (float)$trx->level0) {

        $levelName = 'Level 0';
        $trx->buyer_name = $trx->wallet_name;

    } elseif ((float)$trx->pt_value == (float)$trx->level1) {

        $levelName = 'Level 1';
        $trx->buyer_name = $trx->level1_name;

    } elseif ((float)$trx->pt_value == (float)$trx->level2) {

        $levelName = 'Level 2';
        $trx->buyer_name = $trx->level2_name;

    } elseif ((float)$trx->pt_value == (float)$trx->level3) {

        $levelName = 'Level 3';
        $trx->buyer_name = $trx->level3_name;

    } elseif ((float)$trx->pt_value == (float)$trx->level4) {

        $levelName = 'Level 4';
        $trx->buyer_name = $trx->level4_name;

    } elseif ((float)$trx->pt_value == (float)$trx->level5) {

        $levelName = 'Level 5';
        $trx->buyer_name = $trx->level5_name;

    } elseif ((float)$trx->pt_value == (float)$trx->level6) {

        $levelName = 'Level 6';
        $trx->buyer_name = $trx->level6_name;
    }

    // fallback
    if (!$levelName) {

        $levelName = 'Referral Earnings';

        $trx->buyer_name = 'Referral User';
    }

    /*
    |--------------------------------------------------------------------------
    | UNIQUE KEY
    |--------------------------------------------------------------------------
    | Prevent same MLM wallet row showing multiple times
    */

    $uniqueKey =
        $trx->id . '_' .
        $levelName . '_' .
        $trx->pt_value . '_' .
        $trx->pt_coins;

    if (!isset($uniqueTransactions[$uniqueKey])) {

        $uniqueTransactions[$uniqueKey] = true;

        $levels[$levelName][] = $trx;
    }
}

   return view(
    'frontend.user.mlm_wallet',
    compact(
        'confirmedAmount',
        'holdAmount',
        'withdrawableAmount',
        'levels',
        'totalEarning',
        'totalWithdrawn',
        'refundedAmount',
        'networkStats'
    )
);
}


public function withdrawRequest(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

$user_id = auth()->id();

$refundedAmount = User::where('id', $user_id)
    ->value('mlm_wallet') ?? 0;

$totalEarning = DB::table('mlm_wallet')
    ->where('user_id', $user_id)
    ->where('wallet_status', 1)
    ->sum('pt_value');

$totalWithdrawn = DB::table('mlm_withdraw_requests')
    ->where('user_id', $user_id)
    ->whereIn('status', ['pending','approved'])
    ->sum('amount');

$totalWalletUsed = DB::table('orders')
    ->where('user_id', $user_id)
    ->sum('mlm_wallet_used');

$confirmedAmount = max(
    $totalEarning
    - $totalWithdrawn
    - $totalWalletUsed
    + $refundedAmount,
    0
);

if ($confirmedAmount < 0) {
    $confirmedAmount = 0;
}

if($request->amount > $confirmedAmount)
{
    flash('Insufficient balance')->error();
    return back();
}

    DB::table('mlm_withdraw_requests')->insert([

        'user_id' => auth()->id(),

        'amount' => $request->amount,

        'status' => 'pending',

        'created_at' => now(),

        'updated_at' => now()

    ]);

    flash(
        'Request sent successfully. Please wait for approval.'
    )->success();

    return back();
}
}