<?php require_once("redirect.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php require_once("../sections/views_head.php") ?>

</head>

<body id="page-top">
  <?php foreach ($messageTypes as $type) {
    if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["message_$type"])) {
      echo "<div class='message-$type' data-message-$type='{$_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["message_$type"]}'></div>";
    }
  } ?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("../sections/views_sidebar.php") ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once("../sections/views_topbar.php") ?>
        <!-- End of Topbar -->
