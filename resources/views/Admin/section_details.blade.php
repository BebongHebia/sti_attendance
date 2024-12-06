@extends('Admin.sidebar')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Section Details</h1>
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
                <h4 class="text-start">Section : <span style="color:orange"><b>{{ $section->section_name }}</b></span></h4>
                <p class="text-start">School Year : <span style="color:orange"><b>{{ $section->school_year }}</b></span> <br>
                    Grade Level : <span style="color:orange"><b>{{ $section->grade_lvl }}</b></span>
                </p>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <p class="text-start">List of Students</p>

                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped" id="data_table">
                            <thead class="table-dark">
                                <th>Complete name</th>
                                <th>Sex</th>
                                <th>Phone</th>
                                <th>I.D No.#</th>
                                <th>
                                    Action
                                </th>
                            </thead>
                            <tbody id="student_list_table_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <p class="text-start">Section Details</p>

                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-striped" id="data_table_1">
                            <thead class="table-dark">
                                <th>Complete name</th>
                                <th>
                                    Action
                                </th>
                            </thead>
                            <tbody id="section_details_table_body">

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


    display_section_details();
    display_student();
    function display_student(){
        $.ajax({
            type: "GET",
            url: `{{ url('/get-student') }}`,
            success: function (data) {
                let rows = '';

                $.each(data, function (index, student) {
                    rows += `

                        <tr>
                            <td>${student.complete_name}</td>
                            <td>${student.sex}</td>
                            <td>${student.phone}</td>
                            <td>${student.system_no}</td>
                            <td>
                                <button class="btn btn-success" onclick="add_student(event, ${student.id})">
                                    <i class="fas fa-plus"></i>
                                </button>

                                <form id="add_student_form${student.id}">
                                    @csrf
                                    <input type="hidden" name="student_id" value="${student.id}">
                                    <input type="hidden" name="sys_id" value="{{ $section->id }}">
                                </form>
                            </td>
                        </tr>

                    `;
                });

                $('#student_list_table_body').html(rows);
            }
        });
    }

    function display_section_details(){

       $.ajax({
        type: "GET",
        url: `{{ url('/fetch-section-details/sys=' . $section->id) }}`,
        success: function (data) {
            let rows = '';

            $.each(data, function (index, section_member) {
                rows += `
                    <tr>
                        <td>${section_member.get_student ? section_member.get_student.complete_name : "N/A" }</td>
                        <td>
                            <button class="btn btn-danger" onclick="remove_member(event, ${section_member.id})">
                                <i class="fas fa-trash"></i>
                            </button>

                            <form id="remove_sys_details_form${section_member.id}">
                                @csrf

                                <input type="hidden" name="sys_d_id" value="${section_member.id}">
                            </form>
                        </td>
                    </tr>

                `;
            });

            $('#section_details_table_body').html(rows);
        }
       });
    }

    function remove_member(event, member_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/remove-sys-details') }}`,
            data: $('#remove_sys_details_form' + member_id).serialize(),
            success: function (data) {
                $('#remove_sys_details_form' + member_id)[0].reset();
                display_section_details();
            }
        });
    }


    function add_student(event, student_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/add-student-sysd') }}`,
            data: $('#add_student_form' + student_id).serialize(),
            success: function (data) {
                $('#add_student_form' + student_id)[0].reset();
                display_section_details();

            }
        });
    }
</script>
@endsection
