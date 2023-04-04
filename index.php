<?php
require('config/config.default.php');

($username == '') ? header('location:login.php') : null;

include('header.php');
?>
<?php include('navbar.php') ?>
<?php include('sidebar.php') ?>

<div class="content-wrapper d-flex align-items-center">
    <div class="col-12">
        <h2 class="display-5 text-center">
            Penerapan Metode MOORA Dalam Menentukan Reward Pengacara di Kantor Hukum R.H. Legal Consultan
        </h2>
    </div>
</div>

<?php include('footer.php') ?>