<div id="title">Join Alliance</div>
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$salt = "^^3m]G68([>/275";
$aid = mysql_real_escape_string(htmlentities($_GET['aid']));
$chk = mysql_real_escape_string(htmlentities($_GET['chk']));
if($aid == null) {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
} if(!is_numeric($aid)) {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
}
$aidCheck = mysql_query("SELECT * FROM alliances WHERE id='$aid'");
$aidNum = mysql_num_rows($aidCheck);
if($aidNum != 1) {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
}
if($chk == null) {
echo "Are you sure you want to join this alliance? <a href='index.php?id=13'>Back</a> | <a href='index.php?id=17&aid=".$aid."&chk=1'>Yes</a>";
$token = md5($id.$salt);
$_SESSION['token'] = $token;
} else {
if($chk == "1") {
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
$alliance = $userA['alliance'];
$allC = mysql_query("SELECT * FROM alliances WHERE id='$aid'");
$allA = mysql_fetch_array($allC);
if($alliance != "None") {
echo "Please leave your current alliance before joining a new one.<br /><a href='index.php?id=13'>Back</a>";
} if($_SESSION['token'] != md5($id.$salt)) {
echo "There was an invalid entry. Please go back and try again.<br /><a href='index.php?id=13'>Back</a>";
}


if($alliance == "None" AND $error == null AND $_SESSION['token'] == md5($id.$salt)) {
$alliance = $allA['name'];
$date = date('c');
if($userA['power'] < $allA['min_power']) {
echo "You do not have the required minimum power level to join this alliance. <a href='index.php?id=13'>Back</a>";
} else {
mysql_query("UPDATE players SET alliance='$alliance', join_date='$date', alliancepos='Applicant' WHERE id='$id'");
echo "Congratulations! You have successfully joined <a href='index.php?id=16&nid=".$aid."'>" .$alliance. "</a>!";
}
}
} else {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
}
}
?>