<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Prediksi";
require_once("../templates/views_top.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-body">
          <form action="" method="post">
            <input type="hidden" name="variabel_independen" value="60">
            <input type="hidden" name="variabel_dependen" value="59">
            <div class="form-group">
              <label for="uji_periode">Tahun</label>
              <select name="uji_periode" class="form-control" id="uji_periode" required>
                <option value="" selected>Pilih Tahun</option>
                <?php
                $tahun_sekarang = date('Y');
                for ($tahun = $tahun_sekarang; $tahun <= $tahun_sekarang + 3; $tahun++) {
                  echo '<option value="' . $tahun . '">' . $tahun . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="metode">Metode</label>
              <select name="metode" class="form-control" id="metode" required>
                <option value="" selected>Pilih Metode</option>
                <option value="1">Regression Linear</option>
                <option value="2">Single Exponential Smoothing</option>
              </select>
            </div>
            <div class="form-group" id="migrasi-container">
              <label for="migrasi">Data Migrasi</label>
              <input type="number" name="migrasi" value="1" class="form-control" id="migrasi" min="1" required>
            </div>
            <div class="form-group for-ses" id="alpha-container">
              <label for="nilai_alpha">Nilai Alpha</label>
              <input type="range" name="nilai_alpha" class="form-control" id="nilai_alpha" value="0.1" min="0.1" max="1" step="0.1" required>
              <span id="nilai_migrasi">0.1</span>
              <script>
                $(document).ready(function() {
                  // Sembunyikan elemen nilai_alpha saat halaman dimuat
                  $("#migrasi-container").hide();
                  $("#alpha-container").hide();

                  $("#metode").on("change", function() {
                    if ($(this).val() === "1") {
                      $("#migrasi-container").show();
                    } else {
                      $("#migrasi-container").hide();
                    }

                    if ($(this).val() === "2") {
                      $("#alpha-container").show();
                    } else {
                      $("#alpha-container").hide();
                    }
                  });

                  $("#nilai_alpha").on("input", function() {
                    $("#nilai_migrasi").text($(this).val());
                  });
                });
              </script>
            </div>
            <button type="submit" name="prediksi" class="btn btn-primary btn-sm">Hitung</button>
          </form>
        </div>
      </div>
    </div>
    <?php if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"])) {
      if ($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"]["metode"] == 1) { ?>
        <div class="col-lg-6">
        </div>
    <?php }
    } ?>
  </div>
  <?php if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"])) {
    if ($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"]["metode"] == 1) {
      require_once("regresi-linear.php");
    } else if ($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"]["metode"] == 2) {
      require_once("exponential-smoothing.php");
    } ?>

    <form action="" method="post">
      <button type="submit" name="re_prediksi" class="btn btn-primary btn-sm mb-5">Reset</button>
    </form>

  <?php } ?>

</div>
<!-- /.container-fluid -->

<script src="<?= $baseURL ?>assets/js/demo/datapenduduk.js"></script>
<?php require_once("../templates/views_bottom.php") ?>