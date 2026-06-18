@extends('backend.layouts.app')

@section('content')


<div class="aiz-titlebar mt-2 mb-3">
    <h1 class="h3">MLM Wallet History</h1>
</div>



<div class="card">
    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>
                <tr>
                    <th>S.No</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Total Coins</th>
                    <th>Total Value</th>
                    <th class="text-right">Transaction</th>
                </tr>
            </thead>

            <tbody>

                @foreach($wallets as $key => $wallet)

                <tr>

                    <td>{{ $key+1 }}</td>

                    <td>{{ $wallet->name }}</td>

                    <td>{{ $wallet->email }}</td>

                    <td>{{ $wallet->total_coins }}</td>

                    <td>₹ {{ $wallet->total_value }}</td>

                    <td class="text-right">

                        <a href="{{ route('mlm.wallet.transactions',$wallet->user_id) }}"
                            class="btn btn-soft-primary btn-sm">

                            View Transaction

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection