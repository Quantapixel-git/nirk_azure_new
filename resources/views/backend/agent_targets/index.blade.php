@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
    <h1 class="h3">Agent Target Management</h1>
</div>

<div class="card mb-4">

    <div class="card-header">
        <h5 class="mb-0">Assign Target</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('agent.targets.store') }}"
              method="POST">

            @csrf

            <div class="row">

                <div class="col-md-4">
                    <label>Agent</label>

                    <select name="agent_id"
                            class="form-control aiz-selectpicker"
                            required>

                        <option value="">
                            Select Agent
                        </option>

                        @foreach($agents as $agent)

                            <option value="{{ $agent->id }}">
                                {{ $agent->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <label>User Target</label>

                    <input type="number"
                           name="user_target"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-3">
                    <label>Vendor Target</label>

                    <input type="number"
                           name="vendor_target"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-2">
                    <label>&nbsp;</label>

                    <button type="submit"
                            class="btn btn-primary btn-block">

                        Save
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

<div class="card">

    <div class="card-body">

        <table class="table aiz-table">

            <thead>
<tr>
    <th>#</th>
    <th>Agent</th>
    <th>User Target</th>
    <th>Users Created</th>
    <th>User Status</th>
    <th>Vendor Target</th>
    <th>Vendors Created</th>
    <th>Vendor Status</th>
</tr>
</thead>

           <tbody>

@foreach($targets as $key => $target)

<tr>

    <td>{{ $key + 1 }}</td>

    <td>{{ $target->agent_name }}</td>

    <td>
        {{ $target->created_users }}
        /
        {{ $target->user_target }}
    </td>

    <td>
        {{ $target->created_users }}
    </td>

    <td>
        @if($target->user_completed)
            <span class="badge badge-success">
                Completed
            </span>
        @else
            <span class="badge badge-warning">
                Pending
            </span>
        @endif
    </td>

    <td>
        {{ $target->created_vendors }}
        /
        {{ $target->vendor_target }}
    </td>

    <td>
        {{ $target->created_vendors }}
    </td>

    <td>
        @if($target->vendor_completed)
            <span class="badge badge-success">
                Completed
            </span>
        @else
            <span class="badge badge-warning">
                Pending
            </span>
        @endif
    </td>

</tr>

@endforeach

</tbody>

        </table>

    </div>

</div>

@endsection