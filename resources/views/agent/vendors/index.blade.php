@extends('agent.layout.app')

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">

    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Vendor Management
            </h1>
        </div>

        <div class="col-auto">

            <a href="{{ route('agent.vendors.create') }}"
               class="btn btn-primary">

                <i class="las la-plus"></i>

                Create Vendor

            </a>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">
            Vendors Created By Me
        </h5>
    </div>

    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                 
                    <th>Created At</th>
                </tr>

            </thead>

            <tbody>

                @forelse($vendors as $key => $vendor)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>{{ $vendor->name }}</td>

                    <td>{{ $vendor->email }}</td>

                    <td>{{ $vendor->phone }}</td>

                  
                    <td>
                        {{ $vendor->created_at->format('d M Y') }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6"
                        class="text-center">
                        No Vendors Found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="aiz-pagination mt-4">
            {{ $vendors->links() }}
        </div>

    </div>

</div>

@endsection