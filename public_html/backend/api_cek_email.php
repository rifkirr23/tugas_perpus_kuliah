<?php
session_start();

// connect
$mysqli = new mysqli("localhost","wilopoca_office","wilopoca2019","wilopoca_office");
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

		$email_post = $_POST['email'];
		$data = mysqli_query($mysqli,"select * from customer where email='$email_post'");
		while($d = mysqli_fetch_array($data)){
		    $id =  $d['id_cust'];
		}

    $callback = array('result'=>$id);
 		echo json_encode($callback);

 ?>
