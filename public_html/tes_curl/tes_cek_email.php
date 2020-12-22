<?php
$koneksi = @mysql_connect("localhost","wilopoca_office","wilopoca2019");
mysql_select_db("wilopoca_rts_ekpedisi",$koneksi);

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}else{
   // echo "Sukses Koneksi";
}

$query_sales_aktif = $mysqli -> query("SELECT * from pengguna where level ='sales' and status = 1")
or die(mysqli_error());
while($data_sales_aktif = $query_sales_aktif->fetch_array()){
  $status_sales_aktif = $data_sales_aktif['status_sales'];
  if($status_sales_aktif == 1){
    $status_sales_update = 4;
  }else{
    $status_sales_update = $status_sales_aktif - 1;
  }
  $id_sales_update    = $data_sales_aktif['id_pengguna'];
  $update = $mysqli -> query("UPDATE pengguna SET status_sales='$status_sales_update' where id_sales='$id_sales_update'")
            or die(mysqli_error());
}
 ?>
