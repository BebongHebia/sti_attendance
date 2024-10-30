@extends('SuperAdmin.sidebar')
@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Attendance Admin</h1>
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
                <button class="btn btn-success" data-toggle="modal" data-target="#add_attendance_admin_modal">
                    <i class="fas fa-plus"></i> Add Attendance Admin
                </button>
                <div class="modal fade" id="add_attendance_admin_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Attendance Admin</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add_attendance_admin_form">
                                    @csrf
                                    <input type="hidden" name="role" value="Admin">

                                    <label>Complete Name</label>
                                    <input type="text" name="complete_name" class="form-control" placeholder="Enter Complete name">

                                    <label>Sex</label>
                                    <select class="form-select select2" name="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>

                                    <label>Birthday</label>
                                    <input type="date" name="bday" class="form-control">

                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Enter Address">

                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone">

                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email">

                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Enter Email">

                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password">

                                    <label>Confirm Password</label>
                                    <input type="password" name="c_password" class="form-control" placeholder="Confirm Password">


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
        </div>

        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <p class="card-text">Attendance Admin</p>
                    </div>
                    <div class="card-body">
                        <table class="table tabe-hover table-striped table-bordered" id="data_table">
                            <thead>
                                <th>Complete Name</th>
                                <th>Sex</th>
                                <th>Date of birth</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="att_admin_table_body">

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
    display_attendance_admin();

    function display_attendance_admin() {
        $.ajax({
            type: "GET"
            , url: `{{ url('/get-attendance-admin') }}`
            , success: function(data) {
                let rows = '';

                $.each(data, function(index, att_admin) {
                    rows += `

                            <tr>
                                <td>${att_admin.complete_name}</td>
                                <td>${att_admin.sex}</td>
                                <td>${att_admin.bday}</td>
                                <td>${att_admin.address}</td>
                                <td>${att_admin.phone}</td>
                                <td>${att_admin.email}</td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_attendance_admin_modal${att_admin.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <div class="modal fade" id="edit_attendance_admin_modal${att_admin.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Attendance Admin</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="add_attendance_admin_form">
                                                    @csrf
                                                    <input type="hidden" name="role" value="Admin">
                                                    <input type="hidden" name="att_admin_id" value="${att_admin.id}">

                                                    <label>Complete Name</label>
                                                    <input type="text" name="complete_name" value="${att_admin.complete_name}" class="form-control" placeholder="Enter Complete name">

                                                    <label>Sex</label>
                                                    <select class="form-select select2" name="sex">
                                                        <option value="${att_admin.sex}">${att_admin.sex}</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>

                                                    <label>Birthday</label>
                                                    <input type="date" value="${att_admin.bday}" name="bday" class="form-control">

                                                    <label>Address</label>
                                                    <input type="text" value="${att_admin.address}" name="address" class="form-control" placeholder="Enter Address">

                                                    <label>Phone</label>
                                                    <input type="text" value="${att_admin.phone}" name="phone" class="form-control" placeholder="Enter Phone">

                                                    <label>Email</label>
                                                    <input type="email" value="${att_admin.email}" name="email"  class="form-control" placeholder="Enter Email">

                                                    <label>Username</label>
                                                    <input type="text" value="${att_admin.username}" name="username" class="form-control" placeholder="Enter Email">


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


                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        `;
                });

                $('#att_admin_table_body').html(rows)
            }
        });
    }

    function add_attendance_admin(event) {
        event.preventDefault();

        $.ajax({
            type: "POST"
            , url: `{{ url('/add-attendance-admin') }}`
            , data: $('#add_attendance_admin_form').serialize()
            , success: function(data) {
                $('#add_attendance_admin_form')[0].reset();
                $('#add_attendance_admin_modal').modal('hide');
                display_attendance_admin();
                Swal.fire({
                    title: 'Added'
                    , text: 'Attendance Admin added successfully'
                    , icon: 'success'
                , });

            }
        });
    }

</script>

@endsection
