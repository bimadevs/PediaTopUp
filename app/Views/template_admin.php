<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $web_name ?> - <?= $title ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    
    <!-- jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <?php $this->renderSection('css'); ?>
    
    <!-- End layout styles -->
    <link rel="shorcut icon" href="<?= base_url() ?>home/img/<?= $icon ?>">
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="<?= base_url() ?>admin"><img src="<?= base_url() ?>home/img/<?= $logo ?>" alt="logo" style="width: 130px !important; height: 57px !important;"/></a>
          <a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>admin"><img src="<?= base_url() ?>assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="<?= base_url() ?>assets/images/faces/face1.jpg" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?= $users['name'] ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="<?= base_url() ?>admin/logout">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Hari ini</h6>
                    <p class="text-gray ellipsis mb-0"> Website Release </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-power"></i>
              </a>
            </li>
            <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-format-line-spacing"></i>
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="<?= base_url() ?>assets/images/faces/face1.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?= $users['name'] ?></span>
                  <span class="text-secondary text-small"><?= $users['level'] ?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item <?php if($uri_segment == "admin") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php if($uri_segment == "users") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin/users">
                <span class="menu-title">Pengguna</span>
                <i class="mdi mdi-account menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item <?php if($uri_segment == "product") : ?> active <?php endif ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#product" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Produk</span>
                <i class="mdi mdi-shopping menu-icon"></i>
              </a>
              <div class="collapse" id="product">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>admin/product/category">Kategori</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>admin/product">List Produk</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item <?php if($uri_segment == "bank") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin/bank">
                <span class="menu-title">Bank Deposit</span>
                <i class="mdi mdi-bank menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item <?php if($uri_segment == "bank_withdrawal") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin/bank/withdrawal">
                <span class="menu-title">Bank Penarikan</span>
                <i class="mdi mdi-bank-transfer menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item <?php if($uri_segment == "deposit") : ?> active <?php endif ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#deposit" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Deposit</span>
                <i class="mdi mdi-cash-multiple menu-icon"></i>
              </a>
              <div class="collapse" id="deposit">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>admin/deposit">List Deposit</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>admin/deposit/amount">Nominal Deposit</a>
                  </li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item <?php if($uri_segment == "withdrawal" || $uri_segment == "withdrawal_amount") : ?> active <?php endif ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#withdrawal" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Penarikan Saldo</span>
                <?php if(isset($pending_withdrawals) && $pending_withdrawals > 0): ?>
                <span class="badge badge-warning"><?= $pending_withdrawals ?></span>
                <?php endif; ?>
                <i class="mdi mdi-cash-refund menu-icon"></i>
              </a>
              <div class="collapse" id="withdrawal">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>admin/withdrawal">List Penarikan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>admin/withdrawal/amount">Nominal Penarikan</a>
                  </li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item <?php if($uri_segment == "transaction") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin/transaction">
                <span class="menu-title">Transaksi</span>
                <i class="mdi mdi-chart-bar menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php if($uri_segment == "notification") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin/notification">
                <span class="menu-title">Notifikasi</span>
                <i class="mdi mdi-margin menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php if($uri_segment == "voucher") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin">
                <span class="menu-title">Voucher</span>
                <i class="mdi mdi-margin menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php if($uri_segment == "settings") : ?> active <?php endif ?>">
              <a class="nav-link" href="<?= base_url(); ?>admin/settings">
                <span class="menu-title">Pengaturan Web</span>
                <i class="mdi mdi-cog menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="page-header">
              <h3 class="page-title"> <?php if ($uri_segment == "admin") : ?> <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
                  </span> <?php endif ?> <?= $title ?> </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
              </nav>
            </div>

            <?php $this->renderSection('konten'); ?>
          </div>
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a href="<?= base_url(); ?>" target="_blank"><?= $web_name ?></a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">made with <i class="mdi mdi-heart text-danger"></i> by PetakaCode</span> 
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?= base_url() ?>assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?= base_url() ?>assets/vendors/chart.js/chart.umd.js"></script>
    <script src="<?= base_url() ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?= base_url() ?>assets/js/off-canvas.js"></script>
    <script src="<?= base_url() ?>assets/js/misc.js"></script>
    <script src="<?= base_url() ?>assets/js/settings.js"></script>
    <script src="<?= base_url() ?>assets/js/todolist.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.cookie.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
     <script src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/datetime-moment.js"></script>
    <?php $this->renderSection('js'); ?>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script>
      let table = new DataTable('#myTable', {
          responsive: true,
          "bLengthChange": false,
      });
    </script>
    <!-- End custom js for this page -->
  </body>
</html>