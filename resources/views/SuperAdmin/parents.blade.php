@extends('SuperAdmin.sidebar')
@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Parents</h1>
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

                <section class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-success" data-toggle="modal" data-target="#add_parent_modal">
                                    <i class="fas fa-plus"></i> Add Parent
                                </button>
                                <div class="modal fade" id="add_parent_modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add Parent</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add_parent_form">
                                                    @csrf
                                                    <input type="hidden" name="role" value="Parent">

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

                                                    <input type="hidden" name="parent_name" value="N/A" class="form-control" placeholder="Enter Name of Parent">

                                                    <input type="hidden" name="parent_contact" value="N/A" class="form-control" placeholder="Enter Parent Contact">

                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" placeholder="Enter Email">


                                                </form>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" onclick="add_parent(event)" class="btn btn-primary">Save changes</button>
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
                                            <thead class="table-dark">
                                                <th>Complete Name</th>
                                                <th>Sex</th>
                                                <th>Date of birth</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody id="parent_table_body">

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

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<script>

    display_parent();

    function display_parent(){
        $.ajax({
            type: "GET"
            , url: `{{ url('/get-parent') }}`
            , success: function(data) {
                let rows = '';

                $.each(data, function(index, parent) {
                    rows += `

                            <tr>
                                <td>${parent.complete_name}</td>
                                <td>${parent.sex}</td>
                                <td>${parent.bday}</td>
                                <td>${parent.address}</td>
                                <td>${parent.phone}</td>
                                <td>${parent.email}</td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_parent_modal${parent.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_parent_modal${parent.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <a href="{{ url('/super-admin-parents/view-parent/${parent.id}') }}" class="btn btn-warning">
                                        <i class="fas fa-info"></i>
                                    </a>

                                    <div class="modal fade" id="delete_parent_modal${parent.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Delete Parent</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="delete_parent_form${parent.id}">
                                                    @csrf
                                                    <input type="hidden" name="role" value="Parent">
                                                    <input type="hidden" name="user_id" value="${parent.id}">

                                                    <h5 class="text-center">Confirming Delete Student</h5>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_parent(event, ${parent.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->


                                    <div class="modal fade" id="edit_parent_modal${parent.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Parent Modal</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="edit_parent_form${parent.id}">
                                                    @csrf
                                                    <input type="hidden" name="role" value="Student">
                                                    <input type="hidden" name="user_id" value="${parent.id}">

                                                    <label>Complete Name</label>
                                                    <input type="text" name="complete_name" value="${parent.complete_name}" class="form-control" placeholder="Enter Complete name">

                                                    <label>Sex</label>
                                                    <select class="form-select select2" name="sex">
                                                        <option value="${parent.sex}">${parent.sex}</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>

                                                    <label>Birthday</label>
                                                    <input type="date" value="${parent.bday}" name="bday" class="form-control">

                                                    <label>Address</label>
                                                    <input type="text" value="${parent.address}" name="address" class="form-control" placeholder="Enter Address">

                                                    <label>Phone</label>
                                                    <input type="text" value="${parent.phone}" name="phone" class="form-control" placeholder="Enter Phone">

                                                    <label>Email</label>
                                                    <input type="email" value="${parent.email}" name="email"  class="form-control" placeholder="Enter Email">

                                                    <label>Status</label>
                                                    <select class="form-select select2" name="status">
                                                        <option value="${parent.status}" selected>${parent.status} Selected</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="edit_parent(event, ${parent.id})" class="btn btn-primary">Save changes</button>
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

                $('#parent_table_body').html(rows);
                $('.select2').select2();
            }
        });
    }

    function delete_parent(event, user_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/delete-user') }}`,
            data: $('#delete_parent_form' + user_id).serialize(),
            success: function (data) {
                $('#delete_parent_form' + user_id)[0].reset();
                $('#delete_parent_modal' + user_id).modal('hide');
                display_parent();

                Swal.fire({
                    title: 'Deleted'
                    , text: 'Parent Deleted successfully'
                    , icon: 'warning',
                 });
            }
        });
    }

    function edit_parent(event, user_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/edit-user') }}`,
            data: $('#edit_parent_form' + user_id).serialize(),
            success: function (data) {
                $('#edit_parent_form' + user_id)[0].reset();
                $('#edit_parent_modal' + user_id).modal('hide');
                display_parent();

                Swal.fire({
                    title: 'Edited'
                    , text: 'Parent Edited successfully'
                    , icon: 'success',
                 });
            }
        });
    }

    function add_parent(event) {
        event.preventDefault();

        $.ajax({
            type: "POST"
            , url: `{{ url('/add-user') }}`
            , data: $('#add_parent_form').serialize()
            , success: function(data) {
                $('#add_parent_form')[0].reset();
                $('#add_parent_modal').modal('hide');
                display_parent();
                Swal.fire({
                    title: 'Added'
                    , text: 'Parent added successfully'
                    , icon: 'success'
                , });

            }
        });
    }

</script>
@endsection
