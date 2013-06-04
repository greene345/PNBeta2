<div id="title">View Message</div>
<?php
include("loggedin.php");
$mid = mysql_real_escape_string(htmlentities($_GET['mid']));
if($mid == null) {
echo "<meta http-equiv='REFRESH' content='0;url=http://www.pixelnations.net/beta/index.php?id=2'>";
} if($mid != null) {
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$msgCheck = mysql_query("SELECT * FROM messages WHERE id='$mid' AND receiver='$idfetch[username]' OR id='$mid' AND sender='$idfetch[username]'");
$msgArray = mysql_fetch_array($msgCheck);
$msgNum = mysql_num_rows($msgCheck);
if($msgNum != 1) {
$error .= "Error002 - You cannot view this message because it does not exist. <br />";
}
if($error == null) {
mysql_query("UPDATE messages SET readmsg='1' WHERE id='$mid'");
$sender = mysql_real_escape_string(htmlentities($msgArray['sender']));
$date = date('m/d/y',strtotime($msgArray[date]));
$subject = htmlentities($msgArray['subject']);
$body = htmlentities($msgArray['body']);
echo "<table id='narrow'>";
if($idfetch['username'] == $sender) {
echo "<tr id='narrow'><td id='narrow'>To:</td><td id='narrow'>" . $msgArray['receiver'] . "</td></tr>";
} else {
echo "<tr id='narrow'><td id='narrow'>From:</td><td id='narrow'>" . $sender . "</td></tr>";
}
echo "<tr id='narrow'><td id='narrow'>Date:</td><td id='narrow'>" . $date . "</td></tr>
<tr id='narrow'><td id='narrow'>Subject:</td><td id='narrow'>" . stripslashes($subject) . "</td></tr>
<tr id='narrow'><td colspan='2' id='narrow'>" . wordwrap(stripslashes($body),80,"\n",TRUE) . "</td></tr></table>";
if($idfetch['username'] == $msgArray['receiver']) {
echo "<center><a href='index.php?id=5&to=".$sender."&re=".$subject."'>Reply</a> | <a href='index.php?id=2&delete=1&did=".$mid."'>Delete</a></center>";
}
} else {
echo $error;
}
}
?>