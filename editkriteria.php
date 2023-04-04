<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_kriteria WHERE nama_kriteria = '" . $_POST['nama'] . "'"));
$no = $count + 1;

if ($count == 0) {
    $hazInsert = mysqli_query($koneksi, "UPDATE tbl_kriteria SET kode_kriteria = '" . $_POST['kode'] . "', nama_kriteria = '" . ucwords($_POST['nama']) . "', bobot_kriteria = '" . $_POST['bobot'] / 100 . "' WHERE kode_kriteria = '" . $_GET['kode'] . "'");

    if ($hazInsert) {
        echo json_encode('Data berhasil disimpan...');
    } else {
        echo json_encode(['error' => 'Data gagal disimpan!!! Data sudah tersedia'], http_response_code(400));
    }
} else {
    echo json_encode(['error' => 'Data sudah tersedia!!!'], http_response_code(400));
}
