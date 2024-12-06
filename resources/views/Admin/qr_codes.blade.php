@extends('Admin.sidebar')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QR Codes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-3">
                    <input type="text" id="search_text" class="form-control" placeholder="Please enter Student" oninput="search(event)">
                </div>
                <div class="col-sm-7">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-warning btn-block" onclick="window.print();">
                        <i class="fas fa-print"></i> Print QR Code
                    </button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <p class="card-text">List of Sudents QR Codes</p>
                        </div>
                        <div class="card-body">

                            <div class="row" id="qr_code_container">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        fetch_qr_code();
        function fetch_qr_code(){
            $.ajax({
                type: "GET",
                url: `{{ url('/get-student') }}`,
                success: function (data) {
                    let rows = '';

                    $.each(data, function (index, students) {

                        rows += `

                            <div class="col-sm-2 mt-2" style="border:1px solid white; border-radius:10px; padding:10px;">
                                <center>
                                    <img src='https://barcode.tec-it.com/barcode.ashx?data=${students.system_no}&code=MobileQRUrl' style="width:90%" class="img-fluid"/>
                                    <p class="text-center"  style="color:red"><b>${students.system_no}</b> <br> ${students.complete_name}</p>
                                </center>

                            </div>

                        `;

                    });

                    $('#qr_code_container').html(rows);
                }
            });
        }

        function search(event){




            event.preventDefault();

            var search_text = $('#search_text').val();

            if (search_text.length >= 3){
                $.ajax({
                    type: "GET",
                    url: `{{ url('/search-student/key=${search_text}') }}`,
                    success: function (data) {
                        let rows = '';

                        $.each(data, function (index, students) {

                            rows += `

                                <div class="col-sm-2 mt-2">
                                    <img src='https://barcode.tec-it.com/barcode.ashx?data=${students.system_no}&code=MobileQRUrl' style="width:100%" class="img-fluid"/>
                                    <p class="text-center">${students.system_no}</p>
                                    <p class="text-center">${students.complete_name}</p>
                                </div>

                            `;

                        });

                        $('#qr_code_container').html(rows);
                    }
                });
            }else{
                fetch_qr_code();
            }


        }
    </script>
@endsection
