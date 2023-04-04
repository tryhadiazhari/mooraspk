<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= ($setting['level'] == 1) ? strtoupper($setting['username']) : $query2['nama_pengacara'] ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item mb-2">
                    <a href="./" class="nav-link btn-primary btn-gradient text-white">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Menu Utama</p>
                    </a>
                </li>
                <li class="nav-item my-2" <?= ($setting['level'] == 2) ? 'style="display: none"' : '' ?>>
                    <a href="data_pengacara.php" class="nav-link btn-primary btn-gradient text-white">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Data Pengacara</p>
                    </a>
                </li>
                <li class="nav-item my-2" <?= ($setting['level'] == 2) ? 'style="display: none"' : '' ?>>
                    <a href="kriteria.php" class="nav-link btn-primary btn-gradient text-white">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Kriteria</p>
                    </a>
                </li>
                <li class="nav-item my-2" <?= ($setting['level'] == 2) ? 'style="display: none"' : '' ?>>
                    <a href="subkriteria.php" class="nav-link btn-primary btn-gradient text-white">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Sub Kriteria</p>
                    </a>
                </li>
                <li class="nav-item my-2" <?= ($setting['level'] == 2) ? 'style="display: none"' : '' ?>>
                    <a href="penilaian.php" class="nav-link btn-primary btn-gradient text-white">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Penilaian</p>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="hasil_penilaian.php" class="nav-link btn-primary btn-gradient text-white">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Hasil Penilaian</p>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="#" class="nav-link btn-primary btn-gradient text-white" onclick="window.open('laporan.php')">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Laporan Penilaian</p>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="#" class="nav-link btn-primary btn-gradient text-white logout" onclick="window.location.href='logout.php'">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>