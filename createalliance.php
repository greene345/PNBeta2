<div id="title">Create Alliance</div>
<?php
if(isset($_POST['send'])) {
if(!isset($_POST['token'])) {
$error .= "Error01 - There has been an invalid entry. Please go back and try again. <br />";
} if($_POST['token'] != $_SESSION['token']) {
$error .= "Error02 - There has been an invalid entry. Please go back and try again. <br />";
}
if($error == null) {

$date = mysql_real_escape_string(htmlentities(date("c")));
$name = mysql_real_escape_string(htmlentities($_POST['name']));
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$minpower = mysql_real_escape_string(htmlentities(round($_POST['minpower'])));
$phrase = mysql_real_escape_string(htmlentities($_POST['desc']));
$about = mysql_real_escape_string(htmlentities($_POST['about']));
$members = 1;
$flag = mysql_real_escape_string(htmlentities($_POST['flag']));
$pattern = '#^[a-z0-9\x20]+$#i';
$neutral = mysql_real_escape_string(htmlentities($_POST['neutral']));

$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
$founder = mysql_real_escape_string(htmlentities($userA['username']));
$power = mysql_real_escape_string(htmlentities($userA['power']));
$readiness = $userA['readiness'];

$testA = mysql_query("SELECT * FROM alliances WHERE name='$name'");
$testNum = mysql_num_rows($testA);

if($userA['alliance'] != "None") {
$error .= "Error03 - You are already in an alliance. Please leave your alliance before creating a new one. <br />";
} if($name == "None") {
$error .= "Error04 - You cannot create an alliance with this name. Please try again.<br />";
} if(strlen($name) > 32) {
$error .= "Error05 - Your alliance name cannot exceed 32 characters.<br />";
} if(!preg_match($pattern, $name)) {
$error .= "Error06 - You can only use alphanumeric characters and spaces in your alliance name.<br />";
} if(strlen($phrase) > 25) {
$error .= "Error07 - Your alliance phrase cannot be longer than 25 characters.<br />";
} if(strlen($about) > 1500) {
$error .= "Error08 - Your detailed description cannot be longer than 1,500 characters.<br />";
} if(strlen($name) < 2) {
$error .= "Error09 - Your alliance name must be at least 2 characters long.<br />";
} if($testNum != 0) {
$error .= "Error10 - An alliance with that name has already been created. <br />";
} if($minpower < 0) {
$error .= "Error12 - The minimum power level must be a positive number. <br />";
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
} if(strtolower($name) == "none") {
$error .= "Error047 - You cannot name your alliance None.<br />";
} if(strtolower($name) == "exodite") {
$error .= "Error048 - You cannot name your alliance Exodite.<br />";
}


if($error == null AND $name != "None") {
mysql_query("INSERT INTO alliances (date, name, founder, min_power, power, phrase, about, members, flag, neutral) VALUES ('$date', '$name', '$founder', '$minpower', '$power', '$phrase', '$about', '$members', '$flag', '$neutral')");
mysql_query("UPDATE players SET alliance = '$name', join_date = '$date', alliancepos='Founder' WHERE id='$id'");
echo "Congratulations, you have successfully created the alliance " .$name. "! <br /><br /><center><a href='index.php?id=13'>My Alliance</a></center>";
} else {
echo $error;
}
} else {
echo $error;
}

} else {
//display form
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
?>
<form action="index.php?id=18" method="post">
In an effort to stand up against the oppression of larger nations and alliances, you have chosen to start your own alliance of nations that share common beliefs and ideals. You have decided to call this alliance <input type="text" name="name" maxlength="32">.<br /><br /> Your alliance will uphold the phrase, <input type="text" name="desc" maxlength="25">. <br /><br />Other nations wishing to join your alliance must have a minimum power level of <input type="text" name="minpower" maxlength="8">. 
<br /><br />
Neutral Alliance: <input type="checkbox" name="neutral" value="1"> (This option has no effect other than displaying to the world your alliance is neutral.)
<br /><br />
As founder of your alliance, you must choose a flag to represent your standards.<br />
<br /><img src="images/flags/afghanistan.jpg" name="pictures" id="NATIONAL_FLAG_PICTURE" class="center">
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
<center><select name="flag" id="NATIONAL_FLAG_SELECTION" size="1" onchange="showimage()" onkeyup="showimage()"><?php include("flags.php"); ?></center><br />
You may also write a detailed description of your alliance for everyone to see.
<br />
<center><textarea maxlength="1500" cols="50" rows="10" name="about"></textarea>
<input type="hidden" name="token" value="<?php echo $token; ?>">
<br /><br /><input type="submit" name="send" value="Create Alliance"></center><br />
</form>
<?php 
}
?>