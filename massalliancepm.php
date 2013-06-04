<div id="title">Alliance Message</div>
<?php
require("loggedin.php");
$userID = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$userID'");
$idfetch = mysql_fetch_array($idcheck);
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

if($idfetch['alliance'] != "None") {
if($idfetch['alliancepos'] == "Agent" OR $idfetch['alliancepos'] == "Founder") {
if($_POST['form'] != "Send") {
//show form
echo "<p style='text-align:center; font-weight:bold;'>Subject</p>";
echo "<form action='index.php?id=99' method='post'><p style='text-align:center;'><input type='text' name='subject' value='Mass Alliance Msg'></p><p style='text-align:center; font-weight:bold;'>Body</p><p style='text-align:center;'><textarea name='message' maxlength='1500' required>This message will be sent to every member of your alliance</textarea></p>";
echo "<p style='text-align:center;'><input type='submit' name='form' value='Send'></p></form>";
} else {
//process form
$subject = mysql_real_escape_string($purifier->purify($_POST['subject']));
$body = mysql_real_escape_string($purifier->purify($_POST['message']));
$date = mysql_real_escape_string(htmlentities(date("c")));
if(strlen($body) > 1500) {
echo "Your message cannot be longer than 1500 characters.<br />";
} if(strlen($subject) > 18) {
echo "Your subject cannot be longer than 18 characters.<br />";
}
if(strlen($subject) < 18 AND strlen($body) < 1500) {
$sender = $idfetch['username'];
$alliance = $idfetch['alliance'];
$allc = mysql_query("SELECT username FROM players WHERE alliance='$alliance'");
while($row = mysql_fetch_array($allc)) {
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$row[username]', '$sender', '$subject', '$body', '$date', '0', '0')");
}
echo "Messages successfully sent. Now redirecting back to mailbox...";
echo "<meta http-equiv='REFRESH' content='3;url=http://www.pixelnations.net/beta/index.php?id=2'>";
}
}
} else {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?">';
}
} else {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?">';
echo "2";
}
?>