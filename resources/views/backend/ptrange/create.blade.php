@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
    <h1 class="h3">Add PT Range</h1>
</div>

<div class="card">

    <div class="card-body">

        <form action="{{ route('ptrange.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label>Product Range</label>
                <input type="text" name="product_range" class="form-control"
                    placeholder="Example: 0 - 1000" required>
            </div>

            <div class="form-group">
                <label>Coins</label>
                <input type="number" name="coins" class="form-control"
                    placeholder="Enter coins value" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Range
            </button>

            <a href="{{ route('ptrange.index') }}" class="btn btn-light">
                Back
            </a>

        </form>

    </div>

</div>

@endsection