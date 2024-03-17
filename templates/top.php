<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <?php require_once("sections/head.php") ?>

</head>

<body id="top" <?php if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'])) {
                  if ($_SESSION["project_prediksi_pertumbuhan_penduduk"]['name_page'] != "Beranda") {
                    echo 'class="sub_page"';
                  }
                } ?>>
  <?php foreach ($messageTypes as $type) {
    if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["message_$type"])) {
      echo "<div class='message-$type' data-message-$type='{$_SESSION["project_prediksi_pertumbuhan_penduduk"]["message_$type"]}'></div>";
    }
  } ?>

  <div class="hero_area">
    <!-- header section strats -->
    <?php require_once("sections/nav.php") ?>
    <!-- end header section -->