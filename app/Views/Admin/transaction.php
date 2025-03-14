<?php $this->extend('template_admin'); ?>
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
                    <table id="TransactionTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>No.Invoice</th>
                          <th>Data Pengguna</th>
                          <th>Data Order</th>
                          <th>Price</th>
                          <th>Fee</th>
                          <th>Total</th>
                          <th>Tanggal</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($Transactions as $key => $u) : ?>
                          <tr>
                            <td>#<?= $u['id'] ?></td>
                            <td style="line-height: 1.6 !important;"><?= $u['name'] . "<br>" . $u['email'] . "<br>" . $u['phone'] ?></td>
                            <td style="line-height: 1.6 !important;"><?= $u['product'] . "<br>" . $u['target'] ?></td>
                            <td><?= $curr . " " . number_format($u['price'], 0, ",", "."); ?></td>
                            <td><?= $curr . " " . number_format($u['fee'], 0, ",", "."); ?></td>
                            <td><?= $curr . " " . number_format($u['total'], 0, ",", "."); ?></td>
                            <td><?= date('d-M-Y H:i', strtotime($u['date']));?></td>
                            <td>
                              <?php if($u['status'] == "Pending" || $u['status'] == "Processing") : ?>
                                <label class="badge badge-warning">Pending</label>
                              <?php elseif($u['status'] == "Canceled") : ?>
                                <label class="badge badge-danger">Dibatalkan</label>
                              <?php else : ?>
                                <label class="badge badge-success">Berhasil</label>
                              <?php endif ?>
                            </td>
                            <td>
                            <?php if($u['status'] == "Pending" || $u['status'] == "Processing" || $u['status'] == "Canceled") : ?>
                                <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $u['id'] . '', 'status' => '' . $u['status'] . '')) ?>'><i class="mdi mdi-pencil"></i></a>
                            <?php else : ?>
                                <button href="javascript:void(0);" class="btn btn-sm btn-info disabled" disabled><i class="mdi mdi-pencil"></i></button>
                            <?php endif ?>
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
        <h5 class="modal-title" id="exampleModalLabel">Ubah status Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/transaction/update" class="forms-sample" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Status Transaction</label>
            <select name="status" id="status" class="form-control p-3" required>
                <option value="Processing" selected disabled>- Pilih Status -</option>
                <option value="Completed">Disetujui</option>
                <option value="Canceled">Ditolak</option>
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
<script>
      let table = new DataTable('#TransactionTable', {
          responsive: true,
          ordering: false,
          "bLengthChange": false,
      });
    </script>
<script>
  $("body").on('click', 'a#EditModal', function () {
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("#exampleModalLabel").html('Ubah Status Transaksi #' + $Data.id);
    $("form.forms-sample").attr('action', '/admin/transaction/update');

    $("#id").val($Data.id)
    $("#status").val($Data.status).change();
  })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>