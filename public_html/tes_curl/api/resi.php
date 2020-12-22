<?php

$koneksi = @mysql_connect("localhost","wilopoca_office","wilopoca2019");
mysql_select_db("wilopoca_rts_ekpedisi",$koneksi);

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}else{
   // echo "Sukses Koneksi";
}

    $id=$_GET['id'];
    $dresi = mysql_query("select r.id,r.tanggal,r.supplier,r.tel,r.note,c.kode
													from resi r
		 											JOIN customer c ON (r.cust_id=c.id)
													where r.id='$id'");
    while($row_resi = mysql_fetch_array($dresi)){

        $json[]=array(
           "id"=>$row_resi["id"],
           "tanggal"=>$row_resi["tanggal"],
					 "supplier"=>$row_resi["supplier"],
					 "tel"=>$row_resi["tel"],
					 "note"=>$row_resi["note"],
					 "kode"=>$row_resi["kode"]
        );
    }

    echo json_encode($json);

?>
