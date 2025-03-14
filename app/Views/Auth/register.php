<?php $this->extend('template'); ?>
<?php $this->section('css'); ?>
    <style>
        #Waves {
            background: url('<?= base_url() ?>home/img/waves.png') no-repeat;
            background-size: 100%;
        }

        .box-white {
            position: relative;
            top: -130px;
            border-radius: 7px;
            z-index: 4;
            border: 1px solid transparent;
        }

        .buy-label {
            text-align: center;
            width: auto;
            background: #fff;
            padding: 2px;
            position: relative;
            color: rgba(0,0,0, 0.5);
            margin-top: -10px;
            margin-left: 14px;
            font-size: 13px;
            top: -32px;
            z-index: 1;
        }

        .buy-form-control {
            position: relative;
            z-index: 2;
            background: transparent;
            font-size: 13px;
            padding: 20px 13px;
            border-radius: 8px;
            border: 1px solid rgba(191,201,217, 1)
            outline: none;
        }

        .buy-label-active {
            text-align: center;
            width: 134px;
            background: #fff;
            padding: 0px;
            position: relative;
            color: rgba(0,0,0, 1) !important;
            margin-top: -10px;
            margin-left: 9px;
            font-size: 12px !important;
            top: -55px;
            z-index: 3 !important; 
            transition: top 1s ease 0;
        }

        .buy-form-control:focus {
            background: transparent;
            font-size: 13px;
            padding: 20px 13px;
            border-radius: 8px;
            border: 1px solid #00AA5B;
            box-shadow: 0 0 0 transparent;
        }

        .buy-form-control:focus .buy-label {
            display: none;
        }

        .btn-success {
            background-color: var(--GN500, #00AA5B);
            border: none;
            border-radius: 8px;
            color: #fff;
            outline: none;
            padding: 10px 0;
        }
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="box-white bg-white px-4 pb-4 shadow">
                <div class="row">
                    <div class="col-12 my-3">
                        <img class="d-block mx-auto" width="130" src="<?= base_url() ?>home/img/<?= $logo ?>" alt="">
                    </div>
                    <div class="col-12 my-3"><h5 class="font-weight-bold">Daftar ke <?= $title ?></h5></div>
                    <div class="col-12 mt-3">
                        <form action="/register" method="POST" id="FormValidation">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <input type="text" name="nama" id="nama" class="form-control d-block buy-form-control" placeholder="Nama Lengkap" required>
                                <!-- <label class="buy-label" for="">Nomor HP atau Email</label> -->
                                <small class="text-danger d-none" id="ErrPhone" style="font-size: 10px;"></small>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control d-block buy-form-control" placeholder="Email Aktif" required>
                                <!-- <label class="buy-label" for="">Nomor HP atau Email</label> -->
                                <small class="text-danger d-none" id="ErrPhone" style="font-size: 10px;"></small>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" id="phone" class="form-control d-block buy-form-control" maxlength="16" placeholder="Nomor HP (Whatsapp)" required>
                                <!-- <label class="buy-label" for="">Nomor HP atau Email</label> -->
                                <small class="text-danger d-none" id="ErrPhone2" style="font-size: 10px;"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control d-block buy-form-control" placeholder="Password" autocomplete="off" required>
                                <!-- <label class="buy-label" for="">Password</label> -->
                                <small class="text-danger d-none" id="ErrPasswd" style="font-size: 10px;"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" name="repassword" id="repassword" class="form-control d-block buy-form-control" placeholder="Ketik ulang password" autocomplete="off" required>
                                <!-- <label class="buy-label" for="">Password</label> -->
                                <small class="text-danger d-block" id="ErrRePasswd" style="font-size: 12px; margin-top: 5px; left: 2px;"></small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success d-block mx-auto w-100" id="BTNSubmit" disabled>Daftar</button>
                            </div>
                            <div class="form-group">
                                <label class="d-block mx-auto text-center mt-4">Sudah punya akun? <a href="/login" style="color: #00AA5B"> Login disini</a></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<script>
    $("#phone").on('input', function() {
        $phone = $("#phone").val(),
        intRegex = /^(?:\08|0)[2-9]\d{7,11}$/;

        if($phone.length >= 11) {
            if(intRegex.test($phone)) {
                $("#ErrPhone2").addClass('d-none');
                $("#ErrPhone2").html('');
                $("#BTNSubmit").attr('disabled', false);
            } else {
                $("#ErrPhone2").removeClass('d-none');
                $("#ErrPhone2").html('Masukkan nomor Whatsapp yang valid!');
                $("#BTNSubmit").attr('disabled', true);
            }
        } else {
            $("#ErrPhone2").removeClass('d-none');
            $("#ErrPhone2").html('Masukkan nomor Whatsapp yang valid!');
            $("#BTNSubmit").attr('disabled', true);
        }
    }); 
        
    $("form#FormValidation").on('submit', function() {
        $Password = $("#password").val();
        $rePassword = $("#repassword").val();

        if($Password != $rePassword) {
            $("#ErrRePasswd").html('Password harus sama, silakan cek kembali password anda');
            return false;
        } else {
            return true;
        }
    })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>