<?php $this->extend('template_admin'); ?>

<?php $this->section('css'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?php $this->endSection(); ?>

<?php $this->section('konten'); ?>
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

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive-lg">
                <table id="WithdrawalTable" class="table table-striped nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No.Invoice</th>
                            <th>Data Pengguna</th>
                            <th>Data Bank</th>
                            <th>Total</th>
                            <th>Tanggal Penarikan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($allWithdrawals)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data penarikan saldo</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach($allWithdrawals as $key => $w) : ?>
                        <tr <?php if($w['status'] == "pending") : ?>class="bg-warning bg-opacity-25"<?php endif ?>>
                            <td>#<?= $w['id'] ?></td>
                            <td style="line-height: 1.6 !important;">
                                <b><?= $w['user_name'] ?></b><br>
                                <?= $w['user_phone'] ?>
                            </td>
                            <td style="line-height: 1.6 !important;">
                                <b><?= $w['bank_name'] ?></b><br>
                                <?= $w['bank_account'] ?><br>
                                <?= $w['account_name'] ?>
                            </td>
                            <td>
                                <b>Nominal: <?= $curr . " " .number_format($w['total'] + $w['fee'], 0, ",", "."); ?></b><br>
                                <?php if($w['fee'] > 0) : ?>
                                Biaya Admin: <?= $curr . " " .number_format($w['fee'], 0, ",", "."); ?><br>
                                <?php endif ?>
                                Total Diterima: <?= $curr . " " .number_format($w['total'], 0, ",", "."); ?>
                            </td>
                            <td><?= date('d-M-Y H:i', strtotime($w['date'])); ?></td>
                            <td>
                                <?php if($w['status'] == "pending") : ?>
                                <label class="badge badge-warning">Pending</label>
                                <?php elseif($w['status'] == "approved") : ?>
                                <label class="badge badge-success">Disetujui</label>
                                <?php else : ?>
                                <label class="badge badge-danger">Ditolak</label>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php if($w['status'] == "approved") : ?>
                                <button href="javascript:void(0);" class="btn btn-sm btn-info disabled" disabled><i class="mdi mdi-pencil"></i></button>
                                <?php else : ?>
                                <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#withdrawalModal" data-id='<?= json_encode(array('id' => '' . $w['id'] . '', 'total' => ''.$w['total'] .'', 'fee' => ''.$w['fee'] .'', 'user_name' => ''.$w['user_name'] .'', 'user_phone' => ''.$w['user_phone'] .'', 'note' => ''.$w['note'] .'', 'status' => ''.$w['status'] .'', 'date' => ''.$w['date'] .'')) ?>'><i class="mdi mdi-pencil"></i></a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="withdrawalModal" tabindex="-1" aria-labelledby="withdrawalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="withdrawalModalLabel">Ubah status penarikan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url() ?>admin/withdrawal/edit" class="forms-sample" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Status Penarikan</label>
            <select name="status" id="status" class="form-control p-3" required>
                <option value="pending" selected disabled>- Pilih Status -</option>
                <option value="approved">Disetujui</option>
                <option value="declined">Ditolak</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Catatan untuk pengguna</label>
            <textarea name="note" id="note" class="form-control" rows="7"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        let table = new DataTable('#WithdrawalTable', {
            responsive: true,
            ordering: true,
            "bLengthChange": false,
            order: [[4, 'desc']],
        });
        
        $("body").on('click', 'a#EditModal', function () {
            $Data = jQuery.parseJSON($(this).attr('data-id'));

            $("#withdrawalModalLabel").html('Ubah Status Penarikan #' + $Data.id);
            $("form.forms-sample").attr('action', '<?= base_url() ?>admin/withdrawal/edit');

            $("#id").val($Data.id);
            $("#status").val($Data.status).change();
            $("textarea#note").html($Data.note);
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