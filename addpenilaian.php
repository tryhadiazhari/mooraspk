<?php
require("config/config.default.php");

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_nilai"));
$no = ($count == 0) ? $count + 1 : $count;

$count2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT kode_pengacara FROM tbl_nilai WHERE kode_pengacara = '" . $_POST['pengacara'] . "'"));

$jlh = $_POST['jlh'];

if ($count2 == 0) {
    for ($i = 0; $i < $jlh; $i++) {
        $hazInsert = mysqli_query($koneksi, "INSERT INTO tbl_nilai (`kode_nilai`, `kode_pengacara`,`kode_kriteria`, `bobot_penilaian`) VALUES ('" . $_POST['pengacara'] . $_POST['kriteria'][$i] . "','" . $_POST['pengacara'] . "', '" . $_POST['kriteria'][$i] . "', '" . $_POST['subkriteria'][$i] . "')");
    }

    if ($hazInsert) {
        echo json_encode('Data berhasil disimpan...');
    } else {
        echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
    }
} else {
    echo json_encode(['error' => 'Data dengan Kode ' . $_POST['pengacara'] . ' sudah ada!!!'], http_response_code(400));
}
