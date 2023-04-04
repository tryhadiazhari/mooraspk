<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

$hazCountKriteria = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria ORDER BY kode_kriteria ASC");

$hazQueryPengacara = mysqli_query($koneksi, "SELECT tbl_nilai.kode_kriteria,tbl_nilai.kode_pengacara
FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara
GROUP BY tbl_nilai.kode_pengacara ORDER BY tbl_nilai.kode_pengacara ASC");

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'cekreward') {
        $hazQueryPengacara2 = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria ORDER BY kode_kriteria ASC");

        $hazzz = mysqli_query($koneksi, "SELECT * FROM tbl_penilaian INNER JOIN tbl_datapengacara ON tbl_penilaian.kode_pengacara = tbl_datapengacara.kode_pengacara GROUP BY tbl_penilaian.kode_kriteria");

        $count =  mysqli_num_rows($hazzz);

        $no = 0;
        $hazQueryPengacaras = mysqli_query($koneksi, "SELECT * FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara GROUP BY tbl_nilai.kode_pengacara ORDER BY tbl_nilai.kode_pengacara ASC");

        while ($hazDataPengacaras = mysqli_fetch_array($hazQueryPengacaras)) {
            $no++;

            $nom = 0;

            while ($hazDataPengacara2 = mysqli_fetch_array($hazQueryPengacara2)) {
                $nom++;

                $a = 0;

                $hazQueryNilai = mysqli_query($koneksi, "SELECT tbl_nilai.kode_kriteria, tbl_nilai.kode_pengacara, tbl_nilai.bobot_penilaian FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara WHERE tbl_nilai.kode_kriteria = '" . $hazDataPengacara2['kode_kriteria'] . "' ORDER BY tbl_nilai.kode_pengacara, tbl_nilai.kode_kriteria ASC");

                while ($hazDataNilai = mysqli_fetch_array($hazQueryNilai)) {
                    $a++;
                    $normalisasi[$a] = pow($hazDataNilai['bobot_penilaian'], 2);
                    $normalisasi2[$a] = $hazDataNilai['bobot_penilaian'];
                }

                $jumlah = array_sum($normalisasi);

                $hazQueryNilai2 = mysqli_query($koneksi, "SELECT tbl_nilai.kode_kriteria, tbl_nilai.kode_pengacara, tbl_nilai.bobot_penilaian FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara WHERE tbl_nilai.kode_kriteria = '" . $hazDataPengacara2['kode_kriteria'] . "' ORDER BY tbl_nilai.kode_pengacara, tbl_nilai.kode_kriteria ASC");

                $aa = 0;
                while ($hazDataNilai2 = mysqli_fetch_array($hazQueryNilai2)) {
                    $aa++;
                    $normalisasi3[$aa] = number_format($hazDataNilai2['bobot_penilaian'] / number_format(sqrt($jumlah), 3, '.', ','), 3, '.', ',');
                }

                $hazQueryNilai3 = mysqli_query($koneksi, "SELECT tbl_nilai.kode_kriteria, tbl_nilai.kode_pengacara, tbl_nilai.bobot_penilaian, tbl_kriteria.bobot_kriteria FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara INNER JOIN tbl_kriteria ON tbl_nilai.kode_kriteria = tbl_kriteria.kode_kriteria WHERE tbl_nilai.kode_kriteria = '" . $hazDataPengacara2['kode_kriteria'] . "' ORDER BY tbl_nilai.kode_pengacara, tbl_nilai.kode_kriteria ASC");

                $aaa = 0;
                while ($hazDataNilai3 = mysqli_fetch_array($hazQueryNilai3)) {
                    $aaa++;
                    $normalisasi4[$aaa] = number_format($normalisasi3[$aaa] * (str_replace('%', '', $hazDataNilai3['bobot_kriteria']) / 100), 3, '.', ',');

                    if ($count == 0) {
                        mysqli_query($koneksi, "INSERT INTO tbl_penilaian VALUES ('', '" . $hazDataNilai3['kode_pengacara'] . "', '" . $hazDataPengacara2['kode_kriteria'] . "', '" . number_format($normalisasi3[$aaa] * $hazDataNilai3['bobot_kriteria'], 3, '.', ',') . "')");
                    } else {
                        mysqli_query($koneksi, "UPDATE tbl_penilaian SET nilai_akhir = '" . number_format($normalisasi3[$aaa] * $hazDataNilai3['bobot_kriteria'], 3, '.', ',') . "' WHERE kode_pengacara = '" . $hazDataNilai3['kode_pengacara'] . "' AND kode_kriteria =  '" . $hazDataPengacara2['kode_kriteria'] . "'");
                    }
                }
            }
        }
    }
}

include('header.php')

?>
<?php include('navbar.php') ?>
<?php include('sidebar.php') ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <!-- <div class="card">
                <div class="card-header">
                    <h4 class="my-1">Data Hasil Penilaian</h4>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-md table-responsive-lg nowrap">
                        <thead>
                            <tr>
                                <th rowspan="2" width="1" class="align-middle text-center">No</th>
                                <th rowspan="2" class="align-middle text-center noshort">Kode Pengacara</th>
                                <th colspan="<?= mysqli_num_rows($hazCountKriteria); ?>" class="align-middle text-center">Kriteria</th>
                            </tr>
                            <tr>
                                <?php
                                $kriteria = $hazCountKriteria;
                                while ($hazDataKriteria = mysqli_fetch_array($kriteria)) {
                                ?>
                                    <th class="text-center noshort"><?= $hazDataKriteria['kode_kriteria']; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <?php
                        $hazQueryPengacara = mysqli_query($koneksi, "SELECT * FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara  GROUP BY tbl_nilai.kode_pengacara ORDER BY tbl_nilai.kode_pengacara ASC");

                        $no = 0;

                        if (mysqli_num_rows($hazQueryPengacara) == 0) {
                            echo '<tr></tr>';
                        } else {
                            while ($hazDataPengacara = mysqli_fetch_array($hazQueryPengacara)) {
                                $no++;
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?> </td>
                                    <td class="text-center"><?= $hazDataPengacara['kode_pengacara']; ?></td>
                                    <?php
                                    $hazQueryNilai = mysqli_query($koneksi, "SELECT * FROM tbl_nilai WHERE kode_pengacara = '" . $hazDataPengacara['kode_pengacara'] . "' ORDER BY kode_pengacara, kode_kriteria ASC");
                                    while ($hazDataNilai = mysqli_fetch_array($hazQueryNilai)) {
                                    ?>
                                        <td class="text-center">
                                            <center><?= $hazDataNilai['bobot_penilaian']; ?></center>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                </div>
            </div> -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="my-1 title">Data Ranking</h4>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary bg-gradient btn-ranking" onclick="window.location='<?= $_SERVER['PHP_SELF'] ?>?action=cekreward'">Cari Ranking</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-responsive-lg nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="1" class="align-middle text-center noshort">No</th>
                                <th class="align-middle text-center noshort">Kode Pengacara</th>
                                <th class="align-middle text-center noshort">Nilai Akhir</th>
                                <th class="align-middle text-center noshort">Rangking</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rank = 1;
                            $nomor = 0;
                            $hazQueryRank = mysqli_query($koneksi, "SELECT tbl_datapengacara.nama_pengacara, tbl_penilaian.kode_pengacara, SUM(tbl_penilaian.nilai_akhir) AS nilai_akhir FROM tbl_penilaian INNER JOIN tbl_datapengacara ON tbl_penilaian.kode_pengacara = tbl_datapengacara.kode_pengacara GROUP BY kode_pengacara ORDER BY SUM(nilai_akhir) DESC");
                            while ($hazRank = mysqli_fetch_array($hazQueryRank)) {
                                $nomor++;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $nomor; ?></td>
                                    <td><?= $hazRank['nama_pengacara']; ?></td>
                                    <td class="text-center"><?= number_format($hazRank['nilai_akhir'], 3, '.', ',') ?></td>
                                    <td class="text-center"><?= $rank; ?></td>
                                </tr>
                            <?php $rank++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>