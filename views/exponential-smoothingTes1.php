<?php
$uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['uji_periode'];
$nilai_alpha = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['nilai_alpha'];
$variabel_dependen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['variabel_dependen']; ?>
<hr>
<div class="row">
  <div class="col-lg-6">
    <h5>Memprediksi Jumlah Penduduk</h5>
    <hr>
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
    } ?>
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark" id="">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Nilai Alpha</th>
                <th>Variabel Dependen</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Nilai Alpha</th>
                <th>Variabel Dependen</th>
              </tr>
            </tfoot>
            <tbody>
              <tr>
                <td><?= $uji_periode ?></td>
                <td><?= $nilai_alpha ?></td>
                <td><?= $variabel_dependen ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php
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
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th class="text-center">Periode</th>
                <th class="text-center">Ramalan</th>
                <th class="text-center">MAD</th>
                <th class="text-center">MSE</th>
                <th class="text-center">MAPE</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th class="text-center">Periode</th>
                <th class="text-center">Ramalan</th>
                <th class="text-center">Rata-rata MAD</th>
                <th class="text-center">Rata-rata MSE</th>
                <th class="text-center">Rata-rata MAPE</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $actual_values = array();
              $forecast_values = array();
              $alpha = $nilai_alpha;
              $prev_forecast = 0;
              $first_forecast_done = false;
              $total_mad = 0;
              $total_mse = 0;
              $total_mape = 0;

              // Loop through existing data
              foreach ($views_dependen as $key => $data) {
                if ($data['nama_variabel'] == $variabel_dependen) {
                  if (!$first_forecast_done) {
                    // Initialize the first forecast
                    $prev_forecast = $data['jumlah'];
                    $first_forecast_done = true;
                    echo "<tr>";
                    echo "<td>{$data['periode']}</td>";
                    echo "<td>$prev_forecast</td>";
                    echo "<td>0</td>";
                    echo "<td>0</td>";
                    echo "<td>0</td>";
                    echo "</tr>";
                    $actual_values[] = $data['jumlah'];
                    $forecast_values[] = $prev_forecast;
                  } else {
                    // Calculate subsequent forecasts using the formula
                    $forecast = $alpha * $data['jumlah'] + (1 - $alpha) * $prev_forecast;
                    $prev_forecast = $forecast;
                    $mad = abs($data['jumlah'] - $forecast);
                    $mse = pow($data['jumlah'] - $forecast, 2);
                    $mape = abs(($data['jumlah'] - $forecast) / $data['jumlah']) * 100;
                    $total_mad += $mad;
                    $total_mse += $mse;
                    $total_mape += $mape;
                    echo "<tr>";
                    echo "<td>{$data['periode']}</td>";
                    echo "<td>$forecast</td>";
                    echo "<td>$mad</td>";
                    echo "<td>$mse</td>";
                    echo "<td>$mape%</td>";
                    echo "</tr>";
                    $actual_values[] = $data['jumlah'];
                    $forecast_values[] = $forecast;
                  }
                }
              }

              // Predict for 2024-2027 based on actual data for previous years
              $last_data = end($uniques_dependen);
              $new_data = $last_data + 1;
              $hasil_prediksi = 0;
              for ($year = $new_data; $year <= $uji_periode; $year++) {
                // Calculate forecast for each year using the actual values from previous years
                $forecast = $alpha * end($actual_values) + (1 - $alpha) * end($forecast_values);
                $prev_forecast = $forecast;
                $mad = abs(end($actual_values) - $forecast);
                $mse = pow(end($actual_values) - $forecast, 2);
                $mape = abs((end($actual_values) - $forecast) / end($actual_values)) * 100;
                $total_mad += $mad;
                $total_mse += $mse;
                $total_mape += $mape;
                echo "<tr>";
                echo "<td>$year</td>";
                echo "<td>$forecast</td>";
                echo "<td>$mad</td>";
                echo "<td>$mse</td>";
                echo "<td>$mape%</td>";
                echo "</tr>";
                $actual_values[] = end($actual_values);
                $forecast_values[] = $forecast;
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

              // Calculate error metrics
              if (count($actual_values) != 0) {
                $mean_mad = $total_mad / count($actual_values);
                $mean_mse = $total_mse / count($actual_values);
                $mean_mape = $total_mape / count($actual_values);
              } else {
                $mean_mad = 0;
                $mean_mse = 0;
                $mean_mape = 0;
              }

              // Output error metrics
              echo "<tr>";
              echo "<td></td>";
              echo "<td></td>";
              echo "<td><strong>$mean_mad</strong></td>";
              echo "<td><strong>$mean_mse</strong></td>";
              echo "<td><strong>$mean_mape%</strong></td>";
              echo "</tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php $F_prediksi = $alpha * $prev_forecast + (1 - $alpha) * $prev_forecast; ?>

    <div class="card shadow mb-3">
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi</h5>
      </div>
      <div class="card-body">
        <p>Jumlah penduduk berdasarkan periode <?= $uji_periode ?> adalah: <strong><?= $F_prediksi ?></strong></p>
      </div>
    </div>
    <?php
    // Ambil data aktual dari database untuk tahun yang diprediksi
    $sql_actual = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel 
                      FROM dataset 
                      JOIN data_periode ON dataset.id_periode = data_periode.id_periode 
                      JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel 
                      WHERE data_periode.id_periode = '$data[id_periode]' AND data_variabel.id_variabel = '$data[id_variabel]'";
    $result_actual = mysqli_query($conn, $sql_actual);

    // Periksa apakah query berjalan dengan benar
    if (!$result_actual) {
      die("Query error: " . mysqli_error($conn));
    }

    // Ambil nilai aktual dari hasil query
    $row_actual = mysqli_fetch_assoc($result_actual);
    $nilai_dependen_actual = $row_actual['jumlah'];


    // Hitung error menggunakan metode MAE
    $error = abs($nilai_dependen_actual - $F_prediksi);

    // Hitung error dalam persen
    $error_percentage = ($error / $nilai_dependen_actual) * 100;

    // Menampilkan hasil error
    echo "<div class='card shadow mb-4 border-0'>";
    echo "<div class='card-body'>";
    echo "<h6 class='font-weight-bold'>Error menggunakan Metode MAE</h6>";
    echo "<p>Error = " . $error . "</p>";
    echo "<p>Error dalam persen = " . $error_percentage . "%</p>";
    echo "</div>";
    echo "</div>"; ?>
  </div>
  <div class="col-lg-6">
    <h5>Memprediksi Jumlah Migrasi</h5>
    <hr>
    <?php

    // Prediksi migrasi
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
    } ?>
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark" id="">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Nilai Alpha</th>
                <th>Variabel Dependen</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Nilai Alpha</th>
                <th>Variabel Dependen</th>
              </tr>
            </tfoot>
            <tbody>
              <tr>
                <td><?= $uji_periode ?></td>
                <td><?= $nilai_alpha ?></td>
                <td><?= $variabel_dependen ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php
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
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th class="text-center">Periode</th>
                <th class="text-center">Ramalan</th>
                <th class="text-center">MAD</th>
                <th class="text-center">MSE</th>
                <th class="text-center">MAPE</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th class="text-center">Periode</th>
                <th class="text-center">Ramalan</th>
                <th class="text-center">Rata-rata MAD</th>
                <th class="text-center">Rata-rata MSE</th>
                <th class="text-center">Rata-rata MAPE</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $actual_values = array();
              $forecast_values = array();
              $alpha = $nilai_alpha;
              $prev_forecast = 0;
              $first_forecast_done = false;
              $total_mad = 0;
              $total_mse = 0;
              $total_mape = 0;
              foreach ($views_dependen as $key => $data) {
                if ($data['nama_variabel'] == $variabel_dependen) {
                  if (!$first_forecast_done) {
                    $prev_forecast = $data['jumlah'];
                    $first_forecast_done = true;
                    echo "<tr>";
                    echo "<td>{$data['periode']}</td>";
                    echo "<td>$prev_forecast</td>";
                    echo "<td>0</td>";
                    echo "<td>0</td>";
                    echo "<td>0</td>";
                    echo "</tr>";
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
                    echo "<tr>";
                    echo "<td>{$data['periode']}</td>";
                    echo "<td>$forecast</td>";
                    echo "<td>$mad</td>";
                    echo "<td>$mse</td>";
                    echo "<td>$mape%</td>";
                    echo "</tr>";
                    $actual_values[] = $data['jumlah'];
                    $forecast_values[] = $forecast;
                  }
                }
              }

              // Predict for 2024-2027 based on actual data for previous years
              $last_data = end($uniques_dependen);
              $new_data = $last_data + 1;
              $hasil_prediksi = 0;
              for ($year = $new_data; $year <= $uji_periode; $year++) {
                // Calculate forecast for each year using the actual values from previous years
                $forecast = $alpha * end($actual_values) + (1 - $alpha) * end($forecast_values);
                $prev_forecast = $forecast;
                $mad = abs(end($actual_values) - $forecast);
                $mse = pow(end($actual_values) - $forecast, 2);
                $mape = abs((end($actual_values) - $forecast) / end($actual_values)) * 100;
                $total_mad += $mad;
                $total_mse += $mse;
                $total_mape += $mape;
                echo "<tr>";
                echo "<td>$year</td>";
                echo "<td>$forecast</td>";
                echo "<td>$mad</td>";
                echo "<td>$mse</td>";
                echo "<td>$mape%</td>";
                echo "</tr>";
                $actual_values[] = end($actual_values);
                $forecast_values[] = $forecast;
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

              if (count($actual_values) != 0) {
                $mean_mad = $total_mad / count($actual_values);
                $mean_mse = $total_mse / count($actual_values);
                $mean_mape = $total_mape / count($actual_values);
              } else {
                $mean_mad = 0;
                $mean_mse = 0;
                $mean_mape = 0;
              }
              echo "<tr>";
              echo "<td></td>";
              echo "<td></td>";
              echo "<td><strong>$mean_mad</strong></td>";
              echo "<td><strong>$mean_mse</strong></td>";
              echo "<td><strong>$mean_mape%</strong></td>";
              echo "</tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php $F_prediksi = $alpha * $prev_forecast + (1 - $alpha) * $prev_forecast; ?>

    <div class="card shadow mb-3">
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi</h5>
      </div>
      <div class="card-body">
        <p>Jumlah migrasi berdasarkan periode <?= $uji_periode ?> adalah: <strong><?= $F_prediksi ?></strong></p>
      </div>
    </div>
    <?php
    // Ambil data aktual dari database untuk tahun yang diprediksi
    $sql_actual = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel 
          FROM dataset 
          JOIN data_periode ON dataset.id_periode = data_periode.id_periode 
          JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel 
          WHERE data_periode.id_periode = '$data[id_periode]' AND data_variabel.id_variabel = '$data[id_variabel]'";
    $result_actual = mysqli_query($conn, $sql_actual);

    // Periksa apakah query berjalan dengan benar
    if (!$result_actual) {
      die("Query error: " . mysqli_error($conn));
    }

    // Ambil nilai aktual dari hasil query
    $row_actual = mysqli_fetch_assoc($result_actual);
    $nilai_dependen_actual = $row_actual['jumlah'];


    // Hitung error menggunakan metode MAE
    $error = abs($nilai_dependen_actual - $F_prediksi);

    // Hitung error dalam persen
    $error_percentage = ($error / $nilai_dependen_actual) * 100;

    // Menampilkan hasil error
    echo "<div class='card shadow mb-4 border-0'>";
    echo "<div class='card-body'>";
    echo "<h6 class='font-weight-bold'>Error menggunakan Metode MAE</h6>";
    echo "<p>Error = " . $error . "</p>";
    echo "<p>Error dalam persen = " . $error_percentage . "%</p>";
    echo "</div>";
    echo "</div>";
    ?>
  </div>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Grafik Prediksi</h6>
  </div>
  <div class="card-body">
    <div class="chart-area">
      <canvas id="myAreaChart"></canvas>
      <?php
      $sql = "SELECT 'Jumlah Penduduk' as category, periode, MAX(hasil_prediksi) as hasil_prediksi FROM hasil_es WHERE var_dependen='jumlah_penduduk' GROUP BY category, periode
              UNION
              SELECT 'Jumlah Migrasi' as category, periode, MAX(hasil_prediksi) as hasil_prediksi FROM hasil_es WHERE var_dependen='jumlah_migrasi' GROUP BY category, periode;
              ";
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