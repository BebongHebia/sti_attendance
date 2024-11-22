@extends('SuperAdmin.sidebar')
@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reports</h1>
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
                                    <a href="{{ url('/super-admin-reports/event-id=${events.id}') }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>

                        `;
                    });

                    $('#event_table_body').html(rows);
                }
            });
        }

    </script>
@endsection
