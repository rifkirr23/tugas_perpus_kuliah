<?php
  session_start();
  ini_set('display_errors', 1);
  require('db.php');

  $querysales = $mysqli -> query("SELECT * from pengguna where level = 'saleso' and status_sales = 1")
  or die(mysqli_error());//print_r($querysales);die();
  while($data = $querysales->fetch_array()){
    $whatsapp_sales = $data['whatsapp'];
    $nama_sales = $data['nama_pengguna'];
  }


  if(empty($_GET['id'])){
      $kodecampaign = 'C08';
  }else{
      $kodecampaign = $_GET['id'];
  }
  // print_r($kodecampaign);die();
  // if($_GET['kode_campaign'] == "c01"){
    // die("oke");
    $query_campaign = $mysqli -> query("SELECT * from campaign where kode_campaign ='$kodecampaign'")
    or die(mysqli_error());
    while($data_campaign = $query_campaign->fetch_array()){
      $pesanredirect  = "(".$kodecampaign.") Hai ".$nama_sales." ".$data_campaign['chat_campaign'];
    }
    $query_sales_aktif = $mysqli -> query("SELECT * from pengguna where level ='saleso' and status = 1")
    or die(mysqli_error());
    while($data_sales_aktif = $query_sales_aktif->fetch_array()){
      $id_sales_update = 0;
      $status_sales_update=0;
      $status_sales_aktif=0;
      $status_sales_aktif = $data_sales_aktif['status_sales'];
      if($status_sales_aktif == 1){
        $status_sales_update = 3;
      }else{
        $status_sales_update = $status_sales_aktif - 1;
      }
      $id_sales_update    = $data_sales_aktif['id_pengguna'];
      $update = $mysqli -> query("UPDATE pengguna SET status_sales='$status_sales_update' where id_pengguna='$id_sales_update'");
    }
    sleep(2);
    // print_r($whatsapp_sales);die("ok");
    // if($update){
        header("location:https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect");
    // }

 ?>
