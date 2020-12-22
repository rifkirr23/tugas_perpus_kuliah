<?php
session_start();
ini_set('display_errors', 1);
$condensed = Chr(27) . Chr(33) . Chr(4);
$bold1 = Chr(27) . Chr(69);
$bold0 = Chr(27) . Chr(70);
$italic1 = chr(27) . chr(52);
$italic0 = chr(27) . chr(53);
$tb=chr(9);
$ln=chr(10);
$ff=chr(12);
$rj=chr(27).chr(97).chr(0);
$rj=chr(27).chr(97).chr(2);
$initialized = chr(27).chr(64);
$condensed1 = chr(15);
$condensed0 = chr(18);
$Data  = $initialized;

//Select Database
include("db.php");
//$sql_ambil_id = mysql_query("SELECT nilai FROM umum WHERE nama = 'printsjglobal'")or die(mysql_error());
//$row_ambil_id = mysql_fetch_array($sql_ambil_id);
//$id_cont = $row_ambil_id['nilai'];
$idsj = $_GET['idsj'];
$sql_printglobal = $mysqli -> query("SELECT DISTINCT(invoice_product.id_sj_wc) AS id FROM invoice_product
                                LEFT JOIN sj_wc ON invoice_product.id_sj_wc = sj_wc.id_sj
                                WHERE sj_wc.id_sj = '$idsj'")
                   or die(mysqli_error());
//var_dump($sql_printglobal);
while ($row_printglobal = $sql_printglobal->fetch_array()){
$id = $row_printglobal['id'];//print_r($id);die();
$sql_surat_jalan_detail = $mysqli -> query("SELECT sj_wc.*, container.kode,posisi_indo.tempat,
                                       customer.kode AS customer_kode, customer.nama AS customer_name,
                                       customer.telepon AS telepon,mobil.plat_mobil,master_ekspedisi_lokal.nama_ekspedisi,
                                       master_ekspedisi_lokal.alamat as almteks,
                                       master_ekspedisi_lokal.no_telp as notelpeks,master_ekspedisi_lokal.tipe_ekspedisi,
                                       customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
                                       ,kecamatan.nama as namakec,customer.alamat as almtcust,giw.boleh_kirim,customer.ekspedisi_lokal
                                       ,customer.whatsapp as wacs,customer.id_provinsi2,customer.id_kota2
                                       ,customer.id_kec2
                                       FROM sj_wc
                                       LEFT JOIN mobil ON sj_wc.id_mobil = mobil.id_mobil
                                       LEFT JOIN customer ON customer.id_cust = sj_wc.id_cust
                                       left join provinsi on customer.id_provinsi=provinsi.id_prov
    																	 left join kabupaten on customer.id_kota=kabupaten.id_kab
 																		   left join kecamatan on customer.id_kec=kecamatan.id_kec
                                       LEFT JOIN master_ekspedisi_lokal ON customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi
                                       LEFT JOIN invoice_product ON invoice_product.id_sj_wc = sj_wc.id_sj
                                       LEFT JOIN posisi_indo on invoice_product.posisi_indo=posisi_indo.id_posisi_indo
                                       left join giw on giw.id = invoice_product.id_giw
                                       left join container on container.id_rts = giw.container_id
                                       WHERE sj_wc.id_sj = '$id' group by sj_wc.id_sj")
                           or die(mysqli_error());

while($row_surat_jalan_detail = $sql_surat_jalan_detail->fetch_array()){
// print_r($row_surat_jalan_detail);die();

  // if(substr($row_surat_jalan_detail['kode'],3,1) == '-'){
  // 	$kode=substr($row_surat_jalan_detail['kode'],0,3);
  // }elseif(substr($row_surat_jalan_detail['kode'],7,1) == '-'){
  // 	$kode=substr($row_surat_jalan_detail['kode'],0,7);
  // }else{
  //     $kode=substr($row_surat_jalan_detail['kode'],0,4);
  // }

  $sql_surat_jalan_list = $mysqli -> query("SELECT invoice_product.*, giw.*, resi.nomor AS nomorresi,posisi_indo.tempat
                                       FROM invoice_product
                                       left join giw on giw.id = invoice_product.id_giw
                                       LEFT JOIN resi ON resi.id_resi = giw.resi_id
                                       left join posisi_indo on posisi_indo.id_posisi_indo = invoice_product.posisi_indo
                                       WHERE invoice_product.id_sj_wc = '$id' ORDER BY nomorresi, giw.id ASC")or die(mysql_error());

                                       // print_r($sql_surat_jalan_list);die();

  //Invoice Title
  $Data .= "                                  ".$bold1."SURAT JALAN\n";

  $Data .= $condensed1;
  //Header RTS
  $Data .= str_repeat($tb,14)."Jakarta, ".date("d M Y",strtotime($row_surat_jalan_detail['tanggal_kirim']))."\n";
  // $Data .= str_repeat($tb,14)."Kode : ".$kode."\n";
  $Data .= "Kepada Yth :\n";
  $Data .= $bold1.$row_surat_jalan_detail['customer_kode']." (".$row_surat_jalan_detail['customer_name'].")".$bold0."\n\nAlamat :\n";

  if($row_surat_jalan_detail['id_ekspedisi'] >= 8 ){
    $idp2 = $row_surat_jalan_detail['id_provinsi2'];
    $idk2 = $row_surat_jalan_detail['id_kota2'];
    $idkc2 = $row_surat_jalan_detail['id_kec2'];
    $provinsiekspe = $mysqli -> query("SELECT provinsi.nama FROM provinsi WHERE provinsi.id_prov = $idp2 ")or die(mysql_error());
    $kotaekspe = $mysqli -> query("SELECT kabupaten.nama FROM kabupaten WHERE kabupaten.id_kab = $idk2 ")or die(mysql_error());
    $kecekspe = $mysqli -> query("SELECT kecamatan.nama FROM kecamatan WHERE kecamatan.id_kec = $idkc2 ")or die(mysql_error());
    while($proveks = $provinsiekspe->fetch_array()){
      $provinsiekspedisi = $proveks['nama'];
    }
    while($kotaeks = $kotaekspe->fetch_array()){
      $kotaekspedisi = $kotaeks['nama'];
    }
    while($keceks = $kecekspe->fetch_array()){
      $kecekspedisi = $keceks['nama'];
    }
    $Data .= $bold1."(".$row_surat_jalan_detail['tipe_ekspedisi'].")"." Ekspedisi : ".$row_surat_jalan_detail['nama_ekspedisi']." ,".$provinsiekspedisi." , ".$kotaekspedisi." , ".$kecekspedisi.
             " , ".$row_surat_jalan_detail['almteks'].
             " , Tel: ".$row_surat_jalan_detail['notelpeks'].
             "\nAlamat CS: ".$row_surat_jalan_detail['namaprov']." , ".$row_surat_jalan_detail['namakota']." , ".$row_surat_jalan_detail['namakec']." , ".
              $row_surat_jalan_detail['almtcust'].
              " , Tel: ".$row_surat_jalan_detail['telepon']." , WA: ".$row_surat_jalan_detail['wacs'].
             $bold0."\n";
    // "<br /><br /> Alamat : ".$row_surat_jalan_detail['almtcust']." , ".$row_surat_jalan_detail['namaprov']." , ".$row_surat_jalan_detail['namakota']." , ".$row_surat_jalan_detail['namakec'].
    // " <br /><br /> No. Telp : ".$row_surat_jalan_detail['telepon']."<br /> WA : ".$row_surat_jalan_detail['wacs'];
  }else{
    $Data .= $bold1."(".$row_surat_jalan_detail['tipe_ekspedisi'].")".$row_surat_jalan_detail['namaprov']." , ".$row_surat_jalan_detail['namakota']." , ".$row_surat_jalan_detail['namakec']." , ".
             $row_surat_jalan_detail['almtcust'].
             " , Tel: ".$row_surat_jalan_detail['telepon']." , WA: ".$row_surat_jalan_detail['wacs'].

             $bold0."\n";
    // echo "<b> Alamat : ".$row_surat_jalan_detail['namaprov']." , ".$row_surat_jalan_detail['namakota']." , ".$row_surat_jalan_detail['namakec']."</b> <br /><br />".$row_surat_jalan_detail['almtcust'].
    // " <br /><br /> No. Telp : ".$row_surat_jalan_detail['telpcs']."<br /> WA : ".$row_surat_jalan_detail['wacs'];
  }
  $Data .= $bold1."Surat Jalan No : ".$row_surat_jalan_detail['kode_sj'].str_repeat($tb,2)."Nomor Mobil : ".$row_surat_jalan_detail['plat_mobil']."\n";


  //Header Item GIW
  $Data .= str_repeat("=",137)."\n";
  $Data .= str_repeat(" ",9)."Resi".str_repeat(" ",9)."|".str_repeat(" ",7)."Barcode".str_repeat(" ",7)."|".str_repeat(" ",8)."CTNS".str_repeat(" ",8)."|".str_repeat(" ",8)."Qty".
  str_repeat(" ",8)."|".str_repeat(" ",7)."Kubikasi".str_repeat(" ",7)."|".str_repeat(" ",10)."Remarks\n";
  $Data .= str_repeat("=",137)."\n";
  $ctns = array(); $qty = array(); $volume = array();
  while ($row_surat_jalan_list = $sql_surat_jalan_list->fetch_array()) {
      if($row_surat_jalan_list['tempat'] == "Container"){
        $kode = "X";
      }else{
        $kode=$row_surat_jalan_list['tempat'];
      }
      //Resi
      @$sp = 20-strlen($row_surat_jalan_list['nomorresi']);
      $Data .= " ".$row_surat_jalan_list['nomorresi'].str_repeat(" ",@$sp)." |";

      //Barcode
      @$sp = 19-strlen($row_surat_jalan_list['nomor']);
      $Data .= " ".$row_surat_jalan_list['nomor'].str_repeat(" ",@$sp)." |";

      //CTNS
      @$sp = 18-strlen($row_surat_jalan_list['jumlah']);
      $Data .= " ".str_repeat(" ",@$sp).$row_surat_jalan_list['jumlah']." |";
      $ctns[] = $row_surat_jalan_list['jumlah'];

      //Qty
      @$sp = 17-strlen($row_surat_jalan_list['qty']*$row_surat_jalan_list['jumlah']);
      $Data .= " ".str_repeat(" ",@$sp).$row_surat_jalan_list['qty']*$row_surat_jalan_list['jumlah']." |";
      $qty[] = $row_surat_jalan_list['qty']*$row_surat_jalan_list['jumlah'];

      //Volume
      @$sp = 20-strlen($row_surat_jalan_list['volume']*$row_surat_jalan_list['jumlah']);
      $Data .= " ".str_repeat(" ",@$sp).$row_surat_jalan_list['volume']*$row_surat_jalan_list['jumlah']." |";
      $volume[] = $row_surat_jalan_list['volume']*$row_surat_jalan_list['jumlah'];

      //Remarks
      @$sp = 20-strlen($row_surat_jalan_list['remarks']);
      $Data .= " ".str_repeat(" ",@$sp).$row_surat_jalan_list['remarks']." (".$kode.")"."\n";

      //Seperator Per Item GIW
      $Data .= str_repeat("=",137)."\n";
  }

  //Total
  $Data .= str_repeat(" ",38).$bold1."TOTAL ".$bold0."|".$bold1;
  //Total CTNS
  @$sp = 18-strlen(array_sum($ctns));
  $Data .= " ".str_repeat(" ",@$sp).array_sum($ctns)." |";
  //Total Qty
  @$sp = 17-strlen(array_sum($qty));
  $Data .= " ".str_repeat(" ",@$sp).array_sum($qty)." |";
  //Total Volume
  @$sp = 20-strlen(array_sum($volume));
  $Data .= " ".str_repeat(" ",@$sp).array_sum($volume)." |";
  $Data .= "\n".str_repeat("=",137)."\n";

  //Footer
  $Data .= $bold1.str_repeat(" ",13)."Hormat Kami,".str_repeat(" ",35)."Bagian Gudang,".str_repeat(" ",35)."Tanda Terima,\n\n\n\n\n\n".$bold0."RKP-1:ASLI ; RKP-2:COPY ; RKP-3:ARSIP\n\n";

  $Data .= $bold1."Kita tidak bertanggung jawab, apabila:\n";
  $Data .= $bold1."   -Barang dalam kondisi sobek / lakban ulang tidak diperiksa bersama pihak kami.\n";
  $Data .= $bold1."   -Barang dalam kondisi basah / lembab tidak diperiksa bersama pihak kami.\n";
  $Data .= $bold1."   -Packing list (Ukuran dus & Kubikasi) berbeda dengan yang tertera disurat jalan.\n";
  $Data .= $bold1."   -Barang masih dalam kondisi Packing original namun ada perbedaan Qty (isi dalam) barang.\n";

  $Data .= "\f";
  $Data .= $condensed0;

}
}


echo $Data;
?>
