<div id="title">Aerial Attack</div>
<img src="images/airattack.jpg" class="center">
<?php
require("loggedin.php");

$warID = mysql_real_escape_string(htmlentities($_GET['wid']));
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userS = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userS);
$username = trim($userF['username']);
if(isset($_POST['attack'])) {



$warS = mysql_query("SELECT * FROM wars WHERE id='$warID' AND defender='$username' AND active='1' OR id='$warID' AND attacker='$username' AND active='1'");
$warN = mysql_num_rows($warS);
$warF = mysql_fetch_array($warS);

$lastattack = $warF['lastair'];
$grnddiff = abs(strtotime($lastattack) - strtotime(date(c)));
$groundhours = round($grnddiff/60/60);

$deployjets = mysql_real_escape_string(htmlentities($_POST['fighterjets']));
$deployinterceptors = mysql_real_escape_string(htmlentities($_POST['interceptors']));
$deploybombers = mysql_real_escape_string(htmlentities($_POST['bombers']));

if($warN != 1) {
$error .= "This war does not exist.<br />";
} if($warF['lastair'] == $username) {
$error .= "It is not your turn to attack.<br />";
} if(!is_numeric($deployjets) OR !is_numeric($deployinterceptors) OR !is_numeric($deploybombers)) {
$error .= "You must enter numeric values when deploying units.<br />";
} if($userF['fighterjets'] < $deployjets OR $userF['interceptor'] < $deployinterceptors OR $userF['bomber'] < $deploybombers) {
$error .= "You cannot deploy more aircraft than you own.<br />";
} if(0 > $deployjets OR 0 > $deployinterceptors OR 0 > $deploybombers) {
$error .= "You cannot deploy a negative amount of units.<br />";
}

if($error == null) {

if($username == $warF['defender']) {
$otherman = $warF['attacker'];
} if($username == $warF['attacker']) {
$otherman = $warF['defender'];
}

$offrand = rand(28,38);
$mobility = ($deployjets*3)+($deployinterceptors*3.5)+($deploybombers*1.5);
$damage = ($deployjets*2)+($deployinterceptors*3)+($deploybombers*4.5);
$usertotal = ($damage/$offrand)*$mobility;

$casrand = rand(10,20);

$userjcas = round($deployjets/$casrand);
$usericas = round($deployinterceptors/$casrand);
$userbcas = round($deploybombers/$casrand);

$otherS = mysql_query("SELECT * FROM players WHERE username='$otherman'");
$otherF = mysql_fetch_array($otherS);

$otherjets = $otherF['fighterjets'];
$otherinterceptors = $otherF['interceptor'];
$othersams = $otherF['sam'];

$otherjcas = round($otherjets/$casrand);
$othericas = round($otherinterceptors/$casrand);
$otherscas = round($othersams/$casrand);

$defrand = rand(30,40);
$othermobility = ($otherjets*3)+($otherinterceptors*3.5)+($othersams*1);
$defense = ($otherjets*2)+($otherinterceptors*1.5)+($othersams*4);
$othertotal = ($defense/$defrand)*$othermobility;

if($userjcas*1.4 < $otherjcas) {
$otherjcas = $userjcas*1.4;
} if($otherjcas*1.4 < $userjcas) {
$userjcas = $otherjcas*1.4;
} if($usericas*1.3 < $othericas) {
$othericas = $usericas*1.3;
} if($othericas*1.3 < $usericas) {
$usericas = $othericas*1.3;
} if($userbcas*1.2 < $otherscas) {
$otherscas = $userbcas*1.2;
} if($otherscas*1.2 < $userbcas) {
$userbcas = $otherscas*1.2;
}

$usercasualties = round($usericas+$userjcas+$userbcas);
$othercasualties = round($otherscas+$otherjcas+$othericas);

if($usertotal > $othertotal) {
$outcome = "lost";
$outcome2 = "losing";
$outcome3 = "won";
$outcome4 = "stealing";
$winner = $username;
$winnermoney = $userF['money'];
$losermoney = $otherF['money'];
$loser = $otherman;
$losercas = $otherjcas+$othericas+$otherscas;
$winnercas = $userjcas+$userbcas+$usericas;
$winnercasualties = $usercasualties+$userF['casualties'];
$losercasualties = $othercasualties+$otherF['casualties'];
$winnerjets = round($userF['fighterjets']-($userjcas));
$winnerinterceptors = round($userF['interceptor']-($usericas));
$winnerbombers = round($userF['bomber']-($userbcas));
$winnersams = $userF['sam'];
$loserjets = round($otherF['fighterjets']-($otherjcas));
$loserinterceptors = round($otherF['interceptor']-($othericas));
$loserbombers = round($otherF['bomber']);
$losersams = round($otherF['sam']-($otherscas));
} else {
$outcome = "won";
$outcome2 = "stealing";
$outcome3 = "lost";
$outcome4 = "losing";
$winner = $otherman;
$winnermoney = $otherF['money'];
$losermoney = $userF['money'];
$loser = $username;
$winnercas = $otherjcas+$othericas+$otherscas;
$losercas = $userjcas+$userbcas+$usericas;
$winnercasualties = $othercasualties+$otherF['casualties'];
$losercasualties = $usercasualties+$userF['casualties'];
$winnerjets = round($otherF['fighterjets']-($otherjcas));
$winnerinterceptors = round($otherF['interceptor']-($othericas));
$winnerbombers = round($otherF['bomber']);
$winnersams = round($otherF['sam']-($otherscas));
$loserjets = round($userF['fighterjets']-($userjcas));
$loserinterceptors = round($userF['interceptor']-($usericas));
$loserbombers = round($userF['bomber']-($userbcas));
$losersams = $userF['sam'];
}

$moneyrand = rand(1,50);
$moneyloss = $moneyrand*$losercas;
$winnermoney = $winnermoney+($losercas*$moneyrand);
$losermoney = $losermoney-($losercas*$moneyrand);

if($winner == $userF['username']) {
$citycheck = mysql_query("SELECT * FROM cities WHERE nation='$otherF[nation]' ORDER BY population DESC LIMIT 1");
$cityarray = mysql_fetch_array($citycheck);
$bombers = $deploybombers-$userbcas;
$ran1 = rand(1,5);
$ran2 = rand(1,5);
$ran3 = rand(1,5);
$ran4 = rand(1,5);
$resloss = round($bombers/$ran1);
$comloss = round($bombers/$ran2);
$indloss = round($bombers/$ran3);
$civloss = round($bombers/$ran4);
$newres = $cityarray['residential']-$resloss;
$newcom = $cityarray['commercial']-$comloss;
$newind = $cityarray['industrial']-$indloss;
$newciv = $cityarray['military']-$civloss;

if($newres < 0) {
$newres = 0;
} if($newcom < 0) {
$newcom = 0;
} if($newind < 0) {
$newind = 0;
} if($newciv < 0) {
$newciv = 0;
}
$cityid = $cityarray['id'];
$cityname = $cityarray['name'];

$date = date("c");
mysql_query("UPDATE cities SET residential='$newres', commercial='$newcom', industrial='$newind', military='$newciv' WHERE id='$cityid'");

$body = " ".$username." has scrambled his fighters in an aerial attack against you! You ".$outcome." the battle, destroying ".number_format($usercasualties)." enemy aircraft and ".$outcome2." $".number_format($moneyloss).". You lost ".number_format($otherjcas)." fighter jets, ".number_format($othericas)." interceptors, and ".number_format($otherscas)." SAM batteries in the battle. ".$username."s bombers were able to destroy part of your city named ".$cityname.". ".$resloss." residential, ".$comloss." commercial, ".$indloss." industrial, and ".$civloss." civic zones were destroyed in the attack. Any previous peace offers have been automatically cancelled.";
mysql_query("UPDATE wars SET lastair='$username', defpeace='0', attpeace='0' WHERE id='$warID'");
mysql_query("UPDATE players SET money='$winnermoney', casualties='$winnercasualties', fighterjets='$winnerjets', interceptor='$winnerinterceptors', bomber='$winnerbombers', sam='$winnersams' WHERE username='$winner'");
mysql_query("UPDATE players SET money='$losermoney', casualties='$losercasualties', fighterjets='$loserjets', interceptor='$loserinterceptors', bomber='$loserbombers', sam='$losersams' WHERE username='$loser'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherman', '$username', 'Aerial Attack!', '$body', '$date', '0', '0')");

echo "You have engaged ".$otherman." in an aerial attack! You ".$outcome3." the battle, destroying ".number_format($othercasualties)." enemy aircraft and ".$outcome4." $".number_format($moneyloss).". You lost ".number_format($userjcas)." fighter jets, ".number_format($usericas)." interceptors, and ".number_format($userbcas)." bombers, in the battle. Your bombers were able to destroy a portion of your enemy's city named ".$cityname.". ".$resloss." residential, ".$comloss." commercial, ".$indloss." industrial, and ".$civloss." civic zones were destroyed in the attack. Any previous peace offers have been automatically cancelled.";


} else {

$date = date("c");
$body = " ".$username." has scrambled his fighters in an aerial attack against you! You ".$outcome." the battle, destroying ".number_format($usercasualties)." enemy aircraft and ".$outcome2." $".number_format($moneyloss).". You lost ".number_format($otherjcas)." fighter jets, ".number_format($othericas)." interceptors, and ".number_format($otherscas)." SAM batteries in the battle. Any previous peace offers have been automatically cancelled.";
mysql_query("UPDATE wars SET lastair='$username', defpeace='0', attpeace='0' WHERE id='$warID'");
mysql_query("UPDATE players SET money='$winnermoney', casualties='$winnercasualties', fighterjets='$winnerjets', interceptor='$winnerinterceptors', bomber='$winnerbombers', sam='$winnersams' WHERE username='$winner'");
mysql_query("UPDATE players SET money='$losermoney', casualties='$losercasualties', fighterjets='$loserjets', interceptor='$loserinterceptors', bomber='$loserbombers', sam='$losersams' WHERE username='$loser'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherman', '$username', 'Aerial Attack!', '$body', '$date', '0', '0')");

echo "You have engaged ".$otherman." in an aerial attack! You ".$outcome3." the battle, destroying ".number_format($othercasualties)." enemy aircraft and ".$outcome4." $".number_format($moneyloss).". You lost ".number_format($userjcas)." fighter jets, ".number_format($usericas)." interceptors, and ".number_format($userbcas)." bombers, in the battle. Any previous peace offers have been automatically cancelled.";

}
} else {
echo "You received the following error(s):<br /><br />";
echo $error;
echo "<br /><br /><center><a href='index.php?id=30'>Go Back</a></center>";
}

} else {
//show form
echo "If you wish to scramble your fighters in an aerial attack (Fighter Jets), you may do so. Note, air attacks are turn based so you won't be able to attack again until the game updates or your opponent attacks back.<br /><br />
<form action=\"index.php?id=36&wid=".$warID."\" method=\"post\">
<center><table>
<tr><td>Available Fighter Jets:</td><td>".number_format($userF['fighterjets'])."</td></tr>
<tr><td>Fighter Jets to Deploy:</td><td><input type='text' name='fighterjets' value='".$userF['fighterjets']."'></td></tr>
<tr><td>Available Interceptors:</td><td>".number_format($userF['interceptor'])."</td></tr>
<tr><td>Interceptors to Deploy:</td><td><input type='text' name='interceptors' value='".$userF['interceptor']."'></td></tr>
<tr><td>Available Bombers:</td><td>".number_format($userF['bomber'])."</td></tr>
<tr><td>Bombers to Deploy:</td><td><input type='text' name='bombers' value='".$userF['bomber']."'></td></tr>
</table><br /><input type=\"submit\" name=\"attack\" value=\"Attack!\"></center>
</form>";

}
?>