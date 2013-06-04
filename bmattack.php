<div id="title">Ballistic Missile Attack</div>
<img class="center" src="images/missile.jpg">
<?php
require("loggedin.php");


$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);

$wid = mysql_real_escape_string(htmlentities($_GET['wid']));
$widC = mysql_query("SELECT * FROM wars WHERE id='$wid' AND active='1'");
$widF = mysql_fetch_array($widC);

if(trim($widF['attacker']) == trim($userF['username'])) {
$othername = $widF['defender'];
} if(trim($widF['defender']) == trim($userF['username'])) {
$othername = $widF['attacker'];
} if(trim($widF['attacker']) != trim($userF['username']) AND trim($widF['defender']) != trim($userF['username'])) {
$error .= "Error04 - There was an unexpected error, please go back and try again.<br />";
}

$otherC = mysql_query("SELECT * FROM players WHERE username='$othername'");
$otherF = mysql_fetch_array($otherC);
$othernation = $otherF['nation'];

$otherC = mysql_query("SELECT * FROM players WHERE username='$othername'");
$otherF = mysql_fetch_array($otherC);
$otherCC = mysql_query("SELECT * FROM cities WHERE nation='$othernation' AND capital='0'");

$bmcheck = $userF['bmissiles'];


if(isset($_POST['attack'])) {

$city = mysql_real_escape_string(htmlentities($_POST['city']));


$citycheck = mysql_query("SELECT * FROM cities WHERE name='$city' AND nation='$othernation' LIMIT 1");
$cityfetch = mysql_fetch_array($citycheck);
$population = $cityfetch['population'];
$res = $cityfetch['residential'];
$ind = $cityfetch['industrial'];
$com = $cityfetch['commercial'];
$land = $cityfetch['land'];
$mil = $cityfetch['military'];
$cityid = $cityfetch['id'];
$citynum = mysql_num_rows($citycheck);

$newres = $res-50;
$newind = $ind-50;
$newcom = $com-50;
$newland = $land/2;
$newmil = $mil-50;

if($newres < 0) {
$newres = 0;
} if($newind < 0) {
$newind = 0;
} if($newcom < 0) {
$newcom = 0;
} if($newmil < 0) {
$newmil = 0;
}

$newpopulation = ($newres*10000)+($newind*2600)+($newcom*2400)+($newmil*4000);
$populationloss = $population-$newpopulation;

$nukediff = abs(strtotime($userF['lastbm']) - strtotime(date(c)));
$nukehours = round($nukediff/60/60);

if($bmcheck < 1) {
$error .= "Error01 - You do not have any ballistic missiles to launch.<br />";
} if($widF['lastbm'] == $userF['username']) {
$error .= "Error02 - It is not your turn to launch a ballistic missile.<br />";
} if($citynum != 1) {
$error .= "Error03 - There was an unexpected error. Please try again.<br />";
}

if($error == null) {
$usernation = $userF['nation'];
$username = $userF['username'];
$date = date("c");
$othersoldiers = $otherF['soldiers'];
$otherlosses = round($othersoldiers/7);
$othersoldiers = $othersoldiers-$otherlosses;
$othercasualties = $otherF['casualties']+$otherlosses+$populationloss;
$newmissiles = $bmcheck-1;
$message = " ".$userF['username']." of the nation of ".$userF['nation']." has launched a ballistic missile at your city of ".stripslashes($city).". The resulting blast turned a large portion of the city to rubble, killing ".number_format($population)." citizens and ".number_format($otherlosses)." soldiers!";
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$othername', '$username', 'Missile Attack!', '$message', '$date', '0', '0')");
mysql_query("UPDATE players SET soldiers='$othersoldiers', casualties='$othercasualties' WHERE username='$othername'");
mysql_query("UPDATE players SET bmissiles='$newmissiles' WHERE username='$username'");
mysql_query("UPDATE wars SET defpeace='0', attpeace='0', lastbm='$username' WHERE id='$wid'");
mysql_query("UPDATE cities SET residential='$newres', industrial='$newind', commercial='$newcom', land='$newland', population='$newpopulation', military='$newmil' WHERE id='$cityid'");
echo "You have successfully launched a ballistic missile at your opponent's city of ".$city.". The city was partially destroyed, killing ".number_format($population)." citizens and ".number_format($otherlosses)." soldiers.";
} else {
echo "You have received the following errors:<br /><br />";
echo $error;
echo "<br /><center><a href='index.php?id=30'>Back</a></center>";
}

} else {
echo "Here you can launch ballistic missiles at your opponent, which will heavily damage a city, killing close to half its population and a good portion of that nation's soldiers. Ballistic missiles do a lot of damage, and your opponent may retaliate so be aware of your situation before you start letting loose missiles.<br />";
echo '<form action="index.php?id=40&wid='.$wid.'" method="post"><center><table><tr><td>Ballistic Missiles:</td><td>'.number_format($bmcheck).'</td></tr>';
echo "<tr><td>City to Attack:</td><td><select name='city'>";
while($cFetch = mysql_fetch_array($otherCC)) {
echo "<option value='".$cFetch['name']."'>".$cFetch['name']."</option>";
}
echo "<select></td></tr></table>";
echo "<br /><input type='submit' value='Launch Missile' name='attack'></center></form>";


}

?>