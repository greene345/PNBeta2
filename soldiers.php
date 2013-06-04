<div id="title">Buy/Sell Soldiers</div>
<img src="images/buysoldiers.jpg" class="center"><br />
Here you may buy and sell soldiers, which are used to defend your nation as well as in aggressive attacks against other nations. Soldiers are vital to keeping order within your nation's borders, but you can never exceed more than 2 soldiers per 25 citizens.<br />
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
//
$prevAmount = $userA['soldiers'];
//
$price = 600;
//cities
$cityC = mysql_query("SELECT id FROM cities WHERE nation='$userA[nation]'");
$cities = mysql_num_rows($cityC);
//
if($userA['chickens'] >= $cities) {
$price = $price*.97;
} if($userA['cotton'] >= $cities) {
$price = $price*.99;
}
//
$sellprice = 200;
$cityC = mysql_query("SELECT * FROM cities WHERE nation='$userA[nation]'");

//national armory marvel
if($userA['narmory'] == 1) {
$price = $price-($price*0.05);
}

while($cityF = mysql_fetch_array($cityC)) {
$population = $population+$cityF['population'];
}

$maximum = (($population*8)/100);

if(isset($_POST['send'])) {

$amount = round(mysql_real_escape_string(htmlentities($_POST['amount'])));

$negative = 0;
$cost = round($amount*$price);



if(!is_numeric($amount)) {
$error .= "Error01 - You did not enter a numeric value.<br />";
} if($amount < 0) {
$negative = 1;
} if($amount > 1000000) {
$error .= "Error02 - You cannot purchase more than 1,000,000 soldiers at a time.<br />";
} if($amount < -1000000) {
$error .= "Error03 - You cannot sell more than 1,000,000 soldiers at a time.<br />";
} if($amount+$prevAmount > $maximum AND $amount+$prevAmount > $prevAmount) {
$error .= "Error04 - You cannot purchase more than ".number_format($maximum)." soldiers.<br />";
}

if($negative == 0) {
if($cost > $userA['money']) {
$error .= "Error04 - You cannot purchase that many soldiers because you do not have that much money.<br />";
} 
}
if($negative == 1) {
if($amount+$prevAmount < 0) {
$error .= "Error05 - You cannot sell that many soldiers because you do not have that many soldiers.<br />";
}
}

if($error == null) {
if($negative == 0) {
$newmoney = round($userA['money']-$cost);
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', soldiers='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully purchased ".number_format($amount)." soldiers at a cost of $".number_format($cost).". You now have ".number_format($newamount)." soldiers and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a><br />";
}
if($negative == 1) {
$newmoney = abs($amount*$sellprice)+$userA['money'];
$newamount = round($prevAmount+$amount);
mysql_query("UPDATE players SET money='$newmoney', soldiers='$newamount' WHERE id='$id'");
echo "<br /><br />You have successfully sold ".number_format(abs($amount))." soldiers at a price of $".number_format(abs($amount*$sellprice)).". You now have ".number_format($newamount)." soldiers and a balance of $".number_format($newmoney).".<br /><center><a href='index.php?id=7'>View Nation</a></center>";
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
$prevAmount = $userA['soldiers'];
//
$sellprice = 200;



$maxbuy = round(($userA['money']/$price)-0.5);
$maxsell = $prevAmount;
if($maxbuy > 1000000) {
$maxbuy = 1000000;
} if($prevAmount > 1000000) {
$maxsell = 1000000;
} if($maxbuy+$prevAmount > $maximum) {
$maxbuy = $maximum-$prevAmount-.5;
} if($maxbuy < 0) {
$maxbuy = 0;
}

?>
<br />
<form action="index.php?id=19" method="post">
</center><table id="black">
<tr id="black"><td id="black"><b>Soldiers:</b></td><td id="black"><?php echo number_format($prevAmount); ?></td><td id="black"><b>Purchase Cost:</b></td><td id="black">$<?php echo number_format($price); ?></td></tr>
<tr id="black"><td id="black"><b>Balance:</b></td><td id="black">$<?php echo number_format($userA['money']); ?></td><td id="black"><b>Sell Price:</b></td><td id="black">$<?php echo number_format($sellprice); ?></td></tr>
<tr id="black"><td id="black"><b>Maximum Purchase:</b></td><td id="black"><?php echo number_format($maxbuy); ?></td><td id="black"><b>Maximum Sale:</b></td><td id="black">-<?php echo number_format($maxsell); ?></td></tr>
<tr id="black"><td id="black" colspan="4" class="center">Buy/Sell Amount: <input type="text" name="amount" maxlength="8" value="<?php echo round($maxbuy); ?>" max="100000" required></td></tr>
</table><br />
<center><input type="submit" name="send" value="Buy/Sell"></center>
</form>