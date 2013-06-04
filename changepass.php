<div id="title">Change Password</div>
<?php
if(!isset($_GET['code'])) {
echo "There has been an unexpected error.<br />";
echo "<br /><a href='index.php'>Back</a>";
}
if(isset($_GET['code'])) {
$code = mysql_real_escape_string(htmlentities($_GET['code']));
$username = mysql_real_escape_string(htmlentities($_GET['username']));
$userS = mysql_query("SELECT * FROM players WHERE username='$username'");
if(mysql_num_rows($userS) != 1) {
$error = "There has been an unexpected error.<br />";
}
if($error == null) {
$userF = mysql_fetch_array($userS);
$nation = $userF['date_reg'];
$salt = "';`7z)0)^?1A-57T0SQ4X5y`[e`O}xxxLevK62d93mG9[";
$code = hash("sha256", $nation.$salt);
$realcode = substr($code, 0, 8);
$newpass = rand(10000,9999999);
$salt = "oLLy16jeeerKy84";
$nation = $userF['nation'];
$capital = $userF['capital'];
//password encyption
$saltA = "B1F030404D36B8F75E66D10135298F84D31ECB93ED8E905AA5365481F2A";
$saltB = $capital.$saltA;
$saltC = $saltB.$newpass.$nation;
$password = hash("sha256", $saltC);
mysql_query("UPDATE players SET password='$password' WHERE username='$username'");
echo "You have successfully reset your password. Your temporary password is ".$newpass."<br />Once you have logged in with this password you can change your password on the <a href='index.php?id=26'>\"My Account\"</a> page.";
} else {
echo "You have received the following error(s):<br /><br />";
echo $error;
echo "<br /><a href='index.php'>Go Back</a><br />";
}
}
?>