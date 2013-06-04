<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 4) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
?>
<div id="title">Manage Moderators</div>
Level 0 is strictly for players and will have no access to the Control Panel or any moderation actions.<br />
Level 1 is for low level moderators who can view a nations money/research points, but can only suspend players and cannot see the Control Panel.<br />
Level 2 is for normal moderators who can also use the "Normal Tools" portion of the Control Panel.<br />
Level 3 is for high level moderators who can use the "Advanced Tools" portion of the Control Panel.<br />
Level 4 is strictly for full administrators, who have access to every portion of the Control Panel.<br /><br />
<?php
if($level == 4) {
if(!isset($_POST['submit'])) {
echo "<table class='black'><tr class='black'><th class='thickblack'>Username</th><th class='thickblack'>Level</th></tr>";
$modC = mysql_query("SELECT * FROM players WHERE level='1' OR level='2' OR level='3' OR level='4'");
while($modF = mysql_fetch_array($modC)) {
echo "<tr class='black'><td class='black'>".$modF['username']."</td><td class='black'>".$modF['level']."</td></tr>";
}
echo "</table><br /><center><form action='index.php?id=96' method='post'>Nation Name: <input type='text' name='nation'> Level: <select name='level'><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option></select> <input type='submit' name='submit' value='Go!'></form>";
} if(isset($_POST['submit']) AND $level == 4) {
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));
$level = mysql_real_escape_string(htmlentities($_POST['level']));
if($level > 4) {
$level = 4;
}
$natC = mysql_query("SELECT nation FROM players WHERE nation='$nation'");
$natN = mysql_num_rows($natC);
if($natN == 1) {
mysql_query("UPDATE players SET level='$level' WHERE nation='$nation'");
echo "Nation of ".$nation." has been successfully updated to level ".$level.".";
} else {
echo "That nation doesn't exist.<br />";
}
}
}
?>