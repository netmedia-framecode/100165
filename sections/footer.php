<footer class="footer_section">
  <div class="container">
    <p>Copyright &copy; <a href="https://wasd.netmedia-framecode.com" class="text-decoration-none">WASD Netmedia Framecode</a> <?= date('Y') ?> | Develop by <a href="https://pddikti.kemdikbud.go.id/data_mahasiswa/MENGRTQxQzctNTU4Ri00MTdGLUExQTAtQzM1MzI2MDhDMTZB" target="_blank">Nathalina Dasilva</a></p>
  </div>
</footer>
<!-- footer section -->

<!-- jQery -->
<script src="<?= $baseURL ?>assets/js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<!-- bootstrap js -->
<script src="<?= $baseURL ?>assets/js/bootstrap.js"></script>
<!-- owl slider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!--  OwlCarousel 2 - Filter -->
<script src="https://huynhhuynh.github.io/owlcarousel2-filter/dist/owlcarousel2-filter.min.js"></script>
<!-- custom js -->
<script src="<?= $baseURL ?>assets/js/custom.js"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
</script>

<script src="<?= $baseURL ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= $baseURL ?>assets/js/demo/chart-area-demo.js"></script>

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