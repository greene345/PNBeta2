<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 1) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
?>
<div id="title">Suspend Player</div>
<?php
if(!isset($_POST['submit'])) {
$nation = mysql_real_escape_string(htmlentities($_GET['nation']));
echo "<form action='index.php?id=95' method='post'>Nation Name: <input type='text' name='nation' value='".$nation."'> Length (Days): <input type='number' name='length' value='1'> Reason: <input type='text' name='reason' value='Breaking the Rules'> <input type='submit' name='submit' value='Go!'></form>";
}
if(isset($_POST['submit']) AND $level > 0) {
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));
$length = mysql_real_escape_string(htmlentities($_POST['length']));
$reason = mysql_real_escape_string(htmlentities($_POST['reason']));

$natC = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$natF = mysql_fetch_array($natC);
$natN = mysql_num_rows($natC);

if($length > 365) {
$length = 365;
}

if($natN == 1) {
$date = date('c');
mysql_query("UPDATE players SET suspended='1', suspend_date='$date', suspend_length='$length', suspend_reason='$reason', suspend_mod='$idfetch[username]' WHERE nation='$nation'");
echo "That player has successfully been suspended. Remind a higher moderator to review the nation and either unsuspend or delete it.<br />";
} else {
echo "That nation doesn't exist.<br />";
}
}
?>