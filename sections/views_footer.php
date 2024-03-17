<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; <a href="https://wasd.netmedia-framecode.com" class="text-decoration-none">WASD Netmedia Framecode</a> <?= date('Y') ?> | Develop by Nathalina Dasilva</span>
    </div>
  </div>
</footer>

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
      <div class="modal-header border-bottom-0 shadow">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Yakin ingin keluar?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
      <div class="modal-footer justify-content-center border-top-0">
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary btn-sm" style="cursor: pointer;" onclick="window.location.href='../auth/logout.php'">Keluar</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= $baseURL ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= $baseURL ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= $baseURL ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= $baseURL ?>assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= $baseURL ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= $baseURL ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $baseURL ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= $baseURL ?>assets/js/demo/datatables-demo.js"></script>

<!-- Page level custom scripts -->
<script src="<?= $baseURL ?>assets/js/demo/chart-area-demo.js"></script>
<script src="<?= $baseURL ?>assets/js/demo/chart-pie-demo.js"></script>

<script>
  const showMessage = (type, title, message) => {
    if (message) {
      Swal.fire({
        icon: type,
        title: title,
        text: message,
      });
    }
  };

  showMessage("success", "Berhasil Terkirim", $(".message-success").data("message-success"));
  showMessage("info", "For your information", $(".message-info").data("message-info"));
  showMessage("warning", "Peringatan!!", $(".message-warning").data("message-warning"));
  showMessage("error", "Kesalahan", $(".message-danger").data("message-danger"));
</script>

<script>
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });
</script>

<script>
  CKEDITOR.replace('deskripsi');
</script>
