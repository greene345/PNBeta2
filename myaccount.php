<div id="title">My Account</div>
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
$email = $userF['email'];

$nation = $userF['nation'];
$capital = $userF['capital'];

if($_POST['mail'] == "Submit Changes") {
$mail1 = mysql_real_escape_string($purifier->purify($_POST['mail1']));
$mail2 = mysql_real_escape_string($purifier->purify($_POST['mail2']));
$warmail = mysql_real_escape_string($purifier->purify($_POST['war']));
$adminmail = mysql_real_escape_string($purifier->purify($_POST['admin']));
$javamenu = mysql_real_escape_string($purifier->purify($_POST['javamenu']));

$mailC = mysql_query("SELECT * FROM players WHERE email='$mail1'");
$mailN = mysql_num_rows($mailC);

if($javamenu != 1) {
$javamenu = 0;
}
if($warmail != 1) {
$warmail = 0;
} if($adminmail != 1) {
$adminmail = 0;
}
if($mail1 != null AND $mail2 != null) {
if($mail1 != $mail2) {
$error .= "Error01 - Your e-mail addresses did not match.<br />";
} if(!filter_var($mail1, FILTER_VALIDATE_EMAIL)) {
$error .= "Error02 - You have entered an invalid e-mail address.<br />";
} if($mailN != 0) {
$error .= "Error03 - There is already an account with that e-mail address. Please use another.<br />";
}
} else {
$mail1 = $email;
}
if($error == null) {
mysql_query("UPDATE players SET email='$mail1', warmail='$warmail', adminmail='$adminmail', javamenu='$javamenu' WHERE id='$id'");
echo "You have successfully updated your account.<br />";
} else {
echo "You received the following errors:</br >";
echo $error;
echo "<br />";
}

}

if($_POST['pass'] == "Submit Changes") {
$oldpass = mysql_real_escape_string($purifier->purify($_POST['oldpass']));
$pass1 = mysql_real_escape_string($purifier->purify($_POST['pass1']));
$pass2 = mysql_real_escape_string($purifier->purify($_POST['pass2']));

$salt = "oLLy16jeeerKy84";
$oldpass1 = md5($salt.$oldpass);

//password encyption
$saltA = "B1F030404D36B8F75E66D10135298F84D31ECB93ED8E905AA5365481F2A";
$saltB = $capital.$saltA;
$saltC = $saltB.$oldpass.$nation;
$oldpass2 = hash("sha256", $saltC);

if($oldpass1 != $userF['password'] AND $oldpass2 != $userF['password']) {
$error .= "Error04 - You did not type in the correct password.<br />";
} if($pass1 != $pass2) {
$error .= "Error05 - Your passwords did not match.<br />";
} if(strlen($pass1) < 8) {
$error .= "Error06 - Your password cannot be less than 8 characters.<br />";
}

if($error == null) {

//password encyption
$saltA = "B1F030404D36B8F75E66D10135298F84D31ECB93ED8E905AA5365481F2A";
$saltB = $capital.$saltA;
$saltC = $saltB.$pass1.$nation;
$pass = hash("sha256", $saltC);

mysql_query("UPDATE players SET password='$pass' WHERE id='$id'");
echo "You have successfully updated your account.<br />";
} else {
echo "You have received the following errors:<br />";
echo $error;
echo "<br />";


}
}

if($_POST['delete'] == "Delete Nation") {
if($_POST['final'] == "yes") {
$id = $id;
$username = $userF['username'];
$nation = $userF['nation'];
//delete events
mysql_query("DELETE FROM events WHERE nation='$nation'");
//delete nukes
mysql_query("DELETE FROM nukes WHERE nation='$nation'");
//delete wars
mysql_query("DELETE FROM wars WHERE attacker='$username'");
mysql_query("DELETE FROM wars WHERE defender='$username'");
//delete messages
mysql_query("DELETE FROM messages WHERE receiver='$username'");
//delete cities
mysql_query("DELETE FROM cities WHERE nation='$nation'");
//delete player
mysql_query("DELETE FROM players WHERE id='$id'");
session_destroy();
echo "<meta http-equiv='REFRESH' content='0;url=http://www.pixelnations.net/beta/'>";
}
}


$id = mysql_real_escape_string($purifier->purify($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
$email = $userF['email'];

?>
<table class="center">
<form action="index.php?id=26" method="post">
<tr><td class="center" colspan="2"><b>Change E-mail Address</b></td></tr>
<tr class="left"><td class="left" width="50%">Current E-mail:</td><td class="left" width="50%"><?php echo $email; ?></td></tr>
<tr><td class="left">New E-mail:</td><td class="left"><input type="text" name="mail1" maxlength="32"></td></tr>
<tr><td class="left">Confirm E-mail:</td><td class="left"><input type="text" name="mail2" maxlength="32"></td></tr>
<tr><td class="left">E-mail Me When<br /> Someone Declares<br /> War On Me</td><td class="left"><input type="checkbox" name="war" value="1" <?php if($userF['warmail'] == 1) { echo "checked"; } ?>></td></tr>
<tr><td class="left">Allow Admin to Send<br /> Me Important E-mails</td><td class="left"><input type="checkbox" name="admin" value="1" <?php if($userF['adminmail'] == 1) { echo "checked"; } ?>></td></tr>
<tr><td class="left">Use Javascript Menu</td><td class="left"><input type="checkbox" name="javamenu" value="1" <?php if($userF['javamenu'] == 1) { echo "checked"; } ?>></td></tr>
<tr><td class="center" colspan="2"><input type="submit" name="mail" value="Submit Changes"></td></tr>
</form>
</table>
<hr>
<table class="center">
<form action="index.php?id=26" method="post">
<tr><td class="center" colspan="2"><b>Change Password</b></td></tr>
<tr class="left"><td class="left" width="50%">Old Password:</td><td class="left" width="50%"><input type="password" name="oldpass" maxlength="32"></td></tr>
<tr><td class="left">New Password:</td><td class="left"><input type="password" name="pass1" maxlength="20"></td></tr>
<tr><td class="left">Confirm Password:</td><td class="left"><input type="password" name="pass2" maxlength="20"></td></tr>
<tr><td class="center" colspan="2"><input type="submit" name="pass" value="Submit Changes"></td></tr>
</form>
</table>
<hr>
<center><b>Delete Account</b></center>
If you wish to delete your account, you may do so here. Please know that once you delete your account it is final, and your account will not be able to be restored. If you wish to play again, you will have the option to re-register.
<br /><br />
<center><form action="index.php?id=26" method="post"><input type="checkbox" name="final" value="yes"> I am aware that deleting my nation is final and permanent, and I wish to do so<br /><input type="submit" value="Delete Nation" name="delete"></form></center>




