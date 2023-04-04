<?php
require("config/config.default.php");

($username == '') ? header('location:login.php') : null;

header('Content-type: application/json');

$nik = $_POST['nik'];
$nama = $_POST['nama'];

if (strlen($nik) != 16) {
    echo json_encode(['nik' => 'NIK tidak boleh kurang dari 16 angka!!!'], http_response_code(300));
} else {
    $hazcekdata = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara WHERE nik = '$nik'");
    $hazcekdata2 = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara WHERE nama_pengacara = '$nama'");
    $count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara"));
    $no = $count + 1;

    if (mysqli_num_rows($hazcekdata) == 0) {
        if (mysqli_num_rows($hazcekdata2) == 0) {
            $hazInsert = mysqli_query($koneksi, "INSERT INTO tbl_datapengacara (`kode_pengacara`, `nik`, `nama_pengacara`, `jenis_kelamin`, `alamat`) VALUES ('A$no', $nik, '" . ucwords($nama) . "', '" . $_POST['jk'] . "', '" . $_POST['alamat'] . "')");

            if ($hazInsert) {
                mysqli_query($koneksi, "INSERT INTO tbl_akun VALUES ('A$no', '" . $nik . "', '" . password_hash($nik, PASSWORD_DEFAULT) . "', 2)");
                echo json_encode('Data berhasil disimpan...');
            } else {
                echo json_encode(['error' => 'Data gagal disimpan!!!'], http_response_code(400));
            }
        } else {
            echo json_encode(['nama' => 'Nama Pengacara sudah tersedia!!!'], http_response_code(300));
        }
    } else {
        echo json_encode(['nik' => 'NIK sudah tersedia!!!'], http_response_code(300));
    }
}
