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
                <th>Y<sub>t-1</sub></th>
                <th>Y<sub>t</sub> - Ȳ</th>
                <th>Y<sub>t-1</sub> - Ȳ</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Nilai Dependen</th>
                <th>Y<sub>t-1</sub></th>
                <th>Y<sub>t</sub> - Ȳ</th>
                <th>Y<sub>t-1</sub> - Ȳ</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              for ($i = 1; $i < count($nilai_penduduk); $i++) {
                echo "<tr>";
                echo "<td>" . $periode_penduduk[$i] . "</td>";
                echo "<td>" . $nilai_penduduk[$i] . "</td>";
                echo "<td>" . $nilai_penduduk[$i - 1] . "</td>";
                $diff_y_t = $nilai_penduduk[$i] - $mean_y_penduduk;
                $diff_y_t_1 = $nilai_penduduk[$i - 1] - $mean_y_penduduk;
                echo "<td>" . $diff_y_t . "</td>";
                echo "<td>" . $diff_y_t_1 . "</td>";
                echo "</tr>";
              }

              $last_data = end($periode_penduduk);
              $prev_forecast = end($nilai_penduduk);

              for ($year = $last_data + 1; $year <= $uji_periode; $year++) {
                $forecast = $b0_penduduk + $b1_penduduk * $prev_forecast;
                echo "<tr>";
                echo "<td>" . $year . "</td>";
                echo "<td>" . $forecast . "</td>";
                echo "<td>" . $prev_forecast . "</td>";
                $diff_y_t = $forecast - $mean_y_penduduk;
                $diff_y_t_1 = $prev_forecast - $mean_y_penduduk;
                echo "<td>" . $diff_y_t . "</td>";
                echo "<td>" . $diff_y_t_1 . "</td>";
                echo "</tr>";
                $prev_forecast = $forecast;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class="font-weight-bold">Koefisien Regresi (b1)</h6>
        <p><?= $b1_penduduk ?></p>
        <h6 class="font-weight-bold">Intersep (b0)</h6>
        <p><?= $b0_penduduk ?></p>
      </div>
    </div>
    <div class='card shadow mb-4 border-0'>
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi - Jumlah Penduduk</h5>
      </div>
      <div class='card-body'>
        <p>Prediksi jumlah pada periode mendatang berdasarkan data sebelumnya adalah: <strong><?= round($forecast) ?></strong></p>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <?php
    // Hitung regresi untuk jumlah migrasi
    list($b0_migrasi, $b1_migrasi, $mean_y_migrasi) = hitungRegresi($nilai_migrasi);
    ?>

    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-dark">
            <thead>
              <tr>
                <th>Periode</th>
                <th>Jumlah Penduduk</th>
                <th>Y<sub>t-1</sub></th>
                <th>Y<sub>t</sub> - Ȳ</th>
                <th>Y<sub>t-1</sub> - Ȳ</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Periode</th>
                <th>Jumlah Migrasi</th>
                <th>Y<sub>t-1</sub></th>
                <th>Y<sub>t</sub> - Ȳ</th>
                <th>Y<sub>t-1</sub> - Ȳ</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              for ($i = 1; $i < count($nilai_migrasi); $i++) {
                echo "<tr>";
                echo "<td>" . $periode_migrasi[$i] . "</td>";
                echo "<td>" . $nilai_migrasi[$i] . "</td>";
                echo "<td>" . $nilai_migrasi[$i - 1] . "</td>";
                $diff_y_t = $nilai_migrasi[$i] - $mean_y_migrasi;
                $diff_y_t_1 = $nilai_migrasi[$i - 1] - $mean_y_migrasi;
                echo "<td>" . $diff_y_t . "</td>";
                echo "<td>" . $diff_y_t_1 . "</td>";
                echo "</tr>";
              }

              $last_data = end($periode_migrasi);
              $prev_forecast = end($nilai_migrasi);

              for ($year = $last_data + 1; $year <= $uji_periode; $year++) {
                $forecast = $b0_migrasi + $b1_migrasi * $prev_forecast;
                echo "<tr>";
                echo "<td>" . $year . "</td>";
                echo "<td>" . $forecast . "</td>";
                echo "<td>" . $prev_forecast . "</td>";
                $diff_y_t = $forecast - $mean_y_migrasi;
                $diff_y_t_1 = $prev_forecast - $mean_y_migrasi;
                echo "<td>" . $diff_y_t . "</td>";
                echo "<td>" . $diff_y_t_1 . "</td>";
                echo "</tr>";
                $prev_forecast = $forecast;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class='card shadow mb-4 border-0'>
      <div class='card-body'>
        <h6 class="font-weight-bold">Koefisien Regresi (b1)</h6>
        <p><?= $b1_migrasi ?></p>
        <h6 class="font-weight-bold">Intersep (b0)</h6>
        <p><?= $b0_migrasi ?></p>
      </div>
    </div>
    <div class='card shadow mb-4 border-0'>
      <div class="card-header shadow">
        <h5 class="card-title">Hasil Prediksi - Jumlah Migrasi</h5>
      </div>
      <div class='card-body'>
        <p>Prediksi jumlah pada periode mendatang berdasarkan data sebelumnya adalah: <strong><?= round($forecast) ?></strong></p>
      </div>
    </div>
  </div>
</div>

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
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var ctxPopulation = document.getElementById('chartPopulation').getContext('2d');
  var chartPopulation = new Chart(ctxPopulation, {
    type: 'line',
    data: {
      labels: <?= json_encode($labels_population) ?>,
      datasets: [{
        label: 'Jumlah Penduduk',
        data: <?= json_encode($data_population) ?>,
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        fill: false
      }]
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
        label: 'Jumlah Migrasi',
        data: <?= json_encode($data_migration) ?>,
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1,
        fill: false
      }]
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