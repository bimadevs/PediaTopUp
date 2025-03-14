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

        .css-c1gsx8 {
            font-size: 12px;
            color: var(--NN1000, rgba(0, 0, 0, 0.54));
            display: block;
            margin: 0px 0px 6px;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: normal;
        }

        .detail-deposit {
            font-size: 16px;
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
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>

<div class="container">
    <div class="row">
        <div class="col-12" id="PhoneOrder">
            <div class="box-white bg-white shadow">
                <div class="row">
                    <?php if($withdrawal['status'] == "pending") : ?>
                    <div class="col-12" style="padding: 14px 30px;">
                        <span class="css-c1gsx8">Status Penarikan</span>
                        <p class="text-warning font-weight-bold" style="margin-top: -5px;">Sedang Diproses</p>
                    </div>
                    <div class="col-12 mx-0" style="margin-top: -8px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Rincian Penarikan</span>
                    </div>

                    <div class="col-12 mt-3 py-0" style="padding: 0 30px;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <span class="css-c1gsx8 text-center">Tanggal Penarikan</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= $date ?></p>
                            </div>
                            <div class="col-6">
                                <span class="css-c1gsx8 text-center">No.Invoice</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;">#<?= $withdrawal['id'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12 mx-0 mb-4" style="margin-top: 3px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Detail Pesanan</span>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Bank Tujuan</span>
                        <img src="<?= base_url() ?>home/img/bank/<?= $bank_icon ?>" class="my-2" width="55" alt="">
                        <br>
                        <small><strong><?= $bank_name ?></strong></small>
                        <br>
                        <small><strong><?= $withdrawal['bank_account'] ?></strong> A/N <strong><?= $withdrawal['account_name'] ?></strong></small>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Penarikan</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['total'] + $withdrawal['fee'], 0, ",", "."); ?></p>
                        <?php if($withdrawal['fee'] > 0) : ?>
                        <span class="css-c1gsx8">Biaya Admin</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['fee'], 0, ",", "."); ?></p>
                        <span class="css-c1gsx8">Total Diterima</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['total'], 0, ",", "."); ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Catatan</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?php if(empty($withdrawal['note'])) : echo '-'; else : echo $withdrawal['note']; endif ?></p>
                    </div>

                    <?php elseif($withdrawal['status'] == "approved") : ?>
                    <div class="col-12" style="padding: 14px 30px;">
                        <span class="css-c1gsx8">Status Penarikan</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px;">BERHASIL</p>
                    </div>
                    <div class="col-12 mx-0" style="margin-top: -8px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Rincian Penarikan</span>
                    </div>

                    <div class="col-12 mt-3 py-0" style="padding: 0 30px;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <span class="css-c1gsx8 text-center">Tanggal Penarikan</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= $date ?></p>
                            </div>
                            <div class="col-6">
                                <span class="css-c1gsx8 text-center">No.Invoice</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;">#<?= $withdrawal['id'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Bank Tujuan</span>
                        <img src="<?= base_url() ?>home/img/bank/<?= $bank_icon ?>" class="my-2" width="55" alt="">
                        <br>
                        <small><strong><?= $bank_name ?></strong></small>
                        <br>
                        <small><strong><?= $withdrawal['bank_account'] ?></strong> A/N <strong><?= $withdrawal['account_name'] ?></strong></small>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Penarikan</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['total'] + $withdrawal['fee'], 0, ",", "."); ?></p>
                        <?php if($withdrawal['fee'] > 0) : ?>
                        <span class="css-c1gsx8">Biaya Admin</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['fee'], 0, ",", "."); ?></p>
                        <span class="css-c1gsx8">Total Diterima</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['total'], 0, ",", "."); ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Catatan</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?php if(empty($withdrawal['note'])) : echo '-'; else : echo $withdrawal['note']; endif ?></p>
                    </div>

                    <?php else : ?>
                    <div class="col-12" style="padding: 14px 30px;">
                        <span class="css-c1gsx8">Status Penarikan</span>
                        <p class="text-danger font-weight-bold" style="margin-top: -5px;">DITOLAK</p>
                    </div>
                    <div class="col-12 mx-0" style="margin-top: -8px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Rincian Penarikan</span>
                    </div>

                    <div class="col-12 mt-3 py-0" style="padding: 0 30px;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <span class="css-c1gsx8 text-center">Tanggal Penarikan</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= $date ?></p>
                            </div>
                            <div class="col-6">
                                <span class="css-c1gsx8 text-center">No.Invoice</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;">#<?= $withdrawal['id'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Bank Tujuan</span>
                        <img src="<?= base_url() ?>home/img/bank/<?= $bank_icon ?>" class="my-2" width="55" alt="">
                        <br>
                        <small><strong><?= $bank_name ?></strong></small>
                        <br>
                        <small><strong><?= $withdrawal['bank_account'] ?></strong> A/N <strong><?= $withdrawal['account_name'] ?></strong></small>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Penarikan</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px; text-green"><?= $curr . " " .number_format($withdrawal['total'] + $withdrawal['fee'], 0, ",", "."); ?></p>
                        <?php if($withdrawal['fee'] > 0) : ?>
                        <span class="css-c1gsx8">Biaya Admin</span>
                        <p class="text-danger font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['fee'], 0, ",", "."); ?></p>
                        <span class="css-c1gsx8">Total Diterima</span>
                        <p class="text-danger font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " " .number_format($withdrawal['total'], 0, ",", "."); ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Catatan</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?php if(empty($withdrawal['note'])) : echo '-'; else : echo $withdrawal['note']; endif ?></p>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>