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
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Info boxes -->
        <div class="row">

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Upcomming Event</span>
                        <span class="info-box-number">
                            @php
                            $get_upcomming_event = App\Models\Event::where('status', 'Upcomming')->count();
                            @endphp
                            {{ $get_upcomming_event }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">My Recent Attendance</span>
                        <span class="info-box-number">

                            @php
                                $get_my_current_section = App\Models\SchoolYearSectionDetails::where('student_id', auth()->user()->id)->latest()->first();
                                $my_attendance = App\Models\AttendanceDetail::where('sys_d_id', $get_my_current_section->id)->count();
                            @endphp
                            {{ $my_attendance }}

                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tree"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Current Section</span>
                        <span class="info-box-number">

                            @php
                                $get_my_current_section = App\Models\SchoolYearSectionDetails::where('student_id', auth()->user()->id)->latest()->first();

                            @endphp
                            {{ $get_my_current_section->get_section->section_name }} | {{ $get_my_current_section->get_section->school_year }} | {{ $get_my_current_section->get_section->grade_lvl }}

                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-sm-12">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-dark">
                            <div class="card-header">
                                <p class="card-text">Upcomming Event</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                            <img class="img-fluid mySlides" src="{{ asset('/images/image_1.jpg') }}" style="width:100%">
                                            <img class="img-fluid mySlides" src="{{ asset('/images/image_2.jpg') }}" style="width:100%">
                                            <img class="img-fluid mySlides" src="{{ asset('/images/image_3.jpg') }}" style="width:100%">
                                            <img class="img-fluid mySlides" src="{{ asset('/images/image_4.jpg') }}" style="width:100%">
                                            <img class="img-fluid mySlides" src="{{ asset('/images/image_5.jpg') }}" style="width:100%">
                                        </center>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card card-dark">
                            <div class="card-header">
                                <p class="card-text">Latest Attendance</p>
                            </div>
                            <div class="card-body">
                                <table class="table tabl-hover table-striped table-bordered" id="data_table">
                                    <thead class="table-warning" style="color:black">
                                        <th>Event</th>
                                        <th>Attendance Type</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $get_attendance = App\Models\Attendance::all();
                                        @endphp

                                        @foreach ($get_attendance as $item_get_attendance)
                                            <tr>
                                                <td>{{ $item_get_attendance->get_event->event }}</td>
                                                <td>{{ $item_get_attendance->att_type }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {myIndex = 1}
        x[myIndex-1].style.display = "block";
        setTimeout(carousel, 2000); // Change image every 2 seconds
    }
</script>
@endsection
