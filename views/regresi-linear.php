<?php error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); ?>
<div class="row">
  <div class="col-lg-6">
    <?php
    // Ambil data variabel dependen dari session
    $uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['uji_periode'];

    $periode_penduduk = array();
    $nilai_penduduk = array();
    $periode_migrasi = array();
    $nilai_migrasi = array();

    // Mengambil data dari dataset untuk jumlah penduduk
    foreach ($views_dataset as $data) {
      if ($data['id_variabel'] == 59) {
        $periode_penduduk[] = $data['periode'];
        $nilai_penduduk[] = $data['jumlah'];
      } elseif ($data['id_variabel'] == 60) { // Mengambil data dari dataset untuk jumlah migrasi
        $periode_migrasi[] = $data['periode'];
        $nilai_migrasi[] = $data['jumlah'];
      }
    }

    // Fungsi untuk menghitung regresi linier
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

    // Hitung regresi untuk jumlah penduduk
    list($b0_penduduk, $b1_penduduk, $mean_y_penduduk) = hitungRegresi($nilai_penduduk);
    ?>

    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Nilai Dependen</th>
                <th>X</th>
                <th>Y</th>
                <th>X^2</th>
                <th>Y^2</th>
                <th>XY</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total_x_data_penduduk = 0;
              $total_y_data_penduduk = 0;
              $total_x2_data_penduduk = 0;
              $x_data_penduduk = 1;
              $xy_penduduk = 0;
              $total_actual = 0;
              $n_penduduk = count($nilai_penduduk);
              for ($i = 0; $i < count($nilai_penduduk); $i++) {
                $x2_data_penduduk = $x_data_penduduk ** 2;
                $y2_data_penduduk = $nilai_penduduk[$i] ** 2;
                $xy_penduduk = $x_data_penduduk * $nilai_penduduk[$i];
                echo "<tr>";
                echo "<td>" . $periode_penduduk[$i] . "</td>";
                echo "<td>" . $nilai_penduduk[$i] . "</td>";
                echo "<td>" . $x_data_penduduk . "</td>";
                echo "<td>" . $nilai_penduduk[$i] . "</td>";
                echo "<td>" . $x2_data_penduduk . "</td>";
                echo "<td>" . $y2_data_penduduk . "</td>";
                echo "<td>" . $xy_penduduk . "</td>";
                echo "</tr>";
                $total_x_data_penduduk += $x_data_penduduk;
                $total_y_data_penduduk += $nilai_penduduk[$i];
                $total_x2_data_penduduk += $x2_data_penduduk;
                $total_y2_data_penduduk += $y2_data_penduduk;
                $total_xy_penduduk += $xy_penduduk;
                $x_data_penduduk++;
                $total_actual += $nilai_penduduk[$i];
              }

              echo "<tr>";
              echo "<th colspan='2'>Total</th>";
              echo "<th>" . $total_x_data_penduduk . "</th>";
              echo "<th>" . $total_y_data_penduduk . "</th>";
              echo "<th>" . $total_x2_data_penduduk . "</th>";
              echo "<th>" . $total_y2_data_penduduk . "</th>";
              echo "<th>" . $total_xy_penduduk . "</th>";
              echo "</tr>";

              $r_a = ($n_penduduk*$total_xy_penduduk)-($total_x_data_penduduk*$total_y_data_penduduk);
              $r_b = sqrt(($n_penduduk*$total_x2_data_penduduk)-pow($total_x_data_penduduk, 2));
              $r_c = sqrt(($n_penduduk*$total_y2_data_penduduk)-pow($total_y_data_penduduk, 2));
              $r_koefisien = $r_a/($r_b*$r_c);

              $rata_rata_actual = $total_actual / $n_penduduk;
              $a_penduduk = (($total_y_data_penduduk * $total_x2_data_penduduk) - ($total_x_data_penduduk * $total_xy_penduduk)) / (($n_penduduk * $total_x2_data_penduduk) - ($total_x_data_penduduk ** 2));
              $b_penduduk = ($n_penduduk * $total_xy_penduduk - $total_x_data_penduduk * $total_y_data_penduduk) / ($n_penduduk * $total_x2_data_penduduk - $total_x_data_penduduk ** 2);
              $y_penduduk = $a_penduduk."+".$b_penduduk; 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class='font-weight-bold'>Nilai r Koefisien Korelasi Pearson</h6>
        <p>r = <?= round($r_koefisien, 3) ?></p>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class="font-weight-bold">a (Intercept)</h6>
        <p><?= $a_penduduk ?></p>
        <h6 class="font-weight-bold">b (Slope)</h6>
        <p><?= $b_penduduk ?></p>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Jumlah Penduduk</th>
                <th>Prediksi</th>
                <th>MAPE</th>
                <th>Error</th>
                <th>Absolute Error</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Jumlah Penduduk</th>
                <th>Prediksi</th>
                <th>MAPE</th>
                <th>Error</th>
                <th>Absolute Error</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $x_data_penduduk = 1;

              $total_mad = 0;
              $total_square_error = 0;
              $total_mape = 0;
              $error = 0;
              $total_error = 0;
              $absolute_error = 0;
              $total_absolute_error = 0;

              $check_hasil_rl = "SELECT * FROM hasil_rl WHERE var_dependen='jumlah_penduduk'";
              $data_rl = mysqli_query($conn, $check_hasil_rl);
              if (mysqli_num_rows($data_rl) > 0) {
                $delete_sql = "DELETE FROM hasil_rl WHERE var_dependen='jumlah_penduduk'";
                mysqli_query($conn, $delete_sql);
              }

              for ($i = 0; $i < $n_penduduk; $i++) {
                $prediksi_penduduk = $a_penduduk + $b_penduduk * ($i + 1);
                $error = $nilai_penduduk[$i] - round($prediksi_penduduk, 3);
                $absolute_error = abs($error);

                echo "<tr>";
                echo "<td>" . $periode_penduduk[$i] . "</td>";
                echo "<td>" . $nilai_penduduk[$i] . "</td>";
                echo "<td>" . round($prediksi_penduduk, 3) . "</td>";

                $mad = abs($nilai_penduduk[$i] - $rata_rata_actual);
                $square_error = pow($error, 2);
                $mape = abs(($nilai_penduduk[$i] - $prediksi_penduduk) / $nilai_penduduk[$i]);

                echo "<td>" . round($mape, 4) . "</td>";
                echo "<td>" . round($error, 3) . "</td>";
                echo "<td>" . round($absolute_error, 3) . "</td>";
                echo "</tr>";

                $total_mad += $mad;
                $total_square_error += $square_error;
                $total_mape += $mape;
                $total_error += $error;
                $total_absolute_error += $absolute_error;

                $x_data_penduduk++;
                
                $year = $periode_penduduk[$i];
                $aktual = round($nilai_penduduk[$i]);
                $hasil_prediksi = round($prediksi_penduduk);
                $check_hasil_rl = "SELECT * FROM hasil_rl WHERE periode='$year' AND var_dependen='jumlah_penduduk'";
                $data_rl = mysqli_query($conn, $check_hasil_rl);
                if (mysqli_num_rows($data_rl) == 0) {
                  $insert_sql = "INSERT INTO hasil_rl(periode,var_dependen,aktual,hasil_prediksi) VALUES('$year','jumlah_penduduk','$aktual','$hasil_prediksi')";
                } else if (mysqli_num_rows($data_rl) > 0) {
                  $insert_sql = "UPDATE hasil_rl SET aktual='$aktual', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='jumlah_penduduk'";
                }
                mysqli_query($conn, $insert_sql);
              }

              $last_data = end($periode_penduduk);
              $prev_forecast = end($nilai_penduduk);

              for ($year = $last_data + 1; $year <= $uji_periode; $year++) {
                $forecast = $b0_penduduk + $b1_penduduk * $prev_forecast;
                $prediksi_penduduk = $a_penduduk + $b_penduduk * $x_data_penduduk;
                $error = $nilai_penduduk[$i] - round($prediksi_penduduk, 3);
                $absolute_error = abs($error);

                echo "<tr>";
                echo "<td>" . $year . "</td>";
                echo "<td></td>";
                echo "<td>" . round($prediksi_penduduk, 3) . "</td>";
                echo "<td>0</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "</tr>";

                $prev_forecast = $forecast;
                $total_error += $error;
                $x_data_penduduk++;
                
                $aktual = 0;
                $hasil_prediksi = round($prediksi_penduduk);
                $check_hasil_rl = "SELECT * FROM hasil_rl WHERE periode='$year' AND var_dependen='jumlah_penduduk'";
                $data_rl = mysqli_query($conn, $check_hasil_rl);
                if (mysqli_num_rows($data_rl) == 0) {
                  $insert_sql = "INSERT INTO hasil_rl(periode,var_dependen,aktual,hasil_prediksi) VALUES('$year','jumlah_penduduk','$aktual','$hasil_prediksi')";
                } else if (mysqli_num_rows($data_rl) == 1) {
                  $insert_sql = "UPDATE hasil_rl SET aktual='$aktual', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='jumlah_penduduk'";
                }
                mysqli_query($conn, $insert_sql);
              }

              $average_mad = $total_mad / $n_penduduk;
              $average_square_error = $total_square_error / $n_penduduk;
              $average_mape = $total_mape / $n_penduduk;
              $average_mae = $total_absolute_error / $n_penduduk;

              $total_nilai_penduduk = array_sum($nilai_penduduk);
              $mape_percentage = ($average_mape / $n_penduduk) * 100;
              $mae_percentage = ($average_mae / $rata_rata_actual) * 100;

              echo "<tr>";
              echo "<td><strong>Rata-rata</strong></td>";
              echo "<td><strong>" . round($rata_rata_actual) . "</strong></td>";
              echo "<td><strong></strong></td>";
              echo "<td><strong></strong></td>";
              echo "<td><strong></strong></td>";
              echo "<td><strong>" . round($total_absolute_error, 3) . "</strong></td>";
              echo "</tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi - Jumlah Penduduk</h5>
      </div>
      <div class='card-body'>
        <p>Prediksi Penduduk pada tahun <?= $uji_periode ?> adalah <strong><?= round($prediksi_penduduk) ?></strong></p>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class='font-weight-bold'>Error menggunakan Metode MAPE</h6>
        <p>Error = <?= round($average_mape, 4) ?></p>
        <p>Error dalam persen = <?= round($mape_percentage, 2) ?>%</p>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <?php
    // Ambil data variabel dependen dari session
    $uji_periode = $_SESSION['project_prediksi_pertumbuhan_penduduk']['prediksi']['uji_periode'];

    $periode_penduduk = array();
    $nilai_penduduk = array();
    $periode_migrasi = array();
    $nilai_migrasi = array();

    // Mengambil data dari dataset untuk jumlah penduduk
    foreach ($views_dataset as $data) {
      if ($data['id_variabel'] == 59) {
        $periode_penduduk[] = $data['periode'];
        $nilai_penduduk[] = $data['jumlah'];
      } elseif ($data['id_variabel'] == 60) { // Mengambil data dari dataset untuk jumlah migrasi
        $periode_migrasi[] = $data['periode'];
        $nilai_migrasi[] = $data['jumlah'];
      }
    }

    // Fungsi untuk menghitung regresi linier
    function hitungRegresiMigrasi($nilai_dependen)
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

    // Hitung regresi untuk jumlah penduduk
    list($b0_penduduk, $b1_penduduk, $mean_y_penduduk) = hitungRegresiMigrasi($nilai_penduduk);

    // Hitung regresi untuk jumlah migrasi
    list($b0_migrasi, $b1_migrasi, $mean_y_migrasi) = hitungRegresiMigrasi($nilai_migrasi);
    ?>

    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Nilai Dependen</th>
                <th>X</th>
                <th>Y</th>
                <th>X^2</th>
                <th>Y^2</th>
                <th>XY</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total_x_data_migrasi = 0;
              $total_y_data_migrasi = 0;
              $total_x2_data_migrasi = 0;
              $x_data_migrasi = 1;
              $xy_migrasi = 0;
              $total_actual = 0;
              $n_migrasi = count($nilai_migrasi);
              for ($i = 0; $i < count($nilai_migrasi); $i++) {
                $x2_data_migrasi = $x_data_migrasi ** 2;
                $y2_data_migrasi = $nilai_migrasi[$i] ** 2;
                $xy_migrasi = $x_data_migrasi * $nilai_migrasi[$i];
                echo "<tr>";
                echo "<td>" . $periode_migrasi[$i] . "</td>";
                echo "<td>" . $nilai_migrasi[$i] . "</td>";
                echo "<td>" . $x_data_migrasi . "</td>";
                echo "<td>" . $nilai_migrasi[$i] . "</td>";
                echo "<td>" . $x2_data_migrasi . "</td>";
                echo "<td>" . $y2_data_migrasi . "</td>";
                echo "<td>" . $xy_migrasi . "</td>";
                echo "</tr>";
                $total_x_data_migrasi += $x_data_migrasi;
                $total_y_data_migrasi += $nilai_migrasi[$i];
                $total_x2_data_migrasi += $x2_data_migrasi;
                $total_y2_data_migrasi += $y2_data_migrasi;
                $total_xy_migrasi += $xy_migrasi;
                $x_data_migrasi++;
                $total_actual += $nilai_migrasi[$i];
              }

              echo "<tr>";
              echo "<th colspan='2'>Total</th>";
              echo "<th>" . $total_x_data_migrasi . "</th>";
              echo "<th>" . $total_y_data_migrasi . "</th>";
              echo "<th>" . $total_x2_data_migrasi . "</th>";
              echo "<th>" . $total_y2_data_migrasi . "</th>";
              echo "<th>" . $total_xy_migrasi . "</th>";
              echo "</tr>";

              $r_a = ($n_migrasi*$total_xy_migrasi)-($total_x_data_migrasi*$total_y_data_migrasi);
              $r_b = sqrt(($n_migrasi*$total_x2_data_migrasi)-pow($total_x_data_migrasi, 2));
              $r_c = sqrt(($n_migrasi*$total_y2_data_migrasi)-pow($total_y_data_migrasi, 2));
              $r_koefisien = $r_a/($r_b*$r_c);

              $rata_rata_actual = $total_actual / $n_migrasi;
              $a_migrasi = (($total_y_data_migrasi * $total_x2_data_migrasi) - ($total_x_data_migrasi * $total_xy_migrasi)) / (($n_migrasi * $total_x2_data_migrasi) - ($total_x_data_migrasi ** 2));
              $b_migrasi = ($n_migrasi * $total_xy_migrasi - $total_x_data_migrasi * $total_y_data_migrasi) / ($n_migrasi * $total_x2_data_migrasi - $total_x_data_migrasi ** 2);
              $y_migrasi = $a_migrasi."+".$b_migrasi;
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class='font-weight-bold'>Nilai r Koefisien Korelasi Pearson</h6>
        <p>r = <?= round($r_koefisien, 3) ?></p>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class="font-weight-bold">a (Intercept)</h6>
        <p><?= $a_migrasi ?></p>
        <h6 class="font-weight-bold">b (Slope)</h6>
        <p><?= $b_migrasi ?></p>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Jumlah Migrasi</th>
                <th>Prediksi</th>
                <th>MAPE</th>
                <th>Error</th>
                <th>Absolute Error</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Jumlah Migrasi</th>
                <th>Prediksi</th>
                <th>MAPE</th>
                <th>Error</th>
                <th>Absolute Error</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $x_data_migrasi = 1;

              $total_mad = 0;
              $total_square_error = 0;
              $total_mape = 0;
              $error = 0;
              $total_error = 0;
              $absolute_error = 0;
              $total_absolute_error = 0;

              $check_hasil_rl = "SELECT * FROM hasil_rl WHERE var_dependen='jumlah_migrasi'";
              $data_rl = mysqli_query($conn, $check_hasil_rl);
              if (mysqli_num_rows($data_rl) > 0) {
                $sql = "DELETE FROM hasil_rl WHERE var_dependen='jumlah_migrasi'";
                mysqli_query($conn, $sql);
              }

              for ($i = 0; $i < $n_migrasi; $i++) {
                $prediksi_migrasi = $a_migrasi + $b_migrasi * ($i + 1);
                $error = $nilai_migrasi[$i] - round($prediksi_migrasi, 3);
                $absolute_error = abs($error);

                echo "<tr>";
                echo "<td>" . $periode_migrasi[$i] . "</td>";
                echo "<td>" . $nilai_migrasi[$i] . "</td>";
                echo "<td>" . round($prediksi_migrasi, 3) . "</td>";

                $mad = abs($nilai_migrasi[$i] - $rata_rata_actual);
                $square_error = pow($error, 2);
                $mape = abs(($nilai_migrasi[$i] - $prediksi_migrasi) / $nilai_migrasi[$i]);

                echo "<td>" . round($mape, 3) . "</td>";
                echo "<td>" . round($error, 3) . "</td>";
                echo "<td>" . round($absolute_error, 3) . "</td>";
                echo "</tr>";

                $total_mad += $mad;
                $total_square_error += $square_error;
                $total_mape += $mape;
                $total_error += $error;
                $total_absolute_error += $absolute_error;

                $x_data_migrasi++;
                
                $year = $periode_migrasi[$i];
                $aktual = round($nilai_migrasi[$i]);
                $hasil_prediksi = round($prediksi_migrasi);
                $check_hasil_rl = "SELECT * FROM hasil_rl WHERE periode='$year' AND var_dependen='jumlah_migrasi'";
                $data_rl = mysqli_query($conn, $check_hasil_rl);
                if (mysqli_num_rows($data_rl) == 0) {
                  $sql = "INSERT INTO hasil_rl(periode,var_dependen,aktual,hasil_prediksi) VALUES('$year','jumlah_migrasi','$aktual','$hasil_prediksi')";
                } else if (mysqli_num_rows($data_rl) > 0) {
                  $sql = "UPDATE hasil_rl SET aktual='$aktual', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='jumlah_migrasi'";
                }
                mysqli_query($conn, $sql);
              }

              $last_data = end($periode_migrasi);
              $prev_forecast = end($nilai_migrasi);

              for ($year = $last_data + 1; $year <= $uji_periode; $year++) {
                $forecast = $b0_migrasi + $b1_migrasi * $prev_forecast;
                $prediksi_migrasi = $a_migrasi + $b_migrasi * $x_data_migrasi;
                $error = $nilai_migrasi[$i] - round($prediksi_migrasi, 3);
                $absolute_error = abs($error);

                echo "<tr>";
                echo "<td>" . $year . "</td>";
                echo "<td></td>";
                echo "<td>" . round($prediksi_migrasi, 3) . "</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "</tr>";

                $prev_forecast = $forecast;
                $total_error += $error;
                $x_data_migrasi++;

                $aktual = 0;
                $hasil_prediksi = round($prediksi_migrasi);
                // $sql = mysqli_query($conn, "DELETE FROM hasil_rl WHERE var_dependen='jumlah_migrasi'");
                $check_hasil_rl = "SELECT * FROM hasil_rl WHERE periode='$year' AND var_dependen='jumlah_migrasi'";
                $data_rl = mysqli_query($conn, $check_hasil_rl);
                if (mysqli_num_rows($data_rl) == 0) {
                  $sql = "INSERT INTO hasil_rl(periode,var_dependen,aktual,hasil_prediksi) VALUES('$year','jumlah_migrasi','$aktual','$hasil_prediksi')";
                } else if (mysqli_num_rows($data_rl) > 0) {
                  $sql = "UPDATE hasil_rl SET aktual='$aktual', hasil_prediksi='$hasil_prediksi' WHERE periode='$year' AND var_dependen='jumlah_migrasi'";
                }
                mysqli_query($conn, $sql);
              }

              $average_mad = $total_mad / $n_migrasi;
              $average_square_error = $total_square_error / $n_migrasi;
              $average_mape = $total_mape / $n_migrasi;
              $average_mae = $total_absolute_error / $n_migrasi;

              $total_nilai_migrasi = array_sum($nilai_migrasi);
              $mape_percentage = ($average_mape / $n_migrasi) * 100;
              $mae_percentage = ($average_mae / $rata_rata_actual) * 100;

              echo "<tr>";
              echo "<td><strong>Rata-rata</strong></td>";
              echo "<td><strong>" . round($rata_rata_actual) . "</strong></td>";
              echo "<td><strong></strong></td>";
              echo "<td><strong></strong></td>";
              echo "<td><strong></strong></td>";
              echo "<td><strong>" . round($total_absolute_error, 3) . "</strong></td>";
              echo "</tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi - Jumlah Migrasi</h5>
      </div>
      <div class='card-body'>
        <p>Prediksi Migrasi pada tahun <?= $uji_periode ?> adalah <strong><?= round($prediksi_migrasi) ?></strong></p>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class='font-weight-bold'>Error menggunakan Metode MAPE</h6>
        <p>Error = <?= round($average_mape, 4) ?></p>
        <p>Error dalam persen = <?= round($mape_percentage, 2) ?>%</p>
      </div>
    </div>
  </div>
</div>


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
        <p>Persamaan Regrasi : <?= $y_penduduk?></p>
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
        <p>Persamaan Regrasi : <?= $y_migrasi?></p>
        <canvas id="chartMigration"></canvas>
      </div>
    </div>
  </div>
</div>

<?php
// Query untuk mendapatkan data
$rl_penduduk = "SELECT periode, aktual, hasil_prediksi FROM hasil_rl WHERE var_dependen='jumlah_penduduk'";
$views_rl_penduduk = mysqli_query($conn, $rl_penduduk);

// Inisialisasi variabel sebagai array
$labels_penduduk = [];
$aktual_penduduk = [];
$prediksi_penduduk = [];

// Iterasi melalui hasil query dan isi array
foreach ($views_rl_penduduk as $data_penduduk) {
  $labels_penduduk[] = $data_penduduk['periode'];
  $aktual_penduduk[] = $data_penduduk['aktual'];
  $prediksi_penduduk[] = $data_penduduk['hasil_prediksi'];
}

// Query untuk mendapatkan data
$rl_migrasi = "SELECT periode, aktual, hasil_prediksi FROM hasil_rl WHERE var_dependen='jumlah_migrasi'";
$views_rl_migrasi = mysqli_query($conn, $rl_migrasi);

// Inisialisasi variabel sebagai array
$labels_migrasi = [];
$aktual_migrasi = [];
$prediksi_migrasi = [];

// Iterasi melalui hasil query dan isi array
foreach ($views_rl_migrasi as $data_migrasi) {
  $labels_migrasi[] = $data_migrasi['periode'];
  $aktual_migrasi[] = $data_migrasi['aktual'];
  $prediksi_migrasi[] = $data_migrasi['hasil_prediksi'];
}
?>

<script>
var ctxPopulation = document.getElementById('chartPopulation').getContext('2d');
var chartPopulation = new Chart(ctxPopulation, {
  type: 'line',
  data: {
    labels: <?= json_encode($labels_penduduk) ?>,
    datasets: [{
        label: 'Jumlah Penduduk Prediksi',
        data: <?= json_encode($prediksi_penduduk) ?>,
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        fill: false
      },
      {
        label: 'Jumlah Penduduk Aktual',
        data: <?= json_encode($aktual_penduduk) ?>,
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
    labels: <?= json_encode($labels_migrasi) ?>,
    datasets: [{
        label: 'Jumlah Migrasi Prediksi',
        data: <?= json_encode($prediksi_migrasi) ?>,
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1,
        fill: false
      },
      {
        label: 'Jumlah Migrasi Aktual',
        data: <?= json_encode($aktual_migrasi) ?>,
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
</body>

</html>