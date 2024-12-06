@extends('SuperAdmin.sidebar')
@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Attendance</h1>
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
                    <button class="btn btn-success" data-toggle="modal" data-target="#add_attendance_modal">
                        <i class="fas fa-plus"></i> Add Attendance Sheet
                    </button>
                    <div class="modal fade" id="add_attendance_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Attendance</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="add_attendance_form">
                                        @csrf

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Select Event</label>
                                                <select class="form-select select2" name="event_id" id="select_event" onchange="get_event_Details(event)">
                                                    @php
                                                        $events = App\Models\Event::where('status', 'Ongoing')->get();
                                                    @endphp

                                                    @foreach ($events as $item_events)
                                                        <option value="{{ $item_events->id }}">{{ $item_events->event }}</option>
                                                    @endforeach
                                                </select>

                                                <label>Event</label>
                                                <input type="text" name="event" id="event" class="form-control" readonly>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Date</label>
                                                        <input type="date" name="date" id="date" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Place</label>
                                                        <input type="text" name="place" id="place" class="form-control" readonly>
                                                    </div>
                                                </div>



                                                <label>Attendance Type</label>
                                                <select class="form-select select2" name="att_type">
                                                   <option value="IN-AM">IN-AM</option>
                                                   <option value="OUT-AM">OUT-AM</option>
                                                   <option value="IN-PM">IN-PM</option>
                                                   <option value="OUT-PM">OUT-PM</option>
                                                </select>

                                            </div>
                                        </div>


                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="add_attendance(event)" class="btn btn-primary">Submit</button>
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
                            <p class="card-text">List of Attendance Sheet</p>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Filter By Event</label>
                                    <select class="form-select select2" id="event_id" style="width:100%;" onchange="filter_by_event();">
                                        @php
                                            $events = App\Models\Event::all();
                                        @endphp

                                        @foreach ($events as $item_events)
                                            <option value="{{ $item_events->id }}">{{ $item_events->event }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table table-hover table-bordered table-striped" id="data_table">
                                <thead class="table-dark">
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Place</th>
                                    <th>Attendance Type</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="attendance_table_body">

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
        display_attendance_sheet();



        function filter_by_event(){

            var event_id = $('#event_id').val();

            $.ajax({
                type: "GET",
                url: `{{ url('/filter-attendance-sheet/event-id=${event_id}') }}`,
                success: function (data) {
                    let rows = '';

                    $.each(data, function (index, attendance) {
                        rows += `
                            <tr>
                                <td>${attendance.get_event ? attendance.get_event.event : 'N/A'}</td>
                                <td>${attendance.date}</td>
                                <td>${attendance.place}</td>
                                <td>${attendance.att_type}</td>
                                <td>
                                    <a href="/super-admin-attendace/attendance-id=${attendance.id}" class="btn btn-warning">
                                        <i class="fas fa-file"></i>
                                    </a>

                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_attendance_modal${attendance.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_attendance_modal${attendance.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="delete_attendance_modal${attendance.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Attendance</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="delete_attendance_form${attendance.id}">
                                                        @csrf

                                                        <input type="hidden" name="att_id" value="${attendance.id}">

                                                        <h4 class="text-center">Are you sure you want to delete?</h4>


                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_attendance(event, ${attendance.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->


                                    <div class="modal fade" id="edit_attendance_modal${attendance.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Attendance</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit_attendance_form${attendance.id}">
                                                        @csrf

                                                        <input type="hidden" name="att_id" value="${attendance.id}">
                                                        <div class="row">
                                                            <div class="col-sm-12">


                                                                <label>Event</label>
                                                                <input type="text" name="event" id="event" class="form-control" value="${attendance.event}" readonly>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <label>Date</label>
                                                                        <input type="date"  name="date" id="date" class="form-control" value="${attendance.date}" readonly>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label>Place</label>
                                                                        <input type="text" name="place" id="place" class="form-control" value="${attendance.place}" readonly>
                                                                    </div>
                                                                </div>



                                                                <label>Attendance Type</label>
                                                                <select class="form-select select2" name="att_type">
                                                                    <option value="${attendance.att_type}">${attendance.att_type} Current </option>
                                                                    <option value="IN-AM">IN-AM</option>
                                                                    <option value="OUT-AM">OUT-AM</option>
                                                                    <option value="IN-PM">IN-PM</option>
                                                                    <option value="OUT-PM">OUT-PM</option>
                                                                </select>

                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="edit_attendance(event, ${attendance.id})" class="btn btn-primary">Save changes</button>
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
                    $('.select2').select2();
                }
            });
        }

        function display_attendance_sheet(){
            $.ajax({
                type: "GET",
                url: `{{ url('/fetch-attendance-sheet') }}`,
                success: function (data) {
                    let rows = '';

                    $.each(data, function (index, attendance) {
                        rows += `
                            <tr>
                                <td>${attendance.get_event ? attendance.get_event.event : 'N/A'}</td>
                                <td>${attendance.date}</td>
                                <td>${attendance.place}</td>
                                <td>${attendance.att_type}</td>
                                <td>
                                    <a href="/super-admin-attendace/attendance-id=${attendance.id}" class="btn btn-warning">
                                        <i class="fas fa-file"></i>
                                    </a>

                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_attendance_modal${attendance.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_attendance_modal${attendance.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="delete_attendance_modal${attendance.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Attendance</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="delete_attendance_form${attendance.id}">
                                                        @csrf

                                                        <input type="hidden" name="att_id" value="${attendance.id}">

                                                        <h4 class="text-center">Are you sure you want to delete?</h4>


                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_attendance(event, ${attendance.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->


                                    <div class="modal fade" id="edit_attendance_modal${attendance.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Attendance</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit_attendance_form${attendance.id}">
                                                        @csrf

                                                        <input type="hidden" name="att_id" value="${attendance.id}">
                                                        <div class="row">
                                                            <div class="col-sm-12">


                                                                <label>Event</label>
                                                                <input type="text" name="event" id="event" class="form-control" value="${attendance.event}" readonly>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <label>Date</label>
                                                                        <input type="date"  name="date" id="date" class="form-control" value="${attendance.date}" readonly>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label>Place</label>
                                                                        <input type="text" name="place" id="place" class="form-control" value="${attendance.place}" readonly>
                                                                    </div>
                                                                </div>



                                                                <label>Attendance Type</label>
                                                                <select class="form-select select2" name="att_type">
                                                                    <option value="${attendance.att_type}">${attendance.att_type} Current </option>
                                                                    <option value="IN-AM">IN-AM</option>
                                                                    <option value="OUT-AM">OUT-AM</option>
                                                                    <option value="IN-PM">IN-PM</option>
                                                                    <option value="OUT-PM">OUT-PM</option>
                                                                </select>

                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="edit_attendance(event, ${attendance.id})" class="btn btn-primary">Save changes</button>
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
                    $('.select2').select2();
                }
            });
        }

        function delete_attendance(event, att_id){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/delete-attendance') }}`,
                data: $('#delete_attendance_form' + att_id).serialize(),
                success: function (data) {
                    $('#delete_attendance_form' + att_id)[0].reset();
                    $('#delete_attendance_modal' + att_id).modal('hide');

                    display_attendance_sheet();

                    Swal.fire({
                        title: 'Deleted',
                        text: 'Attendance Deleted Successfully',
                        icon: 'warning',
                    });
                }
            });
        }

        function delete_attendance(event, att_id){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/delete-attendance') }}`,
                data: $('#delete_attendance_form' + att_id).serialize(),
                success: function (data) {
                    $('#delete_attendance_form' + att_id)[0].reset();
                    $('#delete_attendance_modal' + att_id).modal('hide');

                    display_attendance_sheet();

                    Swal.fire({
                        title: 'Deleted',
                        text: 'Attendance Deleted Successfully',
                        icon: 'warning',
                    });
                }
            });
        }

        function edit_attendance(event, att_id){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/edit_attendance') }}`,
                data: $('#edit_attendance_form' + att_id).serialize(),
                success: function (data) {
                    $('#edit_attendance_form' + att_id)[0].reset();
                    $('#edit_attendance_modal' + att_id).modal('hide');

                    display_attendance_sheet();

                    Swal.fire({
                        title: 'Edited',
                        text: 'Attendance Edited Successfully',
                        icon: 'success',
                    });
                }
            });
        }

        function add_attendance(event){
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: `{{ url('/add-attendance') }}`,
                data: $('#add_attendance_form').serialize(),
                success: function (data) {
                    $('#add_attendance_form')[0].reset();
                    $('#add_attendance_modal').modal('hide');
                    display_attendance_sheet();
                    Swal.fire({
                        title: 'Added',
                        text: 'Attendance Added Successfully',
                        icon: 'success',
                    });
                }
            });
        }

        function get_event_Details(event){

            var event_id = $('#select_event').val();

            event.preventDefault();
            $.ajax({
                type: "GET",
                url: `{{ url('/get-selected-event/event-id=${event_id}') }}`,
                success: function (data) {
                    $('#date').val(data.date);
                    $('#place').val(data.place);
                    $('#event').val(data.event);
                }
            });
        }
    </script>

    <script>

    </script>
@endsection
