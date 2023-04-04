<?php
require("config/config.default.php");
if (!$pilihdb) {
    $ket = 'disabled';
    $ket2 = '';
    $alert = '<p><div class="alert alert-danger text-center">Database tidak tersedia!!!</div></p>';
} else {
    $ket = '';
    $ket2 = 'disabled';
    $alert = '';
}
if (isset($_POST['buat'])) {
    $nama_db = "mooraspk";

    mysqli_query($koneksi, "CREATE DATABASE $nama_db;");
    header('location: login.php');
}
if (isset($_POST['buat2'])) {

    $filename = 'mooraspk.sql';

    $templine = '';

    $lines = file($filename);

    foreach ($lines as $line) {

        if (substr($line, 0, 2) == '--' || $line == '')
            continue;
        $templine .= $line;

        if (substr(trim($line), -1, 1) == ';') {
            mysqli_query($koneksi, $templine);
            $templine = '';
        }
    }

    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Moora SPK</title>

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

                <?= $alert ?>
                <form action="" method="post" class="mb-3">
                    <button name="buat" class="btn btn-primary btn-raised btn-block" <?php echo $ket2 ?>>1. Buat Database</button>
                </form>
                <form action='' method='post'>
                    <button name='buat2' class="btn btn-danger btn-raised btn-block" <?php echo $ket ?>>2. Import Database</button>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
</body>

</html>