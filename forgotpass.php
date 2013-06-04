<div id="title">Forgot Password</div>
<?php
if(isset($_POST['submit'])) {
$email = mysql_real_escape_string(htmlentities($_POST['email']));
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$error .= "You have not entered a valid e-mail address.<br />";
}
$eS = mysql_query("SELECT * FROM players WHERE email='$email'");
if(mysql_num_rows($eS) == 0) {
$error .= "An account has not been registered with this e-mail address.<br />";
} if(strlen($email) > 40) {
$error .= "You did not enter a valid e-mail address.<br />";
}

if($error == null) {

$eF = mysql_fetch_array($eS);
$username = $eF['username'];
$nation = $eF['date_reg'];
$salt = "';`7z)0)^?1A-57T0SQ4X5y`[e`O}xxxLevK62d93mG9[";
$code = hash("sha256", $nation.$salt);
$realcode = substr($code, 0, 8);
$to = $email;
$subject = "Pixel Nations Reset Password";
$message = "
<html>
<head>
<title>Reset Your Password</title>
</head>
<body>
<p>A request has been made to reset the password for the Pixel Nations account using the email ".$email."<br /><br />If you made this request, please click <a href='http://www.pixelnations.net/beta/index.php?id=32&username=".$username."&code=".$realcode."'>here</a> to reset your password. If you did not make this request, simply ignore this e-mail.</p>
</body>
</html>
";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= 'From: <webmaster@pixelnations.net>' . "\r\n";
mail($to,$subject,$message,$headers);
echo "An e-mail has been sent to ".$email." with information for changing your password.";
} else {
echo "You have received the following error(s):<br /><br />";
echo $error;
echo "<br /><center><a href='index.php?id=31'>Go Back</a></center><br />";
}
} else {
echo "If you have forgotten your password, you may enter the e-mail address you registered and you will receive an e-mail with further instructions on how to change your password.<br />";
echo "<form action='index.php?id=31' method='post'><table class='center'><tr><td>Email Address:</td><td><input type='text' name='email'></td></tr><tr><td colspan='2'><input type='submit' value='Submit' name='submit'></td></tr></table></form>";
}
?>