<div id="title">Mailbox</div>
<?php
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

include("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$check = mysql_query("SELECT * FROM players WHERE id='$id'");
$fetch = mysql_fetch_array($check);
$username = mysql_real_escape_string($fetch['username']);

$delete = mysql_real_escape_string(htmlentities($_GET['delete']));
if($delete == 1) {
$mailID = mysql_real_escape_string(htmlentities($_GET['did']));
$mailIDS = mysql_query("SELECT * FROM messages WHERE receiver='$username' AND id='$mailID'");
$mailIDN = mysql_num_rows($mailIDS);
if($mailIDN == 1) {
mysql_query("DELETE FROM messages WHERE id='$mailID'");
}
}
$newCheck = mysql_query("SELECT * FROM messages WHERE receiver='$username' ORDER BY date DESC LIMIT 25");
if($_GET['outbox'] == 1) {
$newCheck = mysql_query("SELECT * FROM messages WHERE sender='$username' ORDER BY date DESC LIMIT 25");
}
$numRow = mysql_num_rows($newCheck);
if($_GET['outbox'] != 1) {
echo "<table id='black'><tr id='black'><th id='thickblack'>DATE</td><th id='thickblack'>SENDER</td><th id='thickblack'>SUBJECT</td><th id='thickblack'>READ</td><th id='thickblack'>DELETE</td></tr>";
} if($_GET['outbox'] == 1) {
echo "<table id='black'><tr id='black'><th id='thickblack'>DATE</td><th id='thickblack'>RECEIVER</td><th id='thickblack'>SUBJECT</td><th id='thickblack'>READ</td><th id='thickblack'>DELETE</td></tr>";
}
if($numRow != 0) {
while($row=mysql_fetch_array($newCheck)) {
if($row['readmsg'] == "0") {
$read = "images/icons/message.png";
} if($row['readmsg'] == "1") {
$read = "images/icons/read_message.png";
} 
if($_GET['outbox'] != 1) {
$sendCheck = mysql_query("SELECT * FROM players WHERE username='$row[sender]'");
$senderInfo = mysql_fetch_array($sendCheck);
	echo "<tr id='black'><td class='center' id='black'>" .date('m/d/y',strtotime($row['date'])). "</td><td id='black'><a href='index.php?id=7&nid=" .$senderInfo['id']. "'>"	.$row['sender']. "</a></td><td id='black'><a href='index.php?id=6&mid=" .$row['id']. "'>" .stripslashes($purifier->purify(htmlentities($row['subject']))). "</a></td><td id='black' class='center' ><img src='" .$read. "'></td><td id='black' class='center'><a href='index.php?id=2&delete=1&did=".$row['id']."'><img src='images/icons/x.png'></a></td></tr>";
	} if($_GET['outbox'] == 1) {
	$sendCheck = mysql_query("SELECT id FROM players WHERE username='$row[receiver]'");
$senderInfo = mysql_fetch_array($sendCheck);
	echo "<tr id='black'><td class='center' id='black'>" .date('m/d/y',strtotime($row['date'])). "</td><td id='black'><a href='index.php?id=7&nid=" .$senderInfo['id']. "'>"	.$row['receiver']. "</a></td><td id='black'><a href='index.php?id=6&mid=" .$row['id']. "'>" .stripslashes($purifier->purify(htmlentities($row['subject']))). "</a></td><td id='black' class='center' ><img src='" .$read. "'></td><td id='black' class='center'><a href='index.php?id=2&delete=1&did=".$row['id']."'><img src='images/icons/x.png'></a></td></tr>";

	}
	}
} else {
echo "<tr id='black'><td id='black' colspan='5'><center>What a tidy inbox! You have no messages!</center></td></tr>";
}
echo "</table><br /><center><a href='index.php?id=5'>Compose New Message</a> | <a href='index.php?id=41'>Delete All Read</a>";
if($_GET['outbox'] != 1) {
echo " | <a href='index.php?id=2&outbox=1'>View Sent Messages</a>";
} if($_GET['outbox'] == 1) {
echo " | <a href='index.php?id=2'>View Received Messages</a>";
}
echo "</center>";
?>