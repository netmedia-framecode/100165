<?php error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); ?>
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow mb-3">
      <div class="card-header shadow">
        <h5 class="card-title">Rumus Regresi Linear - Jumlah Penduduk</h5>
      </div>
      <div class="card-body">
        <p>Y<sub>t</sub> = b<sub>0</sub> + b<sub>1</sub>Y<sub>t-1</sub></p>
        <p>Dimana:</p>
        <ul>
          <li><strong>Y<sub>t</sub></strong> adalah nilai variabel pada waktu t.</li>
          <li><strong>Y<sub>t-1</sub></strong> adalah nilai variabel pada waktu t-1.</li>
          <li><strong>b<sub>0</sub></strong> adalah intersep (nilai Y ketika X = 0).</li>
          <li><strong>b<sub>1</sub></strong> adalah koefisien regresi (perubahan Y untuk setiap perubahan satu unit Y sebelumnya).</li>
        </ul>

        <h6 class="font-weight-bold">Perhitungan b0 dan b1</h6>
        <p>Untuk menghitung b<sub>0</sub> dan b<sub>1</sub>, Anda dapat menggunakan rumus berikut:</p>
        <ul>
          <li><strong>b<sub>1</sub> = Σ((Y<sub>t-1</sub> - Ȳ<sub>t-1</sub>)(Y<sub>t</sub> - Ȳ<sub>t</sub>)) / Σ((Y<sub>t-1</sub> - Ȳ<sub>t-1</sub>)<sup>2</sup>)</strong></li>
          <li><strong>b<sub>0</sub> = Ȳ<sub>t</sub> - b<sub>1</sub>Ȳ<sub>t-1</sub></strong></li>
          <li><strong>Σ</strong> adalah simbol sigma yang menunjukkan penjumlahan.</li>
          <li><strong>Ȳ<sub>t-1</sub></strong> adalah rata-rata dari variabel Y pada waktu t-1.</li>
          <li><strong>Ȳ<sub>t</sub></strong> adalah rata-rata dari variabel Y pada waktu t.</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card shadow mb-3">
      <div class="card-header shadow">
        <h5 class="card-title">Rumus Regresi Linear - Jumlah Migrasi</h5>
      </div>
      <div class="card-body">
        <p>Y<sub>t</sub> = b<sub>0</sub> + b<sub>1</sub>Y<sub>t-1</sub></p>
        <p>Dimana:</p>
        <ul>
          <li><strong>Y<sub>t</sub></strong> adalah nilai variabel pada waktu t.</li>
          <li><strong>Y<sub>t-1</sub></strong> adalah nilai variabel pada waktu t-1.</li>
          <li><strong>b<sub>0</sub></strong> adalah intersep (nilai Y ketika X = 0).</li>
          <li><strong>b<sub>1</sub></strong> adalah koefisien regresi (perubahan Y untuk setiap perubahan satu unit Y sebelumnya).</li>
        </ul>

        <h6 class="font-weight-bold">Perhitungan b0 dan b1</h6>
        <p>Untuk menghitung b<sub>0</sub> dan b<sub>1</sub>, Anda dapat menggunakan rumus berikut:</p>
        <ul>
          <li><strong>b<sub>1</sub> = Σ((Y<sub>t-1</sub> - Ȳ<sub>t-1</sub>)(Y<sub>t</sub> - Ȳ<sub>t</sub>)) / Σ((Y<sub>t-1</sub> - Ȳ<sub>t-1</sub>)<sup>2</sup>)</strong></li>
          <li><strong>b<sub>0</sub> = Ȳ<sub>t</sub> - b<sub>1</sub>Ȳ<sub>t-1</sub></strong></li>
          <li><strong>Σ</strong> adalah simbol sigma yang menunjukkan penjumlahan.</li>
          <li><strong>Ȳ<sub>t-1</sub></strong> adalah rata-rata dari variabel Y pada waktu t-1.</li>
          <li><strong>Ȳ<sub>t</sub></strong> adalah rata-rata dari variabel Y pada waktu t.</li>
        </ul>
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
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Nilai Dependen</th>
                <th>X</th>
                <th>Y</th>
                <th>X^2</th>
                <th>Y^2</th>
                <th>XY</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $total_x_data_penduduk = 0;
              $total_y_data_penduduk = 0;
              $total_x2_data_penduduk = 0;
              $x_data_penduduk = 1;
              $xy_penduduk = 0;
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
              }

              echo "<tr>";
              echo "<th colspan='2'>Total Dataset</th>";
              echo "<th>" . $total_x_data_penduduk . "</th>";
              echo "<th>" . $total_y_data_penduduk . "</th>";
              echo "<th>" . $total_x2_data_penduduk . "</th>";
              echo "<th>" . $total_y2_data_penduduk . "</th>";
              echo "<th>" . $total_xy_penduduk . "</th>";
              echo "</tr>";

              $last_data = end($periode_penduduk);
              $prev_forecast = end($nilai_penduduk);

              for ($year = $last_data + 1; $year <= $uji_periode; $year++) {
                $forecast = $b0_penduduk + $b1_penduduk * $prev_forecast;
                $x2_data_penduduk = $x_data_penduduk ** 2;
                $y2_data_penduduk = round($forecast) ** 2;
                $xy_penduduk = $x_data_penduduk * round($forecast);
                echo "<tr>";
                echo "<td>" . $year . "</td>";
                echo "<td>" . round($forecast) . "</td>";
                echo "<td>" . $x_data_penduduk . "</td>";
                echo "<td>" . round($forecast) . "</td>";
                echo "<td>" . round($x2_data_penduduk) . "</td>";
                echo "<td>" . round($y2_data_penduduk) . "</td>";
                echo "<td>" . round($xy_penduduk) . "</td>";
                echo "</tr>";
                $prev_forecast = $forecast;
                $total_x_data_penduduk += $x_data_penduduk;
                $total_y_data_penduduk += $forecast;
                $total_x2_data_penduduk += $x2_data_penduduk;
                $total_y2_data_penduduk += $y2_data_penduduk;
                $total_xy_penduduk += $xy_penduduk;
                $x_data_penduduk++;
              }

              echo "<tr>";
              echo "<th colspan='2'>Total Dataset & Prediksi</th>";
              echo "<th>" . $total_x_data_penduduk . "</th>";
              echo "<th>" . round($total_y_data_penduduk) . "</th>";
              echo "<th>" . round($total_x2_data_penduduk) . "</th>";
              echo "<th>" . round($total_y2_data_penduduk) . "</th>";
              echo "<th>" . round($total_xy_penduduk) . "</th>";
              echo "</tr>";

              $n_penduduk = $x_data_penduduk - 1;
              $a_penduduk = (($total_y_data_penduduk * $total_x2_data_penduduk) - ($total_x_data_penduduk * $total_xy_penduduk)) / (($n_penduduk * $total_x2_data_penduduk) - ($total_x_data_penduduk ** 2));
              $b_penduduk = ($n_penduduk * $total_xy_penduduk - $total_x_data_penduduk * $total_y_data_penduduk) / ($n_penduduk * $total_x2_data_penduduk - $total_x_data_penduduk ** 2);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class="font-weight-bold">Koefisien Regresi (a)</h6>
        <p><?= $a_penduduk ?></p>
        <h6 class="font-weight-bold">Intersep (b)</h6>
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
                <th>MAD</th>
                <th>MSE</th>
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
                <th>MAD</th>
                <th>MSE</th>
                <th>MAPE</th>
                <th>Error</th>
                <th>Absolute Error</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $x_data_penduduk = 1;
              $n_penduduk = count($nilai_penduduk);

              $total_mad = 0;
              $total_mse = 0;
              $total_mape = 0;
              $error = 0;
              $absolute_error = 0;
              $total_absolute_error = 0;

              for ($i = 0; $i < $n_penduduk; $i++) {
                $prediksi_penduduk = $a_penduduk + $b_penduduk * ($i + 1);
                $error = $nilai_penduduk[$i] - round($prediksi_penduduk, 3);
                $absolute_error = abs($error);

                echo "<tr>";
                echo "<td>" . $periode_penduduk[$i] . "</td>";
                echo "<td>" . $nilai_penduduk[$i] . "</td>";
                echo "<td>" . round($prediksi_penduduk, 3) . "</td>";

                $mad = abs($nilai_penduduk[$i] - $prediksi_penduduk);
                $mse = pow($nilai_penduduk[$i] - $prediksi_penduduk, 2);
                $mape = abs(($nilai_penduduk[$i] - $prediksi_penduduk) / $nilai_penduduk[$i]) * 100;

                echo "<td>" . round($mad, 3) . "</td>";
                echo "<td>" . round($mse, 3) . "</td>";
                echo "<td>" . round($mape, 3) . "</td>";
                echo "<td>" . round($error, 3) . "</td>";
                echo "<td>" . round($absolute_error, 3) . "</td>";
                echo "</tr>";

                $total_mad += $mad;
                $total_mse += $mse;
                $total_mape += $mape;
                $total_absolute_error += $absolute_error;

                $x_data_penduduk++;
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
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . round($error, 3) . "</td>";
                echo "<td>" . round($absolute_error, 3) . "</td>";
                echo "</tr>";

                $prev_forecast = $forecast;
                $total_absolute_error += $absolute_error;
                $x_data_penduduk++;
              }

              $average_mad = $total_mad / $n_penduduk;
              $average_mse = $total_mse / $n_penduduk;
              $average_mape = $total_mape / $n_penduduk;
              $average_mae = $total_absolute_error / ($x_data_penduduk - 1);

              $total_nilai_penduduk = array_sum($nilai_penduduk);
              $mae_percentage = ($average_mae / $total_nilai_penduduk) * 100;

              echo "<tr>";
              echo "<td colspan='3'><strong>Rata-rata</strong></td>";
              echo "<td><strong>" . round($average_mad, 3) . "</strong></td>";
              echo "<td><strong>" . round($average_mse, 3) . "</strong></td>";
              echo "<td><strong>" . round($average_mape, 3) . "</strong></td>";
              echo "<td><strong>" . round($average_mae, 3) . "</strong></td>";
              echo "<td><strong>" . round($mae_percentage) . "%</strong></td>";
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
        <h6 class='font-weight-bold'>Error menggunakan Metode MAE</h6>
        <p>Error = <?= round($average_mae, 3) ?></p>
        <p>Error dalam persen = <?= round($mae_percentage) ?>%</p>
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
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Nilai Dependen</th>
                <th>X</th>
                <th>Y</th>
                <th>X^2</th>
                <th>Y^2</th>
                <th>XY</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $total_x_data_migrasi = 0;
              $total_y_data_migrasi = 0;
              $total_x2_data_migrasi = 0;
              $x_data_migrasi = 1;
              $xy_migrasi = 0;
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
              }

              echo "<tr>";
              echo "<th colspan='2'>Total Dataset</th>";
              echo "<th>" . $total_x_data_migrasi . "</th>";
              echo "<th>" . $total_y_data_migrasi . "</th>";
              echo "<th>" . $total_x2_data_migrasi . "</th>";
              echo "<th>" . $total_y2_data_migrasi . "</th>";
              echo "<th>" . $total_xy_migrasi . "</th>";
              echo "</tr>";

              $last_data = end($periode_migrasi);
              $prev_forecast = end($nilai_migrasi);

              for ($year = $last_data + 1; $year <= $uji_periode; $year++) {
                $forecast = $b0_migrasi + $b1_migrasi * $prev_forecast;
                $x2_data_migrasi = $x_data_migrasi ** 2;
                $y2_data_migrasi = round($forecast) ** 2;
                $xy_migrasi = $x_data_migrasi * round($forecast);
                echo "<tr>";
                echo "<td>" . $year . "</td>";
                echo "<td>" . round($forecast) . "</td>";
                echo "<td>" . $x_data_migrasi . "</td>";
                echo "<td>" . round($forecast) . "</td>";
                echo "<td>" . round($x2_data_migrasi) . "</td>";
                echo "<td>" . round($y2_data_migrasi) . "</td>";
                echo "<td>" . round($xy_migrasi) . "</td>";
                echo "</tr>";
                $prev_forecast = $forecast;
                $total_x_data_migrasi += $x_data_migrasi;
                $total_y_data_migrasi += $forecast;
                $total_x2_data_migrasi += $x2_data_migrasi;
                $total_y2_data_migrasi += $y2_data_migrasi;
                $total_xy_migrasi += $xy_migrasi;
                $x_data_migrasi++;
              }

              echo "<tr>";
              echo "<th colspan='2'>Total Dataset & Prediksi</th>";
              echo "<th>" . $total_x_data_migrasi . "</th>";
              echo "<th>" . round($total_y_data_migrasi) . "</th>";
              echo "<th>" . round($total_x2_data_migrasi) . "</th>";
              echo "<th>" . round($total_y2_data_migrasi) . "</th>";
              echo "<th>" . round($total_xy_migrasi) . "</th>";
              echo "</tr>";

              $n_migrasi = $x_data_migrasi - 1;
              $a_migrasi = (($total_y_data_migrasi * $total_x2_data_migrasi) - ($total_x_data_migrasi * $total_xy_migrasi)) / (($n_migrasi * $total_x2_data_migrasi) - ($total_x_data_migrasi ** 2));
              $b_migrasi = ($n_migrasi * $total_xy_migrasi - $total_x_data_migrasi * $total_y_data_migrasi) / ($n_migrasi * $total_x2_data_migrasi - $total_x_data_migrasi ** 2);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class="font-weight-bold">Koefisien Regresi (a)</h6>
        <p><?= $a_migrasi ?></p>
        <h6 class="font-weight-bold">Intersep (b)</h6>
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
                <th>Jumlah Penduduk</th>
                <th>Prediksi</th>
                <th>MAD</th>
                <th>MSE</th>
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
                <th>MAD</th>
                <th>MSE</th>
                <th>MAPE</th>
                <th>Error</th>
                <th>Absolute Error</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $x_data_migrasi = 1;
              $n_migrasi = count($nilai_migrasi);

              $total_mad = 0;
              $total_mse = 0;
              $total_mape = 0;
              $error = 0;
              $absolute_error = 0;
              $total_absolute_error = 0;

              for ($i = 0; $i < $n_migrasi; $i++) {
                $prediksi_migrasi = $a_migrasi + $b_migrasi * ($i + 1);
                $error = $nilai_migrasi[$i] - round($prediksi_migrasi, 3);
                $absolute_error = abs($error);

                echo "<tr>";
                echo "<td>" . $periode_migrasi[$i] . "</td>";
                echo "<td>" . $nilai_migrasi[$i] . "</td>";
                echo "<td>" . round($prediksi_migrasi, 3) . "</td>";

                $mad = abs($nilai_migrasi[$i] - $prediksi_migrasi);
                $mse = pow($nilai_migrasi[$i] - $prediksi_migrasi, 2);
                $mape = abs(($nilai_migrasi[$i] - $prediksi_migrasi) / $nilai_migrasi[$i]) * 100;

                echo "<td>" . round($mad, 3) . "</td>";
                echo "<td>" . round($mse, 3) . "</td>";
                echo "<td>" . round($mape, 3) . "</td>";
                echo "<td>" . round($error, 3) . "</td>";
                echo "<td>" . round($absolute_error, 3) . "</td>";
                echo "</tr>";

                $total_mad += $mad;
                $total_mse += $mse;
                $total_mape += $mape;
                $total_absolute_error += $absolute_error;

                $x_data_migrasi++;
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
                echo "<td>" . round($error, 3) . "</td>";
                echo "<td>" . round($absolute_error, 3) . "</td>";
                echo "</tr>";

                $prev_forecast = $forecast;
                $total_absolute_error += $absolute_error;
                $x_data_migrasi++;
              }

              $average_mad = $total_mad / $n_migrasi;
              $average_mse = $total_mse / $n_migrasi;
              $average_mape = $total_mape / $n_migrasi;
              $average_mae = $total_absolute_error / ($x_data_migrasi - 1);

              $total_nilai_migrasi = array_sum($nilai_migrasi);
              $mae_percentage = ($average_mae / $total_nilai_migrasi) * 100;

              echo "<tr>";
              echo "<td colspan='3'><strong>Rata-rata</strong></td>";
              echo "<td><strong>" . round($average_mad, 3) . "</strong></td>";
              echo "<td><strong>" . round($average_mse, 3) . "</strong></td>";
              echo "<td><strong>" . round($average_mape, 3) . "</strong></td>";
              echo "<td><strong>" . round($average_mae, 3) . "</strong></td>";
              echo "<td><strong>" . round($mae_percentage) . "%</strong></td>";
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
        <h6 class='font-weight-bold'>Error menggunakan Metode MAE</h6>
        <p>Error = <?= round($average_mae, 3) ?></p>
        <p>Error dalam persen = <?= round($mae_percentage) ?>%</p>
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

<?php
// Your PHP code for data preparation and linear regression calculation
// ...

// Prepare data for population chart
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


// Add actual population values to the dataset
$actual_population = $nilai_penduduk;

for ($year = $last_data_population + 1; $year <= $uji_periode; $year++) {
  $actual_population[] = $actual_population_periode[$year]; // Assuming $actual_population_periode is an array containing actual population values for each year
}
// var_dump($actual_population);
// Prepare data for migration chart
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

// Add actual migration values to the dataset
$actual_migration = $nilai_migrasi;
for ($year = $last_data_migration + 1; $year <= $uji_periode; $year++) {
  $actual_migration[] = $actual_migration_periode[$year]; // Assuming $actual_migration_periode is an array containing actual migration values for each year
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
</body>

</html>