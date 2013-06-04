<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 45000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
?>
<div id="title">Grand Shrine</div>
<img src="images/shrine.jpg" class="center">
The Grand Shrine is a great cultural monument. It inspires more genuine creativity from citizens, and makes your people happier.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Increases national happiness by 0.75%</td><td id="black">5 Cities</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['gshrine'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=48' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['gshrine'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($cityN < 5) {
$error .= "Error3 - You must have at least 5 cities before you can construct this wonder.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', gshrine='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>
