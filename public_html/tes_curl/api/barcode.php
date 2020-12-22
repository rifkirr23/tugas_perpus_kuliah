<?php

$koneksi = @mysql_connect("localhost","wilopoca_office","wilopoca2019");
mysql_select_db("wilopoca_rts_ekpedisi",$koneksi);

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}else{
   // echo "Sukses Koneksi";
}
    header("Access-Control-Allow-Origin: *");

    $id=$_GET['id'];
    $dresi = mysql_query("select r.id,r.nomor,r.resi_id,r.barang,r.jenis_barang_id,r.ctns,r.qty,r.berat,
												  r.volume,r.nilai,r.status,r.note,r.kurs,r.remarks,r.harga
													from giw r
		 											JOIN resi c ON (r.resi_id=c.id)
													where r.id='5364'");
    while($row_resi = mysql_fetch_array($dresi)){

        $json[]=array(
           "id"=>$row_resi["id"],
           "barang"=>$row_resi["barang"],
					 "jenis_barang_id"=>$row_resi["jenis_barang_id"],
					 "ctns"=>$row_resi["ctns"],
					 "qty"=>$row_resi["qty"],
					 "berat"=>$row_resi["berat"],
					 "volume"=>$row_resi["volume"],
					 "nilai"=>$row_resi["nilai"],
					 "status"=>$row_resi["status"],
					 "note"=>$row_resi["note"],
					 "kurs"=>$row_resi["kurs"],
					 "remarks"=>$row_resi["remarks"],
					 "harga"=>$row_resi["harga"],
        );
    }

    echo json_encode($json);

?>
