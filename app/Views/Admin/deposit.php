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
                    <table id="DepositTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>No.Invoice</th>
                          <th>Data Pengguna</th>
                          <th>Data Bank</th>
                          <th>Total</th>
                          <th>Tanggal Deposit</th>
                          <th>Tanggal Expired</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($allDeposits as $key => $u) : ?>
                          <tr>
                            <td>#<?= $u['id'] ?></td>
                            <td style="line-height: 1.6 !important;"><?= $u['fullname'] . "<br>" . $u['email'] . "<br>" . $u['phone'] ?></td>
                            <td style="line-height: 1.6 !important;"><?= $u['bank'] . "<br>" . $u['number'] . "<br>" . $u['behalf'] ?></td>
                            <td><?= $curr . " " .number_format($u['total']+$u['uniq'], 0, ",", "."); ?></td>
                            <td><?= date('d-M-Y H:i', strtotime($u['created_at']));?></td>
                            <td><?= date('d-M-Y H:i', strtotime($u['updated_at']));?></td>
                            <td>
                              <?php if($u['status'] == "pending") : ?>
                                <label class="badge badge-warning">Pending</label>
                              <?php elseif($u['status'] == "declined") : ?>
                                <label class="badge badge-danger">Ditolak</label>
                              <?php else : ?>
                                <label class="badge badge-success">Disetujui</label>
                              <?php endif ?>
                            </td>
                            <td>
                            <?php if($u['status'] == "approved") : ?>
                              <button href="javascript:void(0);" class="btn btn-sm btn-info disabled" disabled><i class="mdi mdi-pencil"></i></button>
                            <?php else : ?>
                              <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $u['id'] . '', 'total' => ''.$u['total'] .'', 'proof' => ''.$u['proof'] .'', 'fullname' => ''.$u['fullname'] .'', 'email' => ''.$u['email'] .'', 'note' => ''.$u['note'] .'', 'status' => ''.$u['status'] .'', 'date' => ''.$u['created_at'] .'')) ?>'><i class="mdi mdi-pencil"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Ubah status deposit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/deposit/update" class="forms-sample" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Status Deposit</label>
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

  
      let table = new DataTable('#DepositTable', {
          responsive: true,
          ordering: false,
          "bLengthChange": false,
      });
    </script>
<script>

  $("body").on('click', 'a#EditModal', function () {
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("#exampleModalLabel").html('Ubah Status Deposit #' + $Data.id);
    $("form.forms-sample").attr('action', '/admin/deposit/update');

    $("#id").val($Data.id)
    $("#status").val($Data.status).change();
    $("textarea#note").html($Data.note);
  })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>