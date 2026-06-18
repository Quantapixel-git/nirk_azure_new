@extends('agent.layout.app')

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Order Details
            </h1>
        </div>

        <div class="col-auto">
            <a href="{{ url()->previous() }}"
               class="btn btn-light">
                Back
            </a>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Customer Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">
                <strong>Name</strong>
                <p>{{ $customer->name }}</p>
            </div>

            <div class="col-md-4">
                <strong>Email</strong>
                <p>{{ $customer->email }}</p>
            </div>

            <div class="col-md-4">
                <strong>Phone</strong>
                <p>{{ $customer->phone }}</p>
            </div>

        </div>

    </div>
</div>

<div class="card mt-4">

    <div class="card-header">
        <h5 class="mb-0">Order Information</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Order Code</th>
                <td>{{ $order->code }}</td>
            </tr>

            <tr>
                <th>Grand Total</th>
                <td>{{ single_price($order->grand_total) }}</td>
            </tr>

            <tr>
                <th>Payment Status</th>
                <td>{{ ucfirst($order->payment_status) }}</td>
            </tr>

            <tr>
                <th>Delivery Status</th>
                <td>{{ ucfirst($order->delivery_status) }}</td>
            </tr>

            <tr>
                <th>Order Date</th>
                <td>{{ $order->created_at }}</td>
            </tr>

        </table>

    </div>

</div>

@endsection