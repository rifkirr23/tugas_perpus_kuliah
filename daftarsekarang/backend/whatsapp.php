<?php

$curl_handle=curl_init();
curl_setopt($curl_handle,CURLOPT_URL,"https://wilopocargo.com/daftarsekarang?utm_source=dm&utm_medium=landingpage1&utm_campaign=wasticky".$eid);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "");
$curlemail = curl_exec($curl_handle);
curl_close($curl_handle);

?>
