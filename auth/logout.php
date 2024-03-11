<?php if (!isset($_SESSION)) {
  session_start();
}
require_once("../controller/script.php");
if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"])) {
  unset($_SESSION["project_prediksi_pertumbuhan_penduduk"]);
  header("Location: ./");
  exit();
}
