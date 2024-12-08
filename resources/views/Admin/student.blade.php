@extends('Admin.sidebar')
@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Students</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-sm-10">
                        <button class="btn btn-success" data-toggle="modal" data-target="#add_student_modal">
                            <i class="fas fa-plus"></i> Add Student
                        </button>
                        <div class="modal fade" id="add_student_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Student</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add_student_form">
                                            @csrf
                                            <input type="hidden" name="role" value="Student">

                                            <label>Complete Name</label>
                                            <input type="text" name="complete_name" class="form-control" placeholder="Enter Complete name">

                                            <label>Sex</label>
                                            <select class="form-select select2" name="sex" style="width:100%">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>

                                            <label>Birthday</label>
                                            <input type="date" name="bday" class="form-control">

                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" placeholder="Enter Address">

                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone">

                                            <label>Parent Name</label>
                                            <input type="text" name="parent_name" class="form-control" placeholder="Enter Name of Parent">

                                            <label>Parent Contact</label>
                                            <input type="text" name="parent_contact" class="form-control" placeholder="Enter Parent Contact">

                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter Email">



                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" onclick="add_attendance_admin(event)" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>

                    <div class="col-sm-2">
                        <a href="{{ url('/admin-students/qr-codes') }}" class="btn btn-warning btn-block">
                            Generate QR Code
                        </a>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <p class="card-text">Student Master List</p>
                            </div>
                            <div class="card-body">
                                <table class="table tabe-hover table-striped table-bordered" id="data_table">
                                    <thead class="table-dark">
                                        <th>Complete Name</th>
                                        <th>Sex</th>
                                        <th>Date of birth</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Parent Name</th>
                                        <th>Parent Contact</th>
                                        <th>Email</th>
                                        <th>QR Code</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody id="student_table_body">

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


    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<script>
    display_students();

    function display_students() {
        $.ajax({
            type: "GET"
            , url: `{{ url('/get-student') }}`
            , success: function(data) {
                let rows = '';

                $.each(data, function(index, students) {
                    rows += `

                            <tr>
                                <td>${students.complete_name}</td>
                                <td>${students.sex}</td>
                                <td>${students.bday}</td>
                                <td>${students.address}</td>
                                <td>${students.phone}</td>
                                <td>${students.parent_name}</td>
                                <td>${students.parent_contact}</td>
                                <td>${students.email}</td>
                                <td>
                                    <img src='https://barcode.tec-it.com/barcode.ashx?data=${students.system_no}&code=MobileQRUrl'/>
                                </td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_student_modal${students.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_student_modal${students.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <button class="btn btn-warning" data-toggle="modal" data-target="#reset_account_sec_modal${students.id}">
                                        <i class="fas fa-circle"></i>
                                    </button>

                                    <div class="modal fade" id="reset_account_sec_modal${students.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Reset Account</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="reset_acc_form${students.id}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="${students.id}">

                                                    <h5 class="text-center">Confirming Account Reset</h5>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="reset_account(event, ${students.id})" class="btn btn-warning">Confirm</button>
                                                </div>
                                            </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                    <div class="modal fade" id="delete_student_modal${students.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Delete Student</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="delete_student_form${students.id}">
                                                    @csrf
                                                    <input type="hidden" name="role" value="Admin">
                                                    <input type="hidden" name="user_id" value="${students.id}">

                                                    <h5 class="text-center">Confirming Delete Student</h5>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_student(event, ${students.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->


                                    <div class="modal fade" id="edit_student_modal${students.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Student Modal</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="edit_student_form${students.id}">
                                                    @csrf
                                                    <input type="hidden" name="role" value="Student">
                                                    <input type="hidden" name="user_id" value="${students.id}">

                                                    <label>Complete Name</label>
                                                    <input type="text" name="complete_name" value="${students.complete_name}" class="form-control" placeholder="Enter Complete name">

                                                    <label>Sex</label>
                                                    <select class="form-select select2" name="sex">
                                                        <option value="${students.sex}">${students.sex}</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>

                                                    <label>Birthday</label>
                                                    <input type="date" value="${students.bday}" name="bday" class="form-control">

                                                    <label>Address</label>
                                                    <input type="text" value="${students.address}" name="address" class="form-control" placeholder="Enter Address">

                                                    <label>Phone</label>
                                                    <input type="text" value="${students.phone}" name="phone" class="form-control" placeholder="Enter Phone">

                                                    <label>Email</label>
                                                    <input type="email" value="${students.email}" name="email"  class="form-control" placeholder="Enter Email">

                                                    <label>Parent Name</label>
                                                    <input type="text" value="${students.parent_name}" name="parent_name"  class="form-control" placeholder="Enter Email">

                                                    <label>Parent Contact</label>
                                                    <input type="text" value="${students.parent_contact}" name="parent_contact"  class="form-control" placeholder="Enter Email">

                                                    <label>Status</label>
                                                    <select class="form-select select2" name="status">
                                                        <option value="${students.status}" selected>${students.status} Selected</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="edit_student(event, ${students.id})" class="btn btn-primary">Save changes</button>
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

                $('#student_table_body').html(rows);
                $('.select2').select2();
            }
        });
    }

    function reset_account(event, student_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/reset-account') }}`,
            data: $('#reset_acc_form' + student_id).serialize(),
            success: function (data) {
                $('#reset_acc_form' + student_id)[0].reset();
                $('#reset_account_sec_modal' + student_id).modal('hide');

                Swal.fire({
                    title: 'Success',
                    text: 'Account Reseted',
                    icon: 'success',
                });
            }
        });
    }

    function delete_student(event, student_id) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/delete-user') }}`,
            data: $('#delete_student_form' + student_id).serialize(),
            success: function (data) {
                $('#delete_student_form' + student_id)[0].reset();
                $('#delete_student_modal' + student_id).modal('hide');
                display_students();

                Swal.fire({
                    title: 'Deleted'
                    , text: 'Student Deleted successfully'
                    , icon: 'warning',
                 });
            }
        });
    }


    function edit_student(event, student_id) {
        event.preventDefault();

        $.ajax({
            type: "POST"
            , url: `{{ url('/edit-user') }}`
            , data: $('#edit_student_form' + student_id).serialize()
            , success: function(data) {
                $('#edit_student_form' + student_id)[0].reset();
                $('#edit_student_modal' + student_id).modal('hide');
                display_students();

                Swal.fire({
                    title: 'Edited'
                    , text: 'Student Edited successfully'
                    , icon: 'success'
                , });
            }
        });
    }

    function add_attendance_admin(event) {
        event.preventDefault();

        $.ajax({
            type: "POST"
            , url: `{{ url('/add-user') }}`
            , data: $('#add_student_form').serialize()
            , success: function(data) {
                $('#add_student_form')[0].reset();
                $('#add_student_modal').modal('hide');
                display_students();
                Swal.fire({
                    title: 'Added'
                    , text: 'Student added successfully'
                    , icon: 'success'
                , });

            }
        });
    }

</script>

@endsection
