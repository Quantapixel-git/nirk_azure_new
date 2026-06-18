@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3">
                {{ translate('Blocked MLM Users') }}
            </h1>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            {{ translate('Blocked MLM Users List') }}
        </h5>
    </div>

    <div class="card-body">

        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Name') }}</th>
                    <th>{{ translate('Email') }}</th>
                    <th>{{ translate('Total Referrals') }}</th>
                    <th>{{ translate('Joined On') }}</th>
                    <th>{{ translate('Blocked Date') }}</th>
                    <th>{{ translate('Last Activated') }}</th>
                    <th>{{ translate('Status') }}</th>
                    <th width="250">{{ translate('Action') }}</th>
                </tr>
            </thead>

            <tbody>

                @forelse($inactiveUsers as $key => $user)

                <tr>

                    <td>
                        {{ $key + 1 }}
                    </td>

                    <td>
                        <strong>{{ $user->name }}</strong>
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    <td>
                        <span class="badge badge-info">
                            {{ $user->total_referrals }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                    </td>

                    <td>
                        @if($user->mlm_blocked_at)
                            <span class="text-danger">
                                {{ \Carbon\Carbon::parse($user->mlm_blocked_at)->format('d M Y h:i A') }}
                            </span>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($user->action_date)
                            <span class="text-success">
                                {{ \Carbon\Carbon::parse($user->action_date)->format('d M Y h:i A') }}
                            </span>
                        @else
                            Never
                        @endif
                    </td>

                    <td>
                        @if($user->mlm_status == 'blocked')
                            <span class="badge badge-danger">
                                Blocked
                            </span>
                        @else
                            <span class="badge badge-success">
                                Active
                            </span>
                        @endif
                    </td>

                    <td>

                        <div class="d-flex" style="gap:10px;">

                            {{-- Activate MLM --}}
                            <form action="{{ route('mlm.activate.user',$user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to activate MLM account?')">

                                @csrf

                                <button type="submit"
                                        class="btn btn-success btn-sm">
                                    Activate MLM
                                </button>

                            </form>

                            {{-- Reset Referrals --}}
                            <!-- <form action="{{ route('mlm.reset.referrals',$user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to reset referrals?')">

                                @csrf

                                <button type="submit"
                                        class="btn btn-warning btn-sm">
                                    Reset Referrals
                                </button>

                            </form> -->

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="9" class="text-center">

                        <div class="py-4">

                            <h5 class="text-muted">
                                {{ translate('No blocked MLM users found') }}
                            </h5>

                        </div>

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection