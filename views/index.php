<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
  </div>

  <div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Variabel & Periode</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="variabel">0</a> / <a href="periode">0</a></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-list-ul fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2" onclick="window.location.href='dataset'" style="cursor: pointer;">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Dataset</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
            </div>
            <div class="col-auto">
              <i class="bi bi-bar-chart-steps fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2" onclick="window.location.href='regression-linear'" style="cursor: pointer;">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Regression Linear</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
            </div>
            <div class="col-auto">
              <i class="bi bi-calculator fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2" onclick="window.location.href='exponential-smoothing'" style="cursor: pointer;">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Exponential Smoothing</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
            </div>
            <div class="col-auto">
              <i class="bi bi-calculator fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xl-12 col-lg-7">
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
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
              <div class="dropdown-header">Action:</div>
              <form action="" method="post">
                <button type="submit" name="grafik" value="rl" class="dropdown-item" id="rl">Regression Linear</button>
                <button type="submit" name="grafik" value="es" class="dropdown-item" id="es">Exponential Smoothing</button>
              </form>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="./">All</a>
              <a class="dropdown-item" href="ringkasan-hasil">Ringkasan Hasil</a>
            </div>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
            <?php
            $currentYear = date('Y');
            if (isset($_POST['grafik'])) {
              if ($_POST['grafik'] == 'rl') {
                $sql = "SELECT 'Regression Linear' as category, MONTH(created_at) as month, hasil_prediksi FROM hasil_rl WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) BETWEEN 1 AND 12 GROUP BY month";
              }
              if ($_POST['grafik'] == 'es') {
                $sql = "SELECT 'Exponential Smoothing' as category, MONTH(created_at) as month, hasil_prediksi FROM hasil_es WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) BETWEEN 1 AND 12 GROUP BY month";
              }
            } else {
              $sql = "SELECT 'Regression Linear' as category, MONTH(created_at) as month, hasil_prediksi FROM hasil_rl WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) BETWEEN 1 AND 12 GROUP BY month
              UNION
              SELECT 'Exponential Smoothing' as category, MONTH(created_at) as month, hasil_prediksi FROM hasil_es WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) BETWEEN 1 AND 12 GROUP BY month";
            }
            $result = $conn->query($sql);
            $dataGrafik = [];
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $namaBulan = DateTime::createFromFormat('!m', $row['month'])->format('F');
                $dataGrafik[] = [
                  'category' => $row['category'],
                  'hasil_prediksi' => $row['hasil_prediksi'],
                  'month' => $namaBulan,
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

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>