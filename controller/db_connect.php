<?php
$conn = mysqli_connect("localhost", "root", "Netmedia040700_", "prediksi_pertumbuhan_penduduk");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
