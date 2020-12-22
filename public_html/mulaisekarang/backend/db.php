<?php

$mysqli = new mysqli("localhost","wilopoca_office","wilopoca2019","wilopoca_office");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

?>
