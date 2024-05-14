<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Prediksi";
require_once("../templates/views_top.php"); ?>

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
            <div class="form-group for-ses" id="alpha-container">
              <label for="nilai_alpha">Nilai Alpha</label>
              <input type="range" name="nilai_alpha" class="form-control" id="nilai_alpha" value="0.1" min="0.1" max="1" step="0.1" required>
              <span id="nilai_migrasi">0.1</span>
              <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
              <script>
                $(document).ready(function() {
                  // Sembunyikan elemen nilai_alpha saat halaman dimuat
                  $("#alpha-container").hide();

                  $("#metode").on("change", function() {
                    if ($(this).val() === "2") {
                      // Jika metode yang dipilih adalah Single Exponential Smoothing, sembunyikan elemen nilai_alpha
                      $("#alpha-container").show();
                    } else {
                      // Jika metode yang dipilih bukan Single Exponential Smoothing, sembunyikan elemen nilai_alpha
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
          <div class="card shadow mb-3">
            <div class="card-header shadow">
              <h5 class="card-title">Rumus Regresi Linear</h5>
            </div>
            <div class="card-body">
              <p>Y = b<sub>0</sub> + b<sub>1</sub>X</p>
              <p>Dimana:</p>
              <ul>
                <li><strong>Y</strong> adalah variabel dependen (output).</li>
                <li><strong>X</strong> adalah variabel independen (input).</li>
                <li><strong>b<sub>0</sub></strong> adalah intersep (nilai Y ketika X = 0).</li>
                <li><strong>b<sub>1</sub></strong> adalah koefisien regresi (perubahan Y untuk setiap perubahan satu unit X).</li>
              </ul>

              <h6 class="font-weight-bold">Perhitungan b0 dan b1</h6>
              <p>Untuk menghitung b<sub>0</sub> dan b<sub>1</sub>, Anda dapat menggunakan rumus berikut:</p>
              <ul>
                <li><strong>b<sub>1</sub> = Σ((X - X̄)(Y - Ȳ)) / Σ((X - X̄)<sup>2</sup>)</strong></li>
                <li><strong>b<sub>0</sub> = Ȳ - b<sub>1</sub>X̄</strong></li>
                <li><strong>Σ</strong> adalah simbol sigma yang menunjukkan penjumlahan.</li>
                <li><strong>X̄</strong> adalah rata-rata dari variabel independen (X).</li>
                <li><strong>Ȳ</strong> adalah rata-rata dari variabel dependen (Y).</li>
              </ul>
            </div>
          </div>
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