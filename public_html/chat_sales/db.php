<?php

$mysqli = new mysqli("localhost","wilopoca_wcnew","wilopoca2019","wilopoca_office");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// $dbhost = 'localhost';
// $dbuser = 'wilopoca_office';
// $dbpass = 'wilopoca2019';
// $dbname = 'wilopoca_office';
// $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

?>
