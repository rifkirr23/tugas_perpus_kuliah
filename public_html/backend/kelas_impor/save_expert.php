<?php
  // print_r($_POST); die();
  session_start();
  $_SESSION["dnama"] = $_POST['nama'];
  $_SESSION["demail"] = $_POST['email'];
  $_SESSION["dtelepon"] = $_POST['telepon'];
  $_SESSION["dpaket_daftar"] = $_POST['paket_daftar'];
  $_SESSION["djumlah_daftar"] = $_POST['harga_member'];

  // header("location:https://wilopocargo.com/silahkan-lakukan-pembayaran/");

 ?>
