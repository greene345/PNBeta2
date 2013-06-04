<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 15000000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);

$soldiers = $userF['soldiers']+$userF['paratrooper']+$userF['snipers'];
$tanks = $userF['nomad']+$userF['longhorn']+$userF['maverick'];
$jets = $userF['fighterjets']+$userF['interceptor']+$userF['bomber'];
$bships = $userF['battleships']+$userF['subs']+$userF['carriers']+$userF['destroyers'];
?>
<div id="title">Weapons Testing Facility</div>
<img src="images/wtf.jpg" class="center">
The Weapons Testing Facility provides a location to test dangerous new weapons. Once built, your nation will be able to purchase Nuclear Weapons.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Allows Purchase of Nuclear Weapons</td><td id="black">8 Million Soldiers, 500,000 Vehicles, 25,000 Aircraft, 10,000 Naval Vessels, Nuclear Waste Disposal Site Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['wtf'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=57' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['wtf'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

$soldiers = $userF['soldiers']+$userF['snipers']+$userF['paratroopers'];
$tanks = $userF['nomad']+$userF['maverick']+$userF['longhorn'];
$jets = $userF['bomber']+$userF['fighterjets']+$userF['sam']+$userF['interceptor'];
$bships = $userF['battleships']+$userF['carriers']+$userF['subs']+$userF['destroyers'];

if($soldiers < 8000000) {
$error .= "Error3 - You must have at least 8 million soldiers before you can construct this marvel.<br />";
} if($tanks < 500000) {
$error .= "Error4 - You must have at least 500,000 vehicles before you can construct this marvel.<br />";
} if($jets < 25000) {
$error .= "Error5 - You must have at least 25,000 aircraft before you can construct this marvel.<br />";
} if($bships < 10000) {
$error .= "Error6 - You must have at least 10,000 naval vessels before you can construct this marvel.<br />";
}

if($userF['nwds'] != 1) {
$error .= "Error7 - You must first construct the Nuclear Waste Disposal Site Marvel before you can build this one.<br />";
} 

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', wtf='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>