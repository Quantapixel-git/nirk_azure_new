@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">PT Range / Coins Table</h1>
        </div>

        <div class="col-auto">
            <a href="{{ route('ptrange.create') }}" class="btn btn-primary">
                <i class="las la-plus"></i> Add Range
            </a>
        </div>

    </div>
</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        &times;
    </button>
</div>
@endif

<div class="card">

    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>

                <tr>
                    <th>S.No</th>
                    <th>Product Range</th>
                    <th>Coins</th>
                    <th class="text-right">Options</th>
                </tr>

            </thead>

            <tbody>

                @foreach($ranges as $key => $range)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>{{ $range->product_range }}</td>

                    <td>{{ $range->coins }}</td>

                    <td class="text-right">

                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                            href="{{ route('ptrange.edit',$range->id) }}">

                            <i class="las la-pen"></i>

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection