@extends('agent.layout.app')

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3">
                Create Vendor Account
            </h1>
        </div>
    </div>
</div>

<form action="{{ route('agent.vendors.store') }}"
      method="POST">

    @csrf

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0 h6">
                Vendor Information
            </h5>
        </div>

        <div class="card-body">

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Name
                </label>
                <div class="col-md-10">
                    <input type="text"
                           name="name"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Email
                </label>
                <div class="col-md-10">
                    <input type="email"
                           name="email"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Phone
                </label>
                <div class="col-md-10">
                    <input type="text"
                           name="phone"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Password
                </label>
                <div class="col-md-10">
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Confirm Password
                </label>
                <div class="col-md-10">
                    <input type="password"
                           name="confirm_password"
                           class="form-control"
                           required>
                </div>
            </div>

            <hr>

            <h5 class="mb-4">
                Basic Information
            </h5>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Shop Name
                </label>
                <div class="col-md-10">
                    <input type="text"
                           name="shop_name"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Address
                </label>
                <div class="col-md-10">
                    <textarea name="address"
                              class="form-control"
                              rows="3"
                              required></textarea>
                </div>
            </div>

            <div class="text-right">
                <button type="submit"
                        class="btn btn-primary">
                    Create Vendor
                </button>
            </div>

        </div>

    </div>

</form>

@endsection