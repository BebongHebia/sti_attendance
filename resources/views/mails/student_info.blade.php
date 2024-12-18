<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STI MALAYBALAY EVENT ATTENDANCE SYSTEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>


    <h4>Hello <b>{{ $student_data['complete_name'] }}</b> You are officially registered in STI MALAYBALAY EVENT ATTENDANCE MANAGEMENT SYSTEM. Below are your credentials : </h4>
    <h5>Username : <b>{{ $student_data['username'] }}</b></h5>
    <h5>Password : <b>{{ $student_data['password'] }}</b></h5>
    <img src='https://barcode.tec-it.com/barcode.ashx?data={{ $student_data['system_no'] }}&code=MobileQRUrl'/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
