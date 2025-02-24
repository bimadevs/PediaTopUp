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
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" id="AddModal" data-bs-target="#exampleModal"><i class="mdi mdi-plus"></i> Tambah Bank</button>
                    <div class="table-responsive-lg">
                    <table id="myTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Bank</th>
                          <th>No.Rekening</th>
                          <th>Atas Nama</th>
                          <th>Min Deposit</th>
                          <th>Icon</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($allBanks as $key => $p) : ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $p['name'] ?></td>
                            <td><?= $p['number'] ?></td>
                            <td><?= $p['behalf'] ?></td>
                            <td><?= $curr . " ".number_format($p['min'], 0, ",", "."); ?></td>
                            <td><img src="<?= base_url() ?>home/img/bank/<?= $p['icon'] ?>" alt="" style="width: 90px !important; height: auto !important; border-radius: 0 !important;"></td>
                            <td>
                            <?php if($p['status'] == "1") : ?>
                                <label class="badge badge-success">Aktif</label>
                            <?php else : ?>
                                <label class="badge badge-danger">Tidak Aktif</label>
                            <?php endif ?>
                            </td>
                            <td>
                              <a href="javascript:void(0);" class="btn btn-sm btn-info" type="button" id="EditModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='<?= json_encode(array('id' => '' . $p['id'] . '', 'name' => ''.$p['name'] .'', 'number' => ''.$p['number'] .'', 'behalf' => ''.$p['behalf'] .'', 'min' => ''.$p['min'] .'', 'icon' => ''.$p['icon'] .'', 'status' => ''.$p['status'] .'')) ?>'><i class="mdi mdi-grease-pencil"></i></a>
                              <a href="/admin/bank/delete/<?= $p['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus Bank ini?');" class="btn btn-sm btn-danger" type="button"><i class="mdi mdi-delete"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Bank Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/bank/add" class="forms-sample" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nama Bank</label>
            <input type="text" name="name" id="name" placeholder="Masukkan nama Bank" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">No.Rekening</label>
            <input type="tel" name="number" id="number" placeholder="Masukkan nomor rekening" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Atas Nama</label>
            <input type="text" name="behalf" id="behalf" placeholder="Masukkan nama pemilik rekening" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Minimum Deposit</label>
            <input type="tel" name="min" id="min" placeholder="Masukkan nominal Maksimum Deposit (cth: 10000)" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="">Icon Bank</label>
            <img id="blah" class="d-none mt-2 mb-3" src="" width="90" alt="">
            <input type="file" name="icon" id="icon" class="form-control" required>
            <small class="text-danger iconErr d-none">*Kosongkan jika tidak ingin mengganti icon</small>
          </div>
          <div class="form-group">
            <label for="">Status Bank</label>
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
    $("#exampleModalLabel").html('Tambah Bank Baru');
    $("form.forms-sample").attr('action', '/admin/bank/add');
    $("#icon").attr('required', true);

    $("#id").val('')
    $("#name").val('');
    $("#number").val('');
    $("#behalf").val('');
    $("#min").val('');
    $("#icon").val('');
    $(".iconErr").addClass('d-none');
    $("#status").val('1').change();
    $("#blah").attr('src', '');
    $("#blah").removeClass('d-block');
    $("#blah").addClass('d-none');
  });

  $("body").on('click', 'a.btn-info', function () {
    $("#exampleModalLabel").html('Edit Data Bank');
    $("#icon").attr('required', false);
    $Data = jQuery.parseJSON($(this).attr('data-id'));

    $("form.forms-sample").attr('action', '/admin/bank/edit');

    $(".iconErr").removeClass('d-none');
    $("#id").val($Data.id)
    $("#name").val($Data.name);
    $("#number").val($Data.number);
    $("#behalf").val($Data.behalf);
    $("#min").val($Data.min);
    $("#blah").removeClass('d-none');
    $("#blah").addClass('d-block');
    $("#blah").attr('src', '/home/img/bank/' + $Data.icon);
    $("#status").val($Data.status).change();
  })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>