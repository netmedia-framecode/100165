<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Regression Linear";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <div class="card shadow mb-3">
        <div class="card-header shadow">
          <h5 class="card-title">Prediksi</h5>
        </div>
        <form action="" method="post">
          <input type="hidden" name="variabel_independen" value="59">
          <input type="hidden" name="variabel_dependen" value="60">
          <div class="card-body">
            <div class="form-group">
              <label for="uji_periode">Periode</label>
              <select name="uji_periode" class="form-control" id="uji_periode" required>
                <option value="" selected>Pilih Periode</option>
                <?php
                $tahun_sekarang = date('Y') + 1;
                for ($tahun = $tahun_sekarang; $tahun <= $tahun_sekarang + 3; $tahun++) {
                  echo '<option value="' . $tahun . '">' . $tahun . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="data_migrasi">Data Migrasi</label>
              <input type="number" name="data_migrasi" class="form-control" id="data_migrasi" min="1" required>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" name="uji_prediksi_rl" class="btn btn-primary btn-sm">Hitung</button>
          </div>
        </form>
      </div>

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
      <?php
      if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]['prediksi_rl'])) {
        $uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi_rl']['uji_periode'];
        $data_migrasi = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi_rl']['data_migrasi'];
        $variabel_dependen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi_rl']['variabel_dependen'];
        $variabel_independen_id = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi_rl']['variabel_independen'];

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
                  $sql = "SELECT 'Regression Linear' as category, periode, hasil_prediksi FROM hasil_rl GROUP BY periode";
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

      <?php } ?>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>