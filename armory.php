<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 3500000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);

$soldiers = $userF['soldiers'];
$tanks = $userF['nomad']+$userF['maverick']+$userF['longhorn'];
?>
<div id="title">National Armory</div>
<img src="images/armory.jpg" class="center">
The National Armory is important in making sure your nation is always prepared for war. It acts as a reserve of necessary materials and thus lowers the cost of new soldiers and tanks.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Decreases Cost of Soldiers and Tanks 5%, Allows Nuclear Waste Disposal Site Marvel</td><td id="black">6 Million Soldiers, 200,000 Vehicles, Military Headquarters Marvel, Capitol Building Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['narmory'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=52' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['narmory'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($soldiers < 6000000) {
$error .= "Error3 - You must have at least 6 million soldiers before you can construct this marvel.<br />";
} if($tanks < 200000) {
$error .= "Error4 - You must have at least 200,000 vehicles before you can construct this marvel.<br />";
}

if($userF['mhq'] != 1) {
$error .= "Error5 - You must first construct the Military Headquarters Marvel before you can build this one.<br />";
} if($userF['capb'] != 1) {
$error .= "Error6 - You must first construct the Capitol Building Marvel before you can build this one.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', narmory='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>