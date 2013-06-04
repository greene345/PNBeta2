<div id="title">Delete Nation</div>
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 2) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta">';
die();
}


if(!isset($_POST['sent'])) {
$preban = mysql_real_escape_string(htmlentities($_GET['preban']));
echo "<form action='index.php?id=78' method='post'>Nation Name: <input type='text' name='nation' value='".$preban."'> Ban Player: <input type='checkbox' name='ban' value='1'> <input type='submit' name='sent' value='Go'><br /></form>";
} if(isset($_POST['sent'])) {
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));
$ban = mysql_real_escape_string(htmlentities($_POST['ban']));

if($level < 2) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta">';
die();
}

if($level > 1) {
$resetCheck = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$resetFetch = mysql_fetch_array($resetCheck);
$resetNum = mysql_num_rows($resetCheck);
$username = $resetFetch['username'];
$ip = $resetFetch['ip'];

if($resetNum == 1) {
mysql_query("DELETE FROM messages WHERE sender='$username' OR receiver='$username'");
mysql_query("DELETE FROM cities WHERE nation='$nation'");
mysql_query("DELETE FROM nukes WHERE nation='$nation'");
mysql_query("DELETE FROM wars WHERE attacker='$username' OR defender='$username'");
mysql_query("DELETE FROM players WHERE nation='$nation'");
echo "Nation deleted. IP: ".$ip." ";

if($ban == 1) {
mysql_query("INSERT INTO banned (date, ip, username, nation, moderator, reason) VALUES ('$date', '$ip', '$username', '$nation', '$idfetch[username]', 'Nation Deleted, Selected \"Ban Player\"')");
}

} else {
echo "Nation did not exist.";
}
}
}
?>