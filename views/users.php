<?php require_once("../controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Users";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Email</th>
              <th class="text-center">Status</th>
              <th class="text-center">Role</th>
              <th class="text-center" style="width: 200px;">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Email</th>
              <th class="text-center">Status</th>
              <th class="text-center">Role</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $no = 1;
            foreach ($views_users as $data) { ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['email'] ?></td>
                <td><?= $data['status'] ?></td>
                <td><?= $data['role'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_user'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_user'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['name'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="id_active">Status</label>
                              <select name="id_active" class="form-control" id="id_active" required>
                                <option value="" selected>Pilih Status</option>
                                <?php $id_status = $data['id_active'];
                                foreach ($views_user_status as $data_select_status) {
                                  $selected = ($data_select_status['id_status'] == $id_status) ? 'selected' : ''; ?>
                                  <option value="<?= $data_select_status['id_status'] ?>" <?= $selected ?>><?= $data_select_status['status'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="id_role">Role</label>
                              <select name="id_role" class="form-control" id="id_role" required>
                                <option value="" selected>Pilih Role</option>
                                <?php $id_role = $data['id_role'];
                                foreach ($views_user_role as $data_select_role) {
                                  $selected = ($data_select_role['id_role'] == $id_role) ? 'selected' : ''; ?>
                                  <option value="<?= $data_select_role['id_role'] ?>" <?= $selected ?>><?= $data_select_role['role'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_users" class="btn btn-warning btn-sm">Ubah</button>
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
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>
