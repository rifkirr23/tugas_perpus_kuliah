<?php
  // print_r($_POST); die();
  session_start();
  require('db.php');
  $id_jenis_barang = $_POST['id_jenis_barang'];
  $nama = $_POST['nama'];
  $whatsapp = $_POST['whatsapp'];
  $email = $_POST['email'];
  $alamat = $_POST['alamat'];
  $sp_cargo = $_POST['sp_cargo'];
  $sp_supplier = $_POST['sp_supplier'];

  $input = mysql_query("INSERT INTO leads VALUES (NULL, '$id_jenis_barang', '$nama', '$whatsapp', '$email', '$alamat', '$sp_cargo', '$sp_supplier')") or die(mysql_error());
  if($input == true){
    $_SESSION['message'] = "Daftar Sebagai leads Berhasil";
  }else{
    $_SESSION['message'] = "Daftar Gagal";
  }
  // print_r($_SESSION['message']);die();
  header("location:../index.php");
 ?>
