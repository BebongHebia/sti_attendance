@extends('SuperAdmin.sidebar')
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Supports Details</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">

        <div class="row">
            <div class="col-sm-12">

                <div id="message_container">

                </div>


            </div>
        </div>


    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<script>
    display_message();
    function display_message(){
        var user_id = $('#user_id').val();

        $.ajax({
            type: "GET",
            url: `{{ url('/get-my-message/user-id=${user_id}') }}`,
            success: function (data) {
                let rows = '';

                $.each(data, function (index, message) {

                    const date = new Date(message.created_at);
                    const formattedDate = date.toISOString().split('.')[0].replace('T', ' ');

                    rows += `

                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">${message.get_user.complete_name}</span> <br>
                                <span class="direct-chat-timestamp float-left"> ${formattedDate}</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="{{ url('dist/img/user3-128x128.jpg') }}" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                ${message.message}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>


                    `;

                    console.log(message.id);
                });

                $('#message_container').html(rows);
            }
        });
    }
</script>
@endsection
