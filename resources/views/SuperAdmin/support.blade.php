@extends('SuperAdmin.sidebar')
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Supports</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        @php
            $get_user_message = App\Models\Support::groupBy('user_id')->get();
        @endphp

        @foreach ($get_user_message as $item_get_user_message)
            <div class="card card-primary mt-2 collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <span style="color:orange">
                            <b>
                                {{ $item_get_user_message->get_user->complete_name }}
                            </b>
                        </span>

                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Expand">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <span class="text-start" style="font-style: italic; color:aqua">Latest Message</span><br>
                    @php
                        $get_latest_message = App\Models\Support::where('user_id', $item_get_user_message->user_id)->latest()->first();
                    @endphp
                    {{ $get_latest_message->message }}

                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ url('/super-admin-support/details/user-id=' . $item_get_user_message->user_id) }}" class="btn btn-warning">
                                <i class="fas fa-search"></i> View Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection
