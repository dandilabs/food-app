@extends('components.welcome')
@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h4 class="page-title">Add Users</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        @if ($errors->any())
            <div class="mb-5" role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                    There's something wrong
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                    <p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </p>
                </div>
            </div>
        @endif

        <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" value="{{old('name')}}" placeholder="User Name" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="{{old('email')}}" placeholder="Email">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Image</label>
                        <div class="profile-upload">
                            <div class="upload-input">
                                <input type="file" name="profile_photo_path" placeholder="Avatar" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" value="{{old('password')}}" name="password" placeholder="User password" type="password">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input class="form-control" value="{{old('password_confirmation')}}" placeholder="Confirmation password" name="password_confirmation" type="password">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" value="{{old('address')}}" name="address" placeholder="User address" class="form-control ">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="form-group">
                        <label>Roles</label>
                        <select class="form-control select" name="roles">
                            <option value="USER">User</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" value="{{old('city')}}" name="city" placeholder="User City" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Phone </label>
                        <input class="form-control" value="{{old('phoneNumber')}}" name="phoneNumber" placeholder="Phone number" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>House Number </label>
                        <input class="form-control" value="{{old('houseNumber')}}" name="houseNumber" placeholder="House number" type="text">
                    </div>
                </div>
            </div>
            <div class="m-t-20 text-center">
                <button class="btn btn-primary submit-btn" type="submit">Save User</button>
            </div>
        </form>
    </div>
</div>
@endsection