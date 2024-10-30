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
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                    <h4 class="text-start">Create Account</h4>
                    <form action="{{ url('/create-account') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Complete Name -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Complete Name</label>
                                    <input type="text" required name="complete_name" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Complete name" />
                                </div>


                                <!-- Sex -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Sex</label>
                                    <select required class="form-select"  name="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <!-- Date of Birth -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Date of Birth</label>
                                    <input type="date" required name="bday" id="form3Example3" class="form-control form-control-lg" />
                                </div>

                                <!-- Address -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Address</label>
                                    <input type="text" required name="address" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Address" />
                                </div>

                                <!-- Email -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Email</label>
                                    <input type="email" required name="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Email" />
                                </div>

                                <!-- Phone -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Phone</label>
                                    <input type="text" required name="phone" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Phone" />
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <!-- Parent Name -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Parent Name</label>
                                    <input type="text" required name="parent_name" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Parent Name" />
                                </div>

                                <!-- Parent Contact -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Parent Contact</label>
                                    <input type="text" required name="parent_contact" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Parent Contact" />
                                </div>
                                <!-- Username -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Username</label>
                                    <input type="text" required name="username" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Username" />
                                </div>

                                <!-- Password -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Password</label>
                                    <input type="password" required name="password" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Password" />
                                </div>

                                <!-- confirm Password -->
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label" for="form3Example3">Confirm Password</label>
                                    <input type="password" required name="c_password" id="form3Example3" class="form-control form-control-lg" placeholder="Enter Confirm Password" />
                                </div>
                            </div>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Create Account</button>
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
