<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

$hazQuerySub = mysqli_query($koneksi, "SELECT * FROM tbl_subkriteria ORDER BY kode_subkriteria ASC");

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $hazdelete = mysqli_query($koneksi, "DELETE FROM tbl_subkriteria WHERE kode_subkriteria = '" . $_GET['kode'] . "'");

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
                            <h4 class="my-1 title">Data Sub Kriteria</h4>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-md table-responsive-lg nowrap">
                        <thead>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center noshort" width="1">Sub Kriteria</th>
                            <th class="text-center noshort" width="1">Bobot</th>
                            <th class="text-center noshort" width="11%">Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            while ($hazData = mysqli_fetch_array($hazQuerySub)) {
                                $no++;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= $hazData['nama_subkriteria']; ?></td>
                                    <td class="text-center"><?= $hazData['bobot_nilai'] ?></td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" data-toggle="modal" data-target="#modaledit<?= $hazData['kode_subkriteria'] ?>">Edit</a>
                                            </div>
                                            <div class="col">
                                                <a href="<?= $_SERVER['PHP_SELF'] ?>?action=delete&kode=<?= $hazData['kode_subkriteria'] ?>">Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modaledit<?= $hazData['kode_subkriteria'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaleditLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modaleditLabel">Edit Sub Kriteria</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="editsubkriteria.php?kode=<?= $hazData['kode_subkriteria'] ?>" method="POST" autocomplete="off">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Sub Kriteria</label>
                                                        <input type="text" class="form-control subkriteria" name="subkriteria" id="subkriteria" value="<?= $hazData['nama_subkriteria'] ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bobot</label>
                                                        <input type="number" class="form-control bobotnilai" id="bobotnilaiedit" name="bobotnilai" value="<?= $hazData['bobot_nilai'] ?>" required>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaladdLabel">Tambah Sub Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addsubkriteria.php" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Sub Kriteria</label>
                        <input type="text" class="form-control subkriteria" name="subkriteria" id="subkriteria" required>
                    </div>
                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" class="form-control bobotnilai" id="bobotnilai" name="bobotnilai" required>
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