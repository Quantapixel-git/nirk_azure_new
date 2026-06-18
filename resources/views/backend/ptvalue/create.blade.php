@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('ptvalue.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label>Product</label>

                <select name="product_id" class="form-control" required>

                    <option value="">Select Product</option>

                    @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                    @endforeach

                </select>

            </div>

            @for($i=0;$i<=6;$i++)

                <div class="form-group">
                <label>Level {{ $i }}</label>

                <input type="text"
                    name="level{{ $i }}"
                    class="form-control">

    </div>

    @endfor

    <button class="btn btn-primary">
        Save
    </button>

    </form>

</div>
</div>

@endsection