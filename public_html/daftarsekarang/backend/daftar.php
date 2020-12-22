<?php
  // print_r($_POST); die();
  session_start();
  require('db.php');
  $jenis_barang = $_POST['jenis_barang'];
  $nama = $_POST['nama'];
  $whatsapp = $_POST['whatsapp'];
  $email = $_POST['email'];
  $sp_cargo = $_POST['sp_cargo'];
  $sp_supplier = $_POST['sp_supplier'];
  $dihub = $_POST['dihub'];
  $campaign = $_POST['campaign'];
  $tgl = date('Y-m-d H:i:s');

  $querysales = $mysqli -> query("SELECT * from leads order by id_leads desc limit 1")
  or die(mysqli_error());
  while($data = $querysales->fetch_array()){
    // var_dump($data['id_leads']);
    if($data['id_sales'] == Null || $data['id_sales'] == 24 || $data['id_sales'] == 19){
      $id_sales = 22;
    }else if($data['id_sales'] == 22){
      $id_sales = 23;
    }else if($data['id_sales'] == 23){
      $id_sales = 24;
    }

  }
  // die();
  // $row_query_sales = mysql_fetch_array($querysales);
  // mysqli_query("SELECT id_sales from leads order by id_leads desc limit 1");
  // var_dump($querysales);die();
  // die("oke");

$secret_key = "6Ld_u9MUAAAAAECKBIXb5LdX_YIAWJZI1qtR0upH";
// Disini kita akan melakukan komunkasi dengan google recpatcha
// dengan mengirimkan scret key dan hasil dari response recaptcha nya
$verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
$response = json_decode($verify);
if($response->success){
    $input = $mysqli -> query("INSERT INTO leads VALUES (NULL, '$jenis_barang', '$nama', '$whatsapp', '$email', '$sp_cargo', '$sp_supplier', '$dihub' ,'$tgl','$id_sales','$campaign')")
      or die(mysqli_error());
      if($input == true){
        $_SESSION['message'] = "Daftar Sebagai leads Berhasil";
      }else{
        $_SESSION['message'] = "Daftar Gagal";
      }


      header("location:https://wilopocargo.com/terima-kasih/?id".$campaign);
}else{
        header("location:../index.php?message=recaptcha&id=".$campaign."#contactus");
}
 ?>
