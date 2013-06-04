<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 2) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
?>
<div id="title">Manage Banned Players</div>
<?php
if($level > 1) {
$ubid = mysql_real_escape_string(htmlentities($_GET['ubid']));

if($ubid != null) {
$bancheck = mysql_query("SELECT * FROM banned WHERE id='$ubid'");
$bannum = mysql_num_rows($bancheck);
$banfetch = mysql_fetch_array($bancheck);

if($bannum != 0) {
mysql_query("DELETE FROM banned WHERE id='$ubid'");
echo "The IP address ".$banfetch['ip']." has been unbanned.<br />";
} else {
echo "There was an invalid entry, that IP is not banned.<br />";
}
} else {
$bancheck = mysql_query("SELECT * FROM banned");
echo "<table class='black'><tr class='black'><th class='thickblack'>Date Banned</th><th class='thickblack'>IP Address</th><th class='thickblack'>Username</th><th class='thickblack'>Nation</th><th class='thickblack'>Moderator Banned By</th><th class='thickblack'>Reason</th></tr>";
while($banrow = mysql_fetch_array($bancheck)) {
echo "<tr class='black'><td class='black'>".$banrow['date']."</td><td class='black'><a href='index.php?id=92&ubid=".$banrow['id']."'>".$banrow['ip']."</a></td><td class='black'>".$banrow['username']."</td><td class='black'>".$banrow['nation']."</td><td class='black'>".$banrow['moderator']."</td><td class='black'>".stripslashes($banrow['reason'])."</td></tr>";
}
echo "</table><br />Click on an IP Address to unban it.";
}
}
?>