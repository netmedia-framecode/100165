<?php require_once("../controller/script.php");
$_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'] = "Setting";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'] ?></h1>
  </div>

  <?php foreach ($views_auth as $data) { ?>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block" style="height: 450px; background: url('../assets/img/auth/<?= $data['image'] ?>'); background-position: center; background-size: cover;"></div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Wallpaper System Login!</h1>
              </div>
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="imageOld" value="<?= $data['image'] ?>">
                <div class="form-group">
                  <label for="image">Masukan foto untuk system login</label>
                  <div class="input-group mb-3">
                    <div class="custom-file">
                      <input type="file" name="image" class="custom-file-input" id="image">
                      <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Pilih file</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="bg">Masukan Warna Primary</label>
                  <div class="d-flex justify-content-start align-content-center">
                    <input type="color" name="bg" class="form-control w-50" id="bg" value="<?= $data['bg'] ?>" required>
                    <span class="my-auto ml-3" id="bgCode"><?= $data['bg'] ?></span>
                  </div>
                </div>

                <script>
                  // Tambahkan event listener untuk mendeteksi perubahan warna
                  document.getElementById('bg').addEventListener('input', function() {
                    // Perbarui nilai kode warna
                    document.getElementById('bgCode').textContent = this.value;
                  });
                </script>
                <button type="submit" name="setting" class="btn btn-primary btn-user btn-block">
                  Ubah
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>
