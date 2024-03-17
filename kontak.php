<?php require_once("controller/script.php");
$_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] = "Tentang";
require_once("templates/top.php");
?>

</div>

<section class="contact_section layout_padding">
  <div class="container-fluid">
    <div class="col-lg-4 col-md-5 offset-md-1">
      <div class="heading_container">
        <h2>
          Kontak
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-5 offset-md-1">
        <div class="form_container">
          <form action="" method="post">
            <div>
              <input type="text" name="nama" placeholder="Nama" />
            </div>
            <div>
              <input type="email" name="email" placeholder="Email" />
            </div>
            <div>
              <input type="number" name="phone" placeholder="Phone" />
            </div>
            <div>
              <input type="text" name="pesan" class="message-box" placeholder="Message" />
            </div>
            <div class="btn_box">
              <button type="submit" name="add_kontak">
                Kirim
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-7 col-md-6 px-0">
        <div class="map_container">
          <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125976.67402192042!2d124.8004138351333!3d-9.208982108558606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2cffa2dcf20762f7%3A0xed54b1c628a14116!2sKec.%20Tasifeto%20Bar.%2C%20Kabupaten%20Belu%2C%20Nusa%20Tenggara%20Tim.!5e1!3m2!1sid!2sid!4v1710702794621!5m2!1sid!2sid"  style="border:0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once("templates/bottom.php") ?>