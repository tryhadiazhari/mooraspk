<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_nilai"));
$no = ($count == 0) ? $count + 1 : $count;

$jlh = $_POST['jlh'];

for ($i = 0; $i < $jlh; $i++) {
    $hazUpdate = mysqli_query($koneksi, "UPDATE tbl_nilai SET bobot_penilaian = '" . $_POST['subkriteria'][$i] . "' WHERE kode_pengacara = '" . $_POST['pengacara'] . "' AND kode_kriteria = '" . $_POST['kriteria'][$i] . "'");
}

if ($hazUpdate) {
    echo json_encode('Data berhasil disimpan...');
} else {
    echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
}
