<div id="title">Buy Nuclear Weapons</div>
<img class="center" src="images/buymissiles.jpg">
<?php
require("loggedin.php");


$date = date("c");
$id = mysql_real_escape_string($_SESSION['id']);

$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$price = 200000000;

$money = $userF['money'];

//check for wars
$warcheck = mysql_query("SELECT * FROM wars WHERE attacker='$userF[username]' OR defender='$userF[username]'");
$wars = mysql_num_rows($warcheck);

if(isset($_POST['attack'])) {

$name = mysql_real_escape_string(htmlentities($_POST['name']));
if(strlen($name) > 16) {
$error .= "Your nuclear weapon's nickname cannot be longer than 16 characters.<br />";
}
if(strlen($name) < 3) {
$error .= "Your nuclear weapon's nickname cannot be shorter than 3 characters.<br />";
}
if($userF['wtf'] != 1) {
$error .= "You must purchase the Weapons Testing Facility before you can purchase nuclear weapons.<br />";
}
if($money < $price) {
$error .= "You do not have enough money to buy a nuclear weapon.<br />";
}
if($userF['fission'] != 1) {
$error .= "You must research Nuclear Fission before you can build nuclear weapons.<br />";
} if($wars != 0) {
$error .= "You cannot buy nuclear weapons while at war.<br />";
}

$nation = $userF['nation'];

if($error == null) {
$newmoney = $money-$price;
mysql_query("INSERT INTO nukes (name, date, nation) VALUES ('$name', '$date', '$nation')");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$id'");
echo "Congratulations! You bought a nuclear weapon!";
} else {
echo $error;
}

} else {
echo "Here you can buy nuclear weapons which cause devastating damage.<br />
<form action='index.php?id=38' method='post'><center><table><tr><td>Nickname:</td><td><input type='text' maxlength='16' name='name'></td></tr>
<tr><td>Cost:</td><td class='right'>$".number_format($price)."</td></tr><tr><td>Money Available:</td><td class='right'>$".number_format($money)."</td></tr></table><br /><input type='submit' value='Buy Nuclear Weapon' name='attack'></center></form>";
}

?>
