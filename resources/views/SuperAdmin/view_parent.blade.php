@extends('SuperAdmin.sidebar')
@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View Parent</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">




        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/profile.png') }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $parent->complete_name }}</h3>

                        <p class="text-muted text-center">{{ $parent->role }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Sex</b> <a class="float-right">{{ $parent->sex }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Date of Birth</b> <a class="float-right">{{ $parent->bday }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <a class="float-right">{{ $parent->address }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <a class="float-right">{{ $parent->phone }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $parent->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>System No.#</b> <a class="float-right">{{ $parent->system_no }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">My Students</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#add_parent_student_modal">
                                            <i class="fas fa-plus"></i> Add Student
                                        </button>

                                        <div class="modal fade" id="add_parent_student_modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Add Parent Sudent</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add_parent_student_form">
                                                            @csrf

                                                            <label>Select Section</label>
                                                            <select class="form-select select2" name="sy_section" id="school_year_section" onchange="get_section_member(event)">
                                                                @php
                                                                    $get_sy_section = App\Models\SySection::where('status', 'Active')->get();
                                                                @endphp

                                                                @foreach ($get_sy_section as $item_get_sy_section)
                                                                    <option value="{{ $item_get_sy_section->id }}">{{ $item_get_sy_section->section_name }} | <span style="color:orange"><b>{{ $item_get_sy_section->grade_lvl }}</b></span> | {{ $item_get_sy_section->school_year }}</option>
                                                                @endforeach
                                                            </select>

                                                            <input type="hidden" name="parent_id" value="{{$parent->id}}">
                                                            <label>Select Student</label>
                                                            <select class="form-select select2" name="student_id" id="student_id">
                                                            </select>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="button" onclick="add_parent_student(event)" class="btn btn-primary">Add Student</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->


                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="parent_student_container">

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->



    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<script>
    display_parent_student();
    function get_event_attendance(event, sys_d_id) {
    event.preventDefault();

    // Get the selected event_id from the dropdown
    var event_id = $('#event_id_' + sys_d_id).val();

    // Make the first AJAX call to fetch attendance types (AM-IN, AM-OUT, PM-IN, PM-OUT)
    $.ajax({
        type: "GET",
        url: `{{ url('/get_event_attendance/event-id=${event_id}') }}`, // Dynamic URL
        success: function (data) {
            let rows_header = '';
            let rows_body = '';
            let attendanceCounts = {};

            // Generate table headers dynamically based on the attendance types fetched
            $.each(data, function (index, attendance) {
                rows_header += `
                    <th>${attendance.att_type}</th>
                `;

                // Prepare the attendance types to be used for fetching counts
                attendanceCounts[attendance.att_type] = null;
            });

            // Set the table headers (do this once)
            $('#table_header' + sys_d_id).html(rows_header);

            let requestsRemaining = data.length;  // Track remaining AJAX requests for attendance counts

            // Now, loop through each attendance type to fetch attendance counts
            $.each(data, function (index, attendance) {
                $.ajax({
                    type: "GET",
                    url: `{{ url('/get-attendance/event-id=${event_id}/sys-d-id=${sys_d_id}/attendance-id=${attendance.id}') }}`, // Dynamic URL
                    success: function (attendanceCount) {
                        // Store the attendance count in the corresponding attendance type slot
                        attendanceCounts[attendance.att_type] = attendanceCount;

                        // Once all the attendance counts are fetched, build the table row
                        requestsRemaining--;

                        // After all AJAX requests are completed, construct the table row with all counts
                        if (requestsRemaining === 0) {
                            rows_body = '<tr>';
                            $.each(attendanceCounts, function (type, count) {

                                if (count == 0){
                                    rows_body += `<td><span style="border-radius:10px; padding:5px; background-color:red; color:white;">Absent</span></td>`;
                                }else{
                                    rows_body += `<td><span style="border-radius:10px; padding:5px; background-color:green; color:white;">Present</span></td>`;
                                }



                            });
                            rows_body += '</tr>';

                            // Update the table body with the newly constructed row
                            $('#table_body' + sys_d_id).html(rows_body);
                        }
                    }
                });
            });
        }
    });

    console.log(sys_d_id);
}



function display_parent_student() {
    var parent_id = {{ $parent->id }};

    $.ajax({
        type: "GET",
        url: `{{ url('/get-parent-student/parent-id=${parent_id}') }}`,
        success: function (data) {
            let rows = '';

            $.each(data, function (index, parent_students) {
                rows += `
                    <div class="card card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span style="color:orange; font-weight:bold">${parent_students.get_student_section ? parent_students.get_student_section.get_section.section_name : 'N/A'}</span> |
                                <span style="color:orange; font-weight:bold">${parent_students.get_student_section ? parent_students.get_student_section.get_section.grade_lvl : 'N/A'}</span> |
                                <span style="color:orange; font-weight:bold">${parent_students.get_student_section ? parent_students.get_student_section.get_section.school_year : 'N/A'}</span> |
                                <span style="color:white; font-weight:bold">${parent_students.get_student_section ? parent_students.get_student_section.get_student.complete_name : 'N/A'}</span>
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Select Event</label>
                                    <select class="form-select select2" id="event_id_${parent_students.id}" name="event_id_${parent_students.id}" style="width:100%;" onchange="get_event_attendance(event, ${parent_students.id})">
                                        @php
                                            $event = App\Models\Event::all();
                                        @endphp

                                        @foreach ($event as $item_event)
                                            <option value="{{ $item_event->id }}">{{ $item_event->event }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table table-hover table-bordered table-striped mt-2">
                                <thead id="table_header${parent_students.id}"></thead>
                                <tbody id="table_body${parent_students.id}"></tbody>
                            </table>
                        </div>
                    </div>
                `;
            });

            $('#parent_student_container').html(rows);
        }
    });
}


    function add_parent_student(event) {
        event.preventDefault();

        $.ajax({
            type: "POST"
            , url: `{{ url('/add-student-parent') }}`
            , data: $('#add_parent_student_form').serialize()
            , success: function(data) {
                $('#add_parent_student_form')[0].reset();
                $('#add_parent_student_modal').modal('hide');
                display_parent_student();
                Swal.fire({
                    title:  'Added',
                    text:  'Parent Student Added Successfuly',
                    icon:  'success',
                });
            }
        });
    }

    function get_section_member(event) {

        var section_id = $('#school_year_section').val();
        event.preventDefault();

        $.ajax({
            type: "GET"
            , url: `{{ url('/fetch-section-member/section-id=${section_id}') }}`
            , success: function(data) {
                let rows = '';

                $.each(data, function(index, section_member) {
                    rows += `
                        <option value="${section_member.id}">${section_member.get_student ? section_member.get_student.complete_name : 'N/A'}</option>

                    `;
                });

                $('#student_id').html(rows);
            }
        });

    }

</script>
@endsection
