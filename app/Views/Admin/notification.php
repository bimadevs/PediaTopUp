<?php $this->extend('template_admin'); ?>
<?php $this->section('konten'); ?>
  <?php if (session('errors')): ?>
                    <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-danger bg-danger border-0 m-0 text-ligt alert-dismissable">
                        <?= session('errors') ?>
                        <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
                    </div>
                <?php endif ?>
                <?php if (session('success')): ?>
                    <div align="left" class="alert p-3 px-2 fs-14 text-light mt-1 mb-3 alert-success bg-success border-0 m-0 text-ligt alert-dismissable">
                                <?= session('success') ?>
                                <a style="font-size: 18px; position:absolute; right:5px; top:13px; font-weight : 100;color:white;opacity:1" class="close" data-dismiss="alert" aria-label="close"><i class="mdi mdi-close"></i></a>
                            </div>
                <?php endif ?>
<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" id="AddModal" data-bs-target="#exampleModal"><i class="mdi mdi-plus"></i> Tambah Notifikasi</button>
                    <div class="table-responsive-lg">
                    <table id="myTable" class="table table-striped nowrap" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Notifikasi</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($Notify as $key => $p) : ?>
                          <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $p['notify'] ?></td>
                            <td>
                              <a href="/admin/notification/delete/<?= $p['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus Notifikasi ini?');" class="btn btn-sm btn-danger" type="button"><i class="mdi mdi-delete"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Notifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/admin/notification/add" class="forms-sample" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="">Notifikasi</label>
                            <textarea name="notify" id="notify" placeholder="Masukkan notifikasi" class="form-control" rows="6" required></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                      
                    </div>
                  </div>
                </div>
<?php $this->endSection(); ?>
<?php $this->extend('template_admin'); ?>