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
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" id="AddModal" data-bs-target="#exampleModal"><i class="mdi mdi-plus"></i> Tambah Pengguna</button>
                    <div class="table-responsive-lg">
                    <table id="myTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Lengkap</th>
                          <th>No.Telepon</th>
                          <th>Saldo</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($all_users as $key => $users) : ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $users['name'] ?></td>
                            <td><?= $users['phone'] ?></td>
                            <td><?= $curr . " " .number_format($users['balance'], 0, ",", "."); ?></td>
                            <td>
                              <?php if($users['status'] == "Off") : ?>
                                <label class="badge badge-danger">Tidak Aktif</label>
                              <?php else : ?>
                                <label class="badge badge-success">Aktif</label>
                              <?php endif ?>
                            </td>
                            <td>
                              <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $users['id'] . '', 'name' => ''.$users['name'] .'', 'phone' => ''.$users['phone'] .'', 'email' => ''.$users['email'] .'', 'balance' => ''.$users['balance'] .'', 'status' => ''.$users['status'] .'')) ?>'><i class="mdi mdi-grease-pencil"></i></a>
                              <a href="/admin/users/delete/<?= $users['id'] ?>" onclick="return confirm('Ingin menghapus user ini?');" class="btn btn-sm btn-danger" type="button"><i class="mdi mdi-delete"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/users/add" class="forms-sample" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama Lengkap</label>
            <input type="text" name="fullname" id="fullname" placeholder="Masukkan nama lengkap" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Alamat Email</label>
            <input type="email" name="email" id="email" placeholder="Masukkan email pengguna" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">No.Telepon</label>
            <input type="tel" name="phone" id="phone" placeholder="Masukkan nomor telepon aktif" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Password</label>
            <input type="text" name="password" id="password" placeholder="Masukkan password" class="form-control" required>
            <small class="text-danger d-none" id="errSaldo">*Kosongkan jika tidak ingin mengubah password</small>
          </div>
          <div class="form-group">
            <label for="">Saldo</label>
            <input type="tel" name="balance" id="balance" placeholder="Masukkan saldo pengguna" class="form-control">
            <small class="text-danger d-none" id="errSaldo">*Abaikan jika tidak ingin mengubah balance</small>
          </div>
          <div class="form-group">
            <label for="">Status Users</label>
            <select name="status" id="status" class="form-control p-3" required>
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
  $("body").on('click', 'button#AddModal', function() {
    $("small#errSaldo").addClass('d-none');
    $("#exampleModalLabel").html('Tambah Pengguna Baru');
    $("form.forms-sample").attr('action', '/admin/users/add');
    $("#password").attr('required', true);

    $("#id_user").val('')
    $("#fullname").val('');
    $("#phone").val('');
    $("#email").val('');
    $("#balance").val('');
    $("#status").val('On').change;
  });

  $("body").on('click', 'a.btn-info', function () {
    $("small#errSaldo").removeClass('d-none');
    $("#exampleModalLabel").html('Edit Data Pengguna');
    $("#password").attr('required', false);
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("form.forms-sample").attr('action', '/admin/users/edit');

    $("#id").val($Data.id)
    $("#fullname").val($Data.name);
    $("#phone").val($Data.phone);
    $("#email").val($Data.email);
    $("#balance").val($Data.balance);
    $("#status").val($Data.status).change();
  })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>