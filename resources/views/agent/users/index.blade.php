@extends('agent.layout.app')

@section('panel_content')



<div class="aiz-titlebar mt-2 mb-4">

    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">User Management</h1>
        </div>

        <div class="col-auto">

            <a href="{{ route('agent.users.create') }}"
               class="btn btn-primary">

                <i class="las la-plus"></i>

                Create User Account

            </a>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">Users Created By Me</h5>
    </div>

    <div class="card-body">
<div class="mb-4">
    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
               href="{{ route('agent.users',['status'=>'active']) }}">
                <i class="las la-user-check"></i>
                Active Users
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $status == 'inactive' ? 'active' : '' }}"
               href="{{ route('agent.users',['status'=>'inactive']) }}">
                <i class="las la-user-clock"></i>
                Inactive Users
            </a>
        </li>

    </ul>
</div>
        <table class="table aiz-table mb-0">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Referral Code</th>
           @if($status == 'active')
    <th>View Orders</th>
@endif
                     <th>Status</th>
                    <th>Created At</th>
                </tr>

            </thead>

            <tbody>

                @forelse($users as $key => $user)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->phone }}</td>

                    <td>{{ $user->referral_code }}</td>
                   @if($status == 'active')
<td>
    <a href="{{ route('agent.users.orders', encrypt($user->id)) }}"
       class="btn btn-primary btn-sm">
        <i class="las la-shopping-bag"></i>
        View Orders
    </a>
</td>
@endif

    <td>
    @if($user->is_active == 1)
        <span class="p-2 badge-success">Active</span>
    @else
        <span class="p-2 badge-warning">Inactive</span>
    @endif
</td>

                    <td>{{ $user->created_at->format('d M Y') }}</td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" class="text-center">
                        No Users Found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="aiz-pagination mt-4">
            {{ $users->links() }}
        </div>

    </div>

</div>

@endsection