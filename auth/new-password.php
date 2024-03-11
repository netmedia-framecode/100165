<?php require_once("../controller/script.php");
if (!isset($_GET["en"])) {
  header("Location: ./");
  exit;
} else {
  if (empty($_GET["en"])) {
    header("Location: ./");
    exit;
  } else {
    $en = valid($conn, $_GET["en"]);
    $selectUser = "SELECT * FROM users WHERE en_user='$en'";
    $selectUser = mysqli_query($conn, $selectUser);
    $data = mysqli_fetch_assoc($selectUser);
  }
}
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Reset Password";
require_once("../templates/auth_top.php"); ?>

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <?php foreach ($views_auth as $data) { ?>
            <div class="col-lg-6 d-none d-lg-block" style="background: url('../assets/img/auth/<?= $data['image'] ?>'); background-position: center; background-size: cover;"></div>
          <?php } ?>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Atur ulang password anda</h1>
              </div>
              <form method="post">
                <div class="form-group">
                  <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control form-control-user" id="email" placeholder="Email" readonly>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <input type="password" name="re_password" class="form-control form-control-user" id="re_password" placeholder="Konfirmasi Password" required>
                </div>
                <button type="submit" name="new_password" class="btn btn-primary btn-user btn-block">
                  Atur ulang
                </button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="register">Buat sebuah akun!</a>
              </div>
              <div class="text-center">
                <a class="small" href="./">Sudah memiliki akun? Masuk!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<?php require_once("../templates/auth_bottom.php") ?>
