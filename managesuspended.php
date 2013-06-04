<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 3) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
?>
<div id="title">Manage Suspended Players</div>
<?php
if($level > 2) {
$ubid = mysql_real_escape_string(htmlentities($_GET['ubid']));

if($ubid != null) {
$bancheck = mysql_query("SELECT * FROM players WHERE id='$ubid'");
$bannum = mysql_num_rows($bancheck);
$banfetch = mysql_fetch_array($bancheck);

if($bannum != 0) {
mysql_query("UPDATE players SET suspended='0' WHERE id='$ubid'");
echo "The player ".$banfetch['username']." has been unsuspended.<br />";
} else {
echo "There was an invalid entry, that player is not suspended.<br />";
}
} else {
$bancheck = mysql_query("SELECT * FROM players WHERE suspended='1'");
echo "<table class='black'><tr class='black'><th class='thickblack'>Date Suspended</th><th class='thickblack'>Username</th><th class='thickblack'>Nation</th><th class='thickblack'>Moderator Suspended By</th><th class='thickblack'>Length</th><th class='thickblack'>Reason</th></tr>";
while($banrow = mysql_fetch_array($bancheck)) {
echo "<tr class='black'><td class='black'>".$banrow['suspend_date']."</td><td class='black'><a href='index.php?id=94&ubid=".$banrow['id']."'>".$banrow['username']."</a></td><td class='black'><a href='index.php?id=7&nid=".$banrow['id']."'>".$banrow['nation']."</a></td><td class='black'>".$banrow['suspend_mod']."</td><td class='black'>".$banrow['suspend_length']."</td><td class='black'>".stripslashes($banrow['suspend_reason'])."</td></tr>";
}
echo "</table><br />Click on a username to unsuspend it.";
}
}
?>