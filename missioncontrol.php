<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 500000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$universities = $universities+$cRow['university'];
}
?>
<div id="title">Mission Control</div>
<img src="images/missioncontrol.jpg" class="center">
Building Mission Control will allow your nation to begin Space Exploration and Development. This marvel is an important step forward in the technological world.
<br /><br />
<center><table id='black'><tr id='black'><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id='black'><td id='black'>Allows the Space Station Marvel</td id='black'><td id="black">75 Universities, Grand Observatory Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['misctrl'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=54' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['misctrl'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($universities < 75) {
$error .= "Error3 - You must have at least 75 universities before you can construct this wonder.<br />";
} if($userF['gobs'] != 1) {
$error .= "Error4 - You must first construct the Grand Observatory before you can build the Mission Control Marvel.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', misctrl='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>