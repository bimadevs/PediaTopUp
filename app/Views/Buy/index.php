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
            border-radius: 8px;
            color: #fff;
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
        
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>

<div class="container">
    <div class="row">
        <div class="col-12" id="PhoneOrder">
            <div class="box-white bg-white p-3 pb-4 shadow">
                <div class="row">
                    <div class="col-1 col-sm-1">
                        <img class="slug-icon" src="<?= base_url() ?>/home/img/product/<?= $icon_slug ?>" width="40" alt="">
                    </div>
                    <div class="col ml-4">
                        <label class="buy-label" for="">Masukkan Nomor HP</label>
                        <input type="tel" name="phone" id="phone" class="form-control d-block buy-form-control" placeholder="082134567890" autocomplete="off" required>
                        <small class="text-danger d-none" id="ErrPhone" style="font-size: 10px;">Masukkan nomor yang valid!</small>
                    </div>
                    <div class="col-12 mt-4 d-none">
                        <div id="vertical-scroll">
                            <label class="buy-history text-center mr-2 py-1">081287128812</label>
                            <label class="buy-history text-center mr-2 py-1">08971267242</label>
                            <label class="buy-history text-center mr-2 py-1">081287128812</label>
                            <label class="buy-history text-center mr-2 py-1">081287128812</label>
                            <label class="buy-history text-center mr-2 py-1">081287128812</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none" id="DetailOrder">
            <div class="box-white bg-white px-3 py-0 pb-2 shadow">
                <div class="row">
                    <div class="col-1 col-sm-1">
                        <img class="slug-icon" id="ProducTImage" src="<?= base_url() ?>/home/img/product/<?= $icon_slug ?>" width="39" alt="">
                    </div>
                    <div class="col ml-4 mt-3 pt-1">
                        <h6><?= strtoupper($slug) ?> - <span id="PhoneNumberDetail"></span></h6>
                    </div>
                    <div class="col-12 mt-4 d-block mx-auto text-left">
                        <h5>Detail Pesanan</h5>

                        <div class="row mt-3">
                            <div class="col-12">
                                <span class="css-c1gsx8">Nama Produk</span>
                                <h6 id="ProductName"></h6>
                            </div>
                            <div class="col-12 mt-2">
                                <span class="css-c1gsx8">Harga Produk</span>
                                <h6 id="ProductPrice">-</h6>
                            </div>
                            <?php if($fee != 0) : ?>
                            <div class="col-12 mt-2">
                                <span class="css-c1gsx8">Biaya Admin</span>
                                <h6 id="ProductPrice"><?= $curr . " ".number_format($fee, 0, ",", "."); ?></h6>
                            </div>
                            <?php endif; ?>
                            <div class="col-12 mt-2">
                                <span class="css-c1gsx8">Voucher/Promo</span>
                                <h6 id="isVoucher">-</h6>
                            </div>
                            <div class="col-12 mt-2">
                                <span class="css-c1gsx8">Total Harga</span>
                                <h6 id="TotalPrice">-</h6>
                            </div>
                        </div>

                        <h5 class="mt-3 mb-4">Metode Pembayaran</h5>

                        <div class="box-product bg-white px-3 py-3 my-3 shadow rounded active" id="BoxDetail" style=" border-radius: 7px !important;">
                            <div class="form-check">
                                <small class="badge badge-success font-weight-bold badge-check"><i class="zmdi zmdi-check"></i></small>
                                <!-- <input class="form-check-input" type="radio" name="metodePembayaran" id="metodePembayaran" value="saldo" checked> -->
                                <label class="form-check-label" for="metodePembayaran" style="margin-left: -15px;">
                                    Saldo PediaTopup
                                    <span class="d-block text-success font-weight-bold" id="Saldo"><?= $curr . " " ?> <?php if(isset($_SESSION['phone'])) : echo number_format($users['balance'], 0, ",", "."); else : ?> 0 <?php endif ?></span>
                                </label>
                                <img src="<?= base_url() ?>home/img/<?= $logo ?>" width="70" alt="" style="position: absolute; float: right; right: -5px; top: 5px;">
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
            <form action="/buy" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="idUser" id="idUser" value="<?= $users['id'] ?>">
                <input type="hidden" name="orderPhone" id="orderPhone">
                <input type="hidden" name="idProduct" id="idProduct">

                <button class="btn btn-success d-block mx-auto py-2 w-100" type="submit" style="margin-top: -100px; font-size: 16px;">Lanjutkan Pembayaran</button>
            </form>
        </div>

        <div class="col-12 d-none mt-2" id="ListProduct">
            <div class="row">
                <?php foreach($product as $key => $p) : ?>
                    <div class="col-6 mt-3">
                        <?php if($p['stock'] == 0) : ?>
                            <div class="box-white box-product p-3 shadow-sm disabled" disabled>
                                <span class="product-name"><?= strtoupper($p['slug']) . " " . number_format($p['price'], 0, ",", ".") ?></span>
                                <span class="prices mt-1"><?= $curr . " ".number_format($p['price'], 0, ",", "."); ?></span>
                                <small class="badge badge-danger" style="position: absolute; bottom: 0px; right: 0;">Stok Habis</small>
                            </div>
                        <?php else : ?>
                            <div class="box-white box-product p-3 shadow-sm" id="chooseProduct" data-id="<?= $p['id'] ?>" data-total="<?= $curr . " ".number_format($p['price']+$fee, 0, ",", "."); ?>">
                                <span class="product-name"><?= strtoupper($p['slug']) . " " . number_format($p['price'], 0, ",", ".") ?></span>
                                <span class="prices mt-1"><?= $curr . " ".number_format($p['price'], 0, ",", "."); ?></span>
                            </div>
                        <?php endif ?>
                        
                    </div>
                <?php endforeach ?>
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
        $("#NextBTN").on('click', function() {
            $orderPhone = $("#phone").val();

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
                $("#PhoneNumberDetail").html($orderPhone);
            }, 1200);
        });
        $("#phone").on('input', function() {
            $phone = $("#phone").val(),
            intRegex = /^(?:\+62|62|0)[2-9]\d{7,11}$/;

            if($phone.length >= 11) {
                if(intRegex.test($phone)) {
                    $("#orderPhone").val($phone);
                    $("#ErrPhone").addClass('d-none');
                    $("#ListProduct").removeClass('d-none');
                } else {
                    $("#orderPhone").val('');
                    $("#ErrPhone").removeClass('d-none');
                    $("#ListProduct").addClass('d-none');
                    $("#NextPage").addClass('d-none');
                }
            } else {
                $("#orderPhone").val('');
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