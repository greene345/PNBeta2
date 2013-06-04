<div id="title">Buy/Sell SAM Batteries</div>
<img src="images/buysam.jpg" class="center"><br />
Here you may buy and sell SAM Batteries. SAM Batteries are guns on the ground that launch surface-to-air missiles capable of destroying aircraft above. While SAM Batteries have no offensive value, they are good defensive units. You can have as many as 1 SAM Batteries per 25 fighter jets.<br />
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
//
$prevAmount = $userA['sam'];
//
$price = 400;
$sellprice = 100;

$maximum = ($userA['fighterjets']/25);

if(isset($_POST['send'])) {

$amount = round(mysql_real_escape_string(htmlentities($_POST['amount'])));

$negative = 0;
$cost = round($amount*$price);

if(!is_numeric($amount)) {
$error .= "Error01 - You did not enter a numeric value.<br />";
} if($amount < 0) {
$negative = 1;
} if($amount > 10000) {
$error .= "Error02 - You cannot purchase more than 10,000 SAM batteries at a time.<br />";
} if($amount < -10000) {
$error .= "Error03 - You cannot sell more than 10,000 SAM batteries at a time.<br />";
} if($amount+$prevAmount > $maximum AND $amount+$prevAmount > $prevAmount) {
$error .= "Error04 - You cannot purchase more than ".number_format($maximum)." SAM batteries.<br />";
}

if($negative == 0) {
if($cost > $userA['money']) {
$error .= "Error04 - You cannot purchase that many SAM batteries because you do not have that much money.<br />";
} 
}
if($negative == 1) {
if($amount+$prevAmount < 0) {
$error .= "Error05 - You cannot sell that many SAM batteries because you do not have that many tanks.<br />";
}
}
if($userA['rocketry'] != 1) {
$error .= "Error07 - You must research Rocketry before you can purchase SAM Batteries.<br />";
}

if($error == null) {
if($negative == 0) {
$newmoney = round($userA['money']-$cost);
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', sam='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully purchased ".number_format($amount)." SAM batteries at a cost of $".number_format($cost).". You now have ".number_format($newamount)." SAM batteries and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
}
if($negative == 1) {
$newmoney = (abs($amount*$sellprice))+$userA['money'];
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', sam='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully sold ".number_format(abs($amount))." SAM batteries at a price of $".number_format(abs($amount*$sellprice)).". You now have ".number_format($newamount)." SAM batteries and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
}

} else {
echo "<br /><br />You have received the following errors:<br />";
echo $error;
}
}

$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
//
$prevAmount = $userA['sam'];
//
$price = 400;
$sellprice = 100;

$maxbuy = round(($userA['money']/$price)-0.5);
$maxsell = $prevAmount;
if($maxbuy > 10000) {
$maxbuy = 10000;
} if($prevAmount > 10000) {
$maxsell = 10000;
} if($maxbuy+$prevAmount > $maximum) {
$maxbuy = $maximum-$prevAmount-.5;
} if($maxbuy < 0) {
$maxbuy = 0;
}


?>
<br />
<form action="index.php?id=72" method="post">
<table id="black">
<tr id="black"><td id="black"><b>SAM Batteries:</b></td><td id="black"><?php echo number_format($prevAmount); ?></td><td id="black"><b>Purchase Cost:</b></td><td id="black">$<?php echo number_format($price); ?></td></tr>
<tr id="black"><td id="black"><b>Balance:</b></td><td id="black">$<?php echo number_format($userA['money']); ?></td><td id="black"><b>Sell Price:</b></td><td id="black">$<?php echo number_format($sellprice); ?></td></tr>
<tr id="black"><td id="black"><b>Maximum Purchase:</b></td><td id="black"><?php echo number_format($maxbuy); ?></td><td id="black"><b>Maximum Sale:</b></td><td id="black">-<?php echo number_format($maxsell); ?></td></tr>
<tr id="black"><td id="black" colspan="4" class="center">Buy/Sell Amount: <input type="text" name="amount" maxlength="7" value="<?php echo round($maxbuy); ?>"></td></tr>
</table><br />
<center><input type="submit" name="send" value="Buy/Sell"></center>
</form>