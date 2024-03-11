<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Dataset";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Periode</th>
              <th class="text-center">Nama Variabel</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Periode</th>
              <th class="text-center">Nama Variabel</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_dataset as $data) { ?>
              <tr>
                <td><?= $data['periode'] ?></td>
                <td><?= $data['nama_variabel'] ?></td>
                <td><?= $data['jumlah'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_dataset'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_dataset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['periode'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_dataset" value="<?= $data['id_dataset'] ?>">
                          <input type="hidden" name="periode" value="<?= $data['periode'] ?>">
                          <input type="hidden" name="nama_variabel" value="<?= $data['nama_variabel'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="jumlah">Jumlah</label>
                              <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" class="form-control" id="jumlah" min="1" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_dataset" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_dataset'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_dataset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_dataset" value="<?= $data['id_dataset'] ?>">
                          <input type="hidden" name="periode" value="<?= $data['periode'] ?>">
                          <input type="hidden" name="nama_variabel" value="<?= $data['nama_variabel'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus periode <?= $data['periode'] ?> dengan nama variabel <?= $data['nama_variabel'] ?>, klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_dataset" class="btn btn-danger btn-sm">hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Dataset</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="id_periode">Periode</label>
              <select name="id_periode" class="form-control" id="id_periode" required>
                <option value="" selected>Pilih Periode</option>
                <?php foreach ($views_periode as $data_select_periode) { ?>
                  <option value="<?= $data_select_periode['id_periode'] ?>"><?= $data_select_periode['periode'] ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label for="id_variabel">Variabel</label>
              <select name="id_variabel" class="form-control" id="id_variabel" required>
                <option value="" selected>Pilih Variabel</option>
                <?php foreach ($views_variabel as $data_select_variabel) { ?>
                  <option value="<?= $data_select_variabel['id_variabel'] ?>"><?= $data_select_variabel['nama_variabel'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="jumlah">Jumlah</label>
              <input type="number" name="jumlah" class="form-control" id="jumlah" min="1" required>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_dataset" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>