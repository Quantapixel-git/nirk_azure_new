@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('ptvalue.update',$value->id) }}" method="POST">

            @csrf

            <div class="form-group">
                <label>Product</label>

                <select name="product_id" class="form-control">

                    @foreach($products as $product)

                    <option value="{{ $product->id }}"
                        @if($product->id == $value->product_id) selected @endif>

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
                    value="{{ $value->{'level'.$i} }}"
                    class="form-control">

    </div>

    @endfor

    <button class="btn btn-primary">
        Update
    </button>

    </form>

</div>
</div>

@endsection