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

$warSelect = mysql_query("SELECT * FROM wars");
$w = 0;
while($wRow = mysql_fetch_array($warSelect)) {
mysql_query("UPDATE wars SET lastground='turn', lastair='turn', lastsea='turn'");
$wdiff = abs(strtotime($wRow['start_date']) - strtotime(date(c)));
$wdays = round($wdiff/60/60/24);
if($wdays >= 4) {
mysql_query("UPDATE wars SET active='0' WHERE id='$wRow[id]'");
}
if($wdays >= 5) {
mysql_query("DELETE FROM wars WHERE id='$wRow[id]'");
$w = $w+1;
}
}
$u = 0;
$userSelect = mysql_query("SELECT * FROM players");
while($uRow = mysql_fetch_array($userSelect)) {
$udiff = abs(strtotime($uRow['last_login']) - strtotime(date(c)));
$udays = round($udiff/60/60/24);
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= 'From: <webmaster@pixelnations.net>' . "\r\n";
$to = $uRow['email'];
$subject = "Inactive at Pixel Nations";
if($udays == 20) {
$message = "<html><body><p>".$uRow['username'].", your nation misses you! You have been inactive at <a href='http://www.pixelnations.net/beta'>www.pixelnations.net</a> for 20 days. If you are inactive for more than 35 days, your account will be deleted.</p></body></html>";
mail($to,$subject,$message,$headers);
} if($udays == 25) {
$message = "<html><body><p>".$uRow['username'].", your pixel citizens miss you! You have been inactive at <a href='http://www.pixelnations.net/beta'>www.pixelnations.net</a> for 25 days. If you are inactive for more than 35 days, your account will be deleted.</p></body></html>";
mail($to,$subject,$message,$headers);
} if($udays > 35) {
mysql_query("DELETE FROM players WHERE id='$uRow[id]'");
$u = $u+1;
}
}

mysql_query("DELETE FROM alliances WHERE members='0'");

//gifts
$aSelect = mysql_query("SELECT * FROM aid");
while($aRow = mysql_fetch_array($aSelect)) {
$adiff = abs(strtotime($aRow['date']) - strtotime(date(c)));
$adays = round($adiff/60/60/24);
if($adays > 4) {
mysql_query("DELETE FROM aid WHERE id='$aRow[id]'");
}
}

//events
$eSelect = mysql_query("SELECT * FROM events");
while($eRow = mysql_fetch_array($eSelect)) {
$ediff = abs(strtotime($eRow['date']) - strtotime(date(c)));
$edays = $ediff/60/60/24;
if($edays > 2) {
mysql_query("DELETE FROM events WHERE id='$eRow[id]'");
}
}

//resources
mysql_query("DELETE FROM market WHERE completed='1'");

//check invalid alliance
$invalidaS = mysql_query("SELECT id FROM players WHERE join_date='0000-00-00 00:00:00'");
while($invrow = mysql_fetch_array($invalidaS)) {
mysql_query("UPDATE players SET alliance='None' where id='$invrow[id]'");
}
echo $w;
echo " wars deleted.<br />";
echo $u;
echo " players deleted.<br />";
?>