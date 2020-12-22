<?php
  // print_r($_POST); die();
  session_start();

  // connect
  $mysqli = new mysqli("localhost","wilopoca_office","wilopoca2019","wilopoca_office");
  // Check connection
  if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }

// header('Content-Type: application/json');
// $request = file_get_contents('php://input');
// $req_dump = print_r( $request, true );
// $fp = file_put_contents( 'request.log', $req_dump );


  // print_r($_POST);die();
    $secret_key = "6Ld_u9MUAAAAAECKBIXb5LdX_YIAWJZI1qtR0upH";

    $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
    $response = json_decode($verify);
    if($response->success){

          $nama = $_POST['nama_customer'];
          $email = $_POST['email'];
          $telepon = $_POST['notelp_customer'];
          $datenya=date('Y-m-d H:i:s');
          $input = $mysqli -> query("INSERT INTO daftar_kelas_impor VALUES (NULL, '$datenya', '$nama', '$email', '$telepon', NULL, 0, NULL)")
            or die(mysqli_error());
        
          header("location:https://wilopocargo.com/pendaftaran-berhasil/");
        
          $curl_handle=curl_init();
          curl_setopt($curl_handle,CURLOPT_URL,"https://office.wilopocargo.com/api/email_kelas_impor/email_pertama");
          curl_setopt($curl_handle, CURLOPT_POST, 1);
          curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "nama=$nama&email=$email");
          $curlemail = curl_exec($curl_handle);
          curl_close($curl_handle);
    }else{
        header("location:https://wilopocargo.com/kelas-gratis/?message=recaptcha#daftaron");
    }

 ?>
