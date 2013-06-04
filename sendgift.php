<div id="title">Send Shipment</div>
<img src="images/gift.jpg" class="center"><br />
If you're feeling a little generous, or just have some extra money you'd like to get rid of, you can send a shipment to another player composed of money and/or soldiers. You cannot send more than $10,000,000, 5,000 soldiers, or 3,000 resources at a time, unless you have the World Trade Center marvel. You also can only send 3 shipments every 5 days, unless you have researched Online Banking.<br /><br/>
<?php
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

require("loggedin.php");
$id = mysql_real_escape_string($purifier->purify($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
$userFetch = $userF;

$to = mysql_real_escape_string($purifier->purify($_GET['to']));
$money = $userF['money'];
$soldiers = $userF['soldiers'];

if(!isset($_POST['submit'])) {
?>
<form action='index.php?id=61' method='post'><center><table><tr><td colspan='4' class='right'>Receiving Player:</td><td colspan='4'><input type='text' name='player' value='<?php echo $to; ?>'></td></tr>
<tr><td colspan='2'></td><td>Money to Give:</td><td><input type='number' name='money' value='0' size='8' max='20000000'></td><td>Soldiers to Give:</td><td><input type='number' name='soldiers' maxlength='4' value='0' size='4' max='5000'></td><td colspan='2'></td></tr>
<tr><td colspan='8' class='center'>Resources to Send</td></tr>
<tr id="black"><td id="black"><img src="images/icons/coal.png"><b>Coal:</b></td><td id="black"><input type='number' value='0' name='coal' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/cod.png"><b>Cod:</b></td><td id="black"><input type='number' value='0' name='cod' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/cotton.png"><b>Cotton:</b></td><td id="black"><input type='number' value='0' name='cotton' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/oil.png"><b>Crude Oil:</b></td><td id="black"><input type='number' value='0' name='oil' min='0' max='3000' size='4'></td></tr>
<tr id="black"><td id="black"><img src="images/icons/coffee.png"><b>Coffee Beans:</b></td><td id="black"><input type='number' value='0' name='coffee' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/composite.png"><b>Composite:</b></td><td id="black"><input type='number' value='0' name='composite' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/gold.png"><b>Gold:</b></td><td id="black"><input type='number' value='0' name='gold' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/chickens.png"><b>Chickens:</b></td><td id="black"><input type='number' value='0' name='chickens' min='0' max='3000' size='4'></td></tr>
<td id="black"><img src="images/icons/corn.png"><b>Corn:</b></td><td id="black"><input type='number' value='0' name='corn' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/copper.png" title="Reduces the cost of zones by 2%"><b>Copper:</b></td><td id="black"><input type='number' value='0' name='copper' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/iron.png"><b>Iron:</b></td><td id="black"><input type='number' value='0' name='iron' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/gems.png"><b>Gems:</b></td><td id="black"><input type='number' value='0' name='gems' min='0' max='3000' size='4'></td>
<tr id="black"><td id="black"><img src="images/icons/rubber.png"><b>Rubber:</b></td><td id="black"><input type='number' value='0' name='rubber' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/silver.png"><b>Silver:</b></td><td id="black"><input type='number' value='0' name='silver' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/timber.png"><b>Timber:</b></td><td id="black"><input type='number' value='0' name='timber' min='0' max='3000' size='4'></td><td id="black"><img src="images/icons/water.png"><b>Fresh Water:</b></td><td id="black"><input type='number' value='0' name='water' min='0' max='3000' size='4'></td></tr>

</table><br /><input type='submit' name='submit' value='Send Shipment'></center>
<?php
}

if(isset($_POST['submit'])) {
$giftmoney = max((mysql_real_escape_string($purifier->purify($_POST['money']))), 0);
$giftsoldiers = max((mysql_real_escape_string($purifier->purify($_POST['soldiers']))), 0);
$receiver = max((mysql_real_escape_string($purifier->purify($_POST['player']))), 0);
$rubber = max((mysql_real_escape_string($purifier->purify($_POST['rubber']))), 0);
$coal = max((mysql_real_escape_string($purifier->purify($_POST['coal']))), 0);
$cod = max((mysql_real_escape_string($purifier->purify($_POST['cod']))), 0);
$corn = max((mysql_real_escape_string($purifier->purify($_POST['corn']))), 0);
$timber = max((mysql_real_escape_string($purifier->purify($_POST['timber']))), 0);
$copper = max((mysql_real_escape_string($purifier->purify($_POST['copper']))), 0);
$iron = max((mysql_real_escape_string($purifier->purify($_POST['iron']))), 0);
$oil = max((mysql_real_escape_string($purifier->purify($_POST['oil']))), 0);
$chickens = max((mysql_real_escape_string($purifier->purify($_POST['chickens']))), 0);
$water = max((mysql_real_escape_string($purifier->purify($_POST['water']))), 0);
$silver = max((mysql_real_escape_string($purifier->purify($_POST['silver']))), 0);
$gold = max((mysql_real_escape_string($purifier->purify($_POST['gold']))), 0);
$gems = max((mysql_real_escape_string($purifier->purify($_POST['gems']))), 0);
$composite = max((mysql_real_escape_string($purifier->purify($_POST['composite']))), 0);
$coffee = max((mysql_real_escape_string($purifier->purify($_POST['coffee']))), 0);
$cotton = max((mysql_real_escape_string($purifier->purify($_POST['cotton']))), 0);


$username = $userF['username'];

$recCheck = mysql_query("SELECT * FROM players WHERE username='$receiver'");
$recFetch = mysql_fetch_array($recCheck);
$recNum = mysql_num_rows($recCheck);

$aidC = mysql_query("SELECT * FROM aid WHERE sender='$username'");
$aidN = mysql_num_rows($aidC);

$recaidC = mysql_query("SELECT * FROM aid WHERE receiver = '$receiver'");
$recaidN = mysql_num_rows($recaidC);

$aidslots = 2;
$maxsend = 10000000;

if($userF['wtc'] == 1) {
$maxsend = 20000000;
} if($userF['obank'] == 1) {
$aidslots = 3;
}

//check for errors
if(!is_numeric($giftmoney)) {
$error .= "You did not enter a numeric value in the money field.<br />";
} if(!is_numeric($giftsoldiers)) {
$error .= "You did not enter a numeric value in the soldiers field.<br />";
} if($recNum != 1) {
$error .= "The player you are trying to send a gift to does not exist.<br />";
} if($giftmoney > $money) {
$error .= "You do not have that much money to give.<br />";
} if($giftsoldiers > $soldiers) {
$error .= "You do not have that many soldiers to give.<br />";
} if($aidN > $aidslots) {
$error .= "You cannot send more than ".$aidslots." shipments every 5 days.<br />";
} if($giftmoney > $maxsend) {
$error .= "You cannot send more than $".number_format($maxsend)." at a time.<br />";
} if($giftsoldiers > 5000) {
$error .= "You cannot send more than 5,000 soldiers at a time.<br />";
} if($giftmoney < 0) {
$error .= "You can not send a negative amount of funds.<br />";
} if($giftsoldiers < 0) {
$error .= "You can not send a negative amount of soldiers.<br />";
} if($userF['readiness'] == "peace" AND $recFetch['readiness'] == "war") {
$error .= "You cannot send shipments to wargoing nations while being a peaceful nation.<br />";
} if($recaidN > 9) {
$error .= "You cannot send shipments to this nation because they have already received 10 shipments in the past 5 days.<br />";
} if(($cotton+$rubber+$coal+$cod+$corn+$timber+$copper+$iron+$oil+$chickens+$water+$silver+$gold+$gems+$composite+$coffee) > 3000) {
$error .= "You cannot send more than 3,000 resources at a time.<br />";
} if($userF['cotton'] < $cotton) {
$error .= "You do not have that much cotton to send.<br />";
} if($userF['rubber'] < $rubber) {
$error .= "You do not have that much rubber to send.<br />";
} if($userF['coal'] < $coal) {
$error .= "You do not have that much coal to send.<br />";
} if($userF['cod'] < $cod) {
$error .= "You do not have that much cod to send.<br />";
} if($userF['corn'] < $corn) {
$error .= "You do not have that much corn to send.<br />";
} if($userF['timber'] < $timber) {
$error .= "You do not have that much timber to send.<br />";
} if($userF['copper'] < $copper) {
$error .= "You do not have that much copper to send.<br />";
} if($userF['iron'] < $iron) {
$error .= "You do not have that much iron to send.<br />";
} if($userF['oil'] < $oil) {
$error .= "You do not have that much crude oil to send.<br />";
} if($userF['chickens'] < $chickens) {
$error .= "You do not have that many chickens to send.<br />";
} if($userF['water'] < $water) {
$error .= "You do not have that much fresh water to send.<br />";
} if($userF['silver'] < $silver) {
$error .= "You do not have that much silver to send.<br />";
} if($userF['gold'] < $gold) {
$error .= "You do not have that much gold to send.<br />";
} if($userF['gems'] < $gems) {
$error .= "You do not have that many gems to send.<br />";
} if($userF['composite'] < $composite) {
$error .= "You do not have that much composite to send.<br />";
} if($userF['coffee'] < $coffee) {
$error .= "You do not have that many coffee beans to send.<br />";
}

if($error == null) {
$reccotton = $recFetch['cotton']+$cotton;
$recrubber = $recFetch['rubber']+$rubber;
$reccoal = $recFetch['coal']+$coal;
$reccod = $recFetch['cod']+$cod;
$reccorn = $recFetch['corn']+$corn;
$rectimber = $recFetch['timber']+$timber;
$reccopper = $recFetch['copper']+$copper;
$reciron = $recFetch['iron']+$iron;
$recoil = $recFetch['oil']+$oil;
$recchickens = $recFetch['chickens']+$chickens;
$recwater = $recFetch['water']+$water;
$recsilver = $recFetch['silver']+$water;
$recgold = $recFetch['gold']+$gold;
$recgems = $recFetch['gems']+$gems;
$reccomposite = $recFetch['composite']+$composite;
$reccoffee = $recFetch['coffee']+$coffee;

$usercotton = $userFetch['cotton']-$cotton;
$userrubber = $userFetch['rubber']-$rubber;
$usercoal = $userFetch['coal']-$coal;
$usercod = $userFetch['cod']-$cod;
$usercorn = $userFetch['corn']-$corn;
$usertimber = $userFetch['timber']-$timber;
$usercopper = $userFetch['copper']-$copper;
$useriron = $userFetch['iron']-$iron;
$useroil = $userFetch['oil']-$oil;
$userchickens = $userFetch['chickens']-$chickens;
$userwater = $userFetch['water']-$water;
$usersilver = $userFetch['silver']-$water;
$usergold = $userFetch['gold']-$gold;
$usergems = $userFetch['gems']-$gems;
$usercomposite = $userFetch['composite']-$composite;
$usercoffee = $userFetch['coffee']-$coffee;

$recmoney = $recFetch['money']+$giftmoney;
$recsoldiers = $recFetch['soldiers']+$giftsoldiers;
$newmoney = $money-$giftmoney;
$newsoldiers = $soldiers-$giftsoldiers;
$totalresources = $cotton+$rubber+$coal+$cod+$corn+$timber+$copper+$iron+$oil+$chickens+$water+$silver+$gold+$gems+$composite+$coffee;
$bodymsg = " ".$username." has sent you a shipment! You have received $".number_format($giftmoney).", ".number_format($giftsoldiers)." soldiers, ".number_format($cotton)." cotton, ".number_format($rubber)." rubber, ".number_format($coal)." coal, ".number_format($cod)." cod, ".number_format($corn)." corn, ".number_format($timber)." timber, ".number_format($copper)." copper, ".number_format($iron)." iron, ".number_format($oil)." crude oil, ".number_format($chickens)." chickens, ".number_format($water)." fresh water,".number_format($composite)." composite, ".number_format($silver)." silver, ".number_format($gold)." gold, ".number_format($gems)." gems, and ".number_format($coffee)." coffee beans.";
$date = date("c");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$receiver', '$username', 'Shipment Received', '$bodymsg', '$date', '0', '0')");
mysql_query("INSERT INTO aid (sender, receiver, date, money, soldiers, resources) VALUES ('$username', '$receiver', '$date', '$giftmoney', '$giftsoldiers', '$totalresources')");
mysql_query("UPDATE players SET money='$newmoney', soldiers='$newsoldiers', cotton='$usercotton', rubber='$userrubber', coal='$usercoal', cod='$usercod', corn='$usercorn', timber='$usertimber', copper='$copper', iron='$useriron', oil='$useroil', chickens='$userchickens', water='$userwater', composite='$usercomposite', silver='$usersilver', gold='$usergold', gems='$usergems', coffee='$usercoffee' WHERE username='$username'");
mysql_query("UPDATE players SET money='$recmoney', soldiers='$recsoldiers', cotton='$reccotton', rubber='$recrubber', coal='$reccoal', cod='$reccod', corn='$reccorn', timber='$rectimber', copper='$copper', iron='$reciron', oil='$recoil', chickens='$recchickens', water='$recwater', composite='$reccomposite', silver='$recsilver', gold='$recgold', gems='$recgems', coffee='$reccoffee' WHERE username='$receiver'");
echo "You have successfully sent $".number_format($giftmoney).", ".number_format($giftsoldiers)." soldiers, ".number_format($cotton)." cotton, ".number_format($rubber)." rubber, ".number_format($coal)." coal, ".number_format($cod)." cod, ".number_format($corn)." corn, ".number_format($timber)." timber, ".number_format($copper)." copper, ".number_format($iron)." iron, ".number_format($oil)." crude oil, ".number_format($chickens)." chickens, ".number_format($water)." fresh water,".number_format($composite)." composite, ".number_format($silver)." silver, ".number_format($gold)." gold, ".number_format($gems)." gems, and ".number_format($coffee)." coffee beans to ".$receiver."!";
} else {
echo "You have received the following errors:<br />";
echo $error;
}
}
?>