<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

$hazQueryPengacara = mysqli_query($koneksi, "SELECT * FROM tbl_nilai 
    INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara 
        GROUP BY tbl_nilai.kode_pengacara ORDER BY tbl_nilai.kode_pengacara ASC");

$hazCountKriteria = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria ORDER BY kode_kriteria ASC");

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        mysqli_query($koneksi, "DELETE FROM tbl_nilai WHERE kode_pengacara = '" . $_GET['kode'] . "'");
        mysqli_query($koneksi, "DELETE FROM tbl_penilaian WHERE kode_pengacara = '" . $_GET['kode'] . "'");

        $hazQueryNilai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_nilai"));
        $hazQueryNilai2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_penilaian"));

        if ($hazQueryNilai == 0) {
            mysqli_query($koneksi, "TRUNCATE tbl_nilai");
        }
        if ($hazQueryNilai2 == 0) {
            mysqli_query($koneksi, "TRUNCATE tbl_penilaian");
        }

        header('location: ' . $_SERVER['PHP_SELF']);
    }
}

include('header.php')

?>
<?php include('navbar.php') ?>
<?php include('sidebar.php') ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="my-1 title">Data Penilaian</h4>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary bg-gradient" data-toggle="modal" data-target="#modaladd">Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-md table-responsive-lg nowrap">
                        <thead>
                            <tr>
                                <th width="1" class="align-middle text-center">No</th>
                                <th class="align-middle text-center noshort">Kode Pengacara</th>
                                <?php
                                if (mysqli_num_rows($hazCountKriteria) > 0) {
                                    while ($hazDataKriteria = mysqli_fetch_array($hazCountKriteria)) {
                                ?>
                                        <th width="13%" class="text-center noshort"><?= $hazDataKriteria['nama_kriteria']; ?></th>
                                    <?php } ?>
                                <?php } ?>
                                <th class="align-middle text-center noshort">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $hazQueryPengacara = mysqli_query($koneksi, "SELECT * FROM tbl_nilai INNER JOIN tbl_datapengacara ON tbl_nilai.kode_pengacara = tbl_datapengacara.kode_pengacara  GROUP BY tbl_nilai.kode_pengacara ORDER BY tbl_nilai.kode_pengacara ASC");

                            $no = 0;

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
                                    <td class="text-center">
                                        <div class="row" <?= (mysqli_num_rows($hazQueryNilai) == 0) ? 'style="display: none"' : '' ?>>
                                            <div class="col">
                                                <a href="#" data-toggle="modal" data-target="#modaledit<?= $hazDataPengacara['kode_pengacara'] ?>">Edit</a>
                                            </div>
                                            <div class="col">
                                                <a href="<?= $_SERVER['PHP_SELF'] ?>?action=delete&kode=<?= $hazDataPengacara['kode_pengacara'] ?>">Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modaledit<?= $hazDataPengacara['kode_pengacara'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaladdLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modaladdLabel">Edit Penilaian</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="editpenilaian.php" class="penilaian" method="POST" autocomplete="off">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Pengacara</label>
                                                        <select class="form-control" name="pengacara" id="pengacara" required>
                                                            <option selected disabled></option>
                                                            <?php
                                                            $hazKriteria = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara ORDER BY kode_pengacara ASC");

                                                            while ($data2 = mysqli_fetch_array($hazKriteria)) :

                                                                $hazCekPengacara = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_nilai WHERE kode_pengacara = '" . $hazDataPengacara['kode_pengacara'] . "'"));
                                                            ?>
                                                                <option value="<?= $data2['kode_pengacara'] ?>" <?= ($hazCekPengacara == 0) ? '' : ($data2['kode_pengacara'] == $hazDataPengacara['kode_pengacara'] ? 'selected' : 'disabled') ?>><?= $data2['nama_pengacara'] ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Kriteria</label>
                                                        <?php
                                                        $hazKriteria = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria INNER JOIN tbl_nilai ON tbl_nilai.kode_kriteria = tbl_kriteria.kode_kriteria WHERE kode_pengacara='" . $hazDataPengacara['kode_pengacara'] . "'");

                                                        echo '<input type="hidden" name="jlh" value="' . mysqli_num_rows($hazKriteria) . '">';

                                                        while ($data3 = mysqli_fetch_array($hazKriteria)) :;
                                                        ?>
                                                            <input type="hidden" name="kriteria[]" value="<?= $data3['kode_kriteria'] ?>">

                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <label class="input-group-text"><?= $data3['kode_kriteria'] ?></label>
                                                                </div>
                                                                <select class="custom-select" name="subkriteria[]" required>
                                                                    <option disabled selected>Choose...</option>
                                                                    <?php
                                                                    $hazSubKriteria = mysqli_query($koneksi, "SELECT * FROM tbl_subkriteria ORDER BY bobot_nilai DESC");

                                                                    while ($hazsub = mysqli_fetch_array($hazSubKriteria)) :
                                                                    ?>
                                                                        <option value="<?= $hazsub['bobot_nilai'] ?>" <?= ($data3['bobot_penilaian'] == $hazsub['bobot_nilai']) ? 'selected' : '' ?>><?= $hazsub['nama_subkriteria'] ?></option>
                                                                    <?php endwhile ?>
                                                                </select>
                                                            </div>
                                                        <?php endwhile; ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" id="submit">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaladd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaladdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaladdLabel">Tambah Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addpenilaian.php" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pengacara</label>
                        <select class="form-control" name="pengacara" id="pengacara" required>
                            <option selected disabled></option>
                            <?php
                            $hazQueryPe = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara ORDER BY kode_pengacara ASC");

                            while ($hazPe = mysqli_fetch_array($hazQueryPe)) :

                                $hazCekPengacara = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_nilai WHERE kode_pengacara = '" . $hazPe['kode_pengacara'] . "'"));

                            ?>
                                <option value="<?= $hazPe['kode_pengacara'] ?>" <?= ($hazCekPengacara == 0) ? '' : 'disabled' ?>><?= $hazPe['nama_pengacara'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Kriteria</label>
                        <?php
                        $hazQueryKri = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria ORDER BY kode_kriteria ASC");

                        $no = 0;

                        echo '<input type="hidden" name="jlh" value="' . mysqli_num_rows($hazQueryKri) . '">';

                        while ($hazDataKri = mysqli_fetch_array($hazQueryKri)) : $no++;
                        ?>
                            <input type="hidden" name="kriteria[]" value="<?= $hazDataKri['kode_kriteria'] ?>">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><?= $hazDataKri['kode_kriteria'] ?></label>
                                </div>
                                <select class="custom-select" name="subkriteria[]" required>
                                    <option disabled selected>Choose...</option>
                                    <?php
                                    $hazQuerySub = mysqli_query($koneksi, "SELECT * FROM tbl_subkriteria ORDER BY bobot_nilai DESC");

                                    while ($hazDataSub = mysqli_fetch_array($hazQuerySub)) :
                                    ?>
                                        <option value="<?= $hazDataSub['bobot_nilai'] ?>"><?= $hazDataSub['nama_subkriteria'] ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>