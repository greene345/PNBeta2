<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 120000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$universities = $universities+$cRow['university'];
}
?>
<div id="title">Grand University</div>
<img src="images/university.jpg" class="center">
The Grand University is a great leap forward in the education of your nation. Having such a grand learning facility encourages your citizens learn more.
<br /><br />
<center><table id='black'><tr id='black'><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id='black'><td id='black'>Increases overall literacy 1.5%, Allows Grand Observatory Marvel</td id='black'><td id="black">30 Universities</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['guni'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=45' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['guni'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($universities < 30) {
$error .= "Error3 - You must have at least 30 universities before you can construct this wonder.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', guni='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>