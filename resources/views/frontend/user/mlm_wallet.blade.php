@extends('frontend.layouts.user_panel')

@section('panel_content')



<style>
    .wallet-card{
    position: relative;
    background: linear-gradient(135deg, #667eea, #764ba2);;
    border-radius: 10px;
    padding: 15px;
    min-height: 100px;
    overflow: hidden;

    border: 1px solid rgba(255,255,255,.08);

    box-shadow:
        0 10px 30px rgba(0,0,0,.25),
        inset 0 1px 0 rgba(255,255,255,.05);

    transition: all .3s ease;
}

.wallet-card::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    width:6px;
    height:100%;
    background:#00ff88;
    border-radius:20px;
}

.wallet-card:hover{
    transform: translateY(-5px);

    box-shadow:
        0 15px 35px rgba(0,255,136,.15),
        0 10px 25px rgba(0,0,0,.35);
}

.wallet-card h6{
    color:#ffffff;
    font-size:20px;
    font-weight:500;
    margin-bottom:15px;
}

.wallet-card h2{
    color:#ffffff;
    font-size:30px;
    font-weight:500;
    margin-bottom:10px;
}

.wallet-text{
    color:#00ff88;
    font-size:15px;
    font-weight:600;
}

@media(max-width:768px){

    .wallet-card{
        min-height:auto;
    }

    .wallet-card h2{
        font-size:30px;
    }
}



.network-card-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.network-left{
    text-align:left;
}

.network-right{
    text-align:right;
}

.network-right h2{
    margin:0;
    color:#fff;
    font-size:34px;
    font-weight:700;
}

.network-footer{
    margin-top:15px;
    text-align:right;
}

.network-footer .btn{
    border-radius:8px;
    font-size:13px;
    font-weight:600;
}




.table-responsive table{
    border-radius:10px;
    overflow:hidden;
}

.table thead th{
    vertical-align:middle;
    text-align:center;
}

.table tbody td{
    vertical-align:middle;
}

.badge{
    padding:8px 12px;
    font-size:12px;
}




.status-badge{
    display:inline-block;
    padding:8px 16px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
    text-align:center;
    min-width:100px;
    letter-spacing:.3px;
    border:1px solid transparent;
}

.status-success{
    color:#fff;
    background:linear-gradient(135deg,#28a745,#20c997);
    border-color:#28a745;
    box-shadow:0 4px 10px rgba(40,167,69,.25);
}

.status-warning{
    color:#fff;
    background:linear-gradient(135deg,#ff9800,#ff5722);
    border-color:#ff9800;
    box-shadow:0 4px 10px rgba(255,152,0,.25);
}
</style>





@if(auth()->user()->mlm_status == 'blocked')

<div class="row">
    <div class="col-md-12">

        <div class="alert alert-danger text-center p-4">

            <h3 class="mb-3">
                My Wallet Blocked
            </h3>

            <p class="mb-3">
                Your MY wallet has been blocked due to inactivity during the required 90-day period.
                No MY earnings, withdrawals, wallet usage, or referral commissions can be processed.
            </p>

            @if(auth()->user()->mlm_blocked_at)

            <div class="mb-3">
                <strong>
                    Blocked On:
                    {{ \Carbon\Carbon::parse(auth()->user()->mlm_blocked_at)->format('d M Y h:i A') }}
                </strong>
            </div>

            @endif

            <div class="alert alert-warning mb-0">
                Please contact the administrator to reactivate your MY Wallet account.
            </div>

        </div>

    </div>
</div>

@else
<div class="row mb-4">
    <div class="col-md-12">

        <div class="p-4 text-white rounded"
             style="background: linear-gradient(135deg, #667eea, #764ba2);">

            <h5>My Wallet</h5>

           <div class="d-flex justify-content-between align-items-center">

    <div>

        <h3>₹ {{ $confirmedAmount }}</h3>

        @if($confirmedAmount > 0)

            <p class="text-success mb-0">
                You are now eligible to withdraw or use this amount during checkout.
            </p>

        @else

            <p class="text-warning mb-0">
                Return period is not over yet. Please wait.
            </p>

        @endif

    </div>

    @if($confirmedAmount > 0)

    <button class="btn btn-light"
            data-toggle="modal"
            data-target="#withdrawModal">

        Request Withdrawal

    </button>

    @endif

</div>
        </div>

    </div>
</div>

<div class="my-2">
    <h3 class="font-weight-bold">
        My Wallet Stats
    </h3>
</div>

@php
$totalWalletUsed = DB::table('orders')
    ->where('user_id', auth()->id())
    ->sum('mlm_wallet_used');
@endphp

<div class="row">

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Total Earned</h6>
            <h2>₹ {{ number_format($totalEarning,2) }}</h2>
            <span class="wallet-text">
                Commission Earnings
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Total Withdrawn</h6>
            <h2>₹ {{ number_format($totalWithdrawn,2) }}</h2>
            <span class="wallet-text">
                Withdrawal History
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Used In Orders</h6>
            <h2>₹ {{ number_format($totalWalletUsed,2) }}</h2>
            <span class="wallet-text">
                Wallet Usage
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Refunded Amount</h6>
            <h2>₹ {{ number_format($refundedAmount,2) }}</h2>
            <span class="wallet-text">
                Refunded Orders
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Available Balance</h6>
            <h2>₹ {{ number_format($confirmedAmount,2) }}</h2>
            <span class="wallet-text">
                Ready To Withdraw
            </span>
        </div>
    </div>

</div>


<div class="my-2">
    <h3 class="font-weight-bold">
        My Network Statistics
    </h3>
</div>


<div class="row">

@forelse($networkStats as $key => $stat)

<div class="col-lg-4 col-md-6 mb-4">

    <div class="wallet-card">

        <div class="network-card-top">

            <div class="network-left">

                <h6>{{ $stat['level'] }}</h6>

                @if($key == 0)
                    <span class="wallet-text">
                        Orders : {{ $stat['orders'] }}
                    </span>
                @endif

            </div>

            <div class="network-right">
                <h2>{{ $stat['count'] }}</h2>
            </div>

        </div>

        <div class="network-footer">

            <button class="btn btn-light btn-sm"
                    data-toggle="modal"
                    data-target="#networkModal{{ $key }}">
                View Details
            </button>

        </div>

    </div>

</div>

@empty

<div class="col-md-12">

    <div class="wallet-card text-center">

        <h5 class="mb-2 text-white">
            No Network Available
        </h5>

        <p class="mb-0 text-white">
            You don't have any network members yet.
        </p>

    </div>

</div>

@endforelse

</div>
@foreach($networkStats as $key => $stat)

<div class="modal fade"
     id="networkModal{{ $key }}">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5>
                    {{ $stat['level'] }} Users
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>

                        @if($key == 0)
                        <th>Total Orders</th>
                        @endif

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($stat['users'] as $user)

                    <tr>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>{{ $user->phone }}</td>

                        @if($key == 0)

                        <td>

                           <button class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#orderModal{{ $user->id }}">

    {{ $user->level1_orders ?? 0 }} Orders

</button>

                        </td>

                        @endif

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endforeach

@if(isset($networkStats[0]['users']))
@foreach($networkStats[0]['users'] as $user)

<div class="modal fade"
     id="orderModal{{ $user->id }}">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5>
                    Orders - {{ $user->name }}
                </h5>
<button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Order Code</th>
                        <th>Amount</th>
                        <th>Date</th>

                    </tr>

                    </thead>

                    <tbody>

                  @php
$orderIds = DB::table('mlm_wallet')
    ->where('user_id', $user->id)
    ->where('level', 1)
    ->whereNotNull('order_id')
    ->distinct()
    ->pluck('order_id');

$orders = \App\Models\Order::whereIn('id', $orderIds)
    ->latest()
    ->get();
@endphp

@foreach($orders as $order)
                    <tr>

                        <td>{{ $order->code }}</td>

                        <td>₹ {{ $order->grand_total }}</td>

                        <td>{{ $order->created_at }}</td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endforeach
@endif

<div class="my-2">
    <h3 class="font-weight-bold">
        My All Levels History
    </h3>
</div>


<div class="row">

@forelse($levels as $levelName => $items)

@php
    $totalAmount = collect($items)->sum('pt_value');

   $levelConfirmedAmount = collect($items)
        ->where('wallet_status',1)
        ->sum('pt_value');

    $levelHoldAmount = collect($items)
        ->where('wallet_status',2)
        ->sum('pt_value');

    $totalCoins = collect($items)->sum('pt_coins');
@endphp

<div class="card mb-4 border-0 shadow-lg"
     style="background: linear-gradient(135deg,#667eea,#764ba2); border-radius:15px;">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="text-white mb-1">
                    {{ $levelName }}
                </h4>

                <small class="text-light">
                    My Earnings Summary
                </small>
            </div>

            <div class="text-right">

                <div class="text-white font-weight-bold">
                    Confirmed:
                   ₹ {{ number_format($levelConfirmedAmount,2) }}
                </div>

                <div class="text-warning font-weight-bold">
                    Hold:
                    ₹ {{ number_format($levelHoldAmount,2) }}
                </div>

                <div class="text-success font-weight-bold">
                    Total:
                    ₹ {{ number_format($totalAmount,2) }}
                </div>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-striped mb-0 bg-white">

                <thead class="thead-dark">

                <tr>
                    <th width="8%">#</th>
                    <th>User Name</th>
                    <th>Total Coins</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>

                </thead>

                <tbody>

                @foreach($items as $index => $trx)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $trx->buyer_name ?? 'Self Purchase' }}
                    </td>

                    <td>
                        {{ number_format($trx->pt_coins,2) }}
                    </td>

                    <td>
                        ₹ {{ number_format($trx->pt_value,2) }}
                    </td>

                    <td>

                        @if($trx->wallet_status == 1)

    <span class="status-badge status-success">
        Confirmed
    </span>

@else

    <span class="status-badge status-warning">
        On Hold
    </span>

@endif

                    </td>

                    <td>

                        @if($levelName == 'Level 0')

                            I purchased
                            <strong>
                                {{ $trx->product_name ?? 'a product' }}
                            </strong>
                            and earned
                            ₹ {{ $trx->pt_value }}

                        @else

                            <strong>
                                {{ $trx->buyer_name ?? 'A user' }}
                            </strong>

                            purchased

                            <strong>
                                {{ $trx->product_name ?? 'a product' }}
                            </strong>

                            and you earned

                            ₹ {{ $trx->pt_value }}

                            from

                            {{ $levelName }}

                        @endif

                    </td>

                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr class="font-weight-bold bg-light">

                    <td colspan="2">
                        Total
                    </td>

                    <td>
                        {{ number_format($totalCoins,2) }}
                    </td>

                    <td>
                        ₹ {{ number_format($totalAmount,2) }}
                    </td>

                    <td colspan="2">
                        Confirmed:
                        ₹ {{ number_format($levelConfirmedAmount,2) }}

                        |
                        Hold:
                         ₹ {{ number_format($levelHoldAmount,2) }}
                    </td>

                </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

@empty

<div class="alert alert-info text-center">
    No MLM earnings yet
</div>

@endforelse

</div>


<div class="modal fade"
     id="withdrawModal">

    <div class="modal-dialog">

        <form action="{{ route('mlm.withdraw.request') }}"
              method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Withdrawal Request</h5>
                </div>

                <div class="modal-body">

                    <label>Amount</label>

                    <input type="number"
                           name="amount"
                           max="{{ $confirmedAmount }}"
                           class="form-control"
                           required>

                    <small class="text-muted">
    Available Balance:
    ₹ {{ number_format($confirmedAmount,2) }}
</small>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-primary">

                        Submit Request

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endif
@endsection