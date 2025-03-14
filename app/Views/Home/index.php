<?php $this->extend('template'); ?>
<?php $this->section('css'); ?>
    <style>
        #Waves {
            background: url('<?= base_url() ?>home/img/waves.png') no-repeat;
            background-size: 100%;
        } 
        
        .cs-wa {
            width: 100%;
            margin-bottom: 0px;
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 9999;
        }

        .cs-wa img {
            width: 80px; 
            height: auto;     
        }      
        
        .notifyy {
            font-family: 'Poppins', sans-serif;
            background-color: var(--GN500, #00AA5B); 
            width: 100%;
            display: block;
            margin: auto; 
            margin-top: -35px;
            font-size: 15px;
            color: #fff;
            padding: 13px 0px 6px 0px;
            position: relative;
            z-index: 1;
        }

        .unf-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 15px;
            padding: 12px;
            position: relative;
            z-index: 2;
        }

        .saldo-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .saldo-info {
            display: flex;
            align-items: center;
        }

        .saldo-icon {
            width: 40px;
            height: 40px;
            margin-right: 12px;
        }

        .saldo-icon img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .saldo-content {
            flex: 1;
        }

        .saldo-amount {
            font-size: 1rem;
            font-weight: 600;
            color: #2E2E2E;
            margin: 0;
            line-height: 1.2;
        }

        .saldo-label {
            font-size: 0.8rem;
            color: #757575;
            margin: 2px 0 0 0;
        }

        .button-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-top: 3px;
        }

        .action-button {
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .withdraw-btn {
            background-color: #FF5722;
            color: white;
        }

        .deposit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .action-button:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .action-button i {
            font-size: 1rem;
        }

        @media (max-width: 360px) {
            .unf-card {
                margin: 10px;
                padding: 12px;
            }

            .saldo-amount {
                font-size: 1.2rem;
            }

            .saldo-label {
                font-size: 0.8rem;
            }

            .action-button {
                font-size: 0.8rem;
                padding: 10px;
            }

            .action-button i {
                font-size: 0.9rem;
            }

            .saldo-icon {
                width: 40px;
                height: 40px;
                margin-right: 12px;
            }
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 5px;
            padding: 5px;
            justify-content: center;
            margin: 0 auto;
            max-width: 100%;
        }

        .product-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .product-item:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .product-icon {
            width: 30px;
            height: 30px;
            margin-bottom: 8px;
            object-fit: contain;
        }

        .product-name {
            font-size: 12px;
            color: #2E2E2E;
            text-align: center;
            margin: 0;
            font-family: 'Tokopedia-Reguler';
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .product-icon {
                width: 30px;
                height: 30px;
            }

            .product-name {
                font-size: 11px;
            }
        }

        @media (max-width: 360px) {
            .product-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .product-icon {
                width: 30px;
                height: 30px;
            }

            .product-name {
                font-size: 10px;
            }
        }
    </style>
<?php $this->endSection(); ?>

<?php $this->section('konten'); ?>
<div class="notifyy mb-5">
    <marquee>
    <?php $last_key = count($notify); ?>
    <?php foreach($notify as $key => $n) {
        $matches = array();
        preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{9}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $n['notify'], $matches);
        $matches = $matches[0];
        $NoHP = substr($matches[0], 0, 4) . "****" . substr($matches[0], 8, 4);
        echo "<b><i>" . str_replace($matches[0], $NoHP, $n['notify']) . "</i></b>" . ($key + 1 === $last_key ? "" : " | ");
    } ?>
    </marquee>
</div>

<?php if(isset($_SESSION['phone'])) : ?>
    <h5 style='position: relative; top: -30px;' class='d-block mx-auto px-3'>Halo, <?= $users['name'] ?></h5>
<?php endif ?>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php foreach($slide as $key => $banner) : ?>
            <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>"> 
                <img src="<?= base_url() ?>home/img/banner/<?= $banner ?>" class="d-block css-1tuci21">
            </div>
        <?php endforeach ?>
    </div>
</div>

<div class="mt-5" style="position: relative; z-index: 1;">
    <section class="unf-card">
        <div class="saldo-container">
            <div class="saldo-info">
                <div class="saldo-icon">
                    <img src="<?= base_url() ?>home/img/saldo.png" alt="Saldo Icon">
                </div>
                <div class="saldo-content">
                    <div class="saldo-amount"><?= $curr ?> <?= isset($_SESSION['phone']) ? number_format($users['balance'], 0, ",", ".") : '0' ?></div>
                    <div class="saldo-label">Saldo <?= $title ?></div>
                </div>
            </div>
            <div class="button-container">
                <button onclick="location.href='/withdrawal';" class="action-button withdraw-btn">
                    <i class="fas fa-wallet"></i>
                    <span>Tarik Saldo</span>
                </button>
                <button onclick="location.href='/deposit';" class="action-button deposit-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Kredit</span>
                </button>
            </div>
        </div>
    </section>
</div>

<a href="https://api.whatsapp.com/send?phone=62<?= $whatsapp ?>" target="_blank" class="cs-wa">
    <img src="<?= base_url() ?>/home/img/cuswa.png" class="float-right" alt="Customer Support" />
</a>

<div data-testid="DYNAMIC_ICONS" class="mt-3">
    <div class="px-3">
        <p class="mb-2" style="font-size: 14px; font-weight: 600; color: #2E2E2E;">Isi Ulang</p>
        <div class="product-grid">
            <?php foreach($category as $cat) : ?>
                <a href="<?= base_url() . "buy/" . $cat['slug'] ?>" class="product-item">
                    <img src="<?= base_url() ?>/home/img/product/<?= $cat['img'] ?>" alt="<?= $cat['name'] ?>" class="product-icon">
                    <p class="product-name"><?= $cat['name'] ?></p>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div id="carouselExampleIndicators2" class="carousel slide mt-3" data-ride="carousel">
    <div class="carousel-inner">
        <?php foreach($slide2 as $key2 => $banner2) : ?>
            <div class="carousel-item <?= $key2 == 0 ? 'active' : '' ?>"> 
                <img src="<?= base_url() ?>home/img/banner/<?= $banner2 ?>" class="d-block css-1tuci21">
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>