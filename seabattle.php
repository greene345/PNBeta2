<div id="title">Naval Battle</div>
<img src="images/seabattle.jpg" class="center">
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

$lastattack = $warF['lastsea'];
$grnddiff = abs(strtotime($lastattack) - strtotime(date(c)));
$groundhours = round($grnddiff/60/60);

$deploybships = mysql_real_escape_string(htmlentities($_POST['battleships']));
$deploydestroyers = mysql_real_escape_string(htmlentities($_POST['destroyers']));
$deploysubmarines = mysql_real_escape_string(htmlentities($_POST['submarines']));
$deploycarriers = mysql_real_escape_string(htmlentities($_POST['carriers']));

if($warN != 1) {
$error .= "This war does not exist.<br />";
} if($warF['lastsea'] == $username) {
$error .= "It is not your turn to attack.<br />";
} if(!is_numeric($deploybships) OR !is_numeric($deploydestroyers) OR !is_numeric($deploysubmarines) OR !is_numeric($deploycarriers)) {
$error .= "You must enter numeric values when deploying units.<br />";
} if($userF['battleships'] < $deploybships OR $userF['destroyers'] < $deploydestroyers OR $userF['subs'] < $deploysubmarines OR $userF['carriers'] < $deploycarriers) {
$error .= "You cannot deploy more units than you own.<br />";
} if(0 > $deploysubmarines OR 0 > $deploycarriers OR 0 > $deploybships OR 0 > $deploydestroyers) {
$error .= "You cannot deploy a negative amount of units.<br />";
}

if($error == null) {

if(trim($username) == trim($warF['defender'])) {
$otherman = $warF['attacker'];
} if(trim($username) == trim($warF['attacker'])) {
$otherman = $warF['defender'];
}

$offrand = rand(28,38);
$mobility = ($deploybships*2.5)+($deploydestroyers*3)+($deploysubmarines*4)+($deploycarriers*2.5);
$damage = ($deploybships*2)+($deploydestroyers*2)+($deploysubmarines*3)+($deploycarriers*5);
$usertotal = ($damage/$offrand)*$mobility;

$casrand = rand(3,10);

$userbcas = round($deploybships/$casrand);
$userccas = round($deploycarriers/$casrand);
$userdcas = round($deploydestroyers/$casrand);
$userscas = round($deploysubmarines/$casrand);

$usercasualties = round(($deploybships/$casrand)+($deploydestroyers/$casrand)+($deploysubmarines/$casrand)+($deploycarriers/$casrand));

$otherS = mysql_query("SELECT * FROM players WHERE username='$otherman'");
$otherF = mysql_fetch_array($otherS);

$otherbships = $otherF['battleships'];
$otherdestroyers = $otherF['destroyers'];
$othersubs = $otherF['subs'];
$othercarriers = $otherF['carriers'];

$defrand = rand(30,40);
$othermobility = ($otherbships*2.5)+($otherdestroyers*3)+($othersubs*4)+($othercarriers*2.5);
$defense = ($otherbships*2)+($otherdestroyers*4)+($othersubs*3)+($othercarriers*2);
$othertotal = ($damage/$defrand)*$othermobility;

$otherbcas = round($otherbships/$casrand);
$otherccas = round($othercarriers/$casrand);
$otherdcas = round($otherdestroyers/$casrand);
$otherscas = round($othersubs/$casrand);

if($userbcas*1.6 < $otherbcas) {
$otherbcas = round($userbcas*1.6);
} if($otherbcas*1.6 < $userbcas) {
$userbcas = round($otherbcas*1.6);
} if($userccas*1.1 < $otherccas) {
$otherccas = round($userccas*1.1);
} if($otherccas*1.1 < $userccas) {
$userccas = round($otherccas*1.1);
} if($userdcas*1.4 < $otherdcas) {
$otherdcas = round($userdcas*1.4);
} if($otherdcas*1.4 < $userdcas) {
$userdcas = round($otherdcas*1.4);
} if($userscas*1.2 < $otherscas) {
$otherscas = round($userscas*1.2);
} if($otherscas*1.2 < $userscas) {
$userscas = round($otherscas*1.2);
}

$usercasualties = round($userbcas+$userccas+$userdcas+$userscas);
$othercasualties = round($otherbcas+$otherccas+$otherdcas+$otherscas);

if($usertotal > $othertotal) {
$outcome = "lost";
$outcome2 = "losing";
$outcome3 = "won";
$outcome4 = "stealing";
$winner = $username;
$winnermoney = $userF['money'];
$loser = $otherman;
$losermoney = $otherF['money'];
$losercas = $othercasualties;
$winnercasualties = $usercasualties+$userF['casualties'];
$losercasualties = $othercasualties+$otherF['casualties'];
$winnerbships = round($userF['battleships']-$userbcas);
$winnerdestroyers = round($userF['destroyers']-$userdcas);
$winnersubmarines = round($userF['subs']-$userscas);
$winnercarriers = round($userF['carriers']-$userccas);
$loserbships = round($otherF['battleships']-$otherbcas);
$loserdestroyers = round($otherF['destroyers']-$otherdcas);
$losersubmarines = round($otherF['subs']-$otherscas);
$losercarriers = round($otherF['carriers']-$otherccas);
} else {
$outcome = "won";
$outcome2 = "stealing";
$outcome3 = "lost";
$outcome4 = "losing";
$winner = $otherman;
$winnermoney = $otherF['money'];
$loser = $username;
$losermoney = $userF['money'];
$losercas = $usercasualties;
$winnercasualties = $othercasualties+$otherF['casualties'];
$losercasualties = $usercasualties+$userF['casualties'];
$loserbships = round($userF['battleships']-$userbcas);
$loserdestroyers = round($userF['destroyers']-$userdcas);
$losersubmarines = round($userF['subs']-$userscas);
$losercarriers = round($userF['carriers']-$userccas);
$winnerbships = round($otherF['battleships']-$otherbcas);
$winnerdestroyers = round($otherF['destroyers']-$otherdcas);
$winnersubmarines = round($otherF['subs']-$otherscas);
$winnercarriers = round($otherF['carriers']-$otherccas);

}

$moneyrand = rand(60,300);
$moneyloss = $moneyrand*$losercas;
$winnermoney = $winnermoney+($losercas*$moneyrand);
$losermoney = $losermoney-($losercas*$moneyrand);

if($winner == $userF['username'] AND ($deploycarriers-$userccas) > 0) {
$citycheck = mysql_query("SELECT * FROM cities WHERE nation='$otherF[nation]' ORDER BY population DESC LIMIT 1");
$cityarray = mysql_fetch_array($citycheck);
$bombers = $deploycarriers-$userccas;
$ran1 = rand(1,6);
$ran2 = rand(1,4);
$ran3 = rand(1,4);
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

$body = " ".$username." has engaged your fleet in a naval attack! You ".$outcome." the battle, destroying ".number_format($usercasualties)." enemy ships and ".$outcome2." $".number_format($moneyloss).". You lost ".number_format($otherbcas)." battleships, ".number_format($otherdcas)." destroyers, and ".number_format($otherscas)." submarines, and ".number_format($otherccas)." carriers in the battle. ".$username."'s carriers were able to destroy part of your city named ".$cityname.". ".$resloss." residential, ".$comloss." commercial, ".$indloss." industrial, and ".$civloss." civic zones were destroyed in the attack. Any previous peace offers have been automatically cancelled.";
mysql_query("UPDATE wars SET lastsea='$username', defpeace='0', attpeace='0' WHERE id='$warID'");
mysql_query("UPDATE players SET money='$winnermoney', casualties='$winnercasualties', battleships='$winnerbships', destroyers='$winnerdestroyers', subs='$winnersubmarines', carriers='$winnercarriers' WHERE username='$winner'");
mysql_query("UPDATE players SET money='$losermoney', casualties='$losercasualties', battleships='$loserbships', destroyers='$loserdestroyers', subs='$losersubmarines', carriers='$losercarriers' WHERE username='$loser'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherman', '$username', 'Naval Attack!', '$body', '$date', '0', '0')");

echo "You have engaged ".$otherman." in a naval attack! You ".$outcome3." the battle, destroying ".number_format($othercasualties)." enemy ships and ".$outcome4." $".number_format($moneyloss).". You lost ".number_format($userbcas)." battleships, ".number_format($userdcas)." destroyers, and ".number_format($userscas)." submarines, and ".number_format($userccas)." carriers in the battle. Your carriers were able to destroy a portion of your enemy's city named ".$cityname.". ".$resloss." residential, ".$comloss." commercial, ".$indloss." industrial, and ".$civloss." civic zones were destroyed in the attack. Any previous peace offers have been automatically cancelled.";


} else {

$date = date("c");
$body = " ".$username." has engaged your fleet in a naval attack! You ".$outcome." the battle, sinking ".number_format($usercasualties)." enemy ships and ".$outcome2." $".number_format($moneyloss).". You lost ".number_format($otherbcas)." battleships, ".number_format($otherdcas)." destroyers, ".number_format($otherscas)." submarines, and ".number_format($otherccas)." carriers in the battle. Any existing peace offers have been automatically cancelled.";
mysql_query("UPDATE wars SET lastsea='$username', defpeace='0', attpeace='0' WHERE id='$warID'");
mysql_query("UPDATE players SET money='$winnermoney', casualties='$winnercasualties', battleships='$winnerbships', destroyers='$winnerdestroyers', subs='$winnersubmarines', carriers='$winnercarriers' WHERE username='$winner'");
mysql_query("UPDATE players SET money='$losermoney', casualties='$losercasualties', battleships='$loserbships', destroyers='$loserdestroyers', subs='$losersubmarines', carriers='$losercarriers' WHERE username='$loser'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherman', '$username', 'Naval Attack!', '$body', '$date', '0', '0')");

echo "You have engaged ".$otherman." in a naval attack! You ".$outcome3." the battle, sinking ".number_format($othercasualties)." enemy ships and ".$outcome4." $".number_format($moneyloss).". You lost ".number_format($userbcas)." battleships, ".number_format($userdcas)." destroyers, ".number_format($userscas)." submarines, ".number_format($userccas)." carriers in the battle. Any existing peace offers have been automatically cancelled.";

}
} else {
echo "You received the following error(s):<br /><br />";
echo $error;
echo "<br /><br /><center><a href='index.php?id=30'>Go Back</a></center>";
}

} else {
//show form
echo "If you wish to engage in a naval battle you may do so. Please choose how many naval vessels you wish to deploy for this battle.<br /><br />
<form action=\"index.php?id=35&wid=".$warID."\" method=\"post\">
<center><table>
<tr><td>Available Battleships:</td><td>".number_format($userF['battleships'])."</td></tr>
<tr><td>Battleships to Deploy:</td><td><input type='text' name='battleships' value='".$userF['battleships']."'></td></tr>
<tr><td>Available Destroyers:</td><td>".number_format($userF['destroyers'])."</td></tr>
<tr><td>Destroyers to Deploy:</td><td><input type='text' name='destroyers' value='".$userF['destroyers']."'></td></tr>
<tr><td>Available Submarines:</td><td>".number_format($userF['subs'])."</td></tr>
<tr><td>Submarines to Deploy:</td><td><input type='text' name='submarines' value='".$userF['subs']."'></td></tr>
<tr><td>Available Carriers:</td><td>".number_format($userF['carriers'])."</td></tr>
<tr><td>Carriers to Deploy:</td><td><input type='text' name='carriers' value='".$userF['carriers']."'></td></tr>
</table><br /><input type=\"submit\" name=\"attack\" value=\"Attack!\"></center>
</form>";

}
?>