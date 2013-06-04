<div id="title">Declare War</div>
<?php
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

require("loggedin.php");
$id = $_SESSION['id'];
$userS = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userS);
$username = $userF['username'];
$atS = mysql_query("SELECT * FROM wars WHERE attacker='$username'");
$atSN = mysql_num_rows($atS);
$currentwars = $atSN;
$offalliance = $userF['alliance'];

if(isset($_POST['submit'])) {
$defender = mysql_real_escape_string($purifier->purify($_POST['defender']));
$reason = mysql_real_escape_string($purifier->purify($_POST['reason']));

$dfC2 = mysql_query("SELECT * FROM wars WHERE defender='$defender' AND active='1'");
$dfCN2 = mysql_num_rows($dfC2);
$defwars = $dfCN2;

$dwC = mysql_query("SELECT * FROM wars WHERE attacker='$defender' AND defender='$username' AND active='1'");
$dwC2 = mysql_query("SELECT * FROM wars WHERE defender='$defender' AND attacker='$username' AND active='1'");
$dwCN = mysql_num_rows($dwC);
$dwCN2 = mysql_num_rows($dwC2);
$dualwar = $dwCN+$dwCN2;

$defTest = mysql_query("SELECT * FROM players WHERE username='$defender'");
$defFetch = mysql_fetch_array($defTest);
$defalliance = $defFetch['alliance'];
$defNum = mysql_num_rows($defTest);
$defPower = $defFetch['power'];
$userpower = $userF['power'];

if($defNum != 1) {
$error .= "The person you are trying to declare war on does not exist. Please make sure you are entering their username in the \"Declare On:\" field.<br />";
} if(strlen($reason) > 32) {
$error .= "You have entered an invalid cause for war.<br />";
} if($reason == null) {
$reason = "Unresolved Conflict";
} if($currentwars > 2) {
$error .= "You are already involved in 3 offensive wars.<br />";
} if($defwars > 2) {
$error .= "Your opponent is already involved in 3 defensive wars.<br />";
} if($defender == $username) {
$error .= "You cannot declare war on yourself.<br />";
} if($dualwar != 0) {
$error .= "You are already at war with this nation!<br />";
} if($defFetch['readiness'] == "peace") {
$error .= "Your opponent is a peaceful nation, you may not declare war on them.<br />";
} if($userF['readiness'] == "peace") {
$error .= "You cannot declare war on this opponent because you have chosen your nation to be a peaceful nation. To declare war, please change this setting.<br />";
} if(($userpower*0.75) > $defPower) {
$error .= "You cannot declare war on this nation because they are outside of your power range. You can only declare war on nations with higher power than you, or if there power is up to 25% lower than yours.<br />";
} if($username == null) {
$error .= "There has been an unexpected error. Please go back and try again.<br />";
}

if($error == null AND $_POST['submit'] == "Declare War") {

$date = date("c");
$message = " ".$username." has declared war on you! Their cause for war was: ".stripslashes($reason)." ";
mysql_query("INSERT INTO wars (attacker, defender, offalliance, defalliance, reason, start_date, lastnuke) VALUES ('$username', '$defender', '$offalliance', '$defalliance', '$reason', '$date', '$username')");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$defender', '$username', 'War Declared!', '$message', '$date', '0', '0')");
mysql_query("UPDATE players SET lastnuke='$date' WHERE username='$username'");

echo "You have successfully declared war on ".$defender.".";
echo "<br /><br /><a href='index.php?id=30'>My Wars</a>";
} else {
echo "You have received the following error(s):<br />";
echo $error;
}

} else {
$defender = mysql_real_escape_string($purifier->purify($_GET['att']));
echo "<img class='center' src='images/declare.jpg'><br />";
echo "Are you really sure you want to start a war? Pre-emptive strikes can provoke retaliation from other nations and potentially alliances. Be certain you are prepared for war before you submit your declaration.";
echo "<form action='index.php?id=29' method='post'><br /><center><table><tr><td>Declare On:</td><td><input type='text' value='".$defender."' name='defender'></td></tr><tr><td>Cause for War:</td><td><input type='text' name='reason' value='Unresolved Conflict' maxlength='32'></td></tr>";
echo "</table><br /><input type='submit' value='Declare War' name='submit'></center></form>";
}
?>