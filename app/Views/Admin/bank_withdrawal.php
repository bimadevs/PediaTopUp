<?php $this->extend('template_admin'); ?>
<?php $this->section('konten'); ?>
  <?php if (session('error')): ?>
    <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-danger bg-danger border-0 m-0 text-ligt alert-dismissable">
        <?= session('error') ?>
        <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
    </div>
  <?php endif ?>
  <?php if (session('success')): ?>
    <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-success bg-success border-0 m-0 text-ligt alert-dismissable">
        <?= session('success') ?>
        <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
    </div>
  <?php endif ?>
  <?php if (session('errors')): ?>
    <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-danger bg-danger border-0 m-0 text-ligt alert-dismissable">
        <?= session('errors') ?>
        <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
    </div>
  <?php endif ?>
<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal" id="AddModal">
                      <i class="mdi mdi-plus"></i> Tambah Bank
                    </button>
                    <div class="table-responsive-lg">
                    <table id="BankTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Bank</th>
                          <th>Kode Bank</th>
                          <th>Icon</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($bank as $key => $b) : ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $b['name'] ?></td>
                            <td><?= $b['code'] ?></td>
                            <td>
                              <img src="<?= base_url() ?>home/img/bank/<?= $b['icon'] ?>" width="48" alt="<?= $b['name'] ?>" style="border-radius: 0;">
                            </td>
                            <td>
                              <?php if($b['status'] == "On") : ?>
                                <label class="badge badge-success">Aktif</label>
                              <?php else : ?>
                                <label class="badge badge-danger">Tidak Aktif</label>
                              <?php endif ?>
                            </td>
                            <td>
                              <a href="javascript:void(0);" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $b['id'] . '', 'name' => ''.$b['name'] .'', 'code' => ''.$b['code'] .'', 'status' => ''.$b['status'] .'')) ?>'><i class="mdi mdi-pencil"></i></a>
                              <a href="<?= base_url() ?>admin/bank/withdrawal/delete/<?= $b['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus bank ini?')"><i class="mdi mdi-delete"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Bank Penarikan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/bank/withdrawal/add" class="forms-sample" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama Bank</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Nama Bank" required>
          </div>
          <div class="form-group">
            <label for="">Kode Bank</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Kode Bank" required>
          </div>
          <div class="form-group">
            <label for="">Icon Bank</label>
            <input type="file" class="form-control" name="icon" id="icon">
            <small class="text-danger">*Abaikan jika tidak ingin mengubah icon</small>
          </div>
          <div class="form-group">
            <label for="">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="On">Aktif</option>
                <option value="Off">Tidak Aktif</option>
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
      let table = new DataTable('#BankTable', {
          responsive: true,
          ordering: false,
          "bLengthChange": false,
      });
    
  $("body").on('click', 'button#AddModal', function() {
    $("#exampleModalLabel").html('Tambah Bank Penarikan');
    $("form.forms-sample").attr('action', '/admin/bank/withdrawal/add');

    $("#id").val('')
    $("#name").val('');
    $("#code").val('');
    $("#status").val('On').change();
  });

  $("body").on('click', 'a.btn-info', function () {
    $("#exampleModalLabel").html('Edit Bank Penarikan');
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("form.forms-sample").attr('action', '/admin/bank/withdrawal/edit');

    $("#id").val($Data.id)
    $("#name").val($Data.name);
    $("#code").val($Data.code);
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
</script>

<style>
  .alert .close {
    cursor: pointer;
  }
</style>
<?php $this->endSection(); ?> 