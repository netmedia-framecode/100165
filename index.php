<?php require_once("controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] = "Beranda";
require_once("templates/top.php");
?>

<section class="slider_section">
  <div id="customCarousel1" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="container ">
          <div class="row">
            <div class="col-md-10 mx-auto">
              <div class="detail-box">
                <h1>
                  KABUPATEN BELU<br>
                  Kecamatan Tasifeto Barat
                </h1>
                <p class="text-light">System ini bertujuan untuk pengimplementasian metode regresi linier dan metode single exponential smoothing untuk memprediksi jumlah penduduk di kecamatan Tasifeto Barat.</p>
                <div class="btn-box">
                  <a href="prediksi" class="btn1">
                    Prediksi
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
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
            $num_char = 350;
            $text = trim($data['deskripsi']);
            $text = preg_replace('#</?strong.*?>#is', '', $text);
            $lentext = strlen($text);
            if ($lentext > $num_char) {
              echo substr($text, 0, $num_char) . '...';
            } else if ($lentext <= $num_char) {
              echo substr($text, 0, $num_char);
            }
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

<section class="why_us_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Prediksi
      </h2>
    </div>
    <div class="why_us_container">
      <div class="box">
        <div class="img-box">
          <img src="assets/img/grafik.png" alt="">
        </div>
        <div class="detail-box">
          <h5>
            Regresi Linear
          </h5>
          <p>
            Regresi linier adalah sebuah metode statistik yang digunakan untuk menganalisis hubungan antara dua atau lebih variabel, di mana salah satu variabel digunakan untuk memprediksi variabel lain. Dalam regresi linier, kita mencoba membuat prediksi atau mengukur bagaimana satu hal dipengaruhi oleh yang lain. Pertama, kita memiliki variabel dependen (Y) yang merupakan hal yang ingin kita pahami atau prediksi. Kemudian, kita memiliki variabel independen (X), yang kita pikir mungkin mempengaruhi variabel dependen. Dalam penelitian ini, digunakan regresi liier berganda karena terdapat lebih dari satu buah variabel independen. Dataset penelitian terdiri atas satu variabel dependen (Y) dan dua variabel independen (X). Variabel dependen tersebut adalah atribut jumlah penduduk.
          </p>
        </div>
      </div>
      <div class="box">
        <div class="img-box">
          <img src="assets/img/grafik.png" alt="">
        </div>
        <div class="detail-box">
          <h5>
            Single Exponential Smoothing
          </h5>
          <p>
            Metode single exponential smoothing merupakan metode peramalan yang digunakan untuk meramalkan masa yang akan datang dengan melakukan proses pemulusan (smoothing) dengan menghasilkan data ramalan yang lebih kecil nilai kesalahannya. Metode ini banyak digunakan dalam peramalan, perencanaan persediaan, dan manajemen rantai pasokan untuk membuat estimasi yang lebih baik tentang masa depan berdasarkan data historis. Dalam perhitungan kali ini, peneliti menggunakan metode single exponential smoothing, yang mana data dianggap tidak stabil karena mengalami penurunan dan kenaikan di sekitar nilai mean (nilai rata-rata) yang tetap atau stabil. Penggunaan metode single exponential smoothing dalam memprediksi jumlah penduduk sangat tergantung pada karakteristik data dan tujuan prediksi yang diinginkan.
          </p>
        </div>
      </div>
    </div>
    <div class="btn-box">
      <a href="prediksi">
        Lihat Prediksi
      </a>
    </div>
  </div>
</section>

<?php require_once("templates/bottom.php") ?>