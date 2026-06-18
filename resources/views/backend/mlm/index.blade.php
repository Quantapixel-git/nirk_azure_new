@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{ translate('Points / Coins Values Table') }}</h1>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>

                <tr>

                    <th>{{ translate('S.No') }}</th>

                    <th>{{ translate('Level Information') }}</th>

                    <th>{{ translate('Points / Coins Value As Per Level') }}</th>

                    <th class="text-right">{{ translate('Options') }}</th>

                </tr>

            </thead>

            <tbody>

                @php

                $levels = [

                ['level'=>0,'value'=>1],

                ['level'=>1,'value'=>0.80],

                ['level'=>2,'value'=>0.40],

                ['level'=>3,'value'=>0.30],

                ['level'=>4,'value'=>0.20],

                ['level'=>5,'value'=>0.10],

                ['level'=>6,'value'=>0.05],

                ];

                @endphp


                @foreach($levels as $key => $level)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>
                        <b>LEVEL {{ $level['level'] }}</b>
                    </td>

                    <td>

                        <b>1 Pv/Cn = ₹ {{ $level['value'] }}</b>

                    </td>

                    <td class="text-right">

                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                            href="{{ route('mlm.edit',$level['level']) }}">

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