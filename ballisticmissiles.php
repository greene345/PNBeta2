<div id="title">Buy/Sell Ballistic Missiles</div>
<img src="images/buymissiles.jpg" class="center"><br />
Here you may buy and sell ballistic missiles, which are used to bombard enemy cities, soldiers, tanks, fighter jets, or battleships.<br />
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
//
$prevAmount = $userA['bmissiles'];
//
$price = 5000000;
$sellprice = 100000;

if(isset($_POST['send'])) {

$amount = round(mysql_real_escape_string(htmlentities($_POST['amount'])));

$negative = 0;
$cost = round($amount*$price);

if(!is_numeric($amount)) {
$error .= "Error01 - You did not enter a numeric value.<br />";
} if($amount < 0) {
$negative = 1;
} if($amount > 20) {
$error .= "Error02 - You cannot purchase more than 20 ballistic missiles at a time.<br />";
} if($amount < -2000) {
$error .= "Error03 - You cannot decomission more than 2,000 ballistic missiles at a time.<br />";
}

if($negative == 0) {
if($cost > $userA['money']) {
$error .= "Error04 - You cannot purchase that many ballistic missiles because you do not have that much money.<br />";
} 
}
if($negative == 1) {
if($amount+$prevAmount < 0) {
$error .= "Error05 - You cannot decomission that many ballistic missiles because you do not have that many ballistic missiles.<br />";
}
}

if($userA['rocketry'] != 1) {
$error .= "Error06 - You must research Rocketry before you can purchase Ballistic Missiles.<br />";
}

if($error == null) {
if($negative == 0) {
$newmoney = round($userA['money']-$cost);
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', bmissiles='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully purchased ".number_format($amount)." ballistic missiles at a cost of $".number_format($cost).". You now have ".number_format($newamount)." ballistic missiles and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
}
if($negative == 1) {
$newmoney = abs($amount*$sellprice)+$userA['money'];
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', bmissiles='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully sold ".number_format(abs($amount))." ballistic missiles at a price of $".number_format(abs($amount*$sellprice)).". You now have ".number_format($newamount)." ballistic missiles and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
}

} else {
echo "<br /><br />You have received the following errors:<br />";
echo $error;
echo "<br /><center><a href='index.php?id=23'>Back</a></center>";
}
} else {
$maxbuy = round(($userA['money']/$price)-0.5);
$maxsell = $prevAmount;
if($maxbuy > 20) {
$maxbuy = 20;
} if($prevAmount > 2000) {
$maxsell = "2000";
}
?>
<br />
<form action="index.php?id=23" method="post">
<table id="black">
<tr id="black"><td id="black"><b>Ballistic Missiles:</b></td><td id="black"><?php echo number_format($prevAmount); ?></td><td id="black"><b>Purchase Cost:</b></td><td id="black">$<?php echo number_format($price); ?></td></tr>
<tr id="black"><td id="black"><b>Balance:</b></td><td id="black">$<?php echo number_format($userA['money']); ?></td><td id="black"><b>Sell Price:</b></td><td id="black">$<?php echo number_format($sellprice); ?></td></tr>
<tr id="black"><td id="black"><b>Maximum Purchase:</b></td><td id="black"><?php echo number_format($maxbuy); ?></td><td id="black"><b>Maximum Sale:</b></td><td id="black">-<?php echo number_format($maxsell); ?></td></tr>
<tr id="black"><td id="black" colspan="4" class="center">Buy/Sell Amount: <input type="text" name="amount" maxlength="5"></td></tr>
</table><br />
<center><input type="submit" name="send" value="Buy/Sell"></center>
</form>
<?php
}
?>