@extends('agent.layout.app')

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Orders of {{ $user->name }}
            </h1>
        </div>

        <div class="col-auto">
            <a href="{{ route('agent.users') }}"
               class="btn btn-light">
                Back
            </a>
        </div>

    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">
            User Orders
        </h5>
    </div>

    <div class="card-body">

        <table class="table aiz-table">

            <thead>

                <tr>
                    <th>Order Code</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>

            </thead>

            <tbody>

                @forelse($orders as $order)

                <tr>

                    <td>{{ $order->code }}</td>

                    <td>
                        ₹{{ single_price($order->grand_total) }}
                    </td>

                    <td>
                        {{ ucfirst($order->payment_status) }}
                    </td>

                    <td>
                        {{ ucfirst($order->delivery_status) }}
                    </td>

                    <td>
                        {{ date('d M Y', strtotime($order->created_at)) }}
                    </td>

                    <td>

                       <a href="{{ route('agent.orders.details', encrypt($order->id)) }}"
   class="btn btn-primary btn-sm">
    See Order Details
</a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">
                        No Orders Found
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="aiz-pagination">
            {{ $orders->links() }}
        </div>

    </div>

</div>

@endsection