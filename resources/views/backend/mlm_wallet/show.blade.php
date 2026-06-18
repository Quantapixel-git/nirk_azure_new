@extends('backend.layouts.app')

@section('content')





<div class="card">
    <div class="card-body">

        <h4>User Details</h4>

        <p><b>Name :</b> {{ $user->name }}</p>
        <p><b>Email :</b> {{ $user->email }}</p>

        <hr>

        <h5>Wallet Summary</h5>

        <p><b>Confirmed Coins :</b> {{ $confirmedCoins }}</p>
        <!-- <p><b>Confirmed Value :</b> ₹ {{ $confirmedValue }}</p> -->

        <p><b>Hold Coins :</b> {{ $holdCoins }}</p>
        <!-- <p><b>Hold Value :</b> ₹ {{ $holdValue }}</p> -->

        <hr>

        <table class="table aiz-table">

           <thead>
    <tr>
        <th>#</th>
        <th>PT Coins</th>
        <th>PT Value</th>
        <th>Level</th>
        <th>View Orders</th>
        <th>Status</th>
    </tr>
</thead>

<tbody>

@foreach($transactions as $key => $trx)


<tr>

    <td>{{ $key+1 }}</td>

    <td>{{ $trx->pt_coins }}</td>

    <td>₹ {{ $trx->pt_value }}</td>

    <td>
        <p>
           <b>{{ $trx->level }}</b>
</p>
    </td>

<td>

    @if($trx->order_id)

        <a href="{{ route('all_orders.show', encrypt($trx->order_id)) }}"
           class="btn btn-primary btn-sm"
           target="_blank">

            View Order

        </a>

    @else

        <span class="badge badge-danger">
            No Order
        </span>

    @endif

</td>
    <td>
        @if($trx->wallet_status == 1)
            <button class="btn btn-success btn-sm">Confirmed</button>
        @else
            <button class="btn btn-danger btn-sm">Hold</button>
        @endif
    </td>

</tr>

@endforeach

</tbody>

        </table>

    </div>
</div>



@endsection