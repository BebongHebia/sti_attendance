@extends('student.sidebar')
@section('content')

@php
    $get_latest_sec = App\Models\SchoolYearSectionDetails::where('student_id', auth()->user()->id)->latest()->first();
    $get_latest_sec_count = App\Models\SchoolYearSectionDetails::where('student_id', auth()->user()->id)->latest()->count();


    if($get_latest_sec_count == 0){
        $latest_section_id = 0;
    }else{

        $latest_section_id = $get_latest_sec->id;
    }

@endphp


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Attendance</h1>
                    <input type="hidden" value="{{ $latest_section_id }}" id="student_id">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">

                    @php
                        $get_events = App\Models\Event::all();
                    @endphp

                    @foreach ($get_events as $item_get_events)
                        <div class="card card-primary mt-2 collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <span style="color:orange">
                                        <b>
                                            {{ $item_get_events->event }}
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
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                        @php
                                            $get_attendance = App\Models\Attendance::where('event_id', $item_get_events->id)->get();
                                            $get_attendance_count = App\Models\Attendance::where('event_id', $item_get_events->id)->count();
                                        @endphp
                                        @foreach ($get_attendance as $item_get_attendance)
                                            <th>
                                                {{ $item_get_attendance->att_type }}
                                            </th>
                                        @endforeach
                                    </thead>
                                    <tbody>

                                    
                                    @if($get_attendance_count == 0)

                                    


                                    @else

                                    <tr>
                                            @foreach ($get_attendance as $item_get_attendance)


                                                    @php
                                                        $get_attendance_count = App\Models\AttendanceDetail::where('attendance_id', $item_get_attendance->id)->where('sys_d_id', $get_latest_sec->id)->count();
                                                    @endphp

                                                    @if ($get_attendance_count == 0)
                                                        <td><span style="padding:10px; border-radius:10px; background-color:red; color:white;"><b>Absent</b></span></td>
                                                    @else
                                                        <td><span style="padding:10px; border-radius:10px; background-color:green; color:white;"><b>Present</b></span></td>

                                                    @endif


                                            @endforeach
                                        </tr>

                                    @endif

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach





                </div>
            </div>




        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <script>

    </script>
@endsection

