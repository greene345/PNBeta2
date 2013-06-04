<div id="title">Complete Offer</div>
<?php
require("loggedin.php");
$marketid = mysql_real_escape_string(htmlentities($_GET['marketid']));
$marketcheck = mysql_query("SELECT * FROM market WHERE id='$marketid'");
$marketfetch = mysql_fetch_array($marketcheck);

$resource = $marketfetch['resource'];
$amount = $marketfetch['amount'];
$buysell = $marketfetch['buysell'];
$price = $marketfetch['price'];
$buyerseller = $marketfetch['username'];
$ver = mysql_real_escape_string(htmlentities($_GET['ver']));

$salt = "10j3a8G2O3C587I77Fv34nFSlYbn66";

$total = round($amount*$price,2);

$id = mysql_real_escape_string($_SESSION['id']);
$userF = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE id='$id'"));

$realcode = substr(md5($userF['id'].$salt), 0, 8);
if($realcode != $ver) {
$error .= "Please go back and try again.<br />";
}

$usermoney = $userF['money'];

if($marketfetch['completed'] == 1) {
$error .= "That offer has already been completed.<br />";
}

if($buysell == "buy") {
//current user is selling
$available = $userF[$resource];
if($available < $amount) {
$error .= "You do not have enough of that resource to sell.<br />";
}

$date = date('c');

if($error == null) {
$newuserresource = $available-$amount;
$newmoney = $userF['money']+$total;
mysql_query("UPDATE players SET money='$newmoney', ".$resource."='$newuserresource' WHERE id='$userF[id]'");
$body = "Your market offer to buy ".number_format($amount)." ".$resource." at $".number_format($price,2)." per unit has been completed. You have received ".number_format($amount)." ".ucfirst($resource)." and the seller has received $".number_format($total,2).".";
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$marketfetch[username]', '$userF[username]', 'Market Offer Completed', '$body', '$date', '0', '0')");
$buyername = $marketfetch['username'];
$buyC = mysql_query("SELECT * FROM players WHERE username='$buyername'");
$buyF = mysql_fetch_array($buyC);
$newbuyerresource = $buyF[$resource]+$amount;
mysql_query("UPDATE players SET ".$resource."='$newbuyerresource' WHERE id='$buyF[id]'");
mysql_query("UPDATE market SET completed='1' WHERE id='$marketid'");
echo "You have successfully sold ".number_format($amount)." ".$resource." at $".number_format($price,2)." per unit, earning a total of $".number_format($total,2).".";
} else {
echo "You've received the following errors:<br /><br />";
echo $error;
}
}

if($buysell == "sell") {
//current user is buying
$availablemoney = $userF['money'];
if($availablemoney < $total) {
$error .= "You do not have enough money to complete that offer.<br />";
}

$date = date('c');

if($error == null) {
$newuserresource = $userF[$resource]+$amount;
$newmoney = $userF['money']-$total;
mysql_query("UPDATE players SET money='$newmoney', ".$resource."='$newuserresource' WHERE id='$id'");
$body = "Your market offer to sell ".number_format($amount)." ".$resource." at $".number_format($price,2)." per unit has been completed. You have received $".number_format($total,2)." and the buyer received ".number_format($amount)." ".ucfirst($resource).".";
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$marketfetch[username]', '$userF[username]', 'Market Offer Completed', '$body', '$date', '0', '0')");
$buyername = $marketfetch['username'];
$buyC = mysql_query("SELECT * FROM players WHERE username='$buyername'");
$buyF = mysql_fetch_array($buyC);
$newmoney = $buyF['money']+$total;
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$buyF[id]'");
mysql_query("UPDATE market SET completed='1' WHERE id='$marketid'");
echo "You have successfully purchased ".number_format($amount)." ".$resource." at $".number_format($price,2)." per unit, spending a total of $".number_format($total,2).".";
} else {
echo "You've received the following errors:<br /><br />";
echo $error;
}
}

?>