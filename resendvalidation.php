<div id="title">Re-Send Validation E-mail</div>
<?php

if(isset($_POST['submit'])) {
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));
$email = mysql_real_escape_string(htmlentities($_POST['email']));

$check = mysql_query("SELECT * FROM players WHERE nation='$nation' AND email='$email'");
$fetch = mysql_fetch_array($check);
$num = mysql_num_rows($check);

if($fetch['verify'] == 0) {
$error .= "Your account has already been verified and you may login using the username ".$fetch['username']." and your password.<br />";
} 
if($num != 1) {
$error .= "The nation/e-mail combination you entered does not exist.<br />";
}

if($error == null) {
$verCode = $fetch['verify'];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$to = $email;
$subject = "Welcome to Pixel Nations!";
$message = "
<html>
<head>
<title>Thanks for registering at Pixel Nations!</title>
</head>
<body>
<p>Thanks " .$username. " for signing up at Pixel Nations! To validate your account, please click or copy and paste the following link in your browser:<br /><br /><br />
<a href='http://www.pixelnations.net/beta/index.php?id=4&val=" .$verCode. "'>http://www.pixelnations.net/beta/index.php?id=4&val=" .$verCode. "</a><br /><br />Once you have validated your account, you will be able to log in using the username <b>" .$username. "</b> and the password you created when you registered. 
</body>
</html>
";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= 'From: <webmaster@pixelnations.net>' . "\r\n";
mail($to,$subject,$message,$headers);
echo "Your validation e-mail has been re-sent to the e-mail address ".$email.". If you are still having trouble validating your account, please notify the admin or a moderator on the forums.";
} else {
echo "You have received the following error(s):<br /><br />";
echo $error;
}
} if(!isset($_POST['submit'])) {
echo "<form action='index.php?id=79' method='post'><center><table>
<tr><td>Nation Name:</td><td><input type='text' name='nation'></td></tr>
<tr><td>E-mail Address:</td><td><input type='text' name='email'></td></tr>
</table><br />
<input type='submit' name='submit' value='Resend Validation Email'></form></center>";
}
?>