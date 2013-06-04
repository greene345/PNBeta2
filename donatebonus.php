<div id="title">Donation Bonus</div>
<?php
$id = $_SESSION['id'];
require("loggedin.php");
if($_SESSION['id'] != "127") {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta">';
die();
}

if(!isset($_GET['nation']) AND $id == 127) {
$token = md5(rand(99999,999999));
$_SESSION['token'] = $token;
echo "<form action='index.php?id=84'><center>Nation Name: <input type='text' name='nation'> <select name='bonus'><option value='5'>$5</option><option value='10'>$10</option><option value='20'>$20</option></select> <select name='double'><option value='0'>Normal</option><option value='1'>Double</option></select> <input type='hidden' value='".$token."' name='token'><input type='hidden' value='84' name='id'><input type='submit' value='Go'></form></center>";
} if(isset($_GET['nation']) AND $id == 127) {
$nation = mysql_real_escape_string(htmlentities($_GET['nation']));
$bonus = mysql_real_escape_string(htmlentities($_GET['bonus']));
$double = mysql_real_escape_string(htmlentities($_GET['double']));
$token = mysql_real_escape_string(htmlentities($_GET['token']));
$check1 = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$fetch1 = mysql_fetch_array($check1);
$num = mysql_num_rows($check1);
if($num != 1) {
$error .= "<p>That nation doesn't exist.</p>";
}
$diff10 = abs(strtotime($fetch1['donate_date']) - strtotime(date(c)));
$hours10 = round($diff10/60/60/24);
if($bonus != 5 AND $bonus != 10 AND $bonus != 20) {
$error .= "<p>You did not choose a valid bonus.</p>";
}
if($_SESSION['token'] != $token) {
$error .= "Invalid entry.<br />";
}

if($error == null AND $id == 127 AND $_SESSION['token'] == $token) {

if($bonus == 5) {
$cash = 5000000;
} if($bonus == 10) {
$cash = 12000000;
} if($bonus == 20) {
$cash = 25000000;
}

if($double == 1) {
$cash = $cash*2;
}

$date = date("c");
$newcash = $fetch1['money']+$cash;
$message = mysql_real_escape_string("Hello, your donation bonus has been processed. You donated $".$bonus." and received $".number_format($cash).". Thanks for donating!");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$fetch1[username]', 'Admin', 'Donation Bonus', '$message', '$date', '0', '0')");
mysql_query("UPDATE players SET money='$newcash', donate_date='$date' WHERE nation='$nation'");
echo "Donation Bonus processed.";
$_SESSION['token'] = "1";
} else {
echo $error;
}
}

?>