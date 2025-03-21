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
            border: none;
            border-radius: 48px;
            color: #fff;
            font-size: 12px;
            outline: none;
            padding: 10px 0;
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

        .btn-success {

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
                        <form action="/deposit" method="POST" id="FormDeposit">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" id="id" value="<?= $users['id'] ?>">
                            <input type="hidden" name="percent" id="percent" value="<?php if(str_replace("%", "", $bonus) != 0) : echo str_replace("%", "", $bonus); else : echo "0"; endif ?>">
                            <input type="hidden" name="total" id="total">
                            <div class="form-group mt-3 px-4">
                                <label for="bank" class="form-label">Bank Pilihan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-none border-none"><img id="bank_icon" src="<?= base_url() ?>home/img/bank/<?= $bank[0]['icon'] ?>" width="48" alt=""></span>
                                    <select class="form-control" name="bank" id="bank" required>
                                        <?php foreach($bank as $key => $b) : ?>
                                            <option value="<?= $b['id'] ?>" <?php if($key == 0) : ?> selected <?php endif ?> data-id="<?= $b['icon'] ?>"><?= $b['name'] ?> <?php if(str_replace("%", "", $bonus) != 0) : echo "(Bonus $bonus)"; endif ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-4 px-4">
                                <label for="nominal" class="form-label">Nominal Isi Saldo</label>
                                <input type="hidden" name="nominal" id="nominal" value="">
                                <input type="text" class="form-control" id="nominal_display" placeholder="Nominal Saldo" aria-label="nominal" aria-describedby="nominal" readonly>
                                <small class="text-danger d-none ml-1" style="font-size: 10.5px;" id="Err"></small>
                            </div>
                            <div class="form-group d-block mx-auto text-center">
                                <?php foreach($deposit_amount as $amount) : ?>
                                <div class="selectNominal">
                                   <span price="<?= $amount['amount'] ?>"><?= $curr ?> <?= number_format($amount['amount'], 0, ',', '.') ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if(str_replace("%", "", $bonus) != 0) : ?> 
                            <?php /* Kolom "Saldo yang didapat" dihapus
                            <div class="form-group mt-4 px-4">
                                <label for="totalRp" class="form-label">Saldo yang didapat</label>
                                <input type="tel" class="form-control" name="totalRp" id="totalRp" aria-label="totalRp" aria-describedby="nominal" required readonly value="<?= $curr ?> 0">
                                <small class="text-danger d-none ml-1" style="font-size: 10.5px;" id="Err"></small>
                            </div>
                            */ ?>
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
            Total Pembayaran<br>
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
        $("form#FormDeposit").on('submit', function() {
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

        $("div.selectNominal").on('click', function() {
            $Percent = $("input#percent").val();
            
            $("div.selectNominal").removeClass('active');
            $(this).addClass('active');

            $Nom = $(this).find('span').attr('price');
            
            // Format nominal dengan titik sebagai pemisah ribuan
            $FormattedNom = parseInt($Nom).toLocaleString('id-ID').replace(/,/g, ".");
            
            // Simpan nilai asli di input hidden untuk diproses
            $("input#nominal").val($Nom);
            // Tampilkan nilai yang diformat di input display
            $("input#nominal_display").val("<?= $curr ?> " + $FormattedNom);
            
            $TotalSaldo = parseInt($Nom) + ((parseInt($Nom) / 100) * $Percent);
            
            $("input#total").val($TotalSaldo);
        })
    })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>