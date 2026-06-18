<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\MLMWallet;
use Carbon\Carbon;

class MlmNinetyDayCycle extends Command
{
    protected $signature = 'app:mlm-ninety-day-cycle';

    protected $description = '90 day MLM activity cycle check';

    public function handle()
    {
        $users = User::where('user_type', 'customer')
            ->whereNotNull('referred_by')
            ->get();

        foreach ($users as $user) {

            // =========================
            // 1. CYCLE START DATE
            // =========================
            $startDate = $user->action_date
                ?? $user->recent_order_date
                ?? $user->created_at;

            $startDate = Carbon::parse($startDate);
            $endDate   = $startDate->copy()->addDays(90);

            // =========================
            // 2. STILL ACTIVE CYCLE
            // =========================
            if (now()->lt($endDate)) {
                continue;
            }

            // =========================
            // 3. CHECK ORDERS IN CYCLE
            // =========================
            $hasOrder = Order::where('user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->exists();

            // =========================
            // 4. IF ACTIVE USER
            // =========================
            if ($hasOrder) {

                $latestOrder = Order::where('user_id', $user->id)
                    ->where('created_at', '>=', $startDate)
                    ->latest()
                    ->first();

                if ($latestOrder) {
                    $user->recent_order_date = $latestOrder->created_at;
                    $user->mlm_status = 'active';
                    $user->mlm_blocked_at = null;
                    $user->save();
                }

                continue;
            }

            // =========================
            // 5. BLOCK USER (NO ORDER)
            // =========================
            $user->mlm_status = 'blocked';
            $user->mlm_blocked_at = now();
            $user->save();

            // =========================
            // 6. BLOCK MLM WALLET
            // =========================
            MLMWallet::where('user_id', $user->id)
                ->update([
                    'wallet_status' => 0 // 0 = blocked
                ]);
        }

        $this->info("90-day MLM cycle completed successfully");
    }
}