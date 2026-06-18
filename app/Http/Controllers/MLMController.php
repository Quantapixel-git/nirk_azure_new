<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PTRange;
use App\Models\PTValue;
use App\Models\Product;
use App\Models\MLMWallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;


use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderReturn;









class MLMController extends Controller
{


private function refundMlmWallet($order)
    {
        if (
            !$order ||
            $order->mlm_wallet_used <= 0 ||
            $order->mlm_wallet_refunded
        ) {
            return;
        }

        $user = User::find($order->user_id);

        if (!$user) {
            return;
        }

        $user->mlm_wallet += $order->mlm_wallet_used;
        $user->save();

        $order->mlm_wallet_refunded = 1;
        $order->save();
    }
    public function index()
    {

        return view('backend.mlm.index');
    }

   public function user()
{
    $inactiveUsers = DB::table('users as u')
        ->where('u.user_type', 'customer')
        ->whereNotNull('u.referred_by')
        ->where('u.mlm_status', 'blocked')
       ->select(
    'u.id',
    'u.name',
    'u.email',
    'u.created_at',
    'u.action_date',
    'u.mlm_status',
    'u.mlm_blocked_at',
    DB::raw('(SELECT COUNT(*) FROM users WHERE referred_by = u.id) as total_referrals')
)
        ->orderBy('u.mlm_blocked_at', 'desc')
        ->get();

    return view('backend.mlm.users', compact('inactiveUsers'));
}
public function disableWallet($id)
{
    DB::table('mlm_wallet')
        ->where('user_id', $id)
        ->update(['wallet_status' => 0]);

    return back()->with('success', 'Wallet disabled successfully');
}

public function activateMlmUser($id)
{
    $user = User::findOrFail($id);

    

    try {

        // Activate User MLM
        $user->mlm_status = 'active';
        $user->action_date = now();
        $user->mlm_blocked_at = null;
        $user->save();

        

        return back()->with(
            'success',
            'MLM account activated successfully. New 90-day cycle started.'
        );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );
    }
}

public function resetReferrals($id)
{
    DB::table('users')
        ->where('referred_by', $id)
        ->update(['referred_by' => null]);

    return back()->with('success', 'Referrals reset successfully');
}
    public function edit($level)
    {

        return view('backend.mlm.edit', compact('level'));
    }

    public function updatemlm(Request $request)
    {
        // update logic
        return back()->with('success', 'MLM Updated');
    }



    public function ptrange()
    {
        $ranges = PTRange::orderBy('id', 'asc')->get();
        return view('backend.ptrange.index', compact('ranges'));
    }

    public function createPtrange()
    {
        return view('backend.ptrange.create');
    }


    /* ==============================
   STORE
============================== */
    public function storePtrange(Request $request)
    {
        $request->validate([
            'product_range' => 'required',
            'coins' => 'required|numeric'
        ]);

        PTRange::create([
            'product_range' => $request->product_range,
            'coins' => $request->coins
        ]);

        return redirect()->route('ptrange.index')->with('success', 'Range Added Successfully');
    }


    /* EDIT PAGE */
    public function editPtrange($id)
    {
        $range = PTRange::findOrFail($id);
        return view('backend.ptrange.edit', compact('range'));
    }


    /* UPDATE */
    public function updatePtrange(Request $request, $id)
    {
        $request->validate([
            'product_range' => 'required',
            'coins' => 'required'
        ]);

        $range = PTRange::findOrFail($id);

        $range->update([
            'product_range' => $request->product_range,
            'coins' => $request->coins
        ]);

        return redirect()->route('ptrange.index')->with('success', 'PT Range Updated Successfully');
    }



    /* ==============================
   PT VALUE INDEX
============================== */
    public function ptvalue()
    {
        $values = PTValue::with('product')->orderBy('id', 'desc')->get();
        return view('backend.ptvalue.index', compact('values'));
    }


    /* ==============================
   CREATE PAGE
============================== */
    public function createPtvalue()
    {
        $products = Product::select('id', 'name')->get();
        return view('backend.ptvalue.create', compact('products'));
    }


    /* ==============================
   STORE
============================== */
    public function storePtvalue(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        PTValue::create([
            'product_id' => $request->product_id,
            'level0' => $request->level0,
            'level1' => $request->level1,
            'level2' => $request->level2,
            'level3' => $request->level3,
            'level4' => $request->level4,
            'level5' => $request->level5,
            'level6' => $request->level6,
        ]);

        return redirect()->route('ptvalue.index')->with('success', 'PT Value Added Successfully');
    }


    /* ==============================
   EDIT PAGE
============================== */
    public function editPtvalue($id)
    {
        $value = PTValue::findOrFail($id);
        $products = Product::select('id', 'name')->get();

        return view('backend.ptvalue.edit', compact('value', 'products'));
    }


    /* ==============================
   UPDATE
============================== */
    public function updatePtvalue(Request $request, $id)
    {
        $value = PTValue::findOrFail($id);

        $value->update([
            'product_id' => $request->product_id,
            'level0' => $request->level0,
            'level1' => $request->level1,
            'level2' => $request->level2,
            'level3' => $request->level3,
            'level4' => $request->level4,
            'level5' => $request->level5,
            'level6' => $request->level6,
        ]);

        return redirect()->route('ptvalue.index')->with('success', 'PT Value Updated Successfully');
    }

    //MLM Wallet


    public function mlmWalletHistory()
    {
       $wallets = DB::table('mlm_wallet')
    ->join('users', 'users.id', '=', 'mlm_wallet.user_id')
    ->select(
        'mlm_wallet.user_id',
        'users.name',
        'users.email',
        DB::raw('SUM(mlm_wallet.pt_coins) as total_coins'),
        DB::raw('SUM(mlm_wallet.pt_value) as total_value')
    )
    ->groupBy('mlm_wallet.user_id', 'users.name', 'users.email')
    ->orderByDesc(DB::raw('SUM(mlm_wallet.pt_value)')) // 🔥 Best sorting
    ->get();

        return view('backend.mlm_wallet.index', compact('wallets'));
    }

    public function walletTransactions($user_id)
{
    $user = DB::table('users')
        ->where('id', $user_id)
        ->first();

    $transactions = DB::table('mlm_wallet as mw')
        ->select(
            'mw.id',
            'mw.user_id',
            'mw.pt_coins',
            'mw.pt_value',
            'mw.wallet_status'
        )
        ->where('mw.user_id', $user_id)
        ->get();

    foreach ($transactions as $trx) {

        // =========================
        // DETECT LEVEL
        // =========================

        $level = 0;

        $product = DB::table('product_mlm_prize')
            ->first();

        if ($product) {

            if ($trx->pt_value == $product->level0) {
                $level = 0;
            } elseif ($trx->pt_value == $product->level1) {
                $level = 1;
            } elseif ($trx->pt_value == $product->level2) {
                $level = 2;
            } elseif ($trx->pt_value == $product->level3) {
                $level = 3;
            } elseif ($trx->pt_value == $product->level4) {
                $level = 4;
            } elseif ($trx->pt_value == $product->level5) {
                $level = 5;
            } elseif ($trx->pt_value == $product->level6) {
                $level = 6;
            }
        }

        $trx->level = 'Level ' . $level;

        // =========================
        // FIND LEVEL USER
        // =========================

        $targetUserId = $user_id;

        for ($i = 1; $i <= $level; $i++) {

            $nextUser = DB::table('users')
                ->where('referred_by', $targetUserId)
                ->first();

            if ($nextUser) {
                $targetUserId = $nextUser->id;
            }
        }

        // =========================
        // GET ORDER OF THAT USER
        // =========================

        $order = DB::table('orders')
            ->where('user_id', $targetUserId)
            ->latest()
            ->first();

        $targetUser = DB::table('users')
            ->where('id', $targetUserId)
            ->first();

        $trx->order_id = $order ? $order->id : null;

        $trx->order_user_name = $targetUser->name ?? null;

        $trx->order_user_email = $targetUser->email ?? null;
    }

    // =========================
    // WALLET SUMMARY
    // =========================

    $confirmedCoins = DB::table('mlm_wallet')
        ->where('user_id', $user_id)
        ->where('wallet_status', 1)
        ->sum('pt_coins');

    $confirmedValue = DB::table('mlm_wallet')
        ->where('user_id', $user_id)
        ->where('wallet_status', 1)
        ->sum('pt_value');

    $holdCoins = DB::table('mlm_wallet')
        ->where('user_id', $user_id)
        ->where('wallet_status', 2)
        ->sum('pt_coins');

    $holdValue = DB::table('mlm_wallet')
        ->where('user_id', $user_id)
        ->where('wallet_status', 2)
        ->sum('pt_value');

    return view(
        'backend.mlm_wallet.show',
        compact(
            'user',
            'transactions',
            'confirmedCoins',
            'confirmedValue',
            'holdCoins',
            'holdValue'
        )
    );
}


public function updateReturnStatus(Request $request)
{
    try {

        $request->validate([
            'return_id'    => 'required',
            'order_status' => 'required|in:1,2,3,4'
        ]);

        $return = OrderReturn::findOrFail($request->return_id);

        $return->order_status = $request->order_status;
        $return->save();

        // Refund MLM wallet only when return is approved
        if ($request->order_status == 1) {

            $orderDetail = OrderDetail::find($return->order_detail_id);

            if ($orderDetail) {

                $order = Order::find($orderDetail->order_id);

                if (
                    $order &&
                    $order->mlm_wallet_used > 0 &&
                    !$order->mlm_wallet_refunded
                ) {

                    User::where('id', $order->user_id)
                        ->increment('mlm_wallet', $order->mlm_wallet_used);

                    $order->update([
                        'mlm_wallet_refunded' => 1
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'status'  => $request->order_status
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

 
}
