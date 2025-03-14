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
            padding: 5px 10px;
            font-size: 13px;
            color: rgb(0, 218, 116);
            text-align: center;
            margin-top: 10px;
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

        input.form-control {
            height: 50px;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 18px 13px !important;
            outline: none;
        }

        input.form-control:focus {
            border: 1px solid #ced4da;
            box-shadow: 0 0 0 transparent;
        }

        input.form-control[readonly] {
            background-color: transparent !important;
            opacity: 1;
        }

        .text-success {
            color: #00AA5B !important;
        }

        .prices {
            font-size: 18px;
            color: #00AA5B;
        }

        .shadow-top {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Tambahkan styling untuk input-group-text */
        .input-group-text {
            background: none;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }
        
        select.form-control {
            height: 50px;
            border-radius: 12px;
            outline: none;
            border-left: 0;
            padding-left: 0;
        }
        
        select.form-control:focus {
            border: 1px solid #ced4da;
            border-left: 0;
            box-shadow: 0 0 0 transparent;
        }
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>

<div class="container">
    <div class="row">
        <div class="col-12" id="PhoneOrder">
            <div class="box-white bg-white shadow">
                <div class="row">

                    <div class="col-12 mt-2">
                        <form action="/withdrawal" method="POST" id="FormWithdrawal">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" id="id" value="<?= $users['id'] ?>">
                            <input type="hidden" name="fee" id="fee" value="<?= $fee ?>">
                            <input type="hidden" name="total" id="total">
                            <div class="form-group mt-3 px-4">
                                <label for="bank" class="form-label">Bank Tujuan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-none border-none"><img id="bank_icon" src="<?= base_url() ?>home/img/bank/<?= $bank[0]['icon'] ?>" width="48" alt=""></span>
                                    <select class="form-control" name="bank" id="bank" required>
                                        <?php foreach($bank as $key => $b) : ?>
                                            <option value="<?= $b['id'] ?>" <?php if($key == 0) : ?> selected <?php endif ?> data-id="<?= $b['icon'] ?>"><?= $b['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-4 px-4">
                                <label for="bank_account" class="form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" name="bank_account" id="bank_account" placeholder="Nomor Rekening" required>
                            </div>
                            <div class="form-group mt-4 px-4">
                                <label for="account_name" class="form-label">Nama Pemilik Rekening</label>
                                <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Nama Pemilik Rekening" required>
                            </div>
                            <div class="form-group mt-4 px-4">
                                <label for="nominal" class="form-label">Nominal Penarikan</label>
                                <input type="hidden" name="nominal" id="nominal" value="">
                                <input type="text" class="form-control" id="nominal_display" placeholder="Nominal Penarikan" aria-label="nominal" aria-describedby="nominal" readonly>
                                <small class="text-danger d-none ml-1" style="font-size: 10.5px;" id="Err"></small>
                            </div>
                            <div class="form-group d-block mx-auto text-center">
                                <?php foreach($withdrawal_amount as $amount) : ?>
                                <div class="selectNominal">
                                   <span price="<?= $amount['amount'] ?>"><?= $curr ?> <?= number_format($amount['amount'], 0, ',', '.') ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if($fee > 0) : ?> 
                            <div class="form-group mt-4 px-4">
                                <label for="totalRp" class="form-label">Total yang akan diterima</label>
                                <input type="tel" class="form-control" name="totalRp" id="totalRp" aria-label="totalRp" aria-describedby="nominal" required readonly value="<?= $curr ?> 0">
                                <small class="text-danger d-none ml-1" style="font-size: 10.5px;" id="Err"></small>
                            </div>
                            <div class="form-group mt-4 px-4">
                                <label for="feeRp" class="form-label">Biaya Admin</label>
                                <input type="tel" class="form-control" name="feeRp" id="feeRp" aria-label="feeRp" aria-describedby="nominal" required readonly value="<?= $curr ?> 0">
                                <small class="text-danger d-none ml-1" style="font-size: 10.5px;" id="Err"></small>
                            </div>
                            <?php endif ?>
                            <div class="form-group px-4">
                                <button class="btn btn-success d-block mx-auto w-100" type="submit">Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fixed-bottom d-none p-3 px-4 mx-auto bg-white shadow-top" id="NextPage">
    <div class="row">
        <div class="col-7">
            Total Penarikan<br>
            <span class="prices mt-1 font-weight-bold" id="ShowPrice"></span>   
        </div>
        <div class="col-5 float-right text-right pt-2">
            <button type="button" class="btn btn-success d-block w-100 mx-auto float-right" id="NextBTN">Lanjut</button>
        </div>
    </div>      
</div>

<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<script>
    $(function() {
        $("form#FormWithdrawal").on('submit', function() {
            $bank    = $("select#bank").val();
            $Nominal = $("input#nominal").val();
            
            if($Nominal == "" || $Nominal == "0") {
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
        
        $(".selectNominal").on('click', function() {
            $(".selectNominal").removeClass('active');
            $(this).addClass('active');
            
            $Price = $(this).find('span').attr('price');
            $Fee = $("#fee").val();
            
            if (parseInt($Price) > <?= $users['balance'] ?>) {
                $("#Err").removeClass('d-none');
                $("#Err").html('Saldo kamu tidak cukup');
                $("#nominal").val('');
                $("#nominal_display").val('');
                $("#totalRp").val('<?= $curr ?> 0');
                $("#feeRp").val('<?= $curr ?> 0');
                return false;
            }
            
            $("#Err").addClass('d-none');
            $("#nominal").val($Price);
            $("#nominal_display").val('<?= $curr ?> ' + new Intl.NumberFormat('id-ID').format($Price));
            
            if ($Fee > 0) {
                $FeeAmount = ($Price * $Fee) / 100;
                $Total = $Price - $FeeAmount;
                
                $("#feeRp").val('<?= $curr ?> ' + new Intl.NumberFormat('id-ID').format($FeeAmount));
                $("#totalRp").val('<?= $curr ?> ' + new Intl.NumberFormat('id-ID').format($Total));
                $("#total").val($Total);
            } else {
                $("#feeRp").val('<?= $curr ?> 0');
                $("#totalRp").val('<?= $curr ?> ' + new Intl.NumberFormat('id-ID').format($Price));
                $("#total").val($Price);
            }
        });
    });
</script>
<?php $this->endSection(); ?> 