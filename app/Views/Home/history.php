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
            width: 20px;
            height: 20px;
            position: relative; 
            top: -17px; 
            right: -12px; 
            padding: 0 !important;
            padding-top: 3px !important;
            float: right;
            font-size: 14px !important; 
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
            margin: 5px auto;
            width: 100%;
            text-align: center;
            padding: 5px;
            border: 1px solid rgb(236, 236, 236);
            border-radius: 7px;
            font-size: 12px;
            font-family: Arial;
        }

        .selectNominal a {
            text-decoration: none;
        }

        .active {
            border: 1px solid #00AA5B !important;
        }

        a.btn {
            font-size: 12px;
            box-shadow: 0 0 0 transparent;
            border-radius: 9px;
        }

        a.btn-active {
            border: 1px solid #00AA5B !important;
            background: #00AA5B !important;
            color: #fff !important;
            box-shadow: 0 0 0 transparent !important;
        }

        .description {
            position: relative;
            top: 12px;
        }

        .description b {
            font-size: 15px;
        }

        .description img {
            font-size: 14px;
            position: relative;
            top: -4px;
        }

        a.selectNominal:hover {
            color: #000 !important;
        }
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>

<div class="container">
    <div class="row">
        <div class="col-12" id="PhoneOrder">
            <div class="box-white bg-white shadow">
                <div class="row mb-3 px-3 mt-2">
                    <div class="col-6 mt-2">
                        <a class="btn d-block border mx-auto btn-active" href="javascript:void(0);" id="Transaction">Riwayat Order</a>
                    </div>
                    <div class="col-6 mt-2">
                        <a class="btn d-block border mx-auto" href="javascript:void(0);" id="Deposit">Riwayat Deposit</a>
                    </div>
                </div>

                <div class="row px-3 mt-3 mb-3">
                    <div class="col-12" id="ShowTransaction">
                        <?php foreach($Transactions as $key => $t) : ?>
                            <a href="<?= base_url() ?>order/detail/<?= $t['id'] ?>" class="selectNominal shadow-sm px-3 pb-3 text-left">
                            
                            <img src="<?= base_url() ?>home/img/product/<?= $t['category']['icon'] ?>" class="d-inline-block ml-0" width="43" alt="" style="border-radius: 48px;">
                            <div class="description d-inline-block ml-2">
                                <b><?= $t['product']['name'] ?></b>
                                <p><?= date('d M Y H:i', strtotime($t['date'])); ?></p>
                            </div>
                            <div class="description float-right mr-2">
                                <!-- <small class="badge badge-success font-weight-bold badge-check rounded"><i class="zmdi zmdi-check"></i></small> -->
                            </div>
                        </a>
                        <?php endforeach ?>
                        
                    </div>
                    <div class="col-12 d-none" id="ShowDeposit">
                        <?php foreach($Deposits as $key => $d) : ?>
                            <a href="<?= base_url() ?>deposit/detail/<?= $d['id'] ?>" class="selectNominal shadow-sm px-3 pb-3 text-left">
                            
                            <img src="<?= base_url() ?>home/img/bank/<?= $d['icon'] ?>" class="d-inline-block ml-0" width="43" alt="">
                            <div class="description d-inline-block ml-3">
                                <b>Deposit <?= $curr . " " .number_format($d['total'], 0, ",", "."); ?></b>
                                <p><?= date('d M Y H:i', strtotime($d['date'])); ?></p>
                            </div>
                            <div class="description float-right mr-2">
                                <!-- <small class="badge badge-success font-weight-bold badge-check rounded"><i class="zmdi zmdi-check"></i></small> -->
                            </div>
                        </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<script>
    $(function() {
        $("#Transaction").on('click', function() {
            $(this).addClass('btn-active');
            $("#Deposit").removeClass('btn-active');
            $("#ShowTransaction").removeClass('d-none');
            $("#ShowDeposit").addClass('d-none');
        });

        $("#Deposit").on('click', function() {
            $(this).addClass('btn-active');
            $("#Transaction").removeClass('btn-active');
            $("#ShowDeposit").removeClass('d-none');
            $("#ShowTransaction").addClass('d-none');
        });

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

        $("#NextBTN").on('click', function() {
            $orde<?= $curr ?>hone = $("#phone").val();

            $("#phone").attr('disabled', true);
            $("#Loading").removeClass('d-none');

            setTimeout(() => {
                $("#PhoneOrder").addClass('d-none');
                $("#ListProduct").addClass('d-none');
                $("#SetTitle").html('Pembelian');
                $("#NextPage").addClass('d-none');
                $("#Loading").addClass('d-none');

                $("#BoxDetail").addClass('active');
                $("#DetailOrder").removeClass('d-none');
                $("#PhoneNumberDetail").html($orde<?= $curr ?>hone);
            }, 1200);
        });
        $("#phone").on('input', function() {
            $phone = $("#phone").val(),
            intRegex = /^(?:\+62|62|0)[2-9]\d{7,11}$/;

            if($phone.length >= 11) {
                if(intRegex.test($phone)) {
                    $("#orde<?= $curr ?>hone").val($phone);
                    $("#Er<?= $curr ?>hone").addClass('d-none');
                    $("#ListProduct").removeClass('d-none');
                } else {
                    $("#orde<?= $curr ?>hone").val('');
                    $("#Er<?= $curr ?>hone").removeClass('d-none');
                    $("#ListProduct").addClass('d-none');
                    $("#NextPage").addClass('d-none');
                }
            } else {
                $("#orde<?= $curr ?>hone").val('');
                $("#ListProduct").addClass('d-none');
                $("#NextPage").addClass('d-none');
            }
        }); 

        $("div#chooseProduct").on('click', function() {
            $id = $(this).attr('data-id');
            $Price = $(this).find('.prices').html();
            $ProductName = $(this).find('.product-name').html();
            $TotalPrice  = $(this).attr('data-total');

            $("div.box-product").removeClass('active');
            $(this).addClass('active');
            $("#idProduct").val($id);
            $("#NextPage").removeClass('d-none');
            $("#ShowPrice").html($Price);

            $("#ProductPrice").html($Price);
            $("#ProductName").html($ProductName);

            $("#TotalPrice").html($TotalPrice);
        });
    })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>