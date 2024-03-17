<?php require_once("controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] = "Tentang";
require_once("templates/top.php");
?>

</div>

<section class="about_section layout_padding">
  <div class="container  ">
    <div class="row">
      <div class="col-md-6">
        <div class="detail-box">
          <div class="heading_container">
            <h2>
              Tentang
            </h2>
          </div>
          <?php foreach ($views_tentang as $data) {
            echo $data['deskripsi'];
          } ?>
          <a href="tentang">
            Baca Lebih
          </a>
        </div>
      </div>
      <div class="col-md-6 ">
        <div class="img-box">
          <img src="assets/img/IMG-20240314-WA0008.jpg" style="height: 400px;width: 100%; object-fit: cover;" alt="">
        </div>
      </div>

    </div>
  </div>
</section>

<?php require_once("templates/bottom.php") ?>