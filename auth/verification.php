<?php require_once("../controller/script.php");
if (isset($_SESSION["data_auth"]["en_user"])) {
  $enValue = $_GET["en"];
  $checkEN = "SELECT * FROM users WHERE en_user='$enValue'";
  $checkEN = mysqli_query($conn, $checkEN);
  if (mysqli_num_rows($checkEN) == 0) {
    $_SESSION["project_prediksi_pertumbuhan_penduduk"] = [
      "message-warning" => "Maaf, sepertinya ada kesalahan saat mendaftar.",
      "time-message" => time()
    ];
    header("Location: register");
    exit;
  } else if (mysqli_num_rows($checkEN) > 0) {
    if (!isset($_SESSION["en"]) || $_SESSION["en"] !== $enValue) {
      $_SESSION["en"] = $enValue;
      unset($_SESSION["countdown_started"]);
    }
  }
}
$_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"] = "Verifikasi";
require_once("../templates/auth_top.php");
?>

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <?php foreach ($views_auth as $data) { ?>
            <div class="col-lg-6 d-none d-lg-block" style="background: url('../assets/img/auth/<?= $data['image'] ?>'); background-position: center; background-size: cover;"></div>
          <?php } ?>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Verifikasi akun Anda?</h1>
                <p class="mb-4">Masukan kode token yang kami kirim di email untuk memverifikasi akun disini!</p>
              </div>
              <form method="post">
                <div class="form-group">
                  <input type="hidden" name="en_user" value="<?= $_GET["en"] ?>">
                  <input type="number" name="token" class="form-control form-control-user" id="token" placeholder="Token" required>
                </div>
                <button type="submit" name="verifikasi" class="btn btn-primary btn-user btn-block">
                  Verifikasi
                </button>
              </form>
              <p id="countdown" class="text-center text-dark mt-4"></p>
              <form id="data-message" style="display:none;" class="mt-4" method="post">
                <input type="hidden" name="en_user" value="<?= $_GET["en"] ?>">
                <span id="message" class="text-center text-danger"></span>
                <button type="submit" name="re_verifikasi" class="btn btn-link m-0 p-0 text-danger">Kirim ulang token</button>
              </form>
              <script>
                // Fungsi untuk mengirim permintaan Ajax ke server PHP untuk memperbarui sesi
                function updateSession() {
                  var xhr = new XMLHttpRequest();
                  xhr.open("GET", "verify_session.php", true);
                  xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                      var response = JSON.parse(xhr.responseText);
                      if (response.message) {
                        document.getElementById("message").textContent = response.message;
                        document.getElementById("data-message").style.display = "block";
                      }
                    }
                  };
                  xhr.send();
                }

                // Fungsi untuk menghitung mundur
                function startCountdown(duration, display) {
                  var timer = duration,
                    minutes, seconds;

                  function updateTimer() {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = "Waktu untuk verifikasi " + minutes + ":" + seconds;

                    if (--timer < 0) {
                      clearInterval(intervalId); // Hentikan interval setelah waktu hitung mundur selesai
                      updateSession(); // Panggil fungsi untuk memperbarui sesi PHP

                      // Sembunyikan elemen dengan ID "countdown"
                      display.style.display = "none";
                    }
                  }

                  // Periksa apakah waktu hitung mundur sudah dimulai di sesi
                  var sessionStarted = <?php echo isset($_SESSION['countdown_started']) ? 'true' : 'false'; ?>;

                  if (!sessionStarted) {
                    // Jika belum dimulai, mulai waktu hitung mundur
                    updateTimer();
                    var intervalId = setInterval(updateTimer, 1000);

                    // Tandai bahwa waktu hitung mundur telah dimulai di sesi
                    <?php $_SESSION['countdown_started'] = true; ?>
                  }
                }

                document.addEventListener("DOMContentLoaded", function() {
                  var oneMinute = 60 * 5, // satu menit
                    display = document.getElementById("countdown");
                  startCountdown(oneMinute, display);
                });
              </script>
              <hr>
              <div class="text-center">
                <a class="small" href="register">Buat sebuah akun!</a>
              </div>
              <div class="text-center">
                <a class="small" href="./">Sudah memiliki akun? Masuk!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<?php require_once("../templates/auth_bottom.php") ?>
