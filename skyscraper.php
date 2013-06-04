<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 75000000;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$cityN = mysql_num_rows($cityC);
?>
<div id="title">Towering Skyscraper</div>
<img src="images/skyscraper.jpg" class="center">
The Towering Skyscraper is a remarkable achievement and a big step forward for developing nations. This marvel is a great feat of architecture and engineering. Your people will look at this great building in awe for years to come.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Increases national happiness by 0.25%, increases average income by $0.05, Allows Olympic Stadium</td><td id="black">10 Cities, Advanced Structural Engineering Research</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['skyscraper'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=44' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['skyscraper'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($cityN < 10) {
$error .= "Error3 - You must have at least 10 cities before you can construct this wonder.<br />";
} if($userF['ase'] != 1) {
$error .= "Error4 - You cannot build this marvel until you research Advanced Structural Engineering.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', skyscraper='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>
