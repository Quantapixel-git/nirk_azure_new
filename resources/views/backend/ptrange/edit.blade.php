@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="h3">Edit PT Range</h1>
</div>

<div class="card">

    <div class="card-body">

        <form action="{{ route('ptrange.update',$range->id) }}" method="POST">

            @csrf

            <div class="form-group">
                <label>Product Range</label>
                <input type="text" name="product_range" class="form-control"
                    value="{{ $range->product_range }}" required>
            </div>

            <div class="form-group">
                <label>Coins</label>
                <input type="text" name="coins" class="form-control"
                    value="{{ $range->coins }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Update
            </button>

            <a href="{{ route('ptrange.index') }}" class="btn btn-light">
                Back
            </a>

        </form>

    </div>

</div>

@endsection