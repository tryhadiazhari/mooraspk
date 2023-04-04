<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="assets/dist/img/avatar5.png" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?= ($setting['level'] == 1) ? strtoupper($setting['username']) : strtoupper($query2['nama_pengacara']) ?></span>
            </a>
        </li>
    </ul>
</nav>