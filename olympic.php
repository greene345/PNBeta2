<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 220000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
while($cRow = mysql_fetch_array($cityC)) {
$population = $population+$cRow['population'];
}
?>
<div id="title">Olympic Stadium</div>
<img src="images/olympic.jpg" class="center">
It is a great honor to hold the Olympic Games in your nation. Constructing the Olympic Stadium demonstrates the culture and prowess your nation has.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Increases happiness by 0.5%, Increases average income by $0.01</td><td id="black">30 Million People, Towering Skyscraper Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['olympic'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=49' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['olympic'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($population < 30000000) {
$error .= "Error3 - You must have at 200 million people before you can construct this marvel.<br />";
} if($userF['skyscraper'] != 1) {
$error .= "Error4 - You must first construct the Towering Skyscraper Marvel before you can build the Olympic Stadium.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', olympic='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>