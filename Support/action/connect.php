<?php

error_reporting(E_ALL & ~E_DEPRECATED);

$IP      = "us-cdbr-iron-east-01.cleardb.net";     
$DB_USER = "bf1d22b1aac0f9";          
$DB_PWD  = "57b9b17c";     
$DB_NAME = "heroku_946f48f4a9d8130";        

$con = mysqli_connect($IP, $DB_USER, $DB_PWD, $DB_NAME);
// mysql_query("set names 'utf8'",$con);
// $dbLink = mysql_select_db($DB_NAME,$con);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}