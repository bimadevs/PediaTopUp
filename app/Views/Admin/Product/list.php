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
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" id="AddModal" data-bs-target="#exampleModal"><i class="mdi mdi-plus"></i> Tambah Produk</button>
                    <div class="table-responsive-lg">
                    <table id="myTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Produk</th>
                          <th>Kategori</th>
                          <th>Harga</th>
                          <th>Stok</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($allProduct as $key => $p) : ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $p['product'] ?></td>
                            <td><?= $p['category'] ?></td>
                            <td><?= $curr . " " .number_format($p['price'], 0, ",", "."); ?></td>
                            <td>
                            <?php if($p['stock'] < 30 && $p['stock'] > 0) : ?>
                                <label class="badge badge-warning">Tersisa <?= $p['stock'] ?></label>
                            <?php elseif($p['stock'] >= 30) : ?>
                                <label class="badge badge-success">Tersisa <?= $p['stock'] ?></label>
                            <?php elseif($p['stock'] == 0) : ?>
                                <label class="badge badge-danger">HABIS!</label>
                            <?php endif ?>
                            </td>
                            <td>
                              <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $p['id'] . '', 'category' => ''.$p['idcat'] .'', 'name' => ''.$p['product'] .'', 'price' => ''.$p['price'] .'', 'stock' => ''.$p['stock'] .'')) ?>'><i class="mdi mdi-grease-pencil"></i></a>
                              <a href="/admin/product/delete/<?= $p['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus Produk ini?');" class="btn btn-sm btn-danger" type="button"><i class="mdi mdi-delete"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/product/add" class="forms-sample" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Kategori Produk</label>
            <select class="form-control p-3" name="category" id="category" required>
                <option selected disabled>- Pilih kategori produk -</option>
                <?php foreach($allCategory as $key => $c) : ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">Nama Produk</label>
            <input type="text" name="name" id="name" placeholder="Masukkan nama produk (Cth: OVO 10.000)" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Harga Produk</label>
            <input type="tel" name="price" id="price" placeholder="Masukkan harga produk (Cth: 10000)" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Stok Produk</label>
            <input type="tel" name="stock" id="stock" placeholder="Masukkan stok produk" class="form-control" required>
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
    $("#exampleModalLabel").html('Tambah Produk Baru');
    $("form.forms-sample").attr('action', '/admin/product/add');
    $("#password").attr('required', true);

    $("#id").val('')
    $("#name").val('');
    $("#category").val('').change();
    $("#price").val('');
    $("#stock").val('');
  });

  $("body").on('click', 'a.btn-info', function () {
    $("#exampleModalLabel").html('Edit Data Produk');
    $("#password").attr('required', false);
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("form.forms-sample").attr('action', '/admin/product/edit');

    $("#id").val($Data.id)
    $("#name").val($Data.name);
    $("#category").val($Data.category).change();
    $("#price").val($Data.price);
    $("#stock").val($Data.stock);
  })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>