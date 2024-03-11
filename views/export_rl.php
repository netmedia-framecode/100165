<?php

require_once __DIR__ . '/../assets/vendor/autoload.php';
require_once "../controller/script.php";

$hasil_rl = "SELECT * FROM hasil_rl ORDER BY periode ASC";
$views_hasil_rl = mysqli_query($conn, $hasil_rl);

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h2>Regression Linear</h2>
<p>Hasil prediksi menggunakan perhitungan Regression Linear</p>
<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
  }
</style>
<table class="table table-bordered text-dark" id="dataTable">
  <thead>
    <tr>
      <th>Tgl Hitung</th>
      <th>Periode</th>
      <th>Jumlah Migrasi</th>
      <th>Variabel Independen</th>
      <th>Variabel Dependen</th>
      <th>Hasil Prediksi</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>Tgl Hitung</th>
      <th>Periode</th>
      <th>Jumlah Migrasi</th>
      <th>Variabel Independen</th>
      <th>Variabel Dependen</th>
      <th>Hasil Prediksi</th>
    </tr>
  </tfoot>
  <tbody>
');
foreach ($views_hasil_rl as $data) {
  $created_at = date_create($data["created_at"]);
  $tgl_hitung = date_format($created_at, "d M Y - h:i a");
  $mpdf->WriteHTML('<tr>
      <td>' . $tgl_hitung . '</td>
      <td>' . $data['periode'] . '</td>
      <td>' . $data['jumlah_migrasi'] . '</td>
      <td>' . $data['var_independen'] . '</td>
      <td>' . $data['var_dependen'] . '</td>
      <td>' . $data['hasil_prediksi'] . '</td>
    </tr>
');
}
$mpdf->WriteHTML('</tbody>
</table>
');
$mpdf->Output();
