<?php
$logoutCheck = mysql_query("SELECT * FROM players WHERE loginip='$userIP'");
if(mysql_num_rows($logoutCheck) == 1) {
mysql_query("UPDATE players SET loginip='12' WHERE loginip='$userIP'");
}
session_destroy();
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/">';
?>