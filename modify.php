<div id="title">Modify Nation</div>
<?php
require("loggedin.php");

require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
if(isset($_POST['send'])) {
$token = mysql_real_escape_string($purifier->purify($_POST['token']));
if($token == $_SESSION['token']) {
$gov = mysql_real_escape_string($purifier->purify(htmlentities($_POST['government'])));
$race = mysql_real_escape_string($purifier->purify(htmlentities($_POST['race'])));
$title = mysql_real_escape_string($purifier->purify(htmlentities($_POST['title'])));
$religion = mysql_real_escape_string($purifier->purify(htmlentities($_POST['religion'])));
$tax = mysql_real_escape_string($purifier->purify(htmlentities($_POST['tax'])));
$peace = mysql_real_escape_string($purifier->purify(htmlentities($_POST['peace'])));
$trade = mysql_real_escape_string($purifier->purify(htmlentities($_POST['trade'])));
$sat = mysql_real_escape_string($purifier->purify(htmlentities($_POST['sat'])));
$focus = mysql_real_escape_string($purifier->purify(htmlentities($_POST['focus'])));
$speech = mysql_real_escape_string($purifier->purify(htmlentities($_POST['speech'])));
$flag = mysql_real_escape_string($purifier->purify(htmlentities($_POST['flag'])));
$info = mysql_real_escape_string(htmlentities($purifier->purify($_POST['info'])));
if(strlen($religion) > 20) {
$error .= "Error86 - Your religion cannot be longer than 20 characters><br />";
} if($tax > 21) {
$error .= "Error87 - Your tax rate cannot be greater than 21%.<br />";
} if (preg_match("/\b.com\b/i", $flag)) {
$error .= "Error043 - You did not choose a valid flag.<br />";
} if (preg_match("/\b.net\b/i", $flag)) {
$error .= "Error044 - You did not choose a valid flag.<br />";
} if (preg_match("/\b.org\b/i", $flag)) {
$error .= "Error045 - You did not choose a valid flag.<br />";
} if (preg_match("/\bwww.\b/i", $flag)) {
$error .= "Error046 - You did not choose a valid flag.<br />";
} if (preg_match("/\bhttp\b/i", $flag)) {
$error .= "Error047 - You did not choose a valid flag.<br />";
} if (preg_match("/\b..\b/i", $flag)) {
$error .= "Error047 - You did not choose a valid flag.<br />";
} if (preg_match("/\bbeta\b/i", $flag)) {
$error .= "Error047 - You did not choose a valid flag.<br />";
} if (preg_match("/\bflags\b/i", $flag)) {
$error .= "Error047 - You did not choose a valid flag.<br />";
} if (preg_match("/\bimages\b/i", $flag)) {
$error .= "Error047 - You did not choose a valid flag.<br />";
} if($peace != "war" AND $peace != "peace") {
$error .= "Error93 - You did not choose a valid peace/war setting.<br />";
} if(strlen($title) > 20) {
$error .= "Error94 - Your leader title cannot be longer than 20 characters.<br />";
} if(strlen($gov) > 30) {
$error .= "Error96 - Your government type cannot be longer than 30 characters.<br />";
} if(strlen($race) > 20) {
$error .= "Error97 - Your ethnicity cannot be longer than 20 characters.<br />";
} if(strlen($info) > 1500) {
$error .= "Error98 - Your nation info cannot be longer than 1,500 characters.<br />";
}

$warcheck = mysql_query("SELECT * FROM wars WHERE defender='$userF[username]' OR attacker='$userF[username]'");
$warnum = mysql_num_rows($warcheck);

$date = date('c');
if($peace != $userF['readiness']) {
$lastchange = strtotime($userF['lastchange']);
$lastcollect = strtotime($userF['lastcollect']);
$peacediff = abs($lastchange - strtotime(date(c)));
$peacedays = round($peacediff/60/60/24);
if($lastchange > $lastcollect) {
$error .= "Error98 - You cannot change your peace/war setting until you collect your taxes and pay your bills.<br />";
} if($peacedays < 8) {
$error .= "Error99 - You can only change your peace/war preference once every 7 days.<br />";
} if($warnum > 0 AND $peace == "peace") {
$error .= "Error100 - You cannot change your peace/war preference to peaceful while you are at war.<br />";
} if($peace != "peace" and $peace != "war") {
$error .= "Error101 - Invalid entry.<br />";
}

if($lastcollect > $lastchange) {
if($error == null) {
mysql_query("UPDATE players SET lastchange='$date' WHERE id='$id'");
}
}
}
if($error == null) {
mysql_query("UPDATE players SET flag='$flag', info='$info', title='$title', government='$gov', economy='$trade', principle='$focus', readiness='$peace', religion='$religion', race='$race', tax='$tax', sat='$sat', speech='$speech' WHERE id='$id'");
echo "Congratulations! You have successfully updated your nation.<br /><br /><center><a href='index.php?id=7'>View Nation</a></center>";
}
} else {
$error .= "Error25 - There was a problem handling the request. Please try again.<br />";
}
if($error != null) {
echo "You have received the following errors: <br />";
echo $error;
}
} else {
//display form
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
?>
<form action="index.php?id=27" method="post">
<input type="hidden" name="token" value="<?php echo $token; ?>">
<center><table>
<tr><td> </td><td>
<img src="images/flags/<?php echo $userF['flag']; ?>" name="pictures" id="NATIONAL_FLAG_PICTURE" class="center">
</td></tr>
<script language="javascript">
function showimage()
{
if (!document.images)
return
var path="images/flags/";
document.getElementById("NATIONAL_FLAG_PICTURE").src=path+
document.getElementById("NATIONAL_FLAG_SELECTION").options[document.getElementById("NATIONAL_FLAG_SELECTION").selectedIndex].value
}
</script>
<br />
<tr><td><b>Flag:</b></td><td>
<select name="flag" id="NATIONAL_FLAG_SELECTION" size="1" onchange="showimage()" onkeyup="showimage()">
<option value="<?php echo $userF['flag']; ?>">Current</option>
<?php include("flags.php"); ?>
</td></tr>
<tr><td><b>Leader Title:</b></td><td><input type="text" maxlength="20" value="<?php echo stripslashes($userF['title']); ?>" name="title"></td></tr>
<tr><td><b>Government Type:</b></td><td><input type="text" maxlength="20" value="<?php echo stripslashes($userF['government']); ?>" name="government"></td></tr>
<tr><td><b>Religion:</b></td><td><input type="text" maxlength="20" value="<?php echo stripslashes($userF['religion']); ?>" name="religion"></td></tr>
<tr><td><b>Peace/War: <a href="http://pixelnations.referata.com/wiki/Peace/War_Setting">[?]</a></b></td><td><select name="peace"><option value="peace" <?php if($userF['readiness'] == "peace") { echo "Selected"; } ?>>Peaceful</option><option value="war" <?php if($userF['readiness'] == "war") { echo "Selected"; } ?>>Wargoing</option></select></td></tr>
<tr><td><b>Tax Rate:</b></td><td><select name="tax"><option value="<?php echo $userF['tax']; ?>">Current</option><option value="7" <?php if($userF['tax'] == 7) { echo "Selected"; } ?>>7%</option><option value="9" <?php if($userF['tax'] == 9) { echo "Selected"; } ?>>9%</option><option value="11" <?php if($userF['tax'] == 11) { echo "Selected"; } ?>>11%</option><option value="13" <?php if($userF['tax'] == 13) { echo "Selected"; } ?>>13%</option><option value="15" <?php if($userF['tax'] == 15) { echo "Selected"; } ?>>15%</option><option value="17" <?php if($userF['tax'] == 17) { echo "Selected"; } ?>>17%</option><option value="19" <?php if($userF['tax'] == 19) { echo "Selected"; } ?>>19%</option><option value="21" <?php if($userF['tax'] == 21) { echo "Selected"; } ?>>21%</option></select></td></tr>
<tr><td><b>Ethnicity:</b></td><td><input type="text" name="race" value="<?php echo $userF['race']; ?>" maxlength="20"></td></tr>
<tr><td><b>National Focus:</b></td><td><select name="focus"><option value="economy" <?php if($userF['principle'] == "economy") { echo "Selected"; } ?>>Economy</option><option value="freedom" <?php if($userF['principle'] == "freedom") { echo "Selected"; } ?>>People's Liberties</option><option value="military" <?php if($userF['principle'] == "military") { echo "Selected"; } ?>>Military's Power</option><option value="technology" <?php if($userF['principle'] == "technology") { echo "Selected"; } ?>>Advance of Technology</option></select></td></tr>
<tr><td><b>Freedom of Speech:</b></td><td><select name="speech"><option value="yes" <?php if($userF['speech'] == "yes") { echo "Selected"; } ?>>Allowed</option><option value="no" <?php if($userF['speech'] == "no") { echo "Selected"; } ?>>Restricted</option></select></td></tr>
<tr><td><b>Free Trade:</b></td><td><select name="trade"><option value="market" <?php if($userF['economy'] == "market") { echo "Selected"; } ?>>Allowed</option><option value="command" <?php if($userF['economy'] == "command") { echo "Selected"; } ?>>Restricted</option></select></td></tr>
<tr><td><b>Citizen Happiness:</b></td><td><select name="sat"><option value="1" <?php if($userF['sat'] == "1") { echo "Selected"; } ?>>Important</option><option value="0" <?php if($userF['sat'] == "0") { echo "Selected"; } ?>>Irrelevant</option></select></td></tr>
<tr><td><b>Additional Info:</b><br />(1500 Char.)</td><td><textarea name="info" rows="4" maxlength="1500"><?php echo stripslashes($userF['info']); ?></textarea></td></tr>
<tr><td class="center" colspan="2"><input type="submit" name="send" value="Modify Nation"></td></tr>
</table></center>
</form>

<?php
}
?>