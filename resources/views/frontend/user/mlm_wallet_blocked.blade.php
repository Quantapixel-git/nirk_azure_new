@extends('frontend.layouts.user_panel')

@section('panel_content')

<div class="row">
    <div class="col-md-12">

        <div class="card border-danger shadow">

            <div class="card-body text-center py-5">

                <i class="las la-ban"
                   style="font-size:80px;color:#dc3545;">
                </i>

                <h3 class="mt-3 text-danger">
                    MLM Wallet Blocked
                </h3>

                <p class="mt-3">

                    Your MLM account has been blocked because
                    no qualifying order activity was detected
                    during the required 90-day period.

                </p>

                @if($user->mlm_blocked_at)

                <div class="alert alert-danger mt-3">

                    <strong>Blocked On:</strong>

                    {{ \Carbon\Carbon::parse($user->mlm_blocked_at)->format('d M Y h:i A') }}

                </div>

                @endif

                <div class="alert alert-warning">

                    No MLM earnings, withdrawals, wallet usage,
                    or referral commissions can be processed while
                    your MLM account is blocked.

                </div>

                <p>

                    Please contact the administrator to reactivate
                    your MLM account.

                </p>

            </div>

        </div>

    </div>
</div>

@endsection