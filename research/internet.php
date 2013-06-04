<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 7500;

$points = $userF['rpoints'];

?>
<img src="research/internet.jpg" class="center">
<b>Internet</b> is a network between all capable computers and servers.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Available Points</b></td></tr>
<tr id="black"><td id="black">Reduces Infrastructure Maintenance by 1%</td><td id="black">Networking</td><td id="black"><?php echo number_format($cost); ?> Research Points</td><td id="black"><?php echo number_format($userF['rpoints']); ?> Research Points</td></tr></table></center><br />

<?php

if($_POST['research'] != "Research") {
if($userF['internet'] == 1) {
echo "<center>You have already completed this Research.</center>";
} else {
echo "<center><form action='index.php?id=82&rid=".$_GET['rid']."' method='post'><input type='submit' value='Research' name='research'></form></center>";
}
}
if($_POST['research'] == "Research") {
//check for errors
if($points < $cost) {
$error .= "Error1 - You do not have enough Research Points to complete this Research.<br />";
} if($userF['internet'] == 1) {
$error .= "Error2 - You have already completed this Research.<br />";
} 
if($userF['networking'] != 1) {
$error .= "Error3 - You cannot research this until you research Networking.<br />";
}



if($error == null) {
$newpoints = $userF['rpoints']-$cost;
mysql_query("UPDATE players SET rpoints='$newpoints', internet='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>