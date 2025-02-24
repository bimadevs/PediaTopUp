<?php $this->extend('template_admin'); ?>
<?php $this->section('konten'); ?>
<div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                    <h4 class="font-weight-normal mb-3">Total Deposit Berhasil <i class="mdi mdi-cash-multiple mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?= $curr . " " .number_format($total['deposit'], 0, ",", "."); ?></h2>
                    <a href="/admin/deposit" class="card-text" style="text-decoration: none; color: #fff;">Lihat Detail <i class="mdi mdi-arrow-right mdi-24pxt"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                    <h4 class="font-weight-normal mb-3">Total Transaksi <i class="mdi mdi-chart-bar mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?= $total['order'] ?></h2>
                    <a href="/admin/transaction" class="card-text" style="text-decoration: none; color: #fff;">Lihat Detail <i class="mdi mdi-arrow-right mdi-24pxt"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                    <h4 class="font-weight-normal mb-3">Total Pengguna Aktif <i class="mdi mdi-account mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?= $total['users'] ?></h2>
                    <a href="/admin/users" class="card-text" style="text-decoration: none; color: #fff;">Lihat Detail <i class="mdi mdi-arrow-right mdi-24pxt"></i></a>
                  </div>
                </div>
              </div>
            </div>
<?php $this->endSection(); ?>
<?php $this->section('js'); ?>

<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>