<?php
$userIP = mysql_real_escape_string(htmlentities($_SERVER['REMOTE_ADDR']));

$bancheck = mysql_query("SELECT * FROM banned");
$i = 1;
$banArray[0] = "99.127.159.37";
while($banrow = mysql_fetch_array($bancheck)) {
$banArray[$i] = "".$banrow['ip']."";
$i = $i+1;
}
if(in_array($userIP,$banArray)) {
session_destroy();
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/banned.html">';
die();
}
?>