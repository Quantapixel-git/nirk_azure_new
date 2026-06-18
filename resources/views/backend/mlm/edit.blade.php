@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">

    <h1 class="h3">{{ translate('Edit PV Coin Value') }}</h1>

</div>

<div class="card">

    <div class="card-body">

        <form action="#">

            <div class="form-group row">

                <label class="col-md-3 col-form-label">
                    {{ translate('Level') }}
                </label>

                <div class="col-md-9">

                    <input type="text"
                        class="form-control"
                        value="LEVEL {{ $level }}"
                        disabled>

                </div>

            </div>


            <div class="form-group row">

                <label class="col-md-3 col-form-label">

                    {{ translate('1 PV = Rupee Value') }}

                </label>

                <div class="col-md-9">

                    <input type="number"

                        step="0.01"

                        class="form-control"

                        value="1">

                </div>

            </div>


            <div class="text-right">

                <button class="btn btn-primary">

                    {{ translate('Update') }}

                </button>

            </div>

        </form>

    </div>

</div>

@endsection