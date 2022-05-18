<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
    body {
        background-color: #F50057
    }

    .container {
        height: 100vh
    }

    .card {
        width: 100%;
        padding: 30px
    }

    .form {
        padding: 20px
    }

    .form-control {
        height: 50px;
        background-color: #eee
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #f50057;
        outline: 0;
        box-shadow: none;
        background-color: #eee
    }

    .inputbox {
        margin-bottom: 15px
    }

    .register {
        width: 200px;
        height: 51px;
        background-color: #f50057;
        border-color: #f50057
    }

    .register:hover {
        width: 200px;
        height: 51px;
        background-color: #f50057;
        border-color: #f50057
    }

    .login {
        color: #f50057;
        text-decoration: none
    }

    .login:hover {
        color: #f50057;
        text-decoration: none
    }

    .form-check-input:checked {
        background-color: #f50057;
        border-color: #f50057
    }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="row">
                <div class="col-md-8">
                    <div class="form">
                        <h2>Reset Password</h2>
                        <form action="{{ route('resetpassword') }}" method="post">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="inputbox mt-3"> 
                                <span>Email</span> 
                                <input type="email" placeholder="Please verify your email again" name="email" class="form-control" required>
                            </div>
                            <div class="inputbox mt-3"> 
                                <span>New Password</span> 
                                <input id="show" type="password" placeholder="new password" name="password" class="form-control" required>
                            </div>
                            <div class="inputbox mt-3"> 
                                <span>New Password Confirmation</span>
                                <input id="show_confirm" type="password" placeholder="new password confirmation" name="password_confirmation" class="form-control" required>
                                <input class="mt-3" type="checkbox" onclick="myFunction()"> Show Password
                            </div>
                            <input type="submit" value="Reset Password" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function myFunction() {
            let x = document.getElementById("show")
            let y = document.getElementById("show_confirm")
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
</body>
</html>