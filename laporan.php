<?php require_once("controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] = "Laporan";
require_once("templates/top.php");
?>

</div>


<section class="why_us_section layout_padding">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-7">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Grafik <?php if (isset($_POST['grafik'])) {
                                                                    if ($_POST['grafik'] == "rl") {
                                                                      echo "Regression Linear";
                                                                    }
                                                                    if ($_POST['grafik'] == "es") {
                                                                      echo "Exponential Smoothing";
                                                                    }
                                                                  } ?></h6>
            <div class="dropdown no-arrow">
              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Action:</div>
                <form action="" method="post">
                  <button type="submit" name="grafik" value="rl" class="dropdown-item" id="rl">Regression Linear</button>
                  <button type="submit" name="grafik" value="es" class="dropdown-item" id="es">Exponential Smoothing</button>
                </form>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="laporan">All</a>
              </div>
            </div>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <div class="chart-area" style="height: 400px;">
              <canvas id="myAreaChart"></canvas>
              <?php
              $currentYear = date('Y');
              if (isset($_POST['grafik'])) {
                if ($_POST['grafik'] == 'rl') {
                  $sql = "SELECT 'Regression Linear' as category, periode, hasil_prediksi FROM hasil_rl GROUP BY periode";
                }
                if ($_POST['grafik'] == 'es') {
                  $sql = "SELECT 'Exponential Smoothing' as category, periode, hasil_prediksi FROM hasil_es GROUP BY periode";
                }
              } else {
                $sql = "SELECT 'Regression Linear' as category, periode, hasil_prediksi FROM hasil_rl GROUP BY periode
              UNION
              SELECT 'Exponential Smoothing' as category, periode, hasil_prediksi FROM hasil_es GROUP BY periode";
              }
              $result = $conn->query($sql);
              $dataGrafik = [];
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $dataGrafik[] = [
                    'category' => $row['category'],
                    'hasil_prediksi' => $row['hasil_prediksi'],
                    'periode' => $row['periode'],
                  ];
                }
              }
              ?>

              <script>
                var dataGrafik = <?php echo json_encode($dataGrafik); ?>;
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-7">
        <div class="accordion shadow" id="accordionExample">
          <div class="card">
            <div class="card-header d-flex justify-content-between shadow" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Regression Linear
                </button>
              </h2>
              <a href="views/export_rl" class="btn btn-primary" target="_blank"><i class="bi bi-download"></i> Export</a>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
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
          </div>
          <div class="card">
            <div class="card-header d-flex justify-content-between shadow" id="headingTwo">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Exponential Smoothing
                </button>
              </h2>
              <a href="views/export_es" class="btn btn-primary" target="_blank"><i class="bi bi-download"></i> Export</a>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body">
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
      </div>
    </div>
  </div>
</section>

<?php require_once("templates/bottom.php") ?>