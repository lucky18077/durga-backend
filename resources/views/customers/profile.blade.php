@extends('customers.layouts.main')
@section('main-section')
    @push('title')
        <title>Supplier Profile</title>
    @endpush



    <div class="card">
        <div class="card-header">
            Profile
        </div>
        <div class="card-body">
            <form action="{{ route('supplier/UpdateProfile') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $data->name }}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Number</label>
                        <input type="number" name="number" value="{{ $data->number }}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $data->email }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Address</label>
                        <input type="" name="address" value="{{ $data->address }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>State</label>
                        <select name="state" value="{{ $data->state }}" class="form-control">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>District</label>
                        <select name="district" value="{{ $data->district }}" class="form-control">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>City</label>
                        <input type="" name="city" value="{{ $data->city }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Pincode</label>
                        <input type="" name="pincode" value="{{ $data->pincode }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Password</label>
                        <input type="" name="password" value="{{ $data->password }}" class="form-control" required>
                    </div>
                    <div class="col-md-12 mt-4 text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
