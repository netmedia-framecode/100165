<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Daftar";
require_once("../templates/auth_top.php"); ?>

<div class="card o-hidden border-0 shadow-lg my-5">
  <div class="card-body p-0">
    <!-- Nested Row within Card Body -->
    <div class="row">
      <?php foreach ($views_auth as $data) { ?>
        <div class="col-lg-6 d-none d-lg-block" style="background: url('../assets/img/auth/<?= $data['image'] ?>'); background-position: center; background-size: cover;"></div>
      <?php } ?>
      <div class="col-lg-7">
        <div class="p-5">
          <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Buat sebuah akun!</h1>
          </div>
          <form method="post">
            <div class="form-group">
              <input type="text" name="name" class="form-control form-control-user" id="name" placeholder="Nama" required>
            </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email" required>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password" required>
              </div>
              <div class="col-sm-6">
                <input type="password" name="re_password" class="form-control form-control-user" id="re_password" placeholder="Konfirmasi Password" required>
              </div>
            </div>
            <button type="submit" name="register" class="btn btn-primary btn-user btn-block">
              Daftarkan Akun
            </button>
          </form>
          <hr>
          <div class="text-center">
            <a class="small" href="./">Sudah memiliki akun? Masuk!</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once("../templates/auth_bottom.php") ?>
