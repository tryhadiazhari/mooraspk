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
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);

    var url = window.location.href.split('/');

    if (url[4] != '') {
        $('title').html('Moora SPK | ' + $('.title').html());
    }

    $('#table').DataTable({
        "paging": true,
        "info": true,
        "ordering": true,
        "lengthMenu": [
            [10, 20, 25, 30, 35, 40, 45, 50, -1],
            [10, 20, 25, 30, 35, 40, 45, 50, "Semua"]
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["noshort"]
        }],
    });

    $('#table2').DataTable({
        dom: 'Bfrtip',
        "paging": true,
        "info": false,
        "ordering": true,
        "lengthMenu": [
            [10, 20, 25, 30, 35, 40, 45, 50, -1],
            [10, 20, 25, 30, 35, 40, 45, 50, "Semua"]
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["noshort"]
        }],
        buttons: [{
            extend: 'print',
            title: '',
            messageTop: '<h2 style="text-align: center; font-weight: bold; margin: 0 auto 40px auto; text-decoration: underline">Laporan Hasil Penilaian</h2>',
            customize: function(win) {
                $(win.document.body).find('th, td:first-child, td:last-child').addClass('text-center');
            }
        }]
    });

    $('#table2_wrapper').find('.dataTables_filter').addClass('mb-3 p-0');
    $('#table2_wrapper').find('.dataTables_info').addClass('py-0 mt-2');
    $('#table2_wrapper').find('.dataTables_paginate').addClass('py-0 mt-3').find('.pagination').addClass('my-0');

    $('#table_wrapper').find('.dataTables_info').addClass('py-0 mt-2');
    $('#table_wrapper').find('.dataTables_paginate').addClass('py-0 mt-2').find('.pagination').addClass('my-0')
    $('.buttons-print').removeClass('btn-secondary').addClass('btn-primary px-4 mb-2').find('span').addClass('px-0 mx-0').html('<i class="fa fa-print fa-fw mx-0 mr-2"></i>Cetak');

    $('.nik, .bobot').inputmask({
        placeholder: '',
        regex: '\\d*'
    });

    $('.nama, .subkriteria').inputmask({
        regex: "^[A-Za-z\,\.\\s]+$",
        placeholder: ''
    });

    $('.alamat').inputmask({
        regex: "^[A-Za-z0-9\.\,\\s]+$",
        placeholder: ''
    });

    $('form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            beforeSend: function() {
                $('button[type=submit]').html('Mohon menunggu... <i class="fa fa-spinner fa-spin"></i>');
                $('.form-control').removeClass('is-invalid');
            },
            complete: function() {
                $('button[type=submit]').html('Simpan')
            },
            statusCode: {
                404: function(error) {
                    $.each(error.responseJSON, function(field, value) {
                        $('.' + field).addClass('is-invalid');
                        $('.invalid-' + field).html(value);
                    });
                },
                400: function(error) {
                    toastr.error(error.responseJSON.error);
                },
                300: function(error) {
                    $.each(error.responseJSON, function(field, value) {
                        $('.' + field).addClass('is-invalid');
                        $('.invalid-' + field).html(value);
                    });
                }
            },
            success: function(response) {
                toastr.success(response);

                setTimeout(function() {
                    window.location = '<?= $_SERVER['PHP_SELF'] ?>';
                }, 1000);
            }
        });

    });
</script>
</body>

</html>