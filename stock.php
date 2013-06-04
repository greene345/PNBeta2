<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 320000000;

?>
<div id="title">Stock Exchange</div>
<img src="images/stock.jpg" class="center">
The Stock Exchange is a great economic advance for your nation. It allows the buying and selling of corporate shares all in one central location. It increases the average income of your nation considerably.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Increases average income by $0.10</td><td id="black">Capitol Building Marvel, Coin Mint Marvel</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['sexch'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=53' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['sexch'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 

if($userF['capb'] != 1) {
$error .= "Error4 - You must first construct the Capitol Building Marvel before you can build the Stock Exchange.<br />";
} if($userF['coinm'] != 1) {
$error .= "Error5 - You must first construct the Coin Mint Marvel before you can build the Stock Exchange.<br />";
}

if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', sexch='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>