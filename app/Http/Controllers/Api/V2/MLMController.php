<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\MLMWallet;
use App\Models\Product;
use App\Models\ProductMLMPrize;




class MLMController extends Controller
{

    // ===================================================
    // MLM WALLET DETAILS API
    // ===================================================
    public function getMlmWalletDetails(Request $request)
    {
        try {

            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $userId = $request->user_id;

            // ============================================
            // FETCH USER
            // ============================================
            $user = User::find($userId);

            // ============================================
            // TOTAL HOLD VALUES
            // ============================================
            $holdCoins = MLMWallet::where('user_id', $userId)
                            ->where('wallet_status', 2)
                            ->sum('pt_coins');

            $holdValue = MLMWallet::where('user_id', $userId)
                            ->where('wallet_status', 2)
                            ->sum('pt_value');
                            
                            
                            
                            // ============================================
// TOTAL CONFIRMED VALUES
// ============================================
$confirmedCoins = MLMWallet::where('user_id', $userId)
                    ->where('wallet_status', 1)
                    ->sum('pt_coins');

$confirmedValue = MLMWallet::where('user_id', $userId)
                    ->where('wallet_status', 1)
                    ->sum('pt_value');

            // ============================================
            // FETCH MLM DETAILS
            // ============================================
            $wallets = MLMWallet::where('user_id', $userId)
                        ->latest()
                        ->get();

            $data = [];

            foreach ($wallets as $wallet) {

    // ============================================
    // PRODUCT DETAILS
    // ============================================
    $product = Product::find($wallet->product_id);

    // ============================================
    // LEVEL NAME
    // ============================================
    $levelName = 'Level ' . $wallet->level;

    // ============================================
    // WALLET STATUS
    // ============================================
    $walletStatus = $wallet->wallet_status == 2
        ? 'On Hold'
        : 'Approved';

    $data[] = [

        'wallet_id' => $wallet->id,

        'product_id' => $wallet->product_id,

        'product_name' => $product->name ?? $product->product_name ?? '',

        'user_id' => $wallet->user_id,

        // exact stored level
        'level' => $wallet->level,

        // level text
        'level_name' => $levelName,

        // same stored coins
        'coins' => $wallet->pt_coins,

        // exact value from product_mlm_prize
        'earning_amount' => $wallet->pt_value,

        'wallet_status' => $walletStatus,

        'created_at' => date('d M Y h:i A', strtotime($wallet->created_at)),
    ];
}
            return response()->json([

                'result' => true,

                'user_details' => [
                    'user_id' => $user->id,
                    'name'    => $user->name,
                    'email'   => $user->email,
                ],

              'wallet_summary' => [

        'hold_total_coins'      => $holdCoins,
        'hold_total_value'      => $holdValue,

        'confirmed_total_coins' => $confirmedCoins,
        'confirmed_total_value' => $confirmedValue,

    ],

                'total_records' => count($data),

                'wallet_details' => $data,

            ]);

        } catch (\Exception $e) {

            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }



    // ===================================================
    // STORE MLM WALLET ENTRY AFTER ORDER
    // ===================================================
    public function storeMlmIncome($orderId)
    {

        try {

            // ============================================
            // FETCH ORDER
            // ============================================
            $order = Order::find($orderId);

            if (!$order) {
                return;
            }

            // ============================================
            // FETCH ORDER DETAILS
            // ============================================
            $orderDetails = OrderDetail::where('order_id', $orderId)->get();

            foreach ($orderDetails as $detail) {

                // ============================================
                // PRODUCT MLM PRIZE
                // ============================================
                $prize = ProductMLMPrize::where('product_id', $detail->product_id)
                            ->first();

                if (!$prize) {
                    continue;
                }

                // ============================================
                // BUYER
                // ============================================
                $buyer = User::find($order->user_id);

                if (!$buyer) {
                    continue;
                }

                // ============================================
                // START REFERRAL CHAIN
                // ============================================
                $currentUserId = $buyer->referred_by;

                // ============================================
                // LOOP LEVEL 0 TO 6
                // ============================================
                for ($level = 0; $level <= 6; $level++) {

                    if (!$currentUserId) {
                        break;
                    }

                    // ============================================
                    // LEVEL COLUMN
                    // ============================================
                    $levelColumn = 'level' . $level;

                    // ============================================
                    // EXACT LEVEL VALUE
                    // ============================================
                    $levelAmount = $prize->$levelColumn ?? 0;

                    // ============================================
                    // STORE MLM WALLET
                    // ============================================
                    MLMWallet::create([

                        'user_id' => $currentUserId,

                        'product_id' => $detail->product_id,

                        'pt_coins' => $prize->coins,

                        // exact level value store
                        'pt_value' => $levelAmount,

                        'level' => $level,

                        'wallet_status' => 2,

                    ]);

                    // ============================================
                    // NEXT REFERRAL USER
                    // ============================================
                    $nextUser = User::find($currentUserId);

                    if (!$nextUser) {
                        break;
                    }

                    $currentUserId = $nextUser->referred_by;
                }
            }

        } catch (\Exception $e) {

            \Log::error($e->getMessage());
        }
    }
}