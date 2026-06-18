@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">PT Value Table</h1>
        </div>

        <div class="col-auto">
            <a href="{{ route('ptvalue.create') }}" class="btn btn-primary">
                <i class="las la-plus"></i> Add PT Value
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

        <table class="table aiz-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Level0</th>
                    <th>Level1</th>
                    <th>Level2</th>
                    <th>Level3</th>
                    <th>Level4</th>
                    <th>Level5</th>
                    <th>Level6</th>
                    <th class="text-right">Options</th>
                </tr>
            </thead>

            <tbody>

                @foreach($values as $key => $value)

                <tr>

                    <td>{{ $key+1 }}</td>

                    <td>{{ $value->product->name ?? '' }}</td>

                    <td>{{ $value->level0 }}</td>
                    <td>{{ $value->level1 }}</td>
                    <td>{{ $value->level2 }}</td>
                    <td>{{ $value->level3 }}</td>
                    <td>{{ $value->level4 }}</td>
                    <td>{{ $value->level5 }}</td>
                    <td>{{ $value->level6 }}</td>

                    <td class="text-right">

                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                            href="{{ route('ptvalue.edit',$value->id) }}">

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