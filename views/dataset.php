<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Dataset";
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
          <input type="hidden" name="id_variabel" value="60">
          <div class="card-body">
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
              <label for="jumlah">Data Migrasi</label>
              <input type="number" name="jumlah" class="form-control" id="jumlah" min="1" required>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" name="add_dataset" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun</th>
                  <th>Jumlah Penduduk</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Tahun</th>
                  <th>Jumlah Penduduk</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php $no = 1;
                foreach ($views_dataset as $data) { ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $data['periode'] ?></td>
                    <td><?= $data['jumlah'] ?></td>
                    <td><?= $data['nama_variabel'] ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_dataset'] ?>">
                        <i class="bi bi-pencil-square"></i> Ubah
                      </button>
                      <div class="modal fade" id="ubah<?= $data['id_dataset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="exampleModalLabel">Ubah periode <?= $data['periode'] ?></h5>
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
                                  <label for="jumlah">Data Migrasi</label>
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
                                <p>Jika anda yakin ingin menghapus periode <?= $data['periode'] ?>, klik Hapus!</p>
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
                <?php $no++;
                } ?>
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