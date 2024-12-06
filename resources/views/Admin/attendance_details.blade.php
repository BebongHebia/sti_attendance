@extends('Admin.sidebar')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Attendance Details <span style="color:orange; font-weight:bold">{{ $attendance_details->get_event->event }}</span> - <span style="color:orange; font-weight:bold">{{ $attendance_details->att_type }}</span></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <input type="hidden" name="att_id" value="{{ $attendance_details->id }}" id="att_id">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <p class="card-text">List of Attendee</p>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered table-striped" id="data_table">
                        <thead class="table-dark">
                            <th>Student</th>
                            <th>Student No.#</th>
                            <th>Date/Time</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="attendance_table_body">

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        display_attendance_details();
        function display_attendance_details(){

            var att_id = $('#att_id').val();


            $.ajax({
                type: "GET",
                url: `{{ url('/fetch-attendance-details/att-d-id=${att_id}') }}`,
                success: function (data) {
                    let rows = '';

                    $.each(data, function (index, attendance_details) {
                        rows += `

                            <tr>
                                <td>${attendance_details.get_section_details.get_student ? attendance_details.get_section_details.get_student.complete_name : 'N/A'}</td>
                                <td>${attendance_details.get_section_details.get_student ? attendance_details.get_section_details.get_student.system_no : 'N/A'}</td>
                                <td>${attendance_details.created_at}</td>
                                <td>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_attendance_modal${attendance_details.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="delete_attendance_modal${attendance_details.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Attendance</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="delete_attendance_form${attendance_details.id}">
                                                        @csrf

                                                        <input type="hidden" name="att_d_id" value="${attendance_details.id}">

                                                        <h5 class="text-center">Are you sure you want to delete?</h5>



                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_att_details(event, ${attendance_details.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                </td>
                            </tr>

                        `;
                    });

                    $('#attendance_table_body').html(rows);
                }
            });
        }


        function delete_att_details(event, att_d_id){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/delete-attendance-details') }}`,
                data: $('#delete_attendance_form' + att_d_id).serialize(),
                success: function (data) {
                    $('#delete_attendance_form' + att_d_id)[0].reset();
                    $('#delete_attendance_modal' + att_d_id).modal('hide');

                    display_attendance_details();

                    Swal.fire({
                        title: 'Deleted',
                        text: 'Attendance Details Deleted',
                        icon: 'success',
                    });
                }
            });
        }
    </script>
@endsection
