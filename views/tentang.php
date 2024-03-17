<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Tentang";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-body">
          <?php foreach ($views_tentang as $data) { ?>
            <form action="" method="post">
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"><?= $data['deskripsi'] ?></textarea>
              </div>
              <button type="submit" name="edit_tentang" class="btn btn-warning">Edit</button>
            </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>