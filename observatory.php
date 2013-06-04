<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 360000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$universities = $universities+$cRow['university'];
$libraries = $libraries+$cRow['library'];
}
?>
<div id="title">Grand Observatory</div>
<img src="images/observatory.jpg" class="center">
The Grand Observatory is a huge development in the field of astronomy and leads to further advances in space technology.
<br /><br />
<center><table id='black'><tr id='black'><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id='black'><td id='black'>Increases overall literacy 0.5%, Allows Mission Control Marvel</td id='black'><td id="black">Grand University Marvel, 45 Universities, 36 Libraries</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php

if($_POST['marvel'] != "Construct Marvel") {
if($userF['gobs'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=51' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['gobs'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($universities < 45) {
$error .= "Error3 - You must have at least 30 universities before you can construct this marvel.<br />";
} if($libraries < 36) {
$error .= "Error4 - You must have at least 36 libraries before you can construct this marvel.<br />";
} if($userF['guni'] != 1) {
$error .= "Error5 - You must first construct the Great University Marvel before you can build this one.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', gobs='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>