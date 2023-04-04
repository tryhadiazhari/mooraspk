<?php
require("config/config.default.php");

$cekdb = mysqli_query($koneksi, "SELECT 1 FROM tbl_akun LIMIT 1");
if ($cekdb == false) {
    header("Location: install.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moora SPK | Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card" style="border-radius: 10px">
            <div class="card-body login-card-body" style="border-radius: 10px">
                <p class="login-box-msg" style="padding: 0; margin-bottom: 20px; font-size: 1.2em; font-weight: bold;">Menentukan Reward Pengacara <br>Kantor Hukum R.H. Legal Consultan</p>

                <form action="ceklogin.php" method="post" autocomplete="off">
                    <div class="input-group my-4">
                        <input type="text" class="form-control username" name="username" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback invalid-username"></div>
                    </div>
                    <div class="input-group my-4">
                        <input type="password" class="form-control password" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback invalid-password"></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('button[type=submit]').html('Mohon menunggu... <i class="fa fa-spinner fa-spin"></i>');
                        $('.form-control').removeClass('is-invalid');
                    },
                    complete: function() {
                        $('button[type=submit]').html('Login')
                    },
                    statusCode: {
                        404: function(error) {
                            $.each(error.responseJSON, function(field, value) {
                                $('.' + field).addClass('is-invalid');
                                $('.invalid-' + field).html(value);
                            })
                        },
                        400: function(error) {
                            toastr.error(error.responseJSON.error);
                        }
                    },
                    success: function(response) {
                        toastr.success(response);

                        setTimeout(function() {
                            window.location = './';
                        }, 3000);
                    }
                })
            })
        })
    </script>
</body>

</html>