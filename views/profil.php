<?php require_once("../controller/script.php");
$_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'] = "Profil";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'] ?></h1>
  </div>

  <?php foreach ($view_profile as $data) { ?>
    <div class="card mb-3 border-0 shadow">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="../assets/img/profil/<?= $data["image"] ?>" alt="<?= $data["image"] ?>" style="width: 350px;height: 350px;object-fit: cover;">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <table class="table table-sm table-borderless text-dark">
              <thead>
                <tr>
                  <th scope="col" style="width: 50px;">Nama</th>
                  <th scope="col" class="text-right" style="width: 20px;">:</th>
                  <th scope="col" style="width: 200px;"><?= $data['name'] ?></th>
                </tr>
                <tr>
                  <th scope="col">Email</th>
                  <th scope="col" class="text-right">:</th>
                  <th scope="col"><?= $data['email'] ?></th>
                </tr>
                <tr>
                  <th scope="col">Status</th>
                  <th scope="col" class="text-right">:</th>
                  <th scope="col"><?= $data['status'] ?></th>
                </tr>
                <tr>
                  <th scope="col">Role</th>
                  <th scope="col" class="text-right">:</th>
                  <th scope="col"><?= $data['role'] ?></th>
                </tr>
              </thead>
            </table>
            <p class="card-text"><small class="text-muted">Terakhir diperbarui <?php $date = date_create($data["updated_at"]);
                                                                                echo date_format($date, "l, d M Y"); ?></small></p>

            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah">
              <i class="bi bi-pencil-square"></i> Ubah
            </button>
            <div class="modal fade" id="ubah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0 shadow">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                    <input type="hidden" name="imageOld" value="<?= $data['image'] ?>">
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control" id="name" minlength="3" required>
                      </div>
                      <div class="form-group">
                        <label for="password">Password baru <small>(Optional)</small></label>
                        <input type="text" name="password" class="form-control" id="password" minlength="8">
                      </div>
                      <div class="form-group">
                        <label for="image">Foto profil <small>(Optional)</small></label>
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Pilih file</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center border-top-0">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                      <button type="submit" name="edit_profil" class="btn btn-warning btn-sm">Ubah</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>
