<div id="title">Offer Peace</div>
<img src="images/peace.jpg" class="center">
If you wish to end your war and offer peace to your opponent, you may do so here.<br /><br />
<?php require("loggedin.php");

$oppnation = mysql_real_escape_string($_GET['nat']);
$id = mysql_real_escape_string($_SESSION['id']);

$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
$username = $userF['username'];

$otherC = mysql_query("SELECT * FROM players WHERE nation='$oppnation'");
$otherF = mysql_fetch_array($otherC);
$othername = $otherF['username'];
$otherN = mysql_num_rows($otherC);

if($otherN == 1) {

$warC1 = mysql_query("SELECT * FROM wars WHERE defender='$username' AND attacker='$othername'");
$warN1 = mysql_num_rows($warC1);
if($warN1 == 1) {
$defender = $username;
$attacker = $othername;
}
$warC2 = mysql_query("SELECT * FROM wars WHERE defender='$othername' AND attacker='$username'");
$warN2 = mysql_num_rows($warC2);
if($warN2 == 1) {
$defender = $othername;
$attacker = $username;
}
if($warN2 == 0 AND $warN1 == 0) {
$error .= "You cannot make peace because you are not at war with this opponent.<br />";
}

if($attacker == $username) {
$warF = mysql_fetch_array($warC2);
$oppPeace = $warF['defpeace'];
$peacetype = "attpeace";
} if($attacker == $othername) {
$warF = mysql_fetch_array($warC1);
$oppPeace = $warF['attpeace'];
$peacetype = "defpeace";
}

if($oppPeace == 1) {
$oppOpeace = "yes";
} if($oppPeace == 0) {
$oppOpeace = "no";
}

if(isset($_POST['peace'])) {
if($oppOpeace == "yes") {
mysql_query("UPDATE wars SET active='0' WHERE id='$warF[id]'");
echo "You have successfully made peace with your opponent.<br />";
$message = " ".$username." has accepted your peace offer. You are no longer at war with the nation of ".$userF['nation'].".";
$date = date("c");
mysql_query("DELETE FROM wars WHERE id='$warF[id]'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherF[username]', '$username', 'Peace Accepted', '$message', '$date', '0', '0')");
} if($oppOpeace == "no") {
mysql_query("UPDATE wars SET ".$peacetype."='1' WHERE id='$warF[id]'");
echo "You have successfully offered peace to your opponent.<br />";
$message = " ".$username." has sent you a peace offer. If you wish to no longer be at war with the nation of ".$userF['nation']." visit their nation and offer them peace in return.";
$date = date("c");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherF[username]', '$username', 'Peace Offer', '$message', '$date', '0', '0')");
}

} else {
echo "<center>Has Opponent Offered Peace: ".$oppOpeace."<br /><form method='post' action='index.php?id=42&nat=".$oppnation."'><input type='submit' value='Offer Peace' name='peace'></form></center>";
}
} else {
echo "An unexpected error has occured. Please go back and try again.<br />";
}
?>