<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Ringkasan Hasil";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
  </div>

  <div class="accordion shadow" id="accordionExample">
    <div class="card">
      <div class="card-header d-flex justify-content-between shadow" id="headingOne">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Regression Linear
          </button>
        </h2>
        <a href="export_rl" class="btn btn-primary" target="_blank"><i class="bi bi-download"></i> Export</a>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable">
              <thead>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Jumlah Migrasi</th>
                  <th class="text-center">Variabel Independen</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Jumlah Migrasi</th>
                  <th class="text-center">Variabel Independen</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_hasil_rl as $data) { ?>
                  <tr>
                    <td><?php $created_at = date_create($data["created_at"]);
                        echo date_format($created_at, "d M Y - h:i a"); ?></td>
                    <td><?= $data['periode'] ?></td>
                    <td><?= $data['jumlah_migrasi'] ?></td>
                    <td><?= $data['var_independen'] ?></td>
                    <td><?= $data['var_dependen'] ?></td>
                    <td><?= $data['hasil_prediksi'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header d-flex justify-content-between shadow" id="headingTwo">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Exponential Smoothing
          </button>
        </h2>
        <a href="export_es" class="btn btn-primary" target="_blank"><i class="bi bi-download"></i> Export</a>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable1">
              <thead>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Nilai Alpha</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Tgl Hitung</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Nilai Alpha</th>
                  <th class="text-center">Variabel Dependen</th>
                  <th class="text-center">Hasil Prediksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_hasil_es as $data) { ?>
                  <tr>
                    <td><?php $created_at = date_create($data["created_at"]);
                        echo date_format($created_at, "d M Y - h:i a"); ?></td>
                    <td><?= $data['periode'] ?></td>
                    <td><?= $data['nilai_alpha'] ?></td>
                    <td><?= $data['var_dependen'] ?></td>
                    <td><?= $data['hasil_prediksi'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>