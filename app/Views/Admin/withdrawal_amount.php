<?php $this->extend('template_admin'); ?>

<?php $this->section('css'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?php $this->endSection(); ?>

<?php $this->section('konten'); ?>
<div class="row">
    <div class="col-12">
        <?php if (session('errors')): ?>
            <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-danger bg-danger border-0 m-0 text-ligt alert-dismissable">
                <?= session('errors') ?>
                <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
            </div>
        <?php endif ?>
        <?php if (session('success')): ?>
            <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-success bg-success border-0 m-0 text-ligt alert-dismissable">
                <?= session('success') ?>
                <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal" id="AddModal">
                <i class="mdi mdi-plus"></i> Tambah Nominal
            </button>
            <div class="table-responsive-lg">
                <table id="WithdrawalAmountTable" class="table table-striped nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($withdrawal_amount as $key => $wa) : ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $curr . " " .number_format($wa['amount'], 0, ",", "."); ?></td>
                            <td>
                                <?php if($wa['status'] == "1") : ?>
                                <label class="badge badge-success">Aktif</label>
                                <?php else : ?>
                                <label class="badge badge-danger">Tidak Aktif</label>
                                <?php endif ?>
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $wa['id'] . '', 'amount' => ''.$wa['amount'] .'', 'status' => ''.$wa['status'] .'')) ?>'><i class="mdi mdi-pencil"></i></a>
                                <a href="<?= base_url() ?>admin/withdrawal/amount/delete/<?= $wa['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus nominal ini?')"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Nominal Penarikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url() ?>admin/withdrawal/amount/add" class="forms-sample" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nominal</label>
                        <input type="number" class="form-control" name="amount" id="amount" placeholder="Masukkan nominal" required>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(function () {
        let table = new DataTable('#WithdrawalAmountTable', {
            responsive: true,
            ordering: false,
            "bLengthChange": false,
        });
        
        $("body").on('click', 'button#AddModal', function() {
            $("#exampleModalLabel").html('Tambah Nominal Penarikan');
            $("form.forms-sample").attr('action', '<?= base_url() ?>admin/withdrawal/amount/add');

            $("#id").val('');
            $("#amount").val('');
            $("#status").val('1').change();
        });

        $("body").on('click', 'a.btn-info', function () {
            $("#exampleModalLabel").html('Edit Nominal Penarikan');
            $Data = jQuery.parseJSON($(this).attr('data-id'));

            $("form.forms-sample").attr('action', '<?= base_url() ?>admin/withdrawal/amount/edit');

            $("#id").val($Data.id);
            $("#amount").val($Data.amount);
            $("#status").val($Data.status).change();
        });

        // Menangani klik pada tombol close notifikasi
        $(document).on('click', '.alert .close', function(e) {
            e.preventDefault();
            $(this).closest('.alert').fadeOut(500, function() {
                $(this).remove();
            });
        });

        // Auto hide alert
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 4000);
    });
</script>
<?php $this->endSection(); ?> 