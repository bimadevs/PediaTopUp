<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="<?= $title ?>" />
    <meta name="description" content="<?= isset($description) ? $description : $title ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:description" content="<?= isset($description) ? $description : $title ?>" />
    <meta property="og:image" content="https://pediatopup.com/home/img/banner/1740544512_2b060ccc6c01a96dd822.jpg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url() ?>home/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>home/css/loading.css">
    <link rel="shorcut icon" href="<?= base_url() ?>home/img/<?= $web['icon'] ?>">
    <?php $this->renderSection('css'); ?>
    <title><?= $title . " - " . $uri_segment ?></title>
    <style>
        @media only screen and (max-width: 360px) {
            .css-1nkfy0p-unf-btn {
                font-family: 'Tokopedia-Reguler' !important;
                font-size: 10px !important;
            }
        }
    </style>
  </head>
  <body>
  <div id="Loading" class="d-none">
    <div class="snippet" data-title="dot-elastic">
      <div class="stage">
        <div class="dot-elastic"></div>
        </div>
    </div>
  </div>
    <div class="container-fluid p-0">
      <div class="row no-gutters m-0 p-0">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 d-block mx-auto m-0 p-0">
          <div id="Waves">
            <?php if($uri_segment == "Home") : ?>
              <?php if(isset($_SESSION['phone'])) : ?>
              <nav class="navbar navbar-light bg-none pt-1 pb-1 p-0">
                  <a href="<?= base_url() ?>history" class="unf-navbar__back"><svg class="unf-icon" viewBox="0 0 24 24" width="24" height="24" fill="var(--color-icon-enabled, #fff)" data-testid="custom-icon" style="display: inline-block; vertical-align: middle;"><path d="M18 2.25H6A1.76 1.76 0 0 0 4.25 4v15.13A1.75 1.75 0 0 0 7 20.59l1-.67 1.28.95a1.23 1.23 0 0 0 1.5 0l1.22-.93 1.25.93c.216.164.48.252.75.25.27.003.535-.085.75-.25l1.25-.95 1 .67a1.75 1.75 0 0 0 2.72-1.46V4A1.76 1.76 0 0 0 18 2.25Zm.25 16.88a.23.23 0 0 1-.13.22.24.24 0 0 1-.26 0l-1.44-1a.75.75 0 0 0-.87 0L14 19.56l-1.55-1.16a.75.75 0 0 0-.9 0L10 19.56 8.45 18.4a.75.75 0 0 0-.87 0l-1.44 1a.24.24 0 0 1-.26 0 .23.23 0 0 1-.13-.22V4A.25.25 0 0 1 6 3.75h12a.25.25 0 0 1 .25.25v15.13Z"></path><path d="M15.5 6.25h-7a.75.75 0 0 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm0 4h-7a.75.75 0 1 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm-3.5 4H8.5a.75.75 0 1 0 0 1.5H12a.75.75 0 1 0 0-1.5Z"></path></svg></a>
                  <div class="unf-navbar__title css-bezv71 esgcme73"><div id=""><div class="css-1mgxejs-unf-searchbar"><div class="css-11op364"><svg class="unf-icon" viewBox="0 0 24 24" width="16" height="16" fill="var(--NN500, #8D96AA)" style="display: inline-block; vertical-align: middle;"><path d="m20.53 19.46-4.4-4.4a7.33 7.33 0 1 0-1.07 1.06l4.41 4.41a.77.77 0 0 0 1.06 0 .77.77 0 0 0 0-1.07Zm-15.78-9a5.75 5.75 0 1 1 5.75 5.75 5.76 5.76 0 0 1-5.75-5.72v-.03Z"></path></svg></div><input data-testid="search-bar" data-unify="SearchBar" class="unf-searchbar__input css-a4zqnd" type="search" block="true" placeholder="Cari E-Money, Kartu Kredit dan lainnya" value=""></div></div></div>
                  <a href="<?= base_url() ?>logout" class="css-4mt3kr">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"><path d="M4 12h8M5 9l-3 3 3 3m3-9.34A7.928 7.928 0 0 1 12.86 4c4.42 0 8 3.58 8 8s-3.58 8-8 8c-1.82 0-3.52-.62-4.86-1.66" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></a>
              </nav>
              <?php else : ?>
                <nav class="navbar navbar-light bg-none pt-1 pb-1 p-0">
                    <a href="<?= base_url() ?>history" class="unf-navbar__back"><svg class="unf-icon" viewBox="0 0 24 24" width="24" height="24" fill="var(--color-icon-enabled, #fff)" data-testid="custom-icon" style="display: inline-block; vertical-align: middle;"><path d="M18 2.25H6A1.76 1.76 0 0 0 4.25 4v15.13A1.75 1.75 0 0 0 7 20.59l1-.67 1.28.95a1.23 1.23 0 0 0 1.5 0l1.22-.93 1.25.93c.216.164.48.252.75.25.27.003.535-.085.75-.25l1.25-.95 1 .67a1.75 1.75 0 0 0 2.72-1.46V4A1.76 1.76 0 0 0 18 2.25Zm.25 16.88a.23.23 0 0 1-.13.22.24.24 0 0 1-.26 0l-1.44-1a.75.75 0 0 0-.87 0L14 19.56l-1.55-1.16a.75.75 0 0 0-.9 0L10 19.56 8.45 18.4a.75.75 0 0 0-.87 0l-1.44 1a.24.24 0 0 1-.26 0 .23.23 0 0 1-.13-.22V4A.25.25 0 0 1 6 3.75h12a.25.25 0 0 1 .25.25v15.13Z"></path><path d="M15.5 6.25h-7a.75.75 0 0 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm0 4h-7a.75.75 0 1 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm-3.5 4H8.5a.75.75 0 1 0 0 1.5H12a.75.75 0 1 0 0-1.5Z"></path></svg></a>
                    <div class="unf-navbar__title css-bezv71 esgcme73"><div id=""><div class="css-1mgxejs-unf-searchbar"><div class="css-11op364"><svg class="unf-icon" viewBox="0 0 24 24" width="16" height="16" fill="var(--NN500, #8D96AA)" style="display: inline-block; vertical-align: middle;"><path d="m20.53 19.46-4.4-4.4a7.33 7.33 0 1 0-1.07 1.06l4.41 4.41a.77.77 0 0 0 1.06 0 .77.77 0 0 0 0-1.07Zm-15.78-9a5.75 5.75 0 1 1 5.75 5.75 5.76 5.76 0 0 1-5.75-5.72v-.03Z"></path></svg></div><input data-testid="search-bar" data-unify="SearchBar" class="unf-searchbar__input css-a4zqnd" type="search" block="true" placeholder="Cari E-Money, Kartu Kredit dan lainnya" value=""></div></div></div>
                    <a href="<?= base_url() ?>login" class="css-4mt3kr"><svg xmlns="http://www.w3.org/2000/svg" class="unf-icon" version="1.0" viewBox="0 0 48 48" width="25" height="25"><path fill="#FFF" d="M19.1 4.4c-4.6 2.5-6.2 8.1-3.9 13.1 1.1 2.4.9 2.9-2 5.2-5.9 4.5-9.3 14.8-6 18.1 1.7 1.7 31.9 1.7 33.6 0 3-3 .3-12.6-5.1-17.4-3.5-3.2-3.8-3.8-2.8-6 4-9-5.3-17.7-13.8-13M28 9c2.5 2.5 2.5 5.5 0 8s-5.5 2.5-8 0c-2.7-2.7-2.6-6.5.2-8.4 3-2.1 5.4-2 7.8.4m2.9 15.8c3.7 2 7.1 7.2 7.1 10.9 0 2.3-.1 2.3-14 2.3s-14 0-14-2.3c0-3.2 3.5-8.4 7.2-10.7 4.1-2.5 9.3-2.6 13.7-.2"/></svg></a>
                </nav>
              <?php endif ?>
              <div class="title">Beli <span style="color:#ffe500;">produk digital</span> di <?= $title ?></div>
              <div class="subtitle">Mulai dari pulsa, paket data, sampai bayar pajak</div>
            <?php else : ?>
              <div id="Waves">
                  <nav class="navbar navbar-light bg-none pt-1 pb-1 p-0">
                      <a href="/" class="unf-navbar__back" aria-label="kembali ke laman sebelumnya"><svg class="unf-icon" viewBox="0 0 24 24" width="24" height="24" fill="#FFFFFF" style="display: inline-block; vertical-align: middle;"><path d="M20 11.25H4.78l5.73-5.72a.77.77 0 0 0 0-1.07.75.75 0 0 0-1.06 0l-7.1 7.1a.77.77 0 0 0 0 1.07l7.1 7.1a.75.75 0 0 0 1.06 0 .77.77 0 0 0 0-1.07l-5.92-5.91H20a.75.75 0 1 0 0-1.5Z"></path></svg></a>
                      <center><div class="unf-navbar__title css-bezv71 esgcme73"><div id="SetTitle" class="title"><?= $HeaderTitle ?></div></div></center>
                      <?php if($uri_segment == "history") : ?>
                        <a href="javasciprt:void(0);" class="css-4mt3kr"><svg class="unf-icon" viewBox="0 0 24 24" width="24" height="24" fill="var(--color-icon-enabled, #fff)" data-testid="custom-icon" style="display: inline-block; vertical-align: middle;"><path d="M18 2.25H6A1.76 1.76 0 0 0 4.25 4v15.13A1.75 1.75 0 0 0 7 20.59l1-.67 1.28.95a1.23 1.23 0 0 0 1.5 0l1.22-.93 1.25.93c.216.164.48.252.75.25.27.003.535-.085.75-.25l1.25-.95 1 .67a1.75 1.75 0 0 0 2.72-1.46V4A1.76 1.76 0 0 0 18 2.25Zm.25 16.88a.23.23 0 0 1-.13.22.24.24 0 0 1-.26 0l-1.44-1a.75.75 0 0 0-.87 0L14 19.56l-1.55-1.16a.75.75 0 0 0-.9 0L10 19.56 8.45 18.4a.75.75 0 0 0-.87 0l-1.44 1a.24.24 0 0 1-.26 0 .23.23 0 0 1-.13-.22V4A.25.25 0 0 1 6 3.75h12a.25.25 0 0 1 .25.25v15.13Z"></path><path d="M15.5 6.25h-7a.75.75 0 0 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm0 4h-7a.75.75 0 1 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm-3.5 4H8.5a.75.75 0 1 0 0 1.5H12a.75.75 0 1 0 0-1.5Z"></path></svg></a>
                      <?php elseif($uri_segment == "login") : ?>
                        <a href="javascript:void(0);" class="css-4mt3kr">&emsp;</a>
                      <?php else : ?>
                        <a href="<?= base_url() ?>history" class="css-4mt3kr"><svg class="unf-icon" viewBox="0 0 24 24" width="24" height="24" fill="var(--color-icon-enabled, #fff)" data-testid="custom-icon" style="display: inline-block; vertical-align: middle;"><path d="M18 2.25H6A1.76 1.76 0 0 0 4.25 4v15.13A1.75 1.75 0 0 0 7 20.59l1-.67 1.28.95a1.23 1.23 0 0 0 1.5 0l1.22-.93 1.25.93c.216.164.48.252.75.25.27.003.535-.085.75-.25l1.25-.95 1 .67a1.75 1.75 0 0 0 2.72-1.46V4A1.76 1.76 0 0 0 18 2.25Zm.25 16.88a.23.23 0 0 1-.13.22.24.24 0 0 1-.26 0l-1.44-1a.75.75 0 0 0-.87 0L14 19.56l-1.55-1.16a.75.75 0 0 0-.9 0L10 19.56 8.45 18.4a.75.75 0 0 0-.87 0l-1.44 1a.24.24 0 0 1-.26 0 .23.23 0 0 1-.13-.22V4A.25.25 0 0 1 6 3.75h12a.25.25 0 0 1 .25.25v15.13Z"></path><path d="M15.5 6.25h-7a.75.75 0 0 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm0 4h-7a.75.75 0 1 0 0 1.5h7a.75.75 0 1 0 0-1.5Zm-3.5 4H8.5a.75.75 0 1 0 0 1.5H12a.75.75 0 1 0 0-1.5Z"></path></svg></a>
                      <?php endif ?>
                      
                  </nav>
              </div>
            <?php endif ?>
            
        </div>

          <?php $this->renderSection('konten'); ?>
          
          <?php if($uri_segment == "Home") : ?>
            <div class="col-12 px-3">
              <img src="<?= base_url() ?>home/img/footer.png" class="img-fluid d-block mx-auto mt-5" style="max-width: 100%; height: auto;">
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>home/js/custom.js">
    <?php if (session('error')): ?>
      <script>
        Swal.fire({
          icon: "error",
          title: "Gagal!",
          text: "<?= session('error') ?>"
        });
      </script>
    <?php endif ?>
    <?php if (session('success')): ?>
      <script>
        Swal.fire({
          icon: "success",
          title: "Horee!!",
          text: "<?= session('success') ?>"
        });
      </script>
    <?php endif ?>
    <?php $this->renderSection('js'); ?>
  </body>
</html>