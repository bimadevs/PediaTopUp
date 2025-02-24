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
                    <div class="col-12 my-3"><h5 class="font-weight-bold">Login ke <?= $title ?></h5></div>
                    <div class="col-12 mt-3">
                        <form action="/login" method="POST">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <input type="tel" name="phone" id="phone" class="form-control d-block buy-form-control" maxlength="16" placeholder="Nomor HP" autocomplete="off" required>
                                <!-- <label class="buy-label" for="">Nomor HP atau Email</label> -->
                                <small class="text-danger d-none" id="ErrPhone" style="font-size: 10px;"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control d-block buy-form-control" placeholder="Password" autocomplete="off" required>
                                <!-- <label class="buy-label" for="">Password</label> -->
                                <small class="text-danger d-none" id="ErrPasswd" style="font-size: 10px;"></small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success d-block mx-auto w-100">Login</button>
                            </div>
                            <div class="form-group">
                                <label class="d-block mx-auto text-center mt-4">Belum punya akun? <a href="/register" style="color: #00AA5B"> Daftar disini</a></label>
                                <label class="d-block mx-auto text-center mt-3"><a href="/login" style="color: #00AA5B"> Lupa Password</a></label>
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

<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>