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

        .slug-icon {
            border-radius: 48px;
            margin-top: 7px;
        }

        .buy-label {
            font-family: 'Tokopedia-Reguler';
            font-size: 13px;
            display: block;
            margin-top: 0px !important;
        }

        .buy-form-control {
            font-family: 'Tokopedia-Reguler';
            border: none;
            background: none;
            border-bottom: 1px solid #00AA5B;
            border-radius: 0;
            outline: none;
            margin-top: -8px;
            padding: 0;
        }

        .buy-form-control:focus {
            box-shadow: 0 0 0 transparent;
            border: none;
            background: none;
            border-bottom: 1px solid #00AA5B;
        }

        .buy-history {
            width: 130px;
            border: 1px solid rgb(0, 218, 116);
            border-radius: 48px;
            font-size: 13px;
            display: inline-block
        }

        #vertical-scroll {
            width: 100%;
            overflow-x: scroll;
            white-space: nowrap;
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;  /* Firefox */
        }

        #vertical-scroll::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }

        .box-white .prices {
            font-family: Arial;
            display: block;
            font-size: 12px;
            font-weight: bold;
        }

        .product-name {
            font-size: 13px !important;
        }

        .box-product.active {
            border: 1px solid rgb(0, 218, 116) !important;
            color: #000;
        }

        .shadow-top {
            box-shadow: 0 -.125rem .25rem rgba(0,0,0,.075)!important
        }

        .btn-success {
            background-color: var(--GN500, #00AA5B);
            border: none;
            border-radius: 48px;
            color: #fff;
            padding: 7px 0;
            outline: none;
        }

        .box-product.disabled {
            border: 1px solid rgb(211, 211, 211);
            background-color:rgb(233, 233, 233);
            color: #666666;
        }

        .css-c1gsx8 {
            font-size: 12px;
            color: var(--NN1000, rgba(0, 0, 0, 0.54));
            display: block;
            margin: 0px 0px 6px;
        }

        .badge-check {
            position: absolute; 
            top: -14px; 
            right: -14px; 
            font-size: 15px; 
            border-radius: 4px; 
            border-top-right-radius: 7px;
        }

        .badge-success {
            background: #00AA5B important;
        }

        select.form-control {
            height: 50px;
            border-radius: 12px;
            outline: none;
            border-left: 0;
            padding-left: 0;
        }
        
        input.form-control {
            height: 50px;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 18px 13px !important;
            outline: none;
        }

        select.form-control:focus {
            border: 1px solid #ced4da;
            border-left: 0;
            box-shadow: 0 0 0 transparent;
        }

        input.form-control:focus {
            border: 1px solid #ced4da;
            box-shadow: 0 0 0 transparent;
        }

        input.form-control[readonly] {
            background-color: transparent !important;
            opacity: 1;
        }

        .input-group-text {
            background: none;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }
        .border {
            border: 1px solid #ced4da !important;
        }

        .selectNominal {
            cursor: pointer;
            display: inline-block;
            margin: 5px 5px;
            width: auto;
            text-align: center;
            padding: 8px 10px;
            border: 1px solid #ced4da;
            border-radius: 48px;
            font-size: 12px;
            font-family: Arial;
        }

        .selectNominal a {
            text-decoration: none;
        }

        .active {
            border: 1px solid #00AA5B !important;
        }

        .alert {
            font-size: 13px;
        }

        .px-6 {
            padding-left: 30px;
            padding-right: 30px;
        }

        .rounded {
            border: 1px solid rgb(236, 236, 236);
            border-radius: 13px !important;
        }

        .boxtime strong {
            font-size: 13px !important;
        }

        .detail-deposit {
            font-size: 16px;
        }
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>

<div class="container">
    <div class="row">
        <div class="col-12" id="PhoneOrder">
            <div class="box-white bg-white shadow">
                <div class="row">
                <?php if (session('deposit_success') || $deposits['status'] == "pending"): ?>
                    <div class="col-12 mt-3 px-6">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-1"></i> <strong>Gotcha!</strong> Permintaan Deposit berhasil dibuat.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif ?>

                <?php if (session('deposit_error')): ?>
                    <div class="col-12 mt-3 px-6">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-1"></i> <strong>Gagal!</strong> <?= session('deposit_error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif ?>

                    <?php if($deposits['status'] == "pending") : ?>
                        <div class="col-12 mt-2 px-6">
                            <label style="font-size: 13px;">Segera lakukan pembayaran sebelum: </label>
                            <div class="boxtime d-block mx-auto w-100 mt-3 p-3 shadow-sm rounded">
                                <strong>Batas waktu pembayaran</strong>
                                <div class="detail-deposit d-block mx-auto mt-2 text-danger font-weight-bold"><?= date('d F Y H:i:s', strtotime($deposits['updated_at']));?></div>
                            </div>
                        </div>

                        <div class="col-12 mt-4 px-6">
                            <label style="font-size: 13px;">Segera lakukan pembayaran sebesar: </label>
                            <div class="boxtime d-block mx-auto w-100 mt-3 p-3 shadow-sm rounded">
                                <strong>Total</strong> <small>*Jumlah yang harus dibayar</small>
                                <div class="detail-deposit d-block mx-auto mt-2 text-danger font-weight-bold"><?= $curr . " " .number_format($deposits['total']+$deposits['uniq'], 0, ",", "."); ?></div>
                            </div>
                        </div>
                        <div class="col-12 mt-4 mb-3 px-6">
                            <label style="font-size: 13px;">Transfer ke rekening <strong><?= $bank['name'] . " " . $bank['number'] . "</strong> A/N <strong>" . $bank['behalf'] ?></strong></label>
                            <div class="mt-2 text-center">
                                <img src="<?= base_url() ?>home/img/bank/<?= $bank['icon'] ?>" alt="<?= $bank['name'] ?>" style="width: 150px !important; height: auto !important; border-radius: 0 !important;">
                            </div>
                        </div>
                    <?php elseif($deposits['status'] == "approved") : ?>
                    <div class="col-12" style="padding: 14px 30px;">
                        <span class="css-c1gsx8">Status Deposit</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px;">BERHASIL</p>
                                                
                    </div>
                    <div class="col-12 mx-0" style="margin-top: -8px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Rincian Deposit</span>
                    </div>

                    <div class="col-12 mt-3 py-0" style="padding: 0 30px;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <span class="css-c1gsx8 text-center">Tanggal Deposit</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= date('d M Y H:i:s', strtotime($deposits['created_at']));?></p>
                            </div>
                            <div class="col-6">
                                <span class="css-c1gsx8 text-center">No.Invoice</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;">#<?= $deposits['id']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Metode Pembayaran</span>
                        <img src="<?= base_url() ?>home/img/bank/<?= $bank['icon'] ?>" class="my-2" width="55" alt="">
                        <br>
                        <small><strong><?= $bank['name'] . " " . $bank['number'] . "</strong> A/N <strong>" . $bank['behalf'] ?></strong></small>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Pembayaran</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($deposits['total']+$deposits['uniq'], 0, ",", "."); ?></p>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Catatan</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?php if(empty($deposits['note'])) : echo '-'; else : echo $deposits['note']; endif ?></p>
                    </div>
                    <?php elseif($deposits['status'] == "declined") : ?>
                    <div class="col-12" style="padding: 14px 30px;">
                        <span class="css-c1gsx8">Status Deposit</span>
                        <p class="text-danger font-weight-bold" style="margin-top: -5px;">DITOLAK</p>
                                                
                    </div>
                    <div class="col-12 mx-0" style="margin-top: -8px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Rincian Deposit</span>
                    </div>

                    <div class="col-12 mt-3 py-0" style="padding: 0 30px;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <span class="css-c1gsx8 text-center">Tanggal Deposit</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= date('d M Y H:i:s', strtotime($deposits['created_at']));?></p>
                            </div>
                            <div class="col-6">
                                <span class="css-c1gsx8 text-center">No.Invoice</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;">#<?= $deposits['id']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Metode Pembayaran</span>
                        <img src="<?= base_url() ?>home/img/bank/<?= $bank['icon'] ?>" class="my-2" width="55" alt="">
                        <br>
                        <small><strong><?= $bank['name'] . " " . $bank['number'] . "</strong> A/N <strong>" . $bank['behalf'] ?></strong></small>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Pembayaran</span>
                        <p class="text-danger font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($deposits['total']+$deposits['uniq'], 0, ",", "."); ?></p>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Catatan</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?php if(empty($deposits['note'])) : echo '-'; else : echo $deposits['note']; endif ?></p>
                    </div>
                    <?php endif ?>

                    
                </div>
            </div>
        </div>
    </div>
</div>

  <?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<script>
    $(function() {
        $("form#FormDeposit").on('submit', function() {
            $bank    = $("select#bank").val();
            $Nominal = $("input#nominal").val();

            if($Nominal.replace(".", "") < 50000) {
                $("#Err").removeClass('d-none');
                $("#Err").html('Kamu harus memilih nominal');
                return false;
            } else {
                return true;
            }
        });
        
        $("#bank").on('change', function() {
            $GetIcon = $('select#bank option:checked').attr('data-id');
            $("#bank_icon").attr('src', '/home/img/bank/' + $GetIcon);
        });

        $("div.selectNominal").on('click', function() {
            $("div.selectNominal").removeClass('active');
            $(this).addClass('active');

            $Nom = $(this).find('span').attr('price');
            $("input#nominal").val($Nom)
        })

        $("input#nominal").on('change', function() {
            $Nom = $("input#nominal").val();
            $Nominal = parseInt($Nom).toLocaleString(); 
            $("input#nominal").val($Nominal);
        });
    })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>