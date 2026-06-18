@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
    <h1 class="h3">MLM Withdrawal Requests</h1>
</div>

<div class="card">

    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>

                <tr>

                    <th>S.No</th>

                    <th>User</th>

                    <th>Email</th>

                    <th>Amount</th>

                    <th>Status</th>

                    <th>Bank Details</th>

                    <th>Date</th>

                    <th class="text-right">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($requests as $key => $request)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>{{ $request->name }}</td>

                    <td>{{ $request->email }}</td>

                    <td>
                        ₹ {{ number_format($request->amount,2) }}
                    </td>

                    <td>

                        @if($request->status == 'approved')

                            <span class="badge badge-success">
                                Approved
                            </span>

                        @elseif($request->status == 'rejected')

                            <span class="badge badge-danger">
                                Rejected
                            </span>

                        @else

                            <span class="badge badge-warning">
                                Pending
                            </span>

                        @endif

                    </td>

                    <td>

                        <strong>Bank :</strong>
                        {{ $request->bank_name ?? '-' }}

                        <br>

                        <strong>Holder :</strong>
                        {{ $request->bank_holder ?? '-' }}

                        <br>

                        <strong>A/C :</strong>
                        {{ $request->bank_account ?? '-' }}

                        <br>

                        <strong>IFSC :</strong>
                        {{ $request->bank_ifsc ?? '-' }}

                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($request->created_at)->format('d M Y h:i A') }}
                    </td>

                    <td class="text-right">

                        @if($request->status == 'pending')

                            <form action="{{ route('mlm.withdraw.approve',$request->id) }}"
                                  method="POST"
                                  style="display:inline-block">

                                @csrf

                                <button type="submit"
                                        class="btn btn-success btn-sm">

                                    Approve

                                </button>

                            </form>

                            <form action="{{ route('mlm.withdraw.reject',$request->id) }}"
                                  method="POST"
                                  style="display:inline-block">

                                @csrf

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    Reject

                                </button>

                            </form>

                        @else

                            --

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">

                        No withdrawal requests found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection