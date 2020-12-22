<?php
$tes="curl";
$curl_handle=curl_init();
curl_setopt($curl_handle,CURLOPT_URL,"https://wilopocargo.com/backend/kelas_impor/save.php");
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "nama_lengkap=$tes&customer_email=$tes&customer_phone=$tes");
$curlemail = curl_exec($curl_handle);
curl_close($curl_handle);


 ?>
