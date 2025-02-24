<?php $this->extend('template'); ?>
<?php $this->section('css'); ?>
    <style>
        #Waves {
            background: url('<?= base_url() ?>home/img/waves.png') no-repeat;
            background-size: 100%;
        }
    </style>
<?php $this->endSection(); ?>
<?php $this->section('konten'); ?>


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php foreach($slide as $key => $banner) : ?>
      <div class="carousel-item <?php if($key == 0) : ?>active<?php endif ?>"> 
        <img src="<?= base_url() ?>home/img/banner/<?= $banner ?>" class="d-block css-1tuci21">
      </div>
      <?php endforeach ?>
  </div>
</div>
<div class="mt-5" data-testid="3_BUTTONS_MYBILLS_ENTRYPOINT">
  <div class="css-1wb57sx">
    <div class="child">
    <div style="width:100%">
      <section class="unf-card css-1cvys1z e1oraaho0" data-unify="Card" data-impression="{&quot;event&quot;:&quot;promoClick&quot;,&quot;eventCategory&quot;:&quot;digital - subhomepage&quot;,&quot;eventAction&quot;:&quot;click&quot;,&quot;eventLabel&quot;:&quot;3 buttons mybills entrypoint - 2 - 3203 - loyal 2&quot;,&quot;screenName&quot;:&quot;/top-up-tagihan&quot;,&quot;currentSite&quot;:&quot;tokopediadigitalRecharge&quot;,&quot;businessUnit&quot;:&quot;recharge&quot;,&quot;userId&quot;:&quot;87991611&quot;,&quot;ecommerce&quot;:{&quot;promoClick&quot;:{&quot;promotions&quot;:[{&quot;id&quot;:&quot;&quot;,&quot;name&quot;:&quot;&quot;,&quot;creative&quot;:&quot;kelola tagihan entrypoint widget&quot;}]}}}">
        <div class="left">
            <div class="css-bqlp8e intrinsic" style="margin-top: -50px;">
                <span class="css-1w3vjqw intrinsic">
                    <img class="css-io8lqb" alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 version=%271.1%27 width=%2740%27 height=%2740%27/%3e">
                </span>
                <img class="css-1c345mg" decoding="async" src="<?= base_url() ?>home/img/saldo.png" alt="" style="object-fit:contain" crossorigin="anonymous">
            </div>
            <div class="content" style="margin-left: -10px;">
                <p data-unify="Typography" color="" class="title css-5nvfdl-unf-heading e12ykf338"><?= $curr . " " ?> <?php if(isset($_SESSION['phone'])) : echo number_format($users['balance'], 0, ",", "."); else : ?> 0 <?php endif ?></p>
                <p data-unify="Typography" color="" class="subtitle css-5nvfdl-unf-heading e12ykf338">Saldo <?= $title ?></p>
            </div>
        </div>
        <div class="right">
            <button onclick="location.href='/deposit';" data-unify="Button" type="button" class="css-1nkfy0p-unf-btn eg8apji0"><span>Tambah Kredit</span></button>
        </div>
      </section>
    </div>
  </div>
</div>
<div data-testid=DYNAMIC_ICONS><div class=css-1opgw9><p class="css-gaf89t-unf-heading e12ykf338"color="var(--NN950, #212121)"data-unify=Typography>Isi Ulang</p><?php foreach($category as $catkeys => $cat) : ?><a class=product href="<?= base_url() . "buy/" . $cat['slug'] ?>"><div class="intrinsic css-bqlp8e"><span class="intrinsic css-1w3vjqw"><img alt=""class="icon css-io8lqb"src="data:image/svg+xml,%3csvg
  xmlns=%27http://www.w3.org/2000/svg%27 version=%271.1%27 width=%2732%27 height=%2732%27/%3e"aria-hidden=true> </span><img alt="Air PDAM"class="icon css-1c345mg"src="<?= base_url() ?>/home/img/product/<?= $cat['img'] ?>"crossorigin=anonymous decoding=async></div><div class=icon_name><?= $cat['name']?></div></a><?php endforeach ?></div></div>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php foreach($slide as $key => $banner) : ?>
      <div class="carousel-item <?php if($key == 0) : ?>active<?php endif ?>"> 
        <img src="<?= base_url() ?>home/img/banner/<?= $banner ?>" class="d-block css-1tuci21">
      </div>
      <?php endforeach ?>
  </div>
</div>
  <?php $this->endSection(); ?>


<?php $this->section('js'); ?>

<?php $this->endSection(); ?>
<?php $this->extend('template'); ?>