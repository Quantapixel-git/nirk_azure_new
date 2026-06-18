@extends('agent.layout.app')

@section('panel_content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">Manage Profile</h1>
        </div>
    </div>
</div>



<form action="{{ route('agent.profile.update') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Basic Information</h5>
        </div>

        <div class="card-body">

            {{-- Name --}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Name
                </label>

                <div class="col-md-10">
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>

                    @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Email
                </label>

                <div class="col-md-10">
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                        required>

                    @error('email')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>

            {{-- Mobile --}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Mobile
                </label>

                <div class="col-md-10">
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"
                        required>

                    @error('phone')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>

            <hr>

            <h5 class="mb-3">
                Change Password
            </h5>

            {{-- Password --}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    New Password
                </label>

                <div class="col-md-10">
                    <input type="password" name="password" class="form-control" placeholder="Enter New Password">

                    @error('password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>

            {{-- Confirm Password --}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Confirm Password
                </label>

                <div class="col-md-10">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">

                    @error('confirm_password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    Update Profile
                </button>
            </div>

        </div>
    </div>

</form>
@endsection