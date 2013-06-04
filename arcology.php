<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 450000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$population = $population+$cRow['population'];
$universities = $universities+$cRow['university'];
}
?>
<div id="title">Arcology</div>
<img src="images/arcology.jpg" class="center">
Arcology is the combination of architecture with ecology. Arcology allows more advanced human habitats, and thus lowers the costs of city zones.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Decreases the cost of city zones by 3%</td><td id="black">Grand University Marvel, Towering Skyscraper Marvel, 50 Universities, 250 Million People</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['arcology'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=50' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['arcology'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($population < 250000000) {
$error .= "Error3 - You must have at 250 million people before you can construct this marvel.<br />";
} if($userF['skyscraper'] != 1) {
$error .= "Error4 - You must first construct the Towering Skyscraper Marvel before you can build the Arcology marvel.<br />";
} if($universities < 50) {
$error .= "Error5 - You must have 50 universities before you can construct this marvel.<br />";
} if($userF['guni'] != 1) {
$error .= "Error6 - You must first construct the Grand University Marvel before you can build the Arcology marvel.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', arcology='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>