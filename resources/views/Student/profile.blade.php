@extends('Student.sidebar')
@section('content')


<head>
        <style>
            .mySlides {display:none;}
        </style>
</head>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profile</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-6">

                <h3 class="text-start">Profile Details</h3>

                <form action="{{ url('/save-profile') }}" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="parent_name" value="{{ auth()->user()->parent_name }}">
                    <input type="hidden" name="parent_contact" value="{{ auth()->user()->parent_contact }}">

                    <label>Name</label>
                    <input type="text" name="complete_name" class="form-control" value="{{ auth()->user()->complete_name }}">

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Sex</label>
                            <select class="form-select select2" name="sex" style="width: 100%;">
                                <option value="{{ auth()->user()->sex }}">{{ auth()->user()->sex }}</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Date of birth</label>
                            <input type="date" name="bday" class="form-control" value="{{ auth()->user()->bday }}">
                        </div>
                    </div>

                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}">

                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">

                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{ auth()->user()->email }}">


                    <button class="btn btn-success btn-block mt-2">
                        <i class="fas fa-save"></i> Save changes
                    </button>

                </form>
            </div>


            <div class="col-sm-6">

                <h3 class="text-start">Security Details</h3>

                <form action="{{ url('/save-user-security') }}" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ auth()->user()->username }}">

                    <label>Password</label>
                    <input type="password" name="password" class="form-control">

                    <hr>

                    <label>New Username</label>
                    <input type="text" name="n_username" class="form-control">

                    <label>New Password</label>
                    <input type="password" name="n_password" class="form-control">

                    <label>Confirm New Password</label>
                    <input type="password" name="cn_password" class="form-control">

                    <button class="btn btn-success btn-block mt-2">
                        <i class="fas fa-save"></i> Save Security
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->


@endsection
