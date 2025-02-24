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
            <div class="box-white bg-white py-3 shadow">
                <div class="row">
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Status Transaksi</span>
                        <?php if($GetTransaction[0]['status'] == "Completed") : ?>
                            <p class="text-success font-weight-bold" style="margin-top: -5px;">BERHASIL</p>
                        <?php elseif($GetTransaction[0]['status'] == "Processing" || $GetTransaction[0]['status'] == "Pending") : ?>
                            <p class="text-warning font-weight-bold" style="margin-top: -5px;"><?= $GetTransaction[0]['status'] ?></p>
                        <?php else : ?>
                            <p class="text-danger font-weight-bold" style="margin-top: -5px;"><?= $GetTransaction[0]['status'] ?></p>
                        <?php endif ?>
                        
                    </div>
                    <div class="col-12 mx-0" style="margin-top: -3px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Rincian Pesanan</span>
                    </div>
                    <div class="col-12 mt-3" style="padding: 0 30px;">
                        <b>Produk <?= $GetTransaction[0]['product'] ?></b>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12 py-0" style="padding: 0 30px;">
                        <div class="row">
                            <div class="col-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <span class="css-c1gsx8 text-center">Tanggal Pembelian</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= date('d M Y H:i', strtotime($GetTransaction[0]['created_at'])) ?></p>
                            </div>
                            <div class="col-6" >
                                <span class="css-c1gsx8 text-center">Order ID</span>
                                <p class="font-weight-bold text-center" style="margin-top: -5px; font-size: 11px;"><?= $GetTransaction[0]['id'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Metode Pembayaran</span>
                        <img src="<?= base_url() ?>home/img/<?= $logo ?>" width="70" alt="">
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Harga</span>
                        <p class="text-success font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " ".number_format($GetTransaction[0]['total'], 0, ",", "."); ?></p>
                    </div>
                    <div class="col-12 mx-0" style="margin-top: 3px;">
                        <span class="badge d-block mx-auto w-100 py-2 text-left" style="padding-left: 15px; background: rgba(0, 0, 0, .1); color: rgba(0, 0, 0, .5);  font-size: 14px;">Detail Pesanan</span>
                    </div>
                    <div class="col-12 mt-3" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Produk</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $GetTransaction[0]['product'] ?></p>
                    </div>
                    
                    <?php if($GetTransaction[0]['fee'] != 0) : ?>
                        <div class="col-12" style="margin-top: -10px;">
                            <hr>
                        </div>
                        <div class="col-12" style="padding: 0 30px;">
                            <span class="css-c1gsx8">Biaya Admin</span>
                            <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $curr . " ".number_format($GetTransaction[0]['fee'], 0, ",", "."); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="col-12" style="margin-top: -10px;">
                        <hr>
                    </div>
                    <div class="col-12" style="padding: 0 30px; margin-bottom: -10px;">
                        <span class="css-c1gsx8">Nomor HP</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px;"><?= $GetTransaction[0]['phone'] ?></p>
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

            $("div.box-product").removeClass('active');
            $(this).addClass('active');
            $("#idProduct").val($id);
            $("#NextPage").removeClass('d-none');
            $("#ShowPrice").html($Price);

            $("#ProductPrice").html($Price);
            $("#ProductName").html($ProductName);

            $("#TotalPrice").html($Price);
        });
    })
</script>
<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>