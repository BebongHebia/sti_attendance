@extends('Parent.sidebar')
@section('content')


<head>
        <style>
            .mySlides {display:none;}
        </style>
</head>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Support</h1>
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
                <form id="parent_support_form">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                    <label>Chat Admin</label>
                    <textarea name="message" cols="30" class="form-control" placeholder="Enter Convern or Suggestions"></textarea>
                </form>
                <div class="row mt-2">
                    <div class="col-sm-3">
                        <button class="btn btn-success" onclick="add_support_message(event)">
                            <i class="fas fa-plus"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-sm-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <p class="card-text">My Support</p>
                    </div>
                    <div class="card-body">

                        <div id="message_container">

                        </div>


                    </div>
                </div>

            </div>
        </div>

    </div>
    <!--/. container-fluid -->
</section>

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
                    rows += `

                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">{{ auth()->user()->complete_name }}</span> <br>
                                <span class="direct-chat-timestamp float-left"> ${message.created_at}</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                ${message.message}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>


                    `;
                });

                $('#message_container').html(rows);
            }
        });
    }
    function add_support_message(event){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/add-support-message') }}`,
            data: $('#parent_support_form').serialize(),
            success: function (data) {
                $('#parent_support_form')[0].reset();
                display_message();
                Swal.fire({
                    title: 'Added',
                    text: 'Added Successfully',
                    icon: 'success',
                });
            }
        });
    }
</script>

@endsection
