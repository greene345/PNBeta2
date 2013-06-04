<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 550125000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);

$bships = $userF['battleships'];

?>
<div id="title">Nuclear Waste Disposal Site</div>
<img src="images/nwds.jpg" class="center">
The Nuclear Waste Disposal Site helps cut down pollution in your nation. It is important for managing nuclear facilities.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Reduces national pollution by 10%, Allows Weapons Testing Facility Marvel</td><td id="black">5,000 Battleships, National Armory Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['nwds'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=55' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['nwds'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($bships < 5000) {
$error .= "Error3 - You must have at least 5,000 Battleships before you can construct this marvel.<br />";
}

if($userF['narmory'] != 1) {
$error .= "Error5 - You must first construct the National Armory Marvel before you can build the Nuclear Waste Disposal Site Marvel.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', nwds='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>