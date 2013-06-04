<?php
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

$basic = array("Rubber", "Coal", "Cod", "Corn", "Timber", "Cotton");
$medium = array("Copper", "Iron", "Crude Oil", "Chickens", "Fresh Water", "Composite");
$rare = array("Silver", "Gold", "Gems", "Coffee Beans");
$citycheck = mysql_query("SELECT id FROM cities ORDER BY resource ASC");
while($row = mysql_fetch_array($citycheck)) {
$rand1 = rand(1,100);
if($rand1 < 75) {
$resource = $basic[rand(0, (count($basic)-1))];
} if($rand1 > 74 AND $rand1 < 95) {
$resource = $medium[rand(0, (count($medium)-1))];
} if($rand1 > 94) {
$resource = $rare[rand(0, (count($rare)-1))];
}
$id = $row['id'];
mysql_query("UPDATE cities SET resource='$resource' WHERE id='$id'");
}
echo "Success";
?>