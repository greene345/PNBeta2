<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT username, alliance, alliancepos, money FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$alliance = $idfetch['alliance'];
if($idfetch['alliance'] == "None" OR $idfetch['alliancepos'] == "Applicant") {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
$allianceC = mysql_query("SELECT * FROM alliances WHERE name='$alliance'");
$allF = mysql_fetch_array($allianceC);
$date = date('c');
$limit = 10;
if($_GET['tr'] == "1000") {
$limit = 1000;
}
?>
<div id="title"><?php echo stripslashes($idfetch['alliance']); ?> Bank</div>
<?php
if(!isset($_POST['withdraw']) AND !isset($_POST['send']) AND !isset($_POST['deposit'])) {
?>
<h2>Last <?php echo $limit; ?> Transactions</h2>
<table class='black'>
<tr class='black'><th class='thickblack'>Date</th><th class='thickblack'>Amount</th><th class='thickblack'>Transaction Type</th><th class='thickblack'>User</th></tr>
<?php
$bCheck = mysql_query("SELECT * FROM bank WHERE alliance='$alliance' ORDER BY date DESC LIMIT ".$limit."");
$bnum = mysql_num_rows($bCheck);
while($brow = mysql_fetch_array($bCheck)) {
echo "<tr class='black'><td class='center' id='black'>".date("m/d/y",strtotime($brow['date']))."</td><td class='right' id='black'>$".number_format($brow['amount'])."</td><td id='black' class='center'>".ucfirst($brow['type'])."</td><td class='center' id='black'>".$brow['user']."</td></tr>";
}
if($bnum == 0) {
echo "<tr class='black'><td class='center' id='black' colspan='4'>No Transactions in Bank History</td></tr>";
}
echo "</table>";
if($_GET['tr'] != "1000") {
echo "<br /><a href='index.php?id=98&tr=1000'>Show Last 1000 Transactions</a>";
} else {
echo "<br /><a href='index.php?id=98'>Show Last 10 Transactions</a>";
}
echo "<h2>Current Balance</h2>";
echo "$".number_format($allF['bank'])."";
echo "<h2>Deposit to Bank</h2>";
echo "<form action='index.php?id=98' method='post'>Amount: $<input type='number' name='amount' min='0'> <input submit name='deposit' value='Deposit' type='submit'></form>";
if($idfetch['alliancepos'] == "Agent" OR $idfetch['alliancepos'] == "Founder") {
echo "<h2>Withdraw from Bank</h2>";
echo "<form action='index.php?id=98' method='post'>Amount: $<input type='number' name='withdrawamount' min='0'> Nation: <input type='text' name='nation'> <input type='submit' name='withdraw' value='Withdraw'></form>";
echo "<h2>Send to Alliance</h2>";
echo "<form action='index.php?id=98' method='post'>Amount: $<input type='number' name='alliancesendamount' min='0'> Alliance: <input type='text' name='alliance'> <input type='submit' name='send' value='Send'></form>";
}
} else {
//deposit
if(isset($_POST['deposit'])) {
$amount = mysql_real_escape_string(htmlentities($_POST['amount']));
$usermoney = $idfetch['money'];
$alliancemoney = $allF['bank'];
if($amount > $usermoney) {
$error .= "You do not have that much money to send.<br />";
} if(!is_numeric($amount)) {
$error .= "You did not enter a numeric amount.<br />";
} if($amount < 0) {
$error .= "You cannot enter a negative amount.<br />";
}
if($error == null) {
$newamoney = $amount+$alliancemoney;
$newumoney = $usermoney-$amount;
mysql_query("UPDATE players SET money='$newumoney' WHERE username='$idfetch[username]'");
mysql_query("UPDATE alliances SET bank='$newamoney' WHERE name='$alliance'");
mysql_query("INSERT INTO bank (date, alliance, user, amount, type) VALUES ('$date', '$alliance', '$idfetch[username]', '$amount', 'Deposit')");
echo "You have successfully executed your transaction. <a href='index.php?id=98'>Back to Alliance Bank</a>";
} else {
echo "<h2>Error!</h2>";
echo $error;
}
}
//withdraw
if(isset($_POST['withdraw'])) {
$amount = mysql_real_escape_string(htmlentities($_POST['withdrawamount']));
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));
$natC = mysql_query("SELECT money, username FROM players WHERE nation='$nation'");
$natN = mysql_num_rows($natC);
$natF = mysql_fetch_array($natC);
if($natN != 1) {
$error .= "That nation doesn't exist.<br />";
} if($amount > $allF['bank']) {
$error .= "The alliance bank does not have that much to withdraw.<br />";
} if(!is_numeric($amount)) {
$error .= "You did not enter a numeric amount.<br />";
} if($amount < 0) {
$error .= "You cannot enter a negative amount.<br />";
}
if($error == null) {
$newamoney = $allF['bank']-$amount;
$newumoney = $natF['money']+$amount;
$body = mysql_real_escape_string("Congratulations! You have received $".number_format($amount)." from the ".$alliance." Bank! The withdrawal from the bank was initiated by ".$idfetch['username'].".");
mysql_query("UPDATE players SET money='$newumoney' WHERE nation='$nation'");
mysql_query("UPDATE alliances SET bank='$newamoney' WHERE name='$alliance'");
mysql_query("INSERT INTO bank (date, alliance, user, amount, type) VALUES ('$date', '$alliance', '$idfetch[username]', '$amount', 'Withdrawal')");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$natF[username]', '$idfetch[username]', 'Shipment from Bank', '$body', '$date', '0', '0')");
echo "You have successfully executed your transaction. <a href='index.php?id=98'>Back to Alliance Bank</a>";
} else {
echo "<h2>Error!</h2>";
echo $error;
}
}
//send to other alliance
if(isset($_POST['send'])) {
$recalliance = mysql_real_escape_string(htmlentities($_POST['alliance']));
$amount = mysql_real_escape_string(htmlentities($_POST['alliancesendamount']));
$aC = mysql_query("SELECT bank FROM alliances WHERE name='$recalliance'");
$aN = mysql_num_rows($aC);
$aF = mysql_fetch_array($aC);
if(!is_numeric($amount)) {
$error .= "You did not enter a numeric amount.<br />";
} if($aN != 1) {
$error .= "That alliance doesn't exist.<br />";
} if($amount > $allF['bank']) {
$error .= "The alliance bank does not have that much to withdraw.<br />";
} if($amount < 0) {
$error .= "You cannot enter a negative amount.<br />";
}
if($error == null) {
$newrmoney = $aF['bank']+$amount;
$newamoney = $allF['bank']-$amount;
mysql_query("UPDATE alliances SET bank='$newrmoney' WHERE name='$recalliance'");
mysql_query("UPDATE alliances SET bank='$newamoney' WHERE name='$alliance'");
mysql_query("INSERT INTO bank (date, alliance, user, amount, type) VALUES ('$date', '$recalliance', '".$alliance." Bank', '$amount', 'Deposit')");
mysql_query("INSERT INTO bank (date, alliance, user, amount, type) VALUES ('$date', '$alliance', '$idfetch[username]', '$amount', 'Withdrawal')");
echo "You have successfully executed your transaction. <a href='index.php?id=98'>Back to Alliance Bank</a>";
} else {
echo "<h2>Error!</h2>";
echo $error;
}
}
}
?>