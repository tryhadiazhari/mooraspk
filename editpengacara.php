<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$nik = $_POST['nik'];
$nama = $_POST['nama'];

$hazcekdata = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara WHERE nik = '$nik'");
$hazcekdata2 = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara WHERE nama_pengacara = '$nama'");
$count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara"));
$no = $count + 1;

if (mysqli_num_rows($hazcekdata) == 1) {
    if (mysqli_num_rows($hazcekdata2) == 0) {
        $hazInsert = mysqli_query($koneksi, "UPDATE tbl_datapengacara SET nama_pengacara = '" . ucwords($nama) . "', jenis_kelamin = '" . $_POST['jk'] . "', alamat = '" . $_POST['alamat'] . "' WHERE nik = '" . $_GET['nik'] . "'");

        if ($hazInsert) {
            echo json_encode('Data berhasil disimpan...');
        } else {
            echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
        }
    } else {
        echo json_encode(['nama' => '<strong>Nama Pengacara sudah ada!!!</strong>'], http_response_code(300));
    }
} else {
    echo json_encode(['nama' => '<strong>Nama Pengacara sudah ada!!!</strong>'], http_response_code(300));
}
