<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 2000000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);

$soldiers = $userF['soldiers']+$userF['paratrooper']+$userF['snipers'];
$tanks = $userF['nomad']+$userF['maverick']+$userF['longhorn'];
?>
<div id="title">Military Headquarters</div>
<img src="images/milhq.jpg" class="center">
The Military Headquarters Marvel is a necessity for any nation with a wargoing nature. It provides a location for your battle commanders to plan attacks and defenses. Having the Military Headquarters Marvel lowers the cost of military upkeep for your nation.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Decreases Military Upkeep by 3%</td><td id="black">3 Million Soldiers, 500,000 Tanks</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['mhq'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=46' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['mhq'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($soldiers < 3000000) {
$error .= "Error3 - You must have at least 3 million soldiers before you can construct this marvel.<br />";
} if($tanks < 500000) {
$error .= "Error4 - You must have at least 500,000 tanks before you can construct this marvel.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', mhq='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>
