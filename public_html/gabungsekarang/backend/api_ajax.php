<?php
require('db.php');
$id_jenis_barang = $_POST['id_jenis_barang'];
$volumeperctns   = ($_POST['tinggi'] * $_POST['panjang'] * $_POST['lebar']) / 1000000;
$beratperctns    = $_POST['berat'];
$ctns            = $_POST['ctns'];
$rmb            = $_POST['rmb'];
$sql_jenis_barang = mysql_query("SELECT * FROM jenis_barang where id = $id_jenis_barang ")or die(mysql_error());
while($row_jenis_barang = mysql_fetch_array($sql_jenis_barang)) {
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
$curl_handle=curl_init();
curl_setopt($curl_handle,CURLOPT_URL,"https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_medium=landingpage2&utm_campaign=hitungbox".$eid);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "");
$curlemail = curl_exec($curl_handle);
curl_close($curl_handle);
 ?>
