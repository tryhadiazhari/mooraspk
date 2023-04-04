<?php
require("config/config.default.php");

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_kriteria"));
$no = $count + 1;

$hazInsert = mysqli_query($koneksi, "INSERT INTO tbl_kriteria (`kode_kriteria`, `nama_kriteria`, `bobot_kriteria`) VALUES ('C$no', '" . ucwords($_POST['nama']) . "', '" . $_POST['bobot'] / 100 . "')");

if ($hazInsert) {
    echo json_encode('Data berhasil disimpan...');
} else {
    echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
}
