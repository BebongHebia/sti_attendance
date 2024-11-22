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
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/user4-128x128.jpg') }}" alt="User profile picture">
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
    function display_parent_student(){
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
                                    <span style="color:orange; font-weight:bold">${parent_students.get_sy_section ? parent_students.get_sy_section.section_name : 'N/A'}</span> |
                                    <span style="color:orange; font-weight:bold">${parent_students.get_sy_section ? parent_students.get_sy_section.grade_lvl : 'N/A'}</span> |
                                    <span style="color:orange; font-weight:bold">${parent_students.get_sy_section ? parent_students.get_sy_section.school_year : 'N/A'}</span> |
                                    <span style="color:white; font-weight:bold">${parent_students.get_student ? parent_students.get_student.complete_name : 'N/A'}</span>
                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
