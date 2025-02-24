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
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" id="AddModal" data-bs-target="#exampleModal"><i class="mdi mdi-plus"></i> Tambah Kategori</button>
                    <div class="table-responsive-lg">
                    <table id="myTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Kategori</th>
                          <th>Slug</th>
                          <th>Icon</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($allCategory as $key => $p) : ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $p['name'] ?></td>
                            <td><?= $p['slug'] ?></td>
                            <td><img src="<?= base_url() ?>home/img/product/<?= $p['icon'] ?>" alt="" width="32" height="32"></td>
                            <td>
                            <?php if($p['status'] == "1") : ?>
                                <label class="badge badge-success">Aktif</label>
                            <?php else : ?>
                                <label class="badge badge-danger">Tidak Aktif</label>
                            <?php endif ?>
                            </td>
                            <td>
                              <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $p['id'] . '', 'category' => ''.$p['name'] .'', 'slug' => ''.$p['slug'] .'', 'icon' => ''.$p['icon'] .'', 'status' => ''.$p['status'] .'')) ?>'><i class="mdi mdi-grease-pencil"></i></a>
                              <a href="/admin/category/delete/<?= $p['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus Kategori ini?');" class="btn btn-sm btn-danger" type="button"><i class="mdi mdi-delete"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/category/add" class="forms-sample" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama Kategori</label>
            <input type="text" name="name" id="name" placeholder="Masukkan nama kategori (Cth: Shopee Pay)" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Slug Kategori</label>
            <input type="text" name="slug" id="slug" placeholder="Masukkan slug kategori (Cth: spay)" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Icon Kategori</label>
            <img id="blah" class="d-none mb-2" src="" width="40" height="40" alt="">
            <input type="file" name="icon" id="icon" class="form-control" required>
            <small class="text-danger iconErr d-none">*Kosongkan jika tidak ingin mengganti icon</small>
          </div>
          <div class="form-group">
            <label for="">Status Kategori</label>
            <select name="status" id="status" class="form-control p-3" required>
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
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $("#blah").removeClass('d-none');
            $("#blah").addClass('d-block');
            $('#blah').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
    }

    $("#icon").change(function(){
        readURL(this);
    });

  $("body").on('click', 'button#AddModal', function() {
    $("#exampleModalLabel").html('Tambah Kategori Baru');
    $("form.forms-sample").attr('action', '/admin/category/add');
    $("#icon").attr('required', true);

    $("#id").val('')
    $("#name").val('');
    $("#slug").val('');
    $("#icon").val('');
    $(".iconErr").addClass('d-none');
    $("#status").val('1').change();
    $("#blah").attr('src', '');
    $("#blah").removeClass('d-block');
    $("#blah").addClass('d-none');
  });

  $("body").on('click', 'a.btn-info', function () {
    $("#exampleModalLabel").html('Edit Data Kategori');
    $("#icon").attr('required', false);
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("form.forms-sample").attr('action', '/admin/category/edit');

    $(".iconErr").removeClass('d-none');
    $("#id").val($Data.id)
    $("#name").val($Data.category);
    $("#slug").val($Data.slug);
    $("#blah").removeClass('d-none');
    $("#blah").addClass('d-block');
    $("#blah").attr('src', '/home/img/product/' + $Data.icon);
    $("#status").val($Data.status).change();
  })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>