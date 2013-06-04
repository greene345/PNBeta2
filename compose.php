<div id="title">Compose Message</div>
<?php
require("loggedin.php");
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$check = mysql_query("SELECT * FROM players WHERE id='$id'");
$fetch = mysql_fetch_array($check);
$username = mysql_real_escape_string($fetch['username']);

if(isset($_POST['send'])) {
$token = mysql_real_escape_string(htmlentities($_POST['token']));
if($token != $_SESSION['token']) {
$error .= "Error001 - There was an error sending the message. Please try again. <br />";
}
$receiver = mysql_real_escape_string($purifier->purify($_POST['receiver']));
$sender = mysql_real_escape_string($purifier->purify($fetch['username']));
$subject = mysql_real_escape_string($purifier->purify($_POST['subject']));
$body = mysql_real_escape_string($purifier->purify($_POST['body']));
$date = mysql_real_escape_string(htmlentities(date("c")));
if($error == null) {
$recCheck = mysql_query("SELECT * FROM players WHERE username='$receiver'");
$recNum = mysql_num_rows($recCheck);
if($recNum != 1) {
$error .= "Error002 - You have entered an invalid recipient name. <br />";
} if($sender == null) {
$error .= "Error003 - There was an error sending the message. Please try again. <br />";
} if($subject == null) {
$error .= "Error004 - You did not give your message a subject.<br />";
} if($body == null) {
$error .= "Error005 - You did not write a message. <br />";
} if(strlen($subject) > 18) {
$error .= "Error006 - Your subject cannot be longer than 18 characters.<br />";
} if(strlen($body) > 1500) {
$error .= "Error007 - Your message cannot be longer than 1,500 characters.<br />";
} if($receiver == "Anson") {
$error .= "Error008 - You cannot message Anson because I am the game owner and administrator. Please make sure that you have exhausted all possible options before contacting me directly. Make sure that you have checked in the Bug and Help sections on the forums. If after doing so you still need to contact me, please do so on the forums.<br />";
} if($receiver == "Unkajo") {
$error .= "Error009 - You cannot message Unkajo because I am the head admin and administrator. Please make sure that you have exhausted all possible options before contacting me directly. Make sure that you have checked in the Bug and Help sections on the forums. If after doing so you still need to contact me, please do so on the forums.<br />";
}
if($error == null) {
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$receiver', '$sender', '$subject', '$body', '$date', '0', '0')");
echo "Message successfully sent. Now redirecting back to mailbox...";
echo "<meta http-equiv='REFRESH' content='3;url=http://www.pixelnations.net/beta/index.php?id=2'>";
} else {
echo $error;
}
} else {
echo $error;
}
} else {
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
$reply = mysql_real_escape_string($purifier->purify($_GET['re']));
$to = mysql_real_escape_string($purifier->purify($_GET['to']));
if($reply != null) {
$reply = "Re: ".$reply." ";
$reply = substr($reply, 0, 18);
}
?>
<form action="index.php?id=5" method="post">
<table class="center" width="30%"><tr><td class="right">To: </td><td class="right"><input type="text" name="receiver" value="<?php echo $to; ?>"></td></tr>
<tr><td class="right">Subject: </td><td class="right"><input type="text" name="subject" value="<?php echo $reply; ?>" maxlength="18"></td></tr>
<tr><td colspan="2"><textarea name="body" rows="8" maxlength="1500"></textarea></td></tr>
<tr><td colspan="2"><input type="submit" name="send" value="Send"></td></tr>
</table>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
}
?>