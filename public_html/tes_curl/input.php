<?php 
//contoh resi id lebih 3075 , contoh id resi no asuransi 5364
$koneksi = @mysql_connect("localhost","wilopoca_office","wilopoca2019");
mysql_select_db("wilopoca_rts_ekpedisi",$koneksi);

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}else{
   // echo "Sukses Koneksi";
}
    
    $id=$_GET['id'];
    
    $update = mysql_query("UPDATE resi SET asuransi=1 WHERE id=$id");
?>