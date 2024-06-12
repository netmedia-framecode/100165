<?php require_once("controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] = "Prediksi";
require_once("templates/top.php");
?>

</div>

<section class="why_us_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Prediksi
      </h2>
    </div>
    <div class="why_us_container">
      <div class="box">
        <div class="img-box bg-primary">
          <img src="assets/img/grafik.png" alt="">
        </div>
        <div class="detail-box">
          <h5>
            Regresi Linear
          </h5>
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable">
              <thead>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Jumlah Migrasi</th>
                  <th class="text-center">Variabel Independen</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Jumlah Migrasi</th>
                  <th class="text-center">Variabel Independen</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_hasil_rl as $data) { ?>
                  <tr>
                    <td><?php $created_at = date_create($data["created_at"]);
                        echo date_format($created_at, "d M Y - h:i a"); ?></td>
                    <td><?= $data['periode'] ?></td>
                    <td><?= $data['jumlah_migrasi'] ?></td>
                    <td><?= $data['var_independen'] ?></td>
                    <td><?= $data['var_dependen'] ?></td>
                    <td><?= $data['hasil_prediksi'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="img-box bg-primary">
          <img src="assets/img/grafik.png" alt="">
        </div>
        <div class="detail-box">
          <h5>
            Single Exponential Smoothing
          </h5>
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable1">
              <thead>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Nilai Alpha</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Nilai Alpha</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_hasil_es as $data) { ?>
                  <tr>
                    <td><?php $created_at = date_create($data["created_at"]);
                        echo date_format($created_at, "d M Y - h:i a"); ?></td>
                    <td><?= $data['periode'] ?></td>
                    <td><?= $data['nilai_alpha'] ?></td>
                    <td><?= $data['var_dependen'] ?></td>
                    <td><?= $data['hasil_prediksi'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once("templates/bottom.php") ?>