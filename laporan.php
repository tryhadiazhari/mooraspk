<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moora SPK | Laporan Reward Pengacara</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/buttons/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/buttons/css/buttons.bootstrap4.min.css">
    <style>
        .dt-buttons.btn-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <div class="container">
                <a href="assets/dist/img/index3.html" class="navbar-brand">
                    <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Moora SPK</span>
                </a>

            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/dist/img/avatar5.png" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline"><?= ($setting['level'] == 1) ? strtoupper($setting['username']) : $query2['nama_pengacara'] ?></span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Laporan Reward Pengacara</h4>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped nowrap" style="width: 100%">
                                <thead class="text-center">
                                    <tr>
                                        <th width="1" class="text-center">No</th>
                                        <th class="text-center noshort">Nama Pengacara</th>
                                        <th class="text-center noshort">Nilai Moora</th>
                                        <th class="text-center noshort">Peringkat</th>
                                        <th class="text-center noshort" width="20%">Reward</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rank = 1;
                                    $nomor = 0;
                                    $hazQueryRank = mysqli_query($koneksi, "SELECT tbl_datapengacara.nama_pengacara, tbl_penilaian.kode_pengacara, SUM(tbl_penilaian.nilai_akhir) AS nilai_akhir FROM tbl_penilaian INNER JOIN tbl_datapengacara ON tbl_penilaian.kode_pengacara = tbl_datapengacara.kode_pengacara GROUP BY kode_pengacara ORDER BY SUM(nilai_akhir) DESC");
                                    while ($hazRank = mysqli_fetch_array($hazQueryRank)) {
                                        $nomor++;

                                        if ($rank <= 4) {
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $nomor; ?></td>
                                                <td><?= $hazRank['nama_pengacara']; ?></td>
                                                <td class="text-center"><?= number_format($hazRank['nilai_akhir'], 3, '.', ','); ?></td>
                                                <td class="text-center"><?= $rank; ?></td>
                                                <td class="text-success text-center">
                                                    <?php
                                                    if ($rank == 1) {
                                                        $reward = 'Rp. 20.000.000,-';
                                                    } else if ($rank == 2) {
                                                        $reward = 'Rp. 15.000.000,-';
                                                    } else if ($rank == 3) {
                                                        $reward = 'Rp. 10.000.000,-';
                                                    } else if ($rank == 4) {
                                                        $reward = 'Rp. 8.000.000,-';
                                                    }
                                                    ?>
                                                    <i class="fa <?= ($rank == 1) ? 'fa-trophy-alt' : 'fa-trophy' ?> fa-fw"></i> <strong><?= $reward ?></strong>
                                                </td>
                                            </tr>
                                    <?php $rank++;
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/buttons/js/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/buttons/js/buttons.html5.min.js"></script>
    <script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
        $('#table').DataTable({
            dom: 'Bfrtip',
            info: false,
            paging: false,
            ordering: true,
            "searching": false,
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"]
            }],
            buttons: [{
                extend: 'print',
                title: '',
                messageTop: '<h2 style="text-align: center; font-weight: bold; margin: 0 auto 40px auto; text-decoration: underline">Laporan Reward Pengacara</h2>',
                customize: function(win) {
                    $(win.document.body).find('th, td:first-child, td:last-child').addClass('text-center');
                }
            }]
        });

        $('.dataTables_wrapper').find('table').removeClass('dataTable');
        $('.dataTables_filter').addClass('mb-3');
        $('.dataTables_info').addClass('py-0');
        $('.dataTables_paginate').addClass('py-0 my-0').find('.pagination').addClass('my-0')
        $('.buttons-print').removeClass('btn-secondary').addClass('btn-primary px-4');
        $('.buttons-print').find('span').addClass('px-0 mx-0').html('<i class="fa fa-print fa-fw mx-0 mr-2"></i>Cetak');

        $('.nav-link').click(function() {
            window.close();
        });
    </script>
</body>

</html>