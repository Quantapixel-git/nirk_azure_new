<?php

namespace App\Jobs;

use App\Models\MLMWallet;
use App\Models\OrderReturn;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ProcessMlmWalletActivation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $walletId;

    public function __construct($walletId)
    {
        $this->walletId = $walletId;
    }

    public function handle(): void
    {
        $wallet = MLMWallet::find($this->walletId);

        if (!$wallet) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Already Active
        |--------------------------------------------------------------------------
        */

        if ($wallet->wallet_status == 1) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Check Return Request Exists
        |--------------------------------------------------------------------------
        */

        $returnExists = OrderReturn::where(
                'order_id',
                $wallet->order_id
            )
            ->where(
                'product_id',
                $wallet->product_id
            )
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | If No Return Request
        |--------------------------------------------------------------------------
        */

        if (!$returnExists) {

            $wallet->wallet_status = 1;

            $wallet->save();

            \Log::info(
                'MLM Wallet Activated',
                [
                    'wallet_id' => $wallet->id
                ]
            );
        }
    }
}