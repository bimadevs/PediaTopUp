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
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <button class="btn btn-primary" type="button" data-bs-toggle="modal" id="AddModal" data-bs-target="#addModal"><i class="mdi mdi-plus"></i> Tambah Nominal Deposit</button>
      <div class="table-responsive-lg">
        <table id="myTable" class="table table-striped nowrap" style="width: 100%;">
          <thead>
            <tr>
              <th>#</th>
              <th>Nominal</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($deposit_amount as $key => $p) : ?>
              <tr>
                <td><?= $key+1 ?></td>
                <td><?= $curr . " " . number_format($p['amount'], 0, ",", "."); ?></td>
                <td>
                  <?php if($p['status'] == "1") : ?>
                    <label class="badge badge-success">Aktif</label>
                  <?php else : ?>
                    <label class="badge badge-danger">Tidak Aktif</label>
                  <?php endif ?>
                </td>
                <td>
                  <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>"><i class="mdi mdi-grease-pencil"></i></button>
                  <a href="/admin/deposit/amount/delete/<?= $p['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus nominal deposit ini?');" class="btn btn-sm btn-danger" type="button"><i class="mdi mdi-delete"></i></a>
                </td>
              </tr>
              
              <!-- Modal Edit untuk setiap nominal -->
              <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel<?= $p['id'] ?>">Edit Nominal Deposit</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin/deposit/amount/edit" method="POST">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= $p['id'] ?>">
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="">Nominal</label>
                          <input type="number" name="amount" value="<?= $p['amount'] ?>" placeholder="Masukkan nominal deposit" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label for="">Status</label>
                          <select name="status" class="form-control" required>
                            <option value="1" <?= $p['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $p['status'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Nominal Deposit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/deposit/amount/add" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nominal</label>
            <input type="number" name="amount" placeholder="Masukkan nominal deposit" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Status</label>
            <select name="status" class="form-control" required>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
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

<script>
  $(document).ready(function() {
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

<style>
  .alert .close {
    cursor: pointer;
  }
</style>

<?php $this->endSection(); ?> 