<?php
$gid = mysql_real_escape_string(htmlentities($_GET['id']));
$id = mysql_real_escape_string($_SESSION['id']);
if(!isset($_SESSION['id'])) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=1&er=1&gid='.$gid.'">';
die();
}
//check if suspended
$suspendC = mysql_query("SELECT * FROM players WHERE id='$id'");
$suspendF = mysql_fetch_array($suspendC);
if($suspendF['suspended'] == 1) {
$suspend_date = $suspendF['suspend_date'];

$diff = abs(strtotime($suspend_date) - strtotime(date(c)));
$days = round($diff/60/60/24);

if($days < $suspendF['suspend_length']) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/suspended.html">';
die();
}
}
?>