<?php
require("config/config.default.php");

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_subkriteria WHERE nama_subkriteria = '" . $_POST['subkriteria'] . "'"));
$no = $count + 1;

if ($count == 0) {
    $hazInsert = mysqli_query($koneksi, "INSERT INTO tbl_subkriteria (`kode_subkriteria`, `nama_subkriteria`, `bobot_nilai`) VALUES ('" . time() . "','" . ucwords($_POST['subkriteria']) . "', '" . $_POST['bobotnilai'] . "')");

    if ($hazInsert) {
        echo json_encode('Data berhasil disimpan...');
    } else {
        echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
    }
} else {
    echo json_encode(['error' => 'Data sudah tersedia!!!'], http_response_code(400));
}
