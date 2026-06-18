<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MLMWithdrawController extends Controller
{
    public function index()
    {
        $requests = DB::table('mlm_withdraw_requests as w')

            ->join('users as u', 'u.id', '=', 'w.user_id')

            ->leftJoin('user_kyc as k', 'k.user_id', '=', 'u.id')

            ->select(
                'w.*',

                'u.name',
                'u.email',

                'k.bank_name',
                'k.bank_holder',
                'k.bank_account',
                'k.bank_ifsc'
            )

            ->latest('w.id')
            ->get();

        return view(
            'backend.mlm_wallet.withdraw_requests',
            compact('requests')
        );
    }

    public function approve($id)
{
    DB::beginTransaction();

    try {

        $withdraw = DB::table('mlm_withdraw_requests')
            ->where('id', $id)
            ->lockForUpdate()
            ->first();

        if (!$withdraw || $withdraw->status != 'pending') {

            flash('Invalid request')->error();

            return back();
        }

        $earning = DB::table('mlm_wallet')
            ->where('user_id', $withdraw->user_id)
            ->where('wallet_status', 1)
            ->sum('pt_value');

        $withdrawn = DB::table('mlm_withdraw_requests')
            ->where('user_id', $withdraw->user_id)
            ->where('status', 'approved')
            ->sum('amount');

        $available = $earning - $withdrawn;

        if ($available < $withdraw->amount) {

            flash('Insufficient MLM balance')->error();

            return back();
        }

        DB::table('mlm_withdraw_requests')
            ->where('id', $id)
            ->update([
                'status'      => 'approved',
                'approved_at' => now(),
                'updated_at'  => now()
            ]);

        /*
        |--------------------------------------------------------------------------
        | BANK PAYOUT API
        |--------------------------------------------------------------------------
        |
        | RazorpayX
        | Cashfree Payout
        | Easebuzz Payout
        |
        */

        DB::commit();

        flash('Withdrawal approved successfully')->success();

        return back();

    } catch (\Exception $e) {

        DB::rollBack();

        flash($e->getMessage())->error();

        return back();
    }
}

    public function reject($id)
    {
        DB::table('mlm_withdraw_requests')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'updated_at' => now()
            ]);

        flash('Withdrawal rejected')->success();

        return back();
    }
}