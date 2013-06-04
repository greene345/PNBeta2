<div id="title">Register for Pixel Nations</div>
<?php
require_once("library/HTMLPurifier.auto.php");
$config = HTMLPurifier_Config::createDefault();

// configuration goes here:
$config->set('Core.Encoding', 'iso-8859-1'); // replace with your encoding
$config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
$purifier = new HTMLPurifier($config);

if(isset($_POST['send'])) {
if(!isset($_POST['token'])) {
$error .= "Error001 - There has been an invalid entry. Please go back and try again. <br />";
} if($_POST['token'] != $_SESSION['token']) {
$error .= "Error002 - There has been an invalid entry. Please go back and try again. <br />";
}
if($error == null) {
$refer = mysql_real_escape_string($purifier->purify($_POST['refer']));
$username = mysql_real_escape_string($purifier->purify($_POST['user']));
$government = mysql_real_escape_string($purifier->purify($_POST['gov']));
$nation = mysql_real_escape_string(($_POST['nation']));
$capital = mysql_real_escape_string(($_POST['capital']));
$race = mysql_real_escape_string($purifier->purify($_POST['race']));
$religion = mysql_real_escape_string($purifier->purify($_POST['religion']));
$tax = mysql_real_escape_string($purifier->purify($_POST['tax']));
$peace = mysql_real_escape_string($purifier->purify($_POST['peace']));
$economy = mysql_real_escape_string($purifier->purify($_POST['economy']));
$satisfaction = mysql_real_escape_string($purifier->purify($_POST['satisfaction']));
$principle = mysql_real_escape_string($purifier->purify($_POST['principle']));
$speech = mysql_real_escape_string($purifier->purify($_POST['speech']));
$flag = mysql_real_escape_string($purifier->purify($_POST['flag']));
$email = mysql_real_escape_string($purifier->purify($_POST['email']));
$email2 = mysql_real_escape_string($purifier->purify($_POST['email2']));
$password = mysql_real_escape_string($purifier->purify($_POST['password']));
$password2 = mysql_real_escape_string($purifier->purify($_POST['password2']));
$terms = mysql_real_escape_string($purifier->purify($_POST['terms']));
$ip = mysql_real_escape_string($purifier->purify($_SERVER['REMOTE_ADDR']));
$userCheck = mysql_query("SELECT * FROM players WHERE username='$username'");
$userNum = mysql_num_rows($userCheck);
$ipCheck = mysql_query("SELECT * FROM players WHERE ip='$ip'");
$ipNum = mysql_num_rows($ipCheck);
$emailCheck = mysql_query("SELECT * FROM players WHERE email='$email'");
$emailNum = mysql_num_rows($emailCheck);
if($ip == "66.113.46.150") {
$ipNum = 0;
}
$nationCheck = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$nationNum = mysql_num_rows($nationCheck);
$date = mysql_real_escape_string(date("c"));
$pattern = '/^([A-Za-zÀ-ÖØ-Þà-öø-ÿ](([A-Za-zÀ-ÖØ-öø-ÿ0-9]*[\'-]?)*[A-Za-zÀ-ÖØ-öø-ÿ0-9]+)*\\.?)( [A-Za-zÀ-ÖØ-Þà-öø-ÿ0-9](([A-Za-zÀ-ÖØ-öø-ÿ0-9]*[\'-]?)*[A-Za-zÀ-ÖØ-öø-ÿ0-9]+)*\\.?)*$/';

if($username == null) {
$error .= "Error003 - You did not enter a valid username.<br /> ";
} if($government == null) {
$error .= "Error004 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($nation == null) {
$error .= "Error005 - You did not enter a valid nation name.<br /> ";
} if($capital == null) {
$error .= "Error006 - You did not enter a valid capital city name.<br /> ";
} if($race == null) {
$error .= "Error007 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($religion == null) {
$error .= "Error008 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($tax == null) {
$error .= "Error009 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($peace == null) {
$error .= "Error010 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($economy == null) {
$error .= "Error011 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($satisfaction == null) {
$error .= "Error012 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($principle == null) {
$error .= "Error013 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($speech == null) {
$error .= "Error014 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($flag == null) {
$error .= "Error015 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($email == null) {
$error .= "Error016 - You did not enter an email address.<br /> ";
} if($email2 == null) {
$error .= "Error017 - You did not confirm your email address.<br /> ";
} if($password == null) {
$error .= "Error018 - You did not enter a password.<br /> ";
} if($password2 == null) {
$error .= "Error019 - You did not confirm your password.<br /> ";
} if(!is_numeric($tax)) {
$error .= "Error020 - There has been an invalid entry. Please go back and try again.<br /> ";
} if($email != $email2) {
$error .= "Error021 - Your e-mail addresses did not match.<br /> ";
} if($password != $password2) {
$error .= "Error022 - Your passwords did not match.<br /> ";
} if(strlen($username) < 4) {
$error .= "Error023 - Your username needs to be more than 3 characters long.<br /> ";
} if(strlen($username) > 14) {
$error .= "Error024 - Your username cannot be more than 14 characters long.<br /> ";
} if(strlen($nation) < 4) {
$error .= "Error025 - Your nation name needs to be more than 3 characters long.<br /> ";
} if(strlen($nation) > 18) {
$error .= "Error026 - Your nation name cannot be more than 18 characters long.<br /> ";
} if(strlen($capital) < 4) {
$error .= "Error027 - Your capital city name needs to be more than 3 characters long.<br /> ";
} if(strlen($capital) > 14) {
$error .= "Error028 - Your capital city name cannot be more than 14 characters long.<br /> ";
} if(strlen($password) < 8) {
$error .= "Error029 - Your password needs to be at least 8 characters long.<br /> ";
} if(strlen($password) > 20) {
$error .= "Error030 - Your password cannot be more than 20 characters long.<br /> ";
} if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$error .= "Error031 - You have entered an invalid email address.<br /> ";
} if(!filter_var($ip, FILTER_VALIDATE_IP)) {
$error .= "Error032 - There has been an error with your IP address. Please try again.<br /> ";
} if($userNum != 0) {
$error .= "Error033 - That username has already been taken. Please try again.<br /> ";
} if($ipNum != 0) {
$error .= "Error034 - There is already an account on this computer. Creating multiple accounts is a bannable offense.<br /> ";
} if($nationNum != 0) {
$error .= "Error035 - That nation name has already been taken. Please try again.<br /> ";
} if(!preg_match($pattern, $username)) {
$error .= "Error036 - Your username cannot contain invalid characters.<br /> ";
} if(!preg_match($pattern, $nation)) {
$error .= "Error037 - Your nation name cannot contain invalid characters.<br /> ";
} if(!preg_match($pattern, $capital)) {
$error .= "Error038 - Your capital city name cannot contain invalid characters.<br /> ";
} if($emailNum != 0) {
$error .= "Error039 - There is already an account registered with this e-mail address.<br />";
} if($terms != "yes") {
$error .= "Error040 - You did not accept the Terms and Conditions required to play the game.<br />";
} if($tax > 21) {
$error .= "Error041 - Your tax rate cannot be greater than 21%.<br />";
} if($race != "mixed" AND $race != "caucasian" AND $race != "black" AND $race != "asian" AND $race != "hispanic" AND $race != "arab" AND $race != "native american") {
$error .= "Error042 - Your race was not chosen from the drop down list provided.<br />";
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
$error .= "Error048 - You did not choose a valid peace/war setting.<br />";
}
$title = $government;
if($government == "Dictator") {
$government = "Dictatorship";
} if($government == "Prime Minister") {
$government = "Republic";
} if($government == "President") {
$government = "Democracy";
} if($government == "King" OR $government == "Queen") {
$government = "Monarchy";
}

if($error == null) {
//referral

//resource
$basic = array("Rubber", "Coal", "Cod", "Corn", "Timber", "Cotton");
$medium = array("Copper", "Iron", "Crude Oil", "Chickens", "Fresh Water", "Composite");
$rare = array("Silver", "Gold", "Gems", "Coffee Beans");
$citycheck = mysql_query("SELECT id FROM cities ORDER BY resource ASC");
$rand1 = rand(1,100);
if($rand1 < 75) {
$resource = $basic[rand(0, (count($basic)-1))];
} if($rand1 > 74 AND $rand1 < 95) {
$resource = $medium[rand(0, (count($medium)-1))];
} if($rand1 > 94) {
$resource = $rare[rand(0, (count($rare)-1))];
}



$verCode = rand(11111111,99999999);
$verCode = mysql_real_escape_string($verCode);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$to = $email;
$subject = "Welcome to Pixel Nations!";
$message = "
<html>
<head>
<title>Thanks for registering at Pixel Nations!</title>
</head>
<body>
<p>Thanks " .$username. " for signing up at Pixel Nations! To validate your account, please click or copy and paste the following link in your browser:<br /><br /><br />
<a href='http://www.pixelnations.net/beta/index.php?id=4&val=" .$verCode. "'>http://www.pixelnations.net/beta/index.php?id=4&val=" .$verCode. "</a><br /><br />Once you have validated your account, you will be able to log in using the username <b>" .$username. "</b> and the password you created when you registered. 
</body>
</html>
";
$bodymsg = mysql_real_escape_string("Hi there! Welcome to Pixel Nations! I am the owner and programmer. Pixel Nations is still in development but is mostly working, you can wage war, form alliances, send messages to your friends, and do just about anything else your heart desires. For more information, please check out the Wiki and the Forums. Thanks!");
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= 'From: <webmaster@pixelnations.net>' . "\r\n";
mail($to,$subject,$message,$headers);
//password encyption
$saltA = "B1F030404D36B8F75E66D10135298F84D31ECB93ED8E905AA5365481F2A";
$saltB = $capital.$saltA;
$saltC = $saltB.$password.$nation;
$password = hash("sha256", $saltC);

mysql_query("INSERT INTO `cities` (name, found_date, nation, land, population, capital, residential, commercial, industrial, military, crime, unemployment, pollution, literacy, happiness, resource) VALUES ('$capital', '$date', '$nation', '10000', '1428000', '1', '75.3', '75', '75', '75', '2', '4.8', '11228', '80', '91.9', '$resource')");
mysql_query("INSERT INTO `players` (date_reg, ip, last_login, username, password, email, verify, refer, nation, capital, flag, title, government, economy, principle, religion, race, tax, sat, speech, money, lastcollect, readiness, soldiers, fighterjets, battleships, bmissiles, power) VALUES ('$date', '$ip', '$date', '$username', '$password', '$email', '$verCode', '$refer', '$nation', '$capital', '$flag', '$title', '$government', '$economy', '$principle', '$religion', '$race', '$tax', '$satisfaction', '$speech', '1500000', '$date', '$peace', '250', '0', '0', '0', '1.45')");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$username', 'Admin', 'Welcome!', '$bodymsg', '$date', '0', '0')");
echo "Congratulations! You have successfully registered for Pixel Nations! An e-mail has been sent to the address you registered with, containing a link to validate your account. If you do not immediately see the e-mail, make sure to check and make sure it wasn't accidentally marked as spam. Once validated, you may log in using the username " .$username. " and the password you created when you registered. ";
} else {
echo "You received the following errors during your registration:<br />";
echo $error;
}
} else {
echo "You received the following errors during your registration: <br />";
echo $error;
}
} else {
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
?>
<form method="post" action="index.php?id=0">
So, you want to create your own country and test your skills as a leader? To complete registration, go ahead and fill out the form below and once you've double-checked everything to make sure it's just how you want it, click Register at the bottom.

<br /><hr>
Unhappy with the shortcomings of the government, you and a small group of followers have elected to form a new nation. Impressed with your beliefs and ideals, a group of people the size of a small city have chosen to join your revolution.
<br /><br />

You, <input title="Username" type="text" name="user" required>, have been appointed as <select name="gov"><option value="King">King</option><option value="Queen">Queen</option><option value="President">President</option><option value="Prime Minister">Prime Minister</option><option value="Dictator">Dictator</option></select> of the newly founded nation of <input type="text" title="Nation Name" name="nation" required>. In the capital city of <input type="text" title="Capital City Name" name="capital" required> the majority of the people are of <select name="race"><option value="mixed">Mixed</option><option value="caucasian">Caucasian</option><option value="black">Black</option><option value="asian">Asian</option><option value="hispanic">Hispanic</option><option value="arab">Arab</option><option value="native american">Native American</option></select> ethnicity and practice <select name="religion"><option value="many religions">Many Religions</option><option value="Atheism">Atheism</option><option value="Islam">Islam</option><option value="Christianity">Christianity</option><option value="Judaism">Judaism</option><option value="Buddhism">Buddhism</option><option value="Taoism">Taoism</option><option value="Shintoism">Shintoism</option><option value="Hinduism">Hinduism</option><option value="Pastafarianism">Pastafarianism</option></select>. The people pay a tax rate of <select name="tax"><option value="7">7%</option><option value="9">9%</option><option value="11">11%</option><option value="13">13%</option><option value="15">15%</option><option value="17">17%</option><option value="19">19%</option><option value="21">21%</option></select>  in this <select name="peace"><option value="peace">Peaceful</option><option value="war">Wargoing</option></select> nation.
<br /><br />

As leader, you have chosen to <select name="economy"><option value="market">Promote</option><option value="command">Restrict</option></select> free trade. The satisfaction of your people with the government is <select name="satisfaction"><option value="1">Very</option><option value="0">Hardly</option></select> important to you. Your main focus is the <select name="principle"><option value="economy">Economy</option><option value="freedom">People's Liberties</option><option value="military">Military's Power</option><option value="technology">Advance of Technology</option></select>. Freedom of Speech is a <select name="speech"><option value="yes">Recognized</option><option value="no">Penalized</option></select> practice in your nation.

<br /><br />
As leader of this new nation, you must choose a flag to represent your nation, and the values it stands for.
<br /><br />
<img src="images/flags/afghanistan.jpg" name="pictures" id="NATIONAL_FLAG_PICTURE" class="center">
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
<center><select name="flag" id="NATIONAL_FLAG_SELECTION" size="1" onchange="showimage()" onkeyup="showimage()">
<?php include("flags.php"); ?></center>

<hr>
If you were referred here by another player, you may enter their username below and they will receive a Referral Bonus.<br />
<center><input type="text" name="refer"></center>
<hr>
<input type="hidden" name="token" value="<?php echo $token; ?>">
Now if you just provide us with a password and e-mail address so that we may validate your account and let you log in securely to our website.
<br />
<table class="center">
<tr><td class="right">E-Mail Address: <input type="text" name="email" required></td><td class="right"> Confirm E-mail Address: <input type="text" name="email2" required></td></tr> 
<tr><td class="right">Password: <input type="password" name="password" required></td><td class="right"> Confirm Password: <input type="password" name="password2" required></td></tr>
</table>
<br />
<center><input type="checkbox" name="terms" value="yes" required> I Accept the <a href='index.php?id=39'>Terms and Conditions</a><br /><br />
<input type="submit" name="send" value="Register"></center>
</form>
<br />
<?php
}
?>