<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 7000000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$universities = $universities+$cRow['university'];
}
?>
<div id="title">Space Elevator</div>
<img src="images/spaceelevator.jpg" class="center">
The Space Elevator is a huge technological feat, and an excellent display of the technological prowess of your nation. 
<br /><br />
<center><table id='black'><tr id='black'><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id='black'><td id='black'>Increases Overall Happiness by 0.25%</td id='black'><td id="black">120 Universities, Space Station Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['se'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=58' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['se'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($universities < 120) {
$error .= "Error3 - You must have at least 120 universities before you can construct this wonder.<br />";
} if($userF['ss'] != 1) {
$error .= "Error4 - You must first construct the Space Station Marvel before you can build the Space Elevator.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', se='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>