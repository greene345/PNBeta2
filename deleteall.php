<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));

$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
$username = $userF['username'];

$msgC = mysql_query("SELECT * FROM messages WHERE receiver='$username' AND readmsg='1'");
while($msgR = mysql_fetch_array($msgC)) {
mysql_query("DELETE FROM messages WHERE id='$msgR[id]'");
}
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=2">';
?>