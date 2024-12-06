@extends('SuperAdmin.sidebar')
@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Event Reports | <span style="color:orange"><b>{{ $events->event }}</b></span></h1>
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


                    <div class="card card-primary">
                        <div class="card-header">
                            <p class="card-text">Attendance Sheet</p>
                        </div>
                        <div class="card-body">



                            <table class="table table-hover table-bordered table-striped">
                                <thead class="table-dark">
                                    <th>Student</th>
                                    @php
                                        $get_event_Attendance = App\Models\Attendance::where('event_id', $events->id)->get();

                                    @endphp
                                    @foreach ($get_event_Attendance as $item_get_event_Attendance)
                                        <th>
                                            {{ $item_get_event_Attendance->att_type }} - Day# {{ $item_get_event_Attendance->day }}
                                        </th>
                                    @endforeach
                                </thead>
                                <tbody id="attendance_details_table_body">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        display_attendance();
        function display_attendance(){
            let rows = '';

            rows += `

                @php
                    $get_Students = App\Models\User::where('role', 'Student')->get();
                    $get_active_section = App\Models\SySection::where('status', 'Active')->get();
                    $get_event_Attendance_count = App\Models\Attendance::where('event_id', $events->id)->count();
                @endphp

                @foreach ($get_active_section as $item_get_active_section)


                    <tr>
                        <td colspan="{{ $get_event_Attendance_count + 1 }}" class="table-success" style="color:black"><a href="{{ url('/super-admin-reports/event-id=' . $events->id . '/section-id=' . $item_get_active_section->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-print"></i> View</a> | Section <b>{{ $item_get_active_section->section_name }}</b> | School Year : <b>{{$item_get_active_section->school_year}}</b> | Grade or College Level : <b>{{$item_get_active_section->grade_lvl}}</b>
                            @php
                                $get_section_members = App\Models\SchoolYearSectionDetails::where('sys_id',  $item_get_active_section->id)->get();
                            @endphp

                            @foreach ($get_section_members as $item_get_section_members)
                                <tr>
                                    <td>{{ $item_get_section_members->get_student->complete_name }}</td>
                                    @foreach ($get_event_Attendance as $item_get_event_Attendance)

                                        @php
                                            $get_attendance = App\Models\AttendanceDetail::where('attendance_id', $item_get_event_Attendance->id)->where('sys_d_id', $item_get_section_members->id)->count();
                                        @endphp

                                        <td>
                                            @if ($get_attendance == 0)
                                                <span style="padding:10px; border-radius:10px; background-color:red; color:white">Absent</span>
                                            @else
                                                <span style="padding:10px; border-radius:10px; background-color:green; color:white">Present</span>
                                            @endif
                                        </td>

                                    @endforeach
                                </tr>
                            @endforeach
                        </td>
                    </tr>

                @endforeach



            `;

            $('#attendance_details_table_body').html(rows);
        }
    </script>
@endsection
