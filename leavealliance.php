<div id="title">Leave Alliance</div>
<?php
require("loggedin.php");
$aid = mysql_real_escape_string(htmlentities($_GET['aid']));
$token = mysql_real_escape_string(htmlentities($_GET['token']));
if($aid == "14" AND $_SESSION['token'] == $token) {
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$allCheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$allFetch = mysql_fetch_array($allCheck);
$alliance = $allFetch['alliance'];
if($alliance != "None") {
$allCheck2 = mysql_query("SELECT * FROM alliances WHERE name='$alliance'");
$allFetch2 = mysql_fetch_array($allCheck2);
$members = $allFetch2['members']-1;
if($members == 0) {
mysql_query("DELETE FROM alliances WHERE name='$alliance'");
}
$date = date("c");
mysql_query("UPDATE players SET alliance='None', alliancepos='None' WHERE id='$id'");
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
} else {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
} 
} else {
$token = md5(rand(99999,999999));
$_SESSION['token'] = $token;
echo "Are you sure you want to leave your alliance?    <a href='index.php?id=13'>Back</a>  |  <a href='index.php?id=14&aid=14&token=".$token."'>Yes</a>";
}
?>