<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$cost = 180000000;

?>
<div id="title">Coin Mint</div>
<img src="images/coinmint.jpg" class="center">
The Coin Mint is a means of producing valuable currency in the form of metal. Coins can be worth more than paper money when made of valuable metals.
<br /><br />
<center><table id='black'><tr id="black"><td id="black" class="center"><b>Benefits</b></td><td id="black" class="center"><b>Requirements</b></td><td id="black" class="center"><b>Cost</b></td><td id="black" class="center"><b>Money</b></td></tr>
<tr id="black"><td id="black">Increases average income by $0.05</td><td id="black">None</td><td id="black">$<?php echo number_format($cost); ?></td><td id="black">$<?php echo number_format($userF['money']); ?></td></tr></table></center><br />

<?php


if($_POST['marvel'] != "Construct Marvel") {
if($userF['coinm'] == 1) {
echo "<center>You already have this Marvel.</center>";
} else {
echo "<center><form action='index.php?id=83' method='post'><input type='submit' value='Construct Marvel' name='marvel'></form></center>";
}
}
if($_POST['marvel'] == "Construct Marvel") {
//check for errors
if($userF['money'] < $cost) {
$error .= "Error1 - You do not have enough money to purchase this marvel.<br />";
} if($userF['coinm'] == 1) {
$error .= "Error2 - You already have this marvel.<br />";
} 


if($error == null) {
$newmoney = $userF['money']-$cost;
mysql_query("UPDATE players SET money='$newmoney', coinm='1' WHERE id='$id'");
} else {
echo "You received the following error(s):<br />";
echo $error;
}
}
?>