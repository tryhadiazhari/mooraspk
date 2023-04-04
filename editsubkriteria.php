<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

// $hazcekdata = mysqli_query($koneksi, "SELECT * FROM tbl_subkriteria WHERE kode_subkriteria = '" . $_GET['kode'] . "'");

// $hazInsert = mysqli_query($koneksi, "UPDATE tbl_subkriteria SET bobot_nilai = '" . $_POST['bobotnilai'] . "' WHERE kode_subkriteria = '" . $_GET['kode'] . "'");

// if ($hazInsert) {
//     echo json_encode('Data berhasil disimpan...');
// } else {
//     echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
// }

$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_subkriteria WHERE nama_subkriteria = '" . $_POST['subkriteria'] . "'"));
$no = $count + 1;

if ($count == 0) {
    $hazInsert = mysqli_query($koneksi, "UPDATE tbl_subkriteria SET nama_subkriteria = '" . $_POST['subkriteria'] . "', bobot_nilai = '" . $_POST['bobotnilai'] . "' WHERE kode_subkriteria = '" . $_GET['kode'] . "'");

    if ($hazInsert) {
        echo json_encode('Data berhasil disimpan...');
    } else {
        echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
    }
} else {
    echo json_encode(['error' => 'Data sudah tersedia!!!'], http_response_code(400));
}
