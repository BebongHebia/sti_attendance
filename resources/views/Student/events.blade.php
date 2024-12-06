@extends('Student.sidebar')
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
