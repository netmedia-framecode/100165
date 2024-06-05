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
              <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="variabel"><?= mysqli_num_rows($views_variabel) ?></a> / <a href="periode"><?= mysqli_num_rows($views_periode) ?></a></div>
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
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_dataset) ?></div>
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
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_hasil_rl) ?></div>
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
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_hasil_es) ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-calculator fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>