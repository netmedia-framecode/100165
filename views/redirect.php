<?php
if (!isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"])) {
  header("Location: ../auth/");
  exit;
}
