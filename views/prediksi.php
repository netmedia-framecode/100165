<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Prediksi";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
  </div>

  <?php if (!isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"])) { ?>
    <div class="card shadow w-50">
      <div class="card-body">
        <form action="" method="post">
          <input type="hidden" name="variabel_independen" value="59">
          <input type="hidden" name="variabel_dependen" value="60">
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
    <?php } else if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"])) {
    if ($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"]["metode"] == 1) { ?>
      <div class="row">
        <div class="col-lg-4">
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
        <div class="col-lg-8">
          <?php $uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['uji_periode'];
          $data_migrasi = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['data_migrasi'];
          $variabel_dependen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['variabel_dependen'];
          $variabel_independen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['variabel_independen'];

          $jumlah_data_independen = 0;
          foreach ($views_variabel as $data_select_variabel) {
            if ($data_select_variabel['id_variabel'] == $variabel_independen_id) {
              $variabel_independen = $data_select_variabel['nama_variabel'];
              foreach ($views_dataset as $data) {
                if ($data['nama_variabel'] == $variabel_independen) {
                  $jumlah_data_independen += $data['jumlah'];
                }
              }
              break;
            }
          }

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

          $uniques_independen = [];
          $uniques_dependen = [];

          foreach ($views_dataset as $data) {
            if ($data['nama_variabel'] == $variabel_independen) {
              if (!in_array($data['periode'], $uniques_independen)) {
                $uniques_independen[] = $data['periode'];
              }
            }
          }

          foreach ($views_dataset as $data) {
            if ($data['nama_variabel'] == $variabel_dependen) {
              if (!in_array($data['periode'], $uniques_dependen)) {
                $uniques_dependen[] = $data['periode'];
              }
            }
          }

          $banyaknya_data_independen = count($uniques_independen);
          $banyaknya_data_dependen = count($uniques_dependen);

          $sum_x = $jumlah_data_independen / $banyaknya_data_independen;
          $sum_y = $jumlah_data_dependen / $banyaknya_data_dependen;

          $mean_x = $jumlah_data_independen / $banyaknya_data_independen;
          $mean_y = $jumlah_data_dependen / $banyaknya_data_dependen;

          $nilai_independen = array();
          $nilai_dependen = array();
          $denominator = 0;
          $numerator = 0;

          foreach ($views_dataset as $data) {
            if ($data['nama_variabel'] == $variabel_independen) {
              $nilai_independen[] = $data['jumlah'];
            } elseif ($data['nama_variabel'] == $variabel_dependen) {
              $nilai_dependen[] = $data['jumlah'];
            }
          }
          ?>
          <div class="card shadow mb-3">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-dark" id="dataTable">
                  <thead>
                    <tr>
                      <th>Periode</th>
                      <th>Jumlah Migrasi</th>
                      <th>Variabel Independen</th>
                      <th>Variabel Dependen</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Periode</th>
                      <th>Jumlah Migrasi</th>
                      <th>Variabel Independen</th>
                      <th>Variabel Dependen</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr>
                      <td><?= $uji_periode ?></td>
                      <td><?= $data_migrasi ?></td>
                      <td><?= $variabel_independen ?></td>
                      <td><?= $variabel_dependen ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card shadow mb-3">
            <div class="card-header shadow">
              <h5 class="card-title">Jumlah Data untuk Uji Prediksi</h5>
            </div>
            <div class="card-body">
              <p>Variabel Independen (<?php if (isset($variabel_independen)) {
                                        echo $variabel_independen;
                                      } else {
                                        echo "-";
                                      }  ?>): <?php if (isset($jumlah_data_independen)) {
                                                echo "<strong>" . number_format($jumlah_data_independen) . " <i class='bi bi-people-fill'></i></strong>";
                                              } else {
                                                echo "<strong>-</strong>";
                                              } ?></p>
              <p>Variabel Dependen (<?php if (isset($variabel_dependen)) {
                                      echo  $variabel_dependen;
                                    } else {
                                      echo "<strong>-</strong>";
                                    } ?>): <?php if (isset($jumlah_data_dependen)) {
                                              echo "<strong>" . number_format($jumlah_data_dependen) . " <i class='bi bi-people-fill'></i></strong>";
                                            } else {
                                              echo "<strong>-</strong>";
                                            } ?></p>
            </div>
          </div>

          <div class="card shadow mb-3">
            <div class="card-header shadow">
              <h5 class="card-title">Data Hasil Perhitungan</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-dark" id="dataTable2">
                  <thead>
                    <tr>
                      <th>Nilai Independen</th>
                      <th>Nilai Dependen</th>
                      <th>X - X̄</th>
                      <th>Y - Ȳ</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nilai Independen</th>
                      <th>Nilai Dependen</th>
                      <th>X - X̄</th>
                      <th>Y - Ȳ</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    if (isset($nilai_independen)) {
                      for ($i = 0; $i < count($nilai_independen); $i++) {
                        echo "<tr>";
                        echo "<td>" . $nilai_independen[$i] . "</td>";
                        echo "<td>" . $nilai_dependen[$i] . "</td>";
                        $diff_x = $nilai_independen[$i] - $mean_x;
                        $diff_y = $nilai_dependen[$i] - $mean_y;
                        echo "<td>" . $diff_x . "</td>";
                        echo "<td>" . $diff_y . "</td>";
                        echo "</tr>";
                        $denominator += pow($diff_x, 2);
                        $numerator += $diff_x * $diff_y;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <?php
          $mean_x = array_sum($nilai_independen) / count($nilai_independen);
          $mean_y = array_sum($nilai_dependen) / count($nilai_dependen);

          $denominator = 0;
          $numerator = 0;
          for ($i = 0; $i < count($nilai_independen); $i++) {
            $diff_x = $nilai_independen[$i] - $mean_x;
            $diff_y = $nilai_dependen[$i] - $mean_y;
            $denominator += pow($diff_x, 2);
            $numerator += $diff_x * $diff_y;
          }

          $b1 = $numerator / $denominator;
          $b0 = $mean_y - $b1 * $mean_x;

          $nilai_dependen_prediksi = $b0 + $b1 * $data_migrasi;

          $sql = "INSERT INTO hasil_rl(periode,jumlah_migrasi,var_independen,var_dependen,hasil_prediksi) VALUES('$uji_periode','$data_migrasi','$variabel_independen','$variabel_dependen','$nilai_dependen_prediksi')";
          mysqli_query($conn, $sql);
          ?>

          <div class="row">
            <div class="col-lg-6">
              <div class='card shadow mb-4 border-0'>
                <div class='card-body'>
                  <h6 class="font-weight-bold">Koefisien Regresi (b1)</h6>
                  <p><?= $b1 ?></p>
                  <h6 class="font-weight-bold">Intersep (b0)</h6>
                  <p><?= $b0 ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class='card shadow mb-4 border-0'>
                <div class="card-header shadow">
                  <h5 class="card-title">Hasil Prediksi</h5>
                </div>
                <div class='card-body'>
                  <p>Jumlah penduduk berdasarkan data migrasi <?= $data_migrasi ?> adalah: <strong><?= number_format($nilai_dependen_prediksi, 4) ?></strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-12">
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
              $error = abs($nilai_dependen_actual - $nilai_dependen_prediksi);

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
            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Regression Linear</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                    <?php
                    $currentYear = date('Y');
                    $sql = "SELECT 'Regression Linear' as category, periode, MAX(hasil_prediksi) AS hasil_prediksi FROM hasil_rl GROUP BY periode";
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
          <form action="" method="post">
            <button type="submit" name="re_prediksi" class="btn btn-primary btn-sm mb-5">Reset</button>
          </form>
        </div>
      </div>
    <?php } else if ($_SESSION["project_prediksi_pertumbuhan_penduduk"]["prediksi"]["metode"] == 2) {
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
      $sum_y = $jumlah_data_dependen / $banyaknya_data_dependen; ?>
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable">
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
            <table class="table table-bordered text-dark" id="dataTable2">
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
                $mean_mad = $total_mad / count($actual_values);
                $mean_mse = $total_mse / count($actual_values);
                $mean_mape = $total_mape / count($actual_values);
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

      <?php $F_prediksi = $alpha * $prev_forecast + (1 - $alpha) * $prev_forecast;

      $sql = "INSERT INTO hasil_es(periode,nilai_alpha,var_dependen,hasil_prediksi) VALUES('$uji_periode','$nilai_alpha','$variabel_dependen','$F_prediksi')";
      mysqli_query($conn, $sql); ?>

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
      echo "</div>";
      ?>
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Grafik Exponential Smoothing</h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
            <?php
            $currentYear = date('Y');
            $sql = "SELECT 'Exponential Smoothing' as category, periode, MAX(hasil_prediksi) AS hasil_prediksi FROM hasil_es GROUP BY periode";
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
      <form action="" method="post">
        <button type="submit" name="re_prediksi" class="btn btn-primary btn-sm mb-5">Reset</button>
      </form>
  <?php }
  } ?>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>