<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['uji_periode'];
$alpha = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['nilai_alpha'];
$variabel_dependen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['variabel_dependen']; ?>
<hr>
<div class="row">
  <div class="col-lg-6">
    <h5>Memprediksi Jumlah Penduduk</h5>
    <?php
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
    if ($banyaknya_data_dependen != 0) {
      $sum_y = $jumlah_data_dependen / $banyaknya_data_dependen;
    } else {
      $sum_y = 0;
    }

    $select_dependen = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel
      FROM dataset 
      JOIN data_periode ON dataset.id_periode = data_periode.id_periode 
      JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel 
      WHERE data_variabel.nama_variabel = '$variabel_dependen' 
      ORDER BY dataset.id_periode
    ";
    $views_dependen = mysqli_query($conn, $select_dependen);
    ?>

    <div class="card shadow mb-4 border-0">
      <div class="card-body">
        Nilai Alpha yang di tentukan adalah <b><?= $alpha ?></b>
      </div>
    </div>

    <div class="card shadow mb-4 border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th class="text-center">Periode</th>
                <th class="text-center">Jumlah Penduduk</th>
                <th class="text-center">Prediksi</th>
                <th class="text-center">Error</th>
                <th class="text-center">Absolut Error</th>
                <th class="text-center">Square Error</th>
                <th class="text-center">MAPE</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $prev_forecast_penduduk = 0;
              $forecast = 0;
              $total_error = 0;
              $total_absolut_error = 0;
              $total_square_error = 0;
              $total_mape = 0;
              $count = 0;
              $count_predict = 0;
              $prev_actual = 0;
              $total_actual = 0;

              foreach ($views_dependen as $key => $data) {
                if ($key == 0) {
                  $forecast = $data['jumlah'];
                  $prev_forecast_penduduk = $forecast;
                  $prev_actual = $data['jumlah'];

                  echo "<tr>";
                  echo "<td>" . $data['periode'] . "</td>";
                  echo "<td>" . $data['jumlah'] . "</td>";
                  echo "<td>$prev_forecast_penduduk</td>";
                  echo "<td>0</td>";
                  echo "<td>0</td>";
                  echo "<td>0</td>";
                  echo "<td></td>";
                  echo "</tr>";

                  $total_actual += $data['jumlah'];
                } else if ($key > 0) {
                  $forecast = $alpha * $prev_actual + (1 - $alpha) * $prev_forecast_penduduk;
                  $prev_forecast_penduduk = $forecast;
                  $error = $data['jumlah'] - $forecast;
                  $absolut_error = abs($error);
                  $square_error = pow($error, 2);
                  $mape = abs(($data['jumlah'] - $forecast) / $data['jumlah']);

                  $total_error += $error;
                  $total_absolut_error += $absolut_error;
                  $total_square_error += $square_error;
                  $total_mape += $mape;
                  $count++;
                  $count_predict++;

                  echo "<tr>";
                  echo "<td>" . $data['periode'] . "</td>";
                  echo "<td>" . $data['jumlah'] . "</td>";
                  echo "<td>" . round($forecast) . "</td>";
                  echo "<td>" . round($error) . "</td>";
                  echo "<td>" . round($absolut_error) . "</td>";
                  echo "<td>" . round($square_error) . "</td>";
                  echo "<td>" . round($mape, 3) . "%</td>";
                  echo "</tr>";

                  $prev_actual = $data['jumlah'];
                  $total_actual += $data['jumlah'];
                }

                $periode = $data['periode'];
                $last_periode = explode(" ", $periode);
              }

              for ($periode = $last_periode[0] + 1; $periode <= $uji_periode; $periode++) {
                $first_predict_periode = $last_periode[0] + 1;
                if ($first_predict_periode == $periode) {
                  $forecast = $alpha * $prev_actual + (1 - $alpha) * $prev_forecast_penduduk;
                  $prev_forecast_penduduk = $forecast;
                  $error = 0 - $forecast;
                  $absolut_error = abs($error);

                  // $total_error += $error;
                  $total_absolut_error += $absolut_error;
                  $count_predict++;

                  echo "<tr>";
                  echo "<td>" . $periode . "</td>";
                  echo "<td></td>";
                  echo "<td>" . round($forecast) . "</td>";
                  echo "<td>" . round($error) . "</td>";
                  echo "<td>" . round($absolut_error) . "</td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";
                } else {
                  $forecast = $alpha * 0 + (1 - $alpha) * $prev_forecast_penduduk;
                  $prev_forecast_penduduk = $forecast;
                  $error = 0 - $forecast;
                  $absolut_error = abs($error);

                  // $total_error += $error;
                  $total_absolut_error += $absolut_error;
                  $count_predict++;

                  echo "<tr>";
                  echo "<td>" . $periode . "</td>";
                  echo "<td></td>";
                  echo "<td>" . round($forecast) . "</td>";
                  echo "<td>" . round($error) . "</td>";
                  echo "<td>" . round($absolut_error) . "</td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";

                  $prev_actual = $data['jumlah'];
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php
    $mean_error = $total_error / ($count + 1);
    $mae = $total_absolut_error / ($count_predict + 1);
    $mse = $total_square_error / ($count + 1);
    $rmse = sqrt($mse);
    $rata_rata_actual = $total_actual / ($count + 1);
    $mae_percentage = ($mae / $rata_rata_actual) * 100;
    ?>

    <div class="card shadow mb-4 border-0">
      <div class="card-header shadow">
        <h5 class="card-title">Nilai error</h5>
      </div>
      <div class="card-body">
        <p>Mean Error = <?= round($mean_error); ?></p>
        <p>MAE = <?= round($mae); ?></p>
        <p>MSE = <?= round($mse); ?></p>
        <p>RMSE = <?= round($rmse); ?></p>
        <p>Nilai error MAE dalam persen = <?= round($mae_percentage, 2); ?>%</p>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi</h5>
      </div>
      <div class="card-body">
        <p>Prediksi penduduk pada tahun <?= $uji_periode ?> adalah: <strong><?= round($forecast) ?></strong></p>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-body">
        <?php
        $actual_values = [];
        $forecast_values = [];
        $labels = [];

        foreach ($views_dependen as $key => $data) {
          if ($data['nama_variabel'] == $variabel_dependen) {
            if (!$first_forecast_done) {
              $prev_actual = $data['jumlah'];
              $prev_forecast = $data['jumlah'];
              $first_forecast_done = true;
              $actual_values[] = $data['jumlah'];
              $forecast_values[] = $prev_forecast;
            } else {
              $forecast = $alpha * $prev_actual + (1 - $alpha) * $prev_forecast;
              $prev_forecast = $forecast;
              $actual_values[] = $data['jumlah'];
              $forecast_values[] = $forecast;
              $prev_actual = $data['jumlah'];
            }
            $labels[] = $data['periode'];
          }
        }

        $last_data = end($labels);
        $new_data = $last_data + 1;
        $hasil_prediksi = 0;

        for ($year = $new_data; $year <= $uji_periode; $year++) {
          $forecast = $alpha * end($actual_values) + (1 - $alpha) * end($forecast_values);
          $prev_forecast = $forecast;
          $actual_values[] = 0;
          $forecast_values[] = $forecast;
          $labels[] = $year;

          $hasil_prediksi = round($forecast);

          $check_hasil_es = "SELECT * FROM hasil_es WHERE periode='$year' AND var_dependen='$variabel_dependen'";
          $data_es = mysqli_query($conn, $check_hasil_es);
          if (mysqli_num_rows($data_es) == 0) {
            $sql = "INSERT INTO hasil_es(periode,nilai_alpha,var_dependen,hasil_prediksi) VALUES('$year','$alpha','$variabel_dependen','$hasil_prediksi')";
          } else if (mysqli_num_rows($data_es) > 0) {
            $sql = "UPDATE hasil_es SET nilai_alpha='$alpha', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='$variabel_dependen'";
          }
          mysqli_query($conn, $sql);
        }
        ?>
        <canvas id="pendudukChart"></canvas>
        <script>
          var ctxPenduduk = document.getElementById('pendudukChart').getContext('2d');
          var pendudukChart = new Chart(ctxPenduduk, {
            type: 'line',
            data: {
              labels: <?= json_encode($labels) ?>,
              datasets: [{
                  label: 'Nilai Aktual',
                  data: <?= json_encode($actual_values) ?>,
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1,
                  borderDash: [5, 5]
                },
                {
                  label: 'Prediksi',
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
                  suggestedMin: <?= min($actual_values) ?>,
                  suggestedMax: <?= max($actual_values) ?>
                }
              }
            }
          });
        </script>

      </div>
    </div>

  </div>

  <div class="col-lg-6">
    <h5>Memprediksi Migrasi Penduduk</h5>
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
    $select_dependen = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel
                  FROM dataset 
                  JOIN data_periode ON dataset.id_periode = data_periode.id_periode 
                  JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel 
                  WHERE data_variabel.nama_variabel = '$variabel_dependen' 
                  ORDER BY dataset.id_periode";
    $views_dependen = mysqli_query($conn, $select_dependen);
    ?>

    <div class="card shadow mb-4 border-0">
      <div class="card-body">
        Nilai Alpha yang di tentukan adalah <b><?= $alpha ?></b>
      </div>
    </div>

    <div class="card shadow mb-4 border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th class="text-center">Periode</th>
                <th class="text-center">Jumlah Migrasi</th>
                <th class="text-center">Prediksi</th>
                <th class="text-center">Error</th>
                <th class="text-center">Absolut Error</th>
                <th class="text-center">Square Error</th>
                <th class="text-center">MAPE</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $prev_forecast_penduduk = 0;
              $forecast = 0;
              $total_error = 0;
              $total_absolut_error = 0;
              $total_square_error = 0;
              $total_mape = 0;
              $count = 0;
              $count_predict = 0;
              $prev_actual = 0;
              $total_actual = 0;

              foreach ($views_dependen as $key => $data) {
                if ($key == 0) {
                  $forecast = $data['jumlah'];
                  $prev_forecast_penduduk = $forecast;
                  $prev_actual = $data['jumlah'];

                  echo "<tr>";
                  echo "<td>" . $data['periode'] . "</td>";
                  echo "<td>" . $data['jumlah'] . "</td>";
                  echo "<td>$prev_forecast_penduduk</td>";
                  echo "<td>0</td>";
                  echo "<td>0</td>";
                  echo "<td>0</td>";
                  echo "<td></td>";
                  echo "</tr>";

                  $total_actual += $data['jumlah'];
                } else if ($key > 0) {
                  $forecast = $alpha * $prev_actual + (1 - $alpha) * $prev_forecast_penduduk;
                  $prev_forecast_penduduk = $forecast;
                  $error = $data['jumlah'] - $forecast;
                  $absolut_error = abs($error);
                  $square_error = pow($error, 2);
                  $mape = abs(($data['jumlah'] - $forecast) / $data['jumlah']);

                  $total_error += $error;
                  $total_absolut_error += $absolut_error;
                  $total_square_error += $square_error;
                  $total_mape += $mape;
                  $count++;
                  $count_predict++;

                  echo "<tr>";
                  echo "<td>" . $data['periode'] . "</td>";
                  echo "<td>" . $data['jumlah'] . "</td>";
                  echo "<td>" . round($forecast) . "</td>";
                  echo "<td>" . round($error) . "</td>";
                  echo "<td>" . round($absolut_error) . "</td>";
                  echo "<td>" . round($square_error) . "</td>";
                  echo "<td>" . round($mape, 3) . "%</td>";
                  echo "</tr>";

                  $prev_actual = $data['jumlah'];
                  $total_actual += $data['jumlah'];
                }

                $periode = $data['periode'];
                $last_periode = explode(" ", $periode);
              }

              for ($periode = $last_periode[0] + 1; $periode <= $uji_periode; $periode++) {
                $first_predict_periode = $last_periode[0] + 1;
                if ($first_predict_periode == $periode) {
                  $forecast = $alpha * $prev_actual + (1 - $alpha) * $prev_forecast_penduduk;
                  $prev_forecast_penduduk = $forecast;
                  $error = 0 - $forecast;
                  $absolut_error = abs($error);

                  // $total_error += $error;
                  $total_absolut_error += $absolut_error;
                  $count_predict++;

                  echo "<tr>";
                  echo "<td>" . $periode . "</td>";
                  echo "<td></td>";
                  echo "<td>" . round($forecast) . "</td>";
                  echo "<td>" . round($error) . "</td>";
                  echo "<td>" . round($absolut_error) . "</td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";
                } else {
                  $forecast = $alpha * 0 + (1 - $alpha) * $prev_forecast_penduduk;
                  $prev_forecast_penduduk = $forecast;
                  $error = 0 - $forecast;
                  $absolut_error = abs($error);

                  // $total_error += $error;
                  $total_absolut_error += $absolut_error;
                  $count_predict++;

                  echo "<tr>";
                  echo "<td>" . $periode . "</td>";
                  echo "<td></td>";
                  echo "<td>" . round($forecast) . "</td>";
                  echo "<td>" . round($error) . "</td>";
                  echo "<td>" . round($absolut_error) . "</td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";

                  $prev_actual = $data['jumlah'];
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php
    $mean_error = $total_error / ($count + 1);
    $mae = $total_absolut_error / ($count_predict + 1);
    $mse = $total_square_error / ($count + 1);
    $rmse = sqrt($mse);
    $rata_rata_actual = $total_actual / ($count + 1);
    $mae_percentage = ($mae / $rata_rata_actual) * 100;
    ?>

    <div class="card shadow mb-4 border-0">
      <div class="card-header shadow">
        <h5 class="card-title">Nilai error</h5>
      </div>
      <div class="card-body">
        <p>Mean Error = <?= round($mean_error); ?></p>
        <p>MAE = <?= round($mae); ?></p>
        <p>MSE = <?= round($mse); ?></p>
        <p>RMSE = <?= round($rmse); ?></p>
        <p>Nilai error MAE dalam persen = <?= round($mae_percentage, 2); ?>%</p>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi</h5>
      </div>
      <div class="card-body">
        <p>Prediksi penduduk pada tahun <?= $uji_periode ?> adalah: <strong><?= round($forecast) ?></strong></p>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-body">
        <?php
        $actual_values = [];
        $forecast_values = [];
        $labels = [];

        foreach ($views_dependen as $key => $data) {
          if ($data['nama_variabel'] == $variabel_dependen) {
            if (!$first_forecast_migrasi_done) {
              $prev_actual = $data['jumlah'];
              $prev_forecast = $data['jumlah'];
              $first_forecast_migrasi_done = true;
              $actual_values[] = $data['jumlah'];
              $forecast_values[] = $prev_forecast;
            } else {
              $forecast = $alpha * $prev_actual + (1 - $alpha) * $prev_forecast;
              $prev_forecast = $forecast;
              $actual_values[] = $data['jumlah'];
              $forecast_values[] = $forecast;
              $prev_actual = $data['jumlah'];
            }
            $labels[] = $data['periode'];
          }
        }

        $last_data = end($labels);
        $new_data = $last_data + 1;
        $hasil_prediksi = 0;

        for ($year = $new_data; $year <= $uji_periode; $year++) {
          $forecast = $alpha * end($actual_values) + (1 - $alpha) * end($forecast_values);
          $prev_forecast = $forecast;
          $actual_values[] = 0;
          $forecast_values[] = $forecast;
          $labels[] = $year;

          $hasil_prediksi = round($forecast);

          $check_hasil_es = "SELECT * FROM hasil_es WHERE periode='$year' AND var_dependen='$variabel_dependen'";
          $data_es = mysqli_query($conn, $check_hasil_es);
          if (mysqli_num_rows($data_es) == 0) {
            $sql = "INSERT INTO hasil_es(periode,nilai_alpha,var_dependen,hasil_prediksi) VALUES('$year','$alpha','$variabel_dependen','$hasil_prediksi')";
          } else if (mysqli_num_rows($data_es) > 0) {
            $sql = "UPDATE hasil_es SET nilai_alpha='$alpha', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='$variabel_dependen'";
          }
          mysqli_query($conn, $sql);
        }

        ?>
        <canvas id="migrasiChart"></canvas>
        <script>
          var ctxMigrasi = document.getElementById('migrasiChart').getContext('2d');
          var migrasiChart = new Chart(ctxMigrasi, {
            type: 'line',
            data: {
              labels: <?= json_encode($labels) ?>,
              datasets: [{
                  label: 'Nilai Aktual',
                  data: <?= json_encode($actual_values) ?>,
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1,
                  borderDash: [5, 5]
                },
                {
                  label: 'Prediksi',
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
                  suggestedMin: <?= min($actual_values) ?>,
                  suggestedMax: <?= max($actual_values) ?>
                }
              }
            }
          });
        </script>

      </div>
    </div>

  </div>

</div>