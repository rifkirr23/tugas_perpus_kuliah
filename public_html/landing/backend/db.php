<?php

$koneksi = @mysql_connect("localhost","wilopoca_office","wilopoca2019");
mysql_select_db("wilopoca_office",$koneksi);

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}else{
   // echo "Sukses Koneksi";
}

?>
