<?php
session_start();

(isset($_SESSION['username'])) ? $username = $_SESSION['username'] : $username = '';

require "config.db.php";
$host = $host;
$user = $user;
$pass = $pass;
$db = $db;

$koneksi = mysqli_connect($host, $user, $pass, "");
if ($koneksi) {
    $pilihdb = mysqli_select_db($koneksi, $db);
    if ($pilihdb) {
        $query = mysqli_query($koneksi, "SELECT * FROM tbl_akun WHERE username = '" . $username . "'");

        if ($query) {
            $setting = mysqli_fetch_array($query);

            $query2 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara WHERE nik = '" . $username . "'"));
        }
    }
} else {
    echo "Koneksi Database Gagal!!!";
}
