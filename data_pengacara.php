<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        mysqli_query($koneksi, "DELETE FROM tbl_datapengacara WHERE kode_pengacara = '" . $_GET['kode'] . "'");
        mysqli_query($koneksi, "DELETE FROM tbl_nilai WHERE kode_pengacara = '" . $_GET['kode'] . "'");
        mysqli_query($koneksi, "DELETE FROM tbl_penilaian WHERE kode_pengacara = '" . $_GET['kode'] . "'");
        mysqli_query($koneksi, "DELETE FROM tbl_akun WHERE id = '" . $_GET['kode'] . "'");

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
                            <h4 class="my-1 title">Data Pengacara</h4>
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
                            <th class="text-center">Nama Pengacara</th>
                            <th class="text-center noshort">Jenis Kelamin</th>
                            <th class="text-center noshort">Alamat</th>
                            <th class="text-center noshort" width="11%">Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $query = mysqli_query($koneksi, "SELECT * FROM tbl_datapengacara ORDER BY kode_pengacara ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $no++;
                            ?>
                                <tr>
                                    <td class="text-center" width="1"><?= $no; ?></td>
                                    <td class="text-center"><?= $data['kode_pengacara']; ?></td>
                                    <td><?= $data['nama_pengacara']; ?></td>
                                    <td class="text-center" width="1"><?= $data['jenis_kelamin']; ?></td>
                                    <td width="30%"><?= $data['alamat']; ?></td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" data-toggle="modal" data-target="#modaledit<?= $data['kode_pengacara'] ?>">Edit</a>
                                            </div>
                                            <div class="col">
                                                <a href="<?= $_SERVER['PHP_SELF'] ?>?action=delete&kode=<?= $data['kode_pengacara'] ?>">Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modaledit<?= $data['kode_pengacara'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaleditLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modaleditLabel">Tambah Pengacara</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="editpengacara.php?nik=<?= $data['nik'] ?>" method="POST" autocomplete="off">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>NIK</label>
                                                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $data['nik'] ?>" readonly>
                                                        <div class="invalid-feedback invalid-nik"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Pengacara</label>
                                                        <input type="text" class="form-control nama" id="nama" name="nama" value="<?= $data['nama_pengacara'] ?>" required>
                                                        <div class="invalid-feedback invalid-nama"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="form-control form-select jk" id="jkedit" name="jk" style="width: 100%;" required>
                                                            <option disabled selected></option>
                                                            <option value="Laki-Laki" <?= ($data['jenis_kelamin'] == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                                                            <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" class="form-control alamat" id="alamat" name="alamat" value="<?= $data['alamat'] ?>" required>
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
                <h5 class="modal-title" id="modaladdLabel">Tambah Pengacara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addpengacara.php" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control nik" id="nik" name="nik" maxlength="16" required>
                        <div class="invalid-feedback invalid-nik"></div>
                    </div>
                    <div class="form-group">
                        <label>Nama Pengacara</label>
                        <input type="text" class="form-control nama" id="nama" name="nama" required>
                        <div class="invalid-feedback invalid-nama"></div>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control form-select jk" id="jk" name="jk" style="width: 100%;" required>
                            <option disabled selected></option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <div class="invalid-feedback invalid-jk"></div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control alamat" id="alamat" name="alamat" required>
                        <div class="invalid-feedback invalid-alamat"></div>
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