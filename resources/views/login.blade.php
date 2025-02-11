<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>STI-Attendance SMS Notification</title>

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

    </style>
</head>
<body style="background-image: url('images/login_background.png'); background-size:cover; background-position:center; background-repeat:no-repeat">
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <center>
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Sample image">
                        <h1 class="text-center">S.E.A.M.S</h1>
                    </center>

                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <h4 class="text-start">Login</h4>
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Username</label>
                            <input type="text" required name="username" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Username" />
                        </div>

                        <!-- Password input -->
                        <label class="form-label" for="form3Example4">Password</label>
                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="password" required name="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                        </div>

                        <!-- Password input -->
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            <!--<p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ url('/create-account-page') }}" class="link-danger">Register</a></p>-->
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2020. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
@include('sweetalert::alert')
