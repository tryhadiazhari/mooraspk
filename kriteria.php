<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $hazdelete = mysqli_query($koneksi, "DELETE FROM tbl_kriteria WHERE kode_kriteria = '" . $_GET['kode'] . "'");

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
                            <h4 class="my-1 title">Data Kriteria</h4>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-md table-responsive-lg nowrap">
                        <thead>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Nama Kriteria</th>
                            <th class="text-center noshort">Bobot (%)</th>
                            <th class="text-center noshort" width="11%">Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $query = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria ORDER BY kode_kriteria ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $no++;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td width="1" class="text-center"><?= $data['kode_kriteria']; ?></td>
                                    <td><?= $data['nama_kriteria']; ?></td>
                                    <td width="3" class="text-center"><?= $data['bobot_kriteria'] * 100; ?></td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" data-toggle="modal" data-target="#modaledit<?= $data['kode_kriteria'] ?>">Edit</a>
                                            </div>
                                            <div class="col">
                                                <a href="<?= $_SERVER['PHP_SELF'] ?>?action=delete&kode=<?= $data['kode_kriteria'] ?>">Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modaledit<?= $data['kode_kriteria'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaleditLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modaleditLabel">Tambah Kriteria</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="editkriteria.php?kode=<?= $data['kode_kriteria'] ?>" method="POST" autocomplete="off">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Kode Kriteria</label>
                                                        <input type="text" class="form-control kode" id="kode" name="kode" value="<?= $data['kode_kriteria'] ?>" readonly>
                                                        <div class="invalid-feedback invalid-kode"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Kriteria</label>
                                                        <input type="text" class="form-control nama" id="nama" name="nama" value="<?= $data['nama_kriteria'] ?>" required>
                                                        <div class="invalid-feedback invalid-nama"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bobot</label>
                                                        <input type="text" class="form-control bobot" id="bobotedit" name="bobot" value="<?= $data['bobot_kriteria'] * 100 ?>" required>
                                                        <div class="invalid-feedback invalid-bobot"></div>
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
                <h5 class="modal-title" id="modaladdLabel">Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addkriteria.php" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kriteria</label>
                        <input type="text" class="form-control nama" id="nama" name="nama" required>
                        <div class="invalid-feedback invalid-nama"></div>
                    </div>
                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="text" class="form-control bobot" id="bobot" name="bobot" required>
                        <div class="invalid-feedback invalid-bobot"></div>
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