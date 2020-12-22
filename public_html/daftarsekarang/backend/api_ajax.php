<?php
require('db.php');
$id_jenis_barang = $_POST['id_jenis_barang'];
$volumeperctns   = ($_POST['tinggi'] * $_POST['panjang'] * $_POST['lebar']) / 1000000;
$beratperctns    = $_POST['berat'];
$ctns            = $_POST['ctns'];
$rmb            = $_POST['rmb'];
$sql_jenis_barang = $mysqli -> query("SELECT * FROM jenis_barang where id = $id_jenis_barang ")
  or die(mysqli_error());
while($row_jenis_barang = mysqli_fetch_array($sql_jenis_barang)) {
  $volume          = $ctns * $volumeperctns;
  $berat           = $ctns * $beratperctns;
  $hargafix        = ($ctns * $volumeperctns) * $row_jenis_barang['harga'];
  if ($berat/$volume > 600){
    $weight_new = ((($berat/$volume) - 600) / 2000) * $volume;
    $volume_new = $volume + $weight_new;
    $hargafix   = $volume_new * $row_jenis_barang['harga'];
  }
  $callback = array('hasil' => $hargafix);
  echo json_encode($callback);
}
// konversi varibael $callback menjadi JSON
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://wilopocargo.com/daftarsekarang?utm_source=dm&utm_medium=landingpage1&utm_campaign=hitungbox"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);
curl_close($ch);
 ?>
