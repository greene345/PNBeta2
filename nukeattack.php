<div id="title">Nuclear Attack</div>
<img class="center" src="images/nuke.jpg">
<?php
require("loggedin.php");


$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$wid = mysql_real_escape_string(htmlentities($_GET['wid']));
$widC = mysql_query("SELECT * FROM wars WHERE id='$wid' AND active='1'");
$widF = mysql_fetch_array($widC);

if(trim($widF['attacker']) == trim($userF['username'])) {
$othername = $widF['defender'];
} if(trim($widF['defender']) == trim($userF['username'])) {
$othername = $widF['attacker'];
} if(trim($widF['attacker']) != trim($userF['username']) AND trim($widF['defender']) != trim($userF['username'])) {
$error .= "Error04 - There was an unexpected error, please go back and try again.<br />";
}

$otherC = mysql_query("SELECT * FROM players WHERE username='$othername'");
$otherF = mysql_fetch_array($otherC);
$othernation = $otherF['nation'];

$otherC = mysql_query("SELECT * FROM players WHERE username='$othername'");
$otherF = mysql_fetch_array($otherC);
$otherCC = mysql_query("SELECT * FROM cities WHERE nation='$othernation' AND capital='0'");

$nukeC = mysql_query("SELECT * FROM nukes WHERE nation='$userF[nation]'");
$nukes = mysql_num_rows($nukeC);

if(isset($_POST['attack'])) {

$nuke = mysql_real_escape_string(htmlentities($_POST['nuke']));
$city = mysql_real_escape_string(htmlentities($_POST['city']));

$nukecheck = mysql_query("SELECT * FROM nukes WHERE name='$nuke' AND nation='$userF[nation]' LIMIT 1");
$nukenum = mysql_num_rows($nukecheck);

$citycheck = mysql_query("SELECT * FROM cities WHERE name='$city' AND nation='$othernation' LIMIT 1");
$cityfetch = mysql_fetch_array($citycheck);
$population = $cityfetch['population'];
$citynum = mysql_num_rows($citycheck);
$cityid = $cityfetch['id'];

$nukediff = abs(strtotime($userF['lastnuke']) - strtotime(date(c)));
$nukehours = round($nukediff/60/60);

if($nukes < 1) {
$error .= "Error01 - You do not have any nuclear weapons to launch.<br />";
} if($widF == $userF['username']) {
$error .= "Error02 - You cannot launch a nuclear warhead at this opponent because it is not your turn.<br />";
} if($citynum == 0) {
$error .= "Error03 - There was an unexpected error. Please try again.<br />";
} if($nukenum != 1) {
$error .= "Error04 - There was an unexpected error. Please try again.<br />";
}

if($error == null) {
$usernation = $userF['nation'];
$username = $userF['username'];
$date = date("c");
$othersoldiers = $otherF['soldiers'];
$otherlosses = round($othersoldiers/4);
$othersoldiers = $othersoldiers-$otherlosses;
$othercasualties = $otherF['casualties']+$otherlosses+$population;
$message = " ".$userF['username']." of the nation of ".$user['nation']." has launched the nuclear weapon, nicknamed ".stripslashes($nuke)." at your city of ".stripslashes($city).". The resulting blast completely destroyed the city, killing ".number_format($population)." citizens and ".number_format($otherlosses)." soldiers! The nuclear attack has lowered your nation\'s happiness by 30% over the next 6 days. Your military leaders recommend you respond immediately!";
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$othername', '$username', 'NUCLEAR ATTACK!', '$message', '$date', '0', '0')");
mysql_query("UPDATE players SET soldiers='$othersoldiers', casualties='$othercasualties', nukehit='$date' WHERE username='$othername'");
mysql_query("UPDATE wars SET lastnuke='$userF[username]', defpeace='0', attpeace='0' WHERE id='$wid'");
mysql_query("DELETE FROM nukes WHERE name='$nuke'");
mysql_query("DELETE FROM cities WHERE name='$city' AND nation='$othernation' AND id='$cityid'");
echo "You have successfully launched the nuclear warhead nicknamed ".$nuke." at your opponent's city of ".$city.". The city was completely destroyed, killing ".number_format($population)." citizens and ".number_format($otherlosses)." soldiers. Your opponent's national happiness has dropped by 30% for the next 6 days.";
} else {
echo "You have received the following errors:<br /><br />";
echo $error;
echo "<br /><center><a href='index.php?id=30'>Back</a></center>";
}

} else {
echo "If you wish to launch a nuclear weapon, you may do so. Please know that nuclear weapons are <b>very</b> destructive and will completely obliterate your opponent's city. Many nations frown upon the use of nuclear weapons, so be aware of the consequences before you launch.<br />";
if(mysql_num_rows($otherCC) != 0) {
echo '<form action="index.php?id=37&wid='.$wid.'" method="post"><center><table><tr><td>Nuke to Launch:</td><td><select name="nuke">';
while($nFetch = mysql_fetch_array($nukeC)) {
echo "<option value='".$nFetch['name']."'>".$nFetch['name']."</option>";
}
echo "</select></td></tr>";
echo "<tr><td>City to Attack:</td><td><select name='city'>";
while($cFetch = mysql_fetch_array($otherCC)) {
echo "<option value='".$cFetch['name']."'>".$cFetch['name']."</option>";
}
echo "<select></td></tr></table>";
echo "<br /><input type='submit' value='Launch Warhead' name='attack'></center></form>";
} else {
echo "<span style='text-align:center;'>Your opponent only has one city.<span>";
}


}

?>