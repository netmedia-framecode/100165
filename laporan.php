<?php require_once("controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] = "Laporan";
require_once("templates/top.php");
?>

</div>


<section class="why_us_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Hasil Laporan Prediksi
      </h2>
      <h6>Hasil prediksi dari tahun 2015</h6>
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
          <p>
            Regresi linier adalah sebuah metode statistik yang digunakan untuk menganalisis hubungan antara dua atau lebih variabel, di mana salah satu variabel digunakan untuk memprediksi variabel lain. Dalam regresi linier, kita mencoba membuat prediksi atau mengukur bagaimana satu hal dipengaruhi oleh yang lain. Pertama, kita memiliki variabel dependen (Y) yang merupakan hal yang ingin kita pahami atau prediksi. Kemudian, kita memiliki variabel independen (X), yang kita pikir mungkin mempengaruhi variabel dependen. Dalam penelitian ini, digunakan regresi liier berganda karena terdapat lebih dari satu buah variabel independen. Dataset penelitian terdiri atas satu variabel dependen (Y) dan dua variabel independen (X). Variabel dependen tersebut adalah atribut jumlah penduduk.
          </p>

          <?php
          $uji_periode = 2017;
          $periode_penduduk = array();
          $nilai_penduduk = array();
          $periode_migrasi = array();
          $nilai_migrasi = array();
          foreach ($views_dataset as $data) {
            if ($data['id_variabel'] == 59) {
              $periode_penduduk[] = $data['periode'];
              $nilai_penduduk[] = $data['jumlah'];
            } elseif ($data['id_variabel'] == 60) {
              $periode_migrasi[] = $data['periode'];
              $nilai_migrasi[] = $data['jumlah'];
            }
          }
          function hitungRegresi($nilai_dependen)
          {
            $mean_y = array_sum($nilai_dependen) / count($nilai_dependen);
            $denominator = 0;
            $numerator = 0;
            for ($i = 1; $i < count($nilai_dependen); $i++) {
              $diff_y_t_1 = $nilai_dependen[$i - 1] - $mean_y;
              $diff_y_t = $nilai_dependen[$i] - $mean_y;
              $denominator += pow($diff_y_t_1, 2);
              $numerator += $diff_y_t_1 * $diff_y_t;
            }
            $b1 = $numerator / $denominator;
            $b0 = $mean_y - $b1 * $mean_y;
            return array($b0, $b1, $mean_y);
          }
          list($b0_penduduk, $b1_penduduk, $mean_y_penduduk) = hitungRegresi($nilai_penduduk);
          ?>

          <!--grafik-->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <!-- Charts -->
          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-3">
                <div class="card-header shadow">
                  <h5 class="card-title">Grafik Prediksi - Jumlah Penduduk</h5>
                </div>
                <div class="card-body">
                  <canvas id="chartPopulation"></canvas>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card shadow mb-3">
                <div class="card-header shadow">
                  <h5 class="card-title">Grafik Prediksi - Jumlah Migrasi</h5>
                </div>
                <div class="card-body">
                  <canvas id="chartMigration"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="btn-box" style="justify-content: left;">
            <a href="views/export_rl" class="btn1 bg-primary" target="_blank">
              Export Data Regresi Linear
            </a>
          </div>

          <?php
          $labels_population = $periode_penduduk;
          $data_population = $nilai_penduduk;
          $last_data_population = end($periode_penduduk);
          $prev_forecast_population = end($nilai_penduduk);
          for ($year = $last_data_population + 1; $year <= $uji_periode; $year++) {
            $labels_population[] = $year;
            $forecast_population = $b0_penduduk + $b1_penduduk * $prev_forecast_population;
            $data_population[] = $forecast_population;
            $prev_forecast_population = $forecast_population;
          }
          $actual_population = $nilai_penduduk;
          for ($year = $last_data_population + 1; $year <= $uji_periode; $year++) {
            $actual_population[] = $actual_population_periode[$year];
          }
          $labels_migration = $periode_migrasi;
          $data_migration = $nilai_migrasi;
          $last_data_migration = end($periode_migrasi);
          $prev_forecast_migration = end($nilai_migrasi);
          for ($year = $last_data_migration + 1; $year <= $uji_periode; $year++) {
            $labels_migration[] = $year;
            $forecast_migration = $b0_migrasi + $b1_migrasi * $prev_forecast_migration;
            $data_migration[] = $forecast_migration;
            $prev_forecast_migration = $forecast_migration;
          }
          $actual_migration = $nilai_migrasi;
          for ($year = $last_data_migration + 1; $year <= $uji_periode; $year++) {
            $actual_migration[] = $actual_migration_periode[$year];
          }
          ?>
          <script>
            var ctxPopulation = document.getElementById('chartPopulation').getContext('2d');
            var chartPopulation = new Chart(ctxPopulation, {
              type: 'line',
              data: {
                labels: <?= json_encode($labels_population) ?>,
                datasets: [{
                    label: 'Jumlah Penduduk Prediksi',
                    data: <?= json_encode($data_population) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                  },
                  {
                    label: 'Jumlah Penduduk Aktual',
                    data: <?= json_encode($actual_population) ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                  }
                ]
              },
              options: {
                scales: {
                  x: {
                    title: {
                      display: true,
                      text: 'Periode'
                    }
                  },
                  y: {
                    title: {
                      display: true,
                      text: 'Jumlah'
                    }
                  }
                }
              }
            });

            var ctxMigration = document.getElementById('chartMigration').getContext('2d');
            var chartMigration = new Chart(ctxMigration, {
              type: 'line',
              data: {
                labels: <?= json_encode($labels_migration) ?>,
                datasets: [{
                    label: 'Jumlah Migrasi Prediksi',
                    data: <?= json_encode($data_migration) ?>,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: false
                  },
                  {
                    label: 'Jumlah Migrasi Aktual',
                    data: <?= json_encode($actual_migration) ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                  }
                ]
              },
              options: {
                scales: {
                  x: {
                    title: {
                      display: true,
                      text: 'Periode'
                    }
                  },
                  y: {
                    title: {
                      display: true,
                      text: 'Jumlah'
                    }
                  }
                }
              }
            });



            var ctxPopulation = document.getElementById('chartPopulation').getContext('2d');
            var chartPopulation = new Chart(ctxPopulation, {
              type: 'line',
              data: {
                labels: <?= json_encode($labels_population) ?>,
                datasets: [{
                    label: 'Jumlah Penduduk Prediksi',
                    data: <?= json_encode($data_population) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                  },
                  {
                    label: 'Y_t-1',
                    data: <?= json_encode($yt_minus_1) ?>, // Ini adalah data Y_t-1 yang harus Anda tambahkan
                    borderColor: 'rgba(255, 206, 86, 1)', // Warna garis untuk Y_t-1
                    borderWidth: 1,
                    fill: false
                  },
                  {
                    label: 'Jumlah Penduduk Aktual',
                    data: <?= json_encode($actual_population) ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                  }
                ]
              },
              options: {
                scales: {
                  x: {
                    title: {
                      display: true,
                      text: 'Periode'
                    }
                  },
                  y: {
                    title: {
                      display: true,
                      text: 'Jumlah'
                    }
                  }
                }
              }
            });
          </script>
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
          <p>
            Metode single exponential smoothing merupakan metode peramalan yang digunakan untuk meramalkan masa yang akan datang dengan melakukan proses pemulusan (smoothing) dengan menghasilkan data ramalan yang lebih kecil nilai kesalahannya. Metode ini banyak digunakan dalam peramalan, perencanaan persediaan, dan manajemen rantai pasokan untuk membuat estimasi yang lebih baik tentang masa depan berdasarkan data historis. Dalam perhitungan kali ini, peneliti menggunakan metode single exponential smoothing, yang mana data dianggap tidak stabil karena mengalami penurunan dan kenaikan di sekitar nilai mean (nilai rata-rata) yang tetap atau stabil. Penggunaan metode single exponential smoothing dalam memprediksi jumlah penduduk sangat tergantung pada karakteristik data dan tujuan prediksi yang diinginkan.
          </p>

          <?php
          $variabel_dependen_id = 60;
          $jumlah_data_dependen = 0;
          foreach ($views_variabel as $data_select_variabel) {
            if ($data_select_variabel['id_variabel'] == $variabel_dependen_id) {
              $variabel_dependen = $data_select_variabel['nama_variabel'];
              foreach ($views_dataset as $data) {
                if ($data['nama_variabel'] == $variabel_dependen) {
                  $jumlah_data_dependen += $data['jumlah'];
                }
              }
              break;
            }
          }
          $select_dependen = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel
                                FROM dataset 
                                JOIN data_periode ON dataset.id_periode = data_periode.id_periode 
                                JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel 
                                WHERE data_variabel.nama_variabel = '$variabel_dependen' 
                                ORDER BY dataset.id_periode";
          $views_dependen = mysqli_query($conn, $select_dependen);
          $uniques_dependen = [];
          foreach ($views_dataset as $data) {
            if ($data['nama_variabel'] == $variabel_dependen) {
              if (!in_array($data['periode'], $uniques_dependen)) {
                $uniques_dependen[] = $data['periode'];
              }
            }
          }

          $banyaknya_data_dependen = count($uniques_dependen);
          if ($banyaknya_data_dependen != 0) {
            $sum_y = $jumlah_data_dependen / $banyaknya_data_dependen;
          } else {
            $sum_y = 0;
          }
          $last_data = end($uniques_dependen);
          $new_data = $last_data + 1;
          $uji_periode = 2027;
          ?>
          <!-- Sisipkan Chart.js -->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <!-- Container untuk grafik -->
          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-3">
                <div class="card-body">
                  <canvas id="pendudukChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card shadow mb-3">
                <div class="card-body">
                  <canvas id="migrasiChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="btn-box" style="justify-content: left;">
            <a href="views/export_es" class="btn1 bg-primary" target="_blank">
              Export Data Exponential Smoothing
            </a>
          </div>

          <?php
          if (isset($views_dependen, $new_data, $uji_periode)) {
            $pendudukData = [];
            $actual_values = [];
            $forecast_values = [];
            $labels = [];
            foreach ($views_dependen as $data) {
              $pendudukData[] = $data['jumlah'];
              $actual_values[] = $data['jumlah'];
              $labels[] = $data['periode'];
            }
            for ($year = $new_data; $year <= $uji_periode; $year++) {
              $predictedValue = round($alpha * end($actual_values) + (1 - $alpha) * end($forecast_values));
              $pendudukData[] =  $forecast;
              $labels[] = $year;
              $forecast_values[] = $predictedValue;
            }
            echo "<script>
              var pendudukData = " . json_encode($pendudukData) . ";
              var actualData = " . json_encode($actual_values) . ";
              var forecastData = " . json_encode($forecast_values) . ";
              var labels = " . json_encode($labels) . ";
              var ctxMigrasi = document.getElementById('migrasiChart').getContext('2d');
              var migrasiChart = new Chart(ctxMigrasi, {
                type: 'line',
                data: {
                  labels: labels,
                  datasets: [{
                    label: 'Nilai Akutal',
                    data: actualData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 1
                  },
                  {
                    label: 'Nilai Prediksi',
                    data: forecastData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                  }]
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true
                    }
                  }
                }
              });
            </script>";
          }
          $uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['uji_periode'];
          $nilai_alpha = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['nilai_alpha'];
          $variabel_dependen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['variabel_dependen'];
          $jumlah_data_dependen = 0;
          foreach ($views_variabel as $data_select_variabel) {
            if ($data_select_variabel['id_variabel'] == $variabel_dependen_id) {
              $variabel_dependen = $data_select_variabel['nama_variabel'];
              foreach ($views_dataset as $data) {
                if ($data['nama_variabel'] == $variabel_dependen) {
                  $jumlah_data_dependen += $data['jumlah'];
                }
              }
              break;
            }
          }
          $uniques_dependen = [];
          foreach ($views_dataset as $data) {
            if ($data['nama_variabel'] == $variabel_dependen) {
              if (!in_array($data['periode'], $uniques_dependen)) {
                $uniques_dependen[] = $data['periode'];
              }
            }
          }
          $banyaknya_data_dependen = count($uniques_dependen);
          $sum_y = ($banyaknya_data_dependen != 0) ? $jumlah_data_dependen / $banyaknya_data_dependen : 0;
          $select_dependen = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel
                    FROM dataset 
                    JOIN data_periode ON dataset.id_periode = data_periode.id_periode 
                    JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel 
                    WHERE data_variabel.nama_variabel = '$variabel_dependen' 
                    ORDER BY dataset.id_periode";
          $views_dependen = mysqli_query($conn, $select_dependen);
          $actual_values = array();
          $forecast_values = array();
          $alpha = $nilai_alpha;
          $prev_forecast = 0;
          $first_forecast_done = false;
          $total_mad = 0;
          $total_mse = 0;
          $total_mape = 0;
          $pendudukData = [];
          $labels = [];
          foreach ($views_dependen as $key => $data) {
            if ($data['nama_variabel'] == $variabel_dependen) {
              if (!$first_forecast_done) {
                $prev_forecast = $data['jumlah'];
                $first_forecast_done = true;
                $pendudukData[] = $data['jumlah'];
                $actual_values[] = $data['jumlah'];
                $forecast_values[] = $prev_forecast;
              } else {
                $forecast = $alpha * $data['jumlah'] + (1 - $alpha) * $prev_forecast;
                $prev_forecast = $forecast;
                $mad = abs($data['jumlah'] - $forecast);
                $mse = pow($data['jumlah'] - $forecast, 2);
                $mape = abs(($data['jumlah'] - $forecast) / $data['jumlah']) * 100;
                $total_mad += $mad;
                $total_mse += $mse;
                $total_mape += $mape;
                $pendudukData[] = $forecast;
                $actual_values[] = $data['jumlah'];
                $forecast_values[] = $forecast;
              }
              $labels[] = $data['periode'];
            }
          }
          $last_data = end($uniques_dependen);
          $new_data = $last_data + 1;
          $hasil_prediksi = 0;
          for ($year = $new_data; $year <= $uji_periode; $year++) {
            $forecast = $alpha * end($actual_values) + (1 - $alpha) * end($forecast_values);
            $prev_forecast = $forecast;
            $mad = abs(end($actual_values) - $forecast);
            $mse = pow(end($actual_values) - $forecast, 2);
            $mape = abs((end($actual_values) - $forecast) / end($actual_values)) * 100;
            $total_mad += $mad;
            $total_mse += $mse;
            $total_mape += $mape;
            $pendudukData[] = $forecast;
            $actual_values[] = end($actual_values);
            $forecast_values[] = $forecast;
            $labels[] = $year;
            $hasil_prediksi = round($forecast);
            $check_hasil_es = "SELECT * FROM hasil_es WHERE periode='$year' AND var_dependen='$variabel_dependen'";
            $data_es = mysqli_query($conn, $check_hasil_es);
            if (mysqli_num_rows($data_es) == 0) {
              $sql = "INSERT INTO hasil_es(periode,nilai_alpha,var_dependen,hasil_prediksi) VALUES('$year','$nilai_alpha','$variabel_dependen','$hasil_prediksi')";
            } else if (mysqli_num_rows($data_es) > 0) {
              $sql = "UPDATE hasil_es SET nilai_alpha='$nilai_alpha', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='$variabel_dependen'";
            }
            mysqli_query($conn, $sql);
          }
          $s = $new_data - 1;
          $m = $uji_periode - $s;
          ?>
          <script>
            var ctxPenduduk = document.getElementById('pendudukChart').getContext('2d');
            var pendudukChart = new Chart(ctxPenduduk, {
              type: 'line',
              data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: <?= json_encode($pendudukData) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Nilai Aktual',
                    data: <?= json_encode(array_slice($actual_values, $m, count($pendudukData))) ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    borderDash: [5, 5]
                  },
                  {
                    label: 'Hasil Prediksi',
                    data: <?= json_encode($forecast_values) ?>,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderDash: [5, 5]
                  }
                ]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: false,
                    suggestedMin: <?= min($pendudukData) ?>,
                    suggestedMax: <?= max($pendudukData) ?>
                  }
                }
              }
            });
          </script>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once("templates/bottom.php") ?>