<?php
session_start();

$mysql_host = "localhost";
$mysql_database = "pixelnat_db";
$mysql_user = "pixelnat_admin";
$mysql_password = "3xezdA0U2ecrkgb3wrUheeLv8GvWx4Ujx4U";

$con = mysql_connect($mysql_host, $mysql_user, $mysql_password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($mysql_database, $con);
?>