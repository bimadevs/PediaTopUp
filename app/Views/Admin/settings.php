<?php $this->extend('template_admin'); ?>
<?php $this->section('css'); ?>
    <style>
        li.nav-item button:focus {
            background: #c58aff !important;
        }
    </style>
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
                <div class="col-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="btn btn-sm btn-primary active" id="umum-tab" data-bs-toggle="tab" data-bs-target="#umum" type="button" role="tab" aria-controls="umum" aria-selected="true">Umum</button>
                        </li>
                        <li class="nav-item mx-2" role="presentation">
                            <button class="btn btn-sm btn-primary" id="banner-tab" data-bs-toggle="tab" data-bs-target="#banner" type="button" role="tab" aria-controls="banner" aria-selected="false">Banner</button>
                        </li>
                        <li class="nav-item mx-2" role="presentation">
                            <button class="btn btn-sm btn-primary" id="banner2-tab" data-bs-toggle="tab" data-bs-target="#banner2" type="button" role="tab" aria-controls="banner2" aria-selected="false">Banner 2</button>
                        </li>
                        <li class="nav-item mx-2" role="presentation">
                            <button class="btn btn-sm btn-primary" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">Password</button>
                        </li>
                        <li class="nav-item mx-2" role="presentation">
                            <button class="btn btn-sm btn-primary" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Lainnya</button>
                        </li>
                    </ul>
                </div>
                <div class="col-12 mt-4 mt-md-5">
                <div class="tab-content" id="myTabContent">    
                    <div class="tab-pane fade active show" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                    <div class="card">
                        <h5 class="card-title mx-md-5 mx-4 mt-4 mt-md-3 mb-0">Pengaturan SEO</h5>
                            <div class="card-body p-md-5 p-4 py-md-4 py-4">
                                <form class="forms-sample" action="/admin/settings/update" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="section" id="section" value="umum">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Nama Website</label>
                                        <input type="text" class="form-control" name="web-title" id="web-title" value="<?= $web_title ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Logo Website</label>
                                        <img class="d-block my-2 mb-3" src="<?= base_url() ?>home/img/<?= $web_logo ?>" width="100" id="logo-preview" alt="">
                                        <div class="input-group col-xs-12"> 
                                        <input type="file" class="form-control file-upload-info" name="web-logo" id="web-logo">
                                        
                                        </div>
                                        <small class="text-danger">*Abaikan jika tidak ingin mengubah logo</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Favicon Website</label>
                                        <img class="d-block my-2 mb-3" src="<?= base_url() ?>home/img/<?= $web_icon ?>" width="50" id="icon-preview" alt="">
                                        <div class="input-group col-xs-12"> 
                                        <input type="file" class="form-control file-upload-info" name="web-icon" id="web-icon">
                                        
                                        </div>
                                        <small class="text-danger">*Abaikan jika tidak ingin mengubah favicon</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Author Website</label>
                                        <input class="form-control" name="web-author" id="web-author" value="<?= $web_author ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Deskripsi Website</label>
                                        <textarea class="form-control" name="web-description" id="web-description" rows="4" required style="line-height: 1.2;"><?= $web_description ?></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Keyword Website</label>
                                        <textarea class="form-control" name="web-keywords" id="web-keywords" rows="4" required style="line-height: 1.1;"><?= $web_keywords ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="banner" role="tabpanel" aria-labelledby="banner-tab">
                        <div class="card">
                        <h5 class="card-title mx-md-5 mx-4 mt-4 mt-md-3 mb-0">Pengaturan Banner</h5>
                            <div class="card-body p-md-5 p-4 py-md-4 py-4">
                            
                                <form class="forms-sample" action="/admin/settings/update" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="section" id="section" value="banner">
                                    <div class="form-group">
                                        <label>Banner Website</label>
                                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                            <?php foreach($slide as $key => $banner) : ?>
                                                <div class="carousel-item  <?php if($key == 0) : ?>active<?php endif ?>">
                                                    <img class="d-block my-2 mb-3 w-100 w-lg-50" src="<?= base_url() ?>home/img/banner/<?= $banner ?>" id="banner-preview" alt="">
                                                </div>
                                            <?php endforeach ?>
                                            </div>
                                        </div>
                       
                                        <div class="input-group col-xs-12"> 
                                            <input type="file" class="form-control file-upload-info" name="banner[]" id="banner" multiple="multiple" accept="image/jpg, image/jpeg"  required>
                                        </div>
                                        <small class="text-danger">*Abaikan jika tidak ingin mengubah banner</small>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="banner2" role="tabpanel" aria-labelledby="banner2-tab">
                        <div class="card">
                        <h5 class="card-title mx-md-5 mx-4 mt-4 mt-md-3 mb-0">Pengaturan Banner 2</h5>
                            <div class="card-body p-md-5 p-4 py-md-4 py-4">
                            
                                <form class="forms-sample" action="/admin/settings/update" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="section" id="section" value="banner2">
                                    <div class="form-group">
                                        <label>Banner Website 2</label>
                                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                            <?php foreach($slide2 as $key2 => $banner2) : ?>
                                                <div class="carousel-item  <?php if($key2 == 0) : ?>active<?php endif ?>">
                                                    <img class="d-block my-2 mb-3 w-100 w-lg-50" src="<?= base_url() ?>home/img/banner/<?= $banner2 ?>" id="banner-preview2" alt="">
                                                </div>
                                            <?php endforeach ?>
                                            </div>
                                        </div>
                       
                                        <div class="input-group col-xs-12"> 
                                            <input type="file" class="form-control file-upload-info" name="banner2[]" id="banner2" multiple="multiple" accept="image/jpg, image/jpeg"  required>
                                        </div>
                                        <small class="text-danger">*Abaikan jika tidak ingin mengubah banner 2</small>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                        <div class="card">
                            <h5 class="card-title mx-md-5 mx-4 mt-4 mt-md-3 mb-0">Ubah Password</h5>
                            <div class="card-body p-md-5 p-4 py-md-4 py-4">
                                <form class="forms-sample" action="/admin/change-password" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label for="old_password">Password Lama</label>
                                        <input type="password" class="form-control" name="old_password" id="old_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Password Baru</label>
                                        <input type="password" class="form-control" name="new_password" id="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary mr-2">Ubah Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="card">
                        <h5 class="card-title mx-md-5 mx-4 mt-4 mt-md-3 mb-0">Pengaturan Lainnya</h5>
                            <div class="card-body p-md-5 p-4 py-md-4 py-4">
                            
                                <form class="forms-sample" action="/admin/settings/update" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="section" id="section" value="other">
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Email Website</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">No.Telepon/Whatsapp</label>
                                        <input type="tel" class="form-control" name="phone" id="phone" value="<?= $phone ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Biaya Admin</label>
                                        <input type="tel" class="form-control" name="fee" id="fee" value="<?= $fee ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Mata Uang</label>
                                        <input type="tel" class="form-control" name="currency" id="currency" value="<?= $currency ?>" required>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="exampleTextarea1">Chat ID Tele</label>
                                            <input type="tel" class="form-control" name="chat_id" id="chat_id" value="<?= $chat_id ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="exampleTextarea1">Bot Token Tele</label>
                                            <input type="tel" class="form-control" name="bot_token" id="bot_token" value="<?= $bot_token ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Bonus Deposit (%)</label>
                                        <input type="text" class="form-control" name="bonus-deposit" value="<?= $bonus_deposit ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Biaya Penarikan (%)</label>
                                        <input type="text" class="form-control" name="fee-withdrawal" value="<?= $fee_withdrawal ?>">
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>                                                       
                </div>
                  
                </div>
              </div>
                </div>
              </div>

<?php $this->endSection(); ?>
<?php $this->section('js'); ?>
<script>
    function readURL(input, $Target) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $($Target).attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
    }

    $("#web-logo").change(function(){
        readURL(this, '#logo-preview');
    });

    $("#web-icon").change(function(){
        readURL(this, '#icon-preview');
    });

  $("body").on('click', 'button#AddModal', function() {
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