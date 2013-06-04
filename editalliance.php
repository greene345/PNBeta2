<div id="title">Edit Alliance</div>
<?php
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

 require("loggedin.php");
 $id = mysql_real_escape_string(htmlentities($_SESSION['id']));
 $userS = mysql_query("SELECT * FROM players WHERE id='$id'");
 $userF = mysql_fetch_array($userS);
 
 $alliance = $userF['alliance'];
 $joindate = $userF['join_date'];
 
 $aid = mysql_real_escape_string(htmlentities($_GET['aid']));
 $allS = mysql_query("SELECT * FROM alliances WHERE id='$aid'");
 $allN = mysql_num_rows($allS);
 $allF = mysql_fetch_array($allS);
 
 if($allF['neutral'] == 1) {
 $checked = "checked='true'";
 } else {
 $checked = " ";
 }
 
 if(isset($_POST['submit'])) {
 
 $flag = mysql_real_escape_string(htmlentities($purifier->purify($_POST['flag'])));
 $phrase = mysql_real_escape_string(htmlentities($purifier->purify($_POST['phrase'])));
 $minimumpower = mysql_real_escape_string(htmlentities($purifier->purify($_POST['minpower'])));
 $about = mysql_real_escape_string(htmlentities($purifier->purify($_POST['about'])));
 $forums = mysql_real_escape_string($purifier->purify($_POST['forums']));
 $irc = mysql_real_escape_string($purifier->purify($_POST['irc']));
 $neutral = mysql_real_escape_string($purifier->purify($_POST['neutral']));
 
 if($allF['name'] != $alliance) {
 $error .= "Error02 - You are not in this alliance.<br />";
 } if($userF['alliancepos'] != "Agent" AND $userF['alliancepos'] != "Founder") {
 $error .= "You cannot edit this alliance because you are not an Agent or the Founder.<br />";
 } if($allF['founder'] == $userF['username']) {
 $error = null;
 } if($userF['username'] == "Admin") {
 $error = null;
 } if($allN != 1) {
 $error .= "Error01 - That alliance does not exist.<br />";
 } if(strlen($phrase) > 36) {
 $error .= "Error03 - Your alliance phrase cannot contain more than 36 characters.<br />";
 } if(strlen($about) > 1500) {
 $error .= "Error04 - Your alliance description cannot have more than 1500 characters.<br />";
 } if(!is_numeric($minimumpower)) {
 $error .= "Error05 - Your minimum power level must be numeric.<br />";
 } if($minimumpower < 0) {
 $error .= "Error06 - Your minimum power level cannot be below 0.<br />";
 } if(!filter_var($forums, FILTER_VALIDATE_URL) AND $forums != null) {
 $error .= "Error07 - You did not enter a valid offsite forum URL.<br />";
 } if(!filter_var($irc, FILTER_VALIDATE_URL) AND $irc != null) {
 $error .= "Error08 - You did not enter a valid IRC link.<br />";
 } if($neutral != 1) {
 $neutral = 0;
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
}
 
 if($error == null AND $allF['name'] == $userF['alliance']) {
 
 mysql_query("UPDATE alliances SET flag='$flag', phrase='$phrase', min_power='$minimumpower', about='$about', forums='$forums', irc='$irc', neutral='$neutral' WHERE id='$aid'");
 echo "Congratulations! You have successfully updated your alliance.<br /><br /><a href='index.php?id=16&nid=".$aid."'>View Alliance</a>";
 
 } else {
 echo "You have received the following error(s):<br /><br />";
 echo $error;
 echo "<br /><br /><center><a href='index.php?id=13'>Go Back</a></center>";
 }
 
 } else {
 ?>
<form action="index.php?id=33&aid=<?php echo $aid; ?>" method="post">
<center><table>
<tr><td> </td><td>
<img src="images/flags/<?php echo $allF['flag']; ?>" name="pictures" id="NATIONAL_FLAG_PICTURE" class="center">
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
<option value="<?php echo $allF['flag']; ?>">Current</option>
<?php include("flags.php"); ?>
</td></tr>
<tr><td><b>Phrase:</b></td><td><input type="text" maxlength="36" value="<?php echo stripslashes($allF['phrase']); ?>" name="phrase"></td></tr>
<tr><td><b>Minimum Power:</b></td><td><input type="number" maxlength="8" value="<?php echo $allF['min_power']; ?>" name="minpower"></td></tr>
<tr><td><b>Offsite Forums:</b></td><td><input type="text" name="forums" value="<?php echo stripslashes($allF['forums']); ?>"></td></tr>
<tr><td><b>IRC Channel:</b></td><td><input type="text" name="irc" value="<?php echo stripslashes($allF['irc']); ?>"></td></tr>
<tr><td><b>Neutral:</b></td><td><input type="checkbox" name="neutral" value="1" <?php echo $checked; ?>"></td></tr>
<tr><td><b>About:</b></td><td><textarea name="about" col="15" row="10"><?php echo stripslashes($allF['about']); ?></textarea></td></tr>

</table>
<br /><center><input type="submit" value="Submit Changes" name="submit"></center></form>
<?php
}
?>