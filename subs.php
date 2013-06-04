<div id="title">Buy/Sell Submarines</div>
<img src="images/buysubs.jpg" class="center"><br />
Here you may buy and sell Submarines. Submarines are overall stronger than Battleships. You can have 1 submarine per 15 battleships.<br />
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
//
$prevAmount = $userA['subs'];
//
$price = 3600;
//cities
$cityC = mysql_query("SELECT id FROM cities WHERE nation='$userA[nation]'");
$cities = mysql_num_rows($cityC);
//
if($userA['iron'] >= $cities) {
$price = $price*.97;
}
//
$sellprice = 700;

$maximum = (($userA['battleships']*15)/100);

if(isset($_POST['send'])) {

$amount = mysql_real_escape_string(htmlentities($_POST['amount']));

$negative = 0;
$cost = round($amount*$price);

if(!is_numeric($amount)) {
$error .= "Error01 - You did not enter a numeric value.<br />";
} if($amount < 0) {
$negative = 1;
} if($amount > 10000) {
$error .= "Error02 - You cannot purchase more than 10,000 submarines at a time.<br />";
} if($amount < -10000) {
$error .= "Error03 - You cannot decomission more than 10,000 submarines at a time.<br />";
} if($amount+$prevAmount > $maximum AND $amount+$prevAmount > $prevAmount) {
$error .= "Error12 - You cannot purchase more than ".number_format($maximum)." submarines.<br />";
}

if($negative == 0) {
if($cost > $userA['money']) {
$error .= "Error04 - You cannot purchase that many submarines because you do not have that much money.<br />";
} 
}
if($negative == 1) {
if($amount+$prevAmount < 0) {
$error .= "Error05 - You cannot decomission that many submarines because you do not have that many submarines.<br />";
}
}

if($userA['sonar'] != 1) {
$error .= "Error06 - You cannot purchase submarines until you research SONAR.<br />";
}

if($error == null) {
if($negative == 0) {
$newmoney = round($userA['money']-$cost);
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', subs='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully purchased ".number_format($amount)." submarines at a cost of $".number_format($cost).". You now have ".number_format($newamount)." submarines and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
}
if($negative == 1) {
$newmoney = abs($amount*$sellprice)+$userA['money'];
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', subs='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully sold ".number_format(abs($amount))." submarines at a price of $".number_format(abs($amount*$sellprice)).". You now have ".number_format($newamount)." submarines and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
}

} else {
echo "<br /><br />You have received the following errors:<br />";
echo $error;
}
}
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
$prevAmount = $userA['subs'];
$maxbuy = round(($userA['money']/$price)-0.5);
$maxsell = $prevAmount;
if($maxbuy > 10000) {
$maxbuy = 10000;
} if($maxsell > 10000) {
$maxsell = 10000;
} if($maxbuy+$prevAmount > $maximum) {
$maxbuy = $maximum-$prevAmount-.5;
} if($maxbuy-1 < $prevAmount) {
$maxbuy = 0;
}


//

//
?>
<br />
<form action="index.php?id=75" method="post">
<table id="black">
<tr id="black"><td id="black"><b>Submarines:</b></td><td id="black"><?php echo number_format($prevAmount); ?></td><td id="black"><b>Purchase Cost:</b></td><td id="black">$<?php echo number_format($price); ?></td></tr>
<tr id="black"><td id="black"><b>Balance:</b></td><td id="black">$<?php echo number_format($userA['money']); ?></td><td id="black"><b>Sell Price:</b></td><td id="black">$<?php echo number_format($sellprice); ?></td></tr>
<tr id="black"><td id="black"><b>Maximum Purchase:</b></td><td id="black"><?php echo number_format($maxbuy); ?></td><td id="black"><b>Maximum Sale:</b></td><td id="black">-<?php echo number_format($maxsell); ?></td></tr>
<tr id="black"><td id="black" colspan="4" class="center">Buy/Sell Amount: <input type="text" name="amount" maxlength="7" value="<?php echo round($maxbuy); ?>"></td></tr>
</table><br />
<center><input type="submit" name="send" value="Buy/Sell"></center>
</form>