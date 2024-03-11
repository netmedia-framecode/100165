<?php
$conn = mysqli_connect("localhost", "root", "", "prediksi_pertumbuhan_penduduk");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
