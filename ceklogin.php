<?php
require("config/config.default.php");

header('Content-type: application/json');

$username = $_POST['username'];
$password = $_POST['password'];
$siswaQ = mysqli_query($koneksi, "SELECT * FROM tbl_akun WHERE username = '$username'");

if (mysqli_num_rows($siswaQ) == 0) {
    echo json_encode(['username' => "Username tidak ditemukan!!!"], http_response_code(404));
} else {
    $siswa = mysqli_fetch_array($siswaQ);

    if (password_verify($password, $siswa['password'])) {
        echo json_encode("Login Berhasil...");

        $_SESSION['username'] = $siswa['username'];
        $_SESSION['lv'] = $siswa['level'];
    } else {
        echo json_encode(['password' => "Password Invalid!!!"], http_response_code(404));
    }
}
