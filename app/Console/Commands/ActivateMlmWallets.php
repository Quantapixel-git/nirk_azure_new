<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MLMWallet;
use App\Models\OrderReturn;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivateMlmWallets extends Command
{
    protected $signature = 'mlm:activate-wallets';

    protected $description = 'Activate MLM wallet after return period expiry';

    public function handle()
    {
        $wallets = MLMWallet::where('wallet_status', 2)
            ->get();

        foreach ($wallets as $wallet) {

            /*
            |--------------------------------------------------------------------------
            | Order Check
            |--------------------------------------------------------------------------
            */

            $order = DB::table('orders')
                ->where('id', $wallet->order_id)
                ->where('user_id', $wallet->user_id)
                ->where('delivery_status', 'delivered')
                ->where('payment_status', 'paid')
                ->first();

            if (!$order) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Product Return Settings
            |--------------------------------------------------------------------------
            */

            $productReturn = DB::table('product_mlm_prize')
                ->where('product_id', $wallet->product_id)
                ->first();

            if (!$productReturn) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Product has no return policy
            |--------------------------------------------------------------------------
            */

            if ($productReturn->is_return != 1) {

                $wallet->update([
                    'wallet_status' => 1
                ]);

                \Log::info('MLM Wallet Activated (No Return)', [
                    'wallet_id' => $wallet->id
                ]);

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Return Days
            |--------------------------------------------------------------------------
            */

            $returnDays = (int) $productReturn->return_days;

            if ($returnDays <= 0) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Delivered Date
            |--------------------------------------------------------------------------
            */

            if (!$order->delivered_date) {
                continue;
            }

            $deliveredDate = Carbon::parse($order->delivered_date);

            $returnEndDate = $deliveredDate
                ->copy()
                ->addDays($returnDays);

            /*
            |--------------------------------------------------------------------------
            | Return Period Not Finished
            |--------------------------------------------------------------------------
            */

            if (now()->lt($returnEndDate)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Check Return Request
            |--------------------------------------------------------------------------
            */

            $returnExists = OrderReturn::where('order_id', $wallet->order_id)
                ->where('user_id', $wallet->user_id)
                ->exists();

            if ($returnExists) {

                \Log::info('MLM Wallet Not Activated - Return Exists', [
                    'wallet_id' => $wallet->id,
                    'order_id'  => $wallet->order_id
                ]);

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Activate Wallet
            |--------------------------------------------------------------------------
            */

            $wallet->update([
                'wallet_status' => 1
            ]);

            \Log::info('MLM Wallet Activated', [
                'wallet_id' => $wallet->id,
                'user_id' => $wallet->user_id,
                'order_id' => $wallet->order_id
            ]);
        }

        $this->info('MLM Wallet Activation Completed');
    }
}