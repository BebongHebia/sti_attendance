@extends('Admin.sidebar')
@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Events</h1>
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
                    <button class="btn btn-success" data-toggle="modal" data-target="#add_event_modal">
                        <i class="fas fa-plus"></i> Add Student
                    </button>
                    <div class="modal fade" id="add_event_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Event</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="add_event_form">
                                        @csrf

                                        <label>Event Name</label>
                                        <input type="text" name="event" class="form-control" placeholder="Event Name">

                                        <label>Description</label>
                                        <textarea name="description" class="form-control" cols="30" rows="10"></textarea>

                                        <label>Date</label>
                                        <input type="date" name="date" class="form-control">

                                        <label>Place</label>
                                        <input type="text" name="place" class="form-control" placeholder="Event Place">

                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="add_event(event)" class="btn btn-primary">Save changes</button>
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
                            <p class="card-text">List of Events</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped table-bordered" id="data_table">
                                <thead class="table-dark">
                                    <th>Event</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Place</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="event_table_body">

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
        fetch_event();
        function fetch_event(){
            $.ajax({
                type: "GET",
                url: `{{ url('/fetch-events') }}`,
                success: function (data) {
                    let rows = '';

                    $.each(data, function (index, events) {
                        rows += `
                            <tr>
                                <td>${events.event}</td>
                                <td>${events.description}</td>
                                <td>${events.date}</td>
                                <td>${events.place}</td>
                                <td>${events.status}</td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_event_modal${events.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_event_modal${events.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="delete_event_modal${events.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Event</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="delete_event_form${events.id}">
                                                        @csrf

                                                        <input type="hidden" name="event_id" value="${events.id}">

                                                        <h4 class="text-center">Are you sure you want to delete?</h4>

                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_event(event, ${events.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->


                                    <div class="modal fade" id="edit_event_modal${events.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Event</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit_event_form${events.id}">
                                                        @csrf

                                                        <input type="hidden" name="event_id" value="${events.id}">

                                                        <label>Event Name</label>
                                                        <input type="text" value="${events.event}" name="event" class="form-control" placeholder="Event Name">

                                                        <label>Description</label>
                                                        <textarea name="description" class="form-control" cols="30" rows="10">${events.description}</textarea>

                                                        <label>Date</label>
                                                        <input type="date" name="date" class="form-control" value="${events.date}">

                                                        <label>Place</label>
                                                        <input type="text" name="place" value="${events.place}" class="form-control" placeholder="Event Place">

                                                        <label>Status</label>
                                                        <select class="form-select select2" name="status">
                                                            <option value="${events.status}">${events.status} Current</option>
                                                            <option value="Incoming">Incoming</option>
                                                            <option value="Ongoing">Ongoing</option>
                                                            <option value="Finish">Finish</option>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="edit_event(event, ${events.id})" class="btn btn-primary">Save changes</button>
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

                    $('#event_table_body').html(rows);
                }
            });
        }

        function delete_event(event, event_id){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/delete-event') }}`,
                data: $('#delete_event_form' + event_id).serialize(),
                success: function (data) {
                    $('#delete_event_form' + event_id)[0].reset();
                    $('#delete_event_modal' + event_id).modal('hide');
                    fetch_event();
                    Swal.fire({
                        title: 'Deleted',
                        text: 'Event Deleted Successfully',
                        icon: 'warning',
                    });

                }
            });
        }

        function edit_event(event, event_id){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/edit-event') }}`,
                data: $('#edit_event_form' + event_id).serialize(),
                success: function (data) {
                    $('#edit_event_form' + event_id)[0].reset();
                    $('#edit_event_modal' + event_id).modal('hide');
                    fetch_event();
                    Swal.fire({
                        title: 'Edited',
                        text: 'Event Edited Successfully',
                        icon: 'success',
                    });

                }
            });
        }

        function add_event(event){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/add-event') }}`,
                data: $('#add_event_form').serialize(),
                success: function (data) {
                    $('#add_event_form')[0].reset();
                    $('#add_event_modal').modal('hide');
                    fetch_event();
                    Swal.fire({
                        title: 'Added',
                        text: 'Event Added Successfully',
                        icon: 'success',
                    });
                }
            });
        }
    </script>
@endsection
