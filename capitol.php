<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 100000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$population = $population+$cRow['population'];
}
?>
<div id="title">Capitol Building</div>
<img src="images/capitolmarvel.jpg" class="center">
The Capitol Building Marvel is important for your national leaders to gather and discuss politics. Being able to operate your government in a smaller space lowers government upkeep costs.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Decreases Government Upkeep by 2%, Allows Stock Exchange Marvel</td><td id="black">20 Million People</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['capb'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=47' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['capb'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($population < 20000000) {
$error .= "Error3 - You must have at least 20 million people before you can construct this marvel.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', capb='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>