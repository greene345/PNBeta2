<div id="title">Ground Battle</div>
<img src="images/groundbattle.jpg" class="center">
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

$lastattack = $warF['lastground'];
$grnddiff = abs(strtotime($lastattack) - strtotime(date(c)));
$groundhours = round($grnddiff/60/60);

$deploysoldiers = mysql_real_escape_string(htmlentities($_POST['soldiers']));
$deploysnipers = mysql_real_escape_string(htmlentities($_POST['snipers']));
$deployparatroopers = mysql_real_escape_string(htmlentities($_POST['paratroopers']));
$deploynomads = mysql_real_escape_string(htmlentities($_POST['nomads']));
$deploymavericks = mysql_real_escape_string(htmlentities($_POST['mavericks']));
$deploylonghorns = mysql_real_escape_string(htmlentities($_POST['longhorns']));


if($warN != 1) {
$error .= "This war does not exist.<br />";
} if($warF['lastground'] == $username) {
$error .= "It is not your turn to attack.<br />";
} if(!is_numeric($deploysoldiers)) {
$error .= "You must enter a numeric value for the amount of soldiers you wish to deploy.<br />";
} if(!is_numeric($deploysnipers)) {
$error .= "You must enter a numeric value for the amount of snipers you wish to deploy.<br />";
} if($deploysoldiers < 5) {
$error .= "You must deploy at least 5 soldiers.<br />";
} if($deploysnipers < 0) {
$error .= "You cannot deploy less than 0 snipers.<br />";
} if($userF['soldiers'] < $deploysoldiers) {
$error .= "You cannot deploy more soldiers than you have.<br />";
} if($userF['snipers'] < $deploysnipers) {
$error .= "You cannot deploy more snipers than you have.<br />";
} if(!is_numeric($deploysnipers)) {
$error .= "You must enter a numeric value for the amount of paratroopers you wish to deploy.<br />";
} if(!is_numeric($deploynomads)) {
$error .= "You must enter a numeric value for the amount of nomads you wish to deploy.<br />";
} if(!is_numeric($deploymavericks)) {
$error .= "You must enter a numeric value for the amount of mavericks you wish to deploy.<br />";
} if(!is_numeric($deploylonghorns)) {
$error .= "You must enter a numeric value for the amount of longhorns you wish to deploy.<br />";
} if($deployparatroopers < 0 OR $deploynomads < 0 OR $deploymavericks < 0 OR $deploylonghorns < 0) {
$error .= "You cannot deploy a negative amount of units.<br />";
} if($deployparatroopers > $userF['paratrooper'] OR $deploynomads > $userF['nomad'] OR $deploymavericks > $userF['maverick'] OR $deploylonghorns > $userF['longhorn']) {
$error .= "You cannot deploy more units than you have.<br />";
}

if($error == null) {

if($username == $warF['defender']) {
$otherman = $warF['attacker'];
} if($username == $warF['attacker']) {
$otherman = $warF['defender'];
}

$offrand = rand(28,58);
$mobility = ($deploysoldiers*2)+($deploysnipers*1)+($deployparatroopers*3)+($deploynomads*3)+($deploymavericks*2)+($deploylonghorns*1.5);
if($userF['combat'] != 1) {
$damage = ($deploysoldiers*1)+($deploysnipers*2.5)+($deployparatroopers*1.5)+($deploynomads*1.5)+($deploymavericks*3)+($deploylonghorns*3);
} if($userF['combat'] == 1) {
$damage = ($deploysoldiers*1.5)+($deploysnipers*2.5)+($deployparatroopers*1.5)+($deploynomads*1.5)+($deploymavericks*3)+($deploylonghorns*3);
}
$usertotal = ($damage/$offrand)*$mobility;

$casrand = rand(15,30);

$usersolcas = round($deploysoldiers/$casrand);
$usersnicas = round($deploysnipers/$casrand);
$userparcas = round($deployparatroopers/$casrand);
$usernomcas = round($deploynomads/$casrand);
$usermavcas = round($deploymavericks/$casrand);
$userloncas = round($deploylonghorns/$casrand);

$otherS = mysql_query("SELECT * FROM players WHERE username='$otherman'");
$otherF = mysql_fetch_array($otherS);

$othersoldiers = $otherF['soldiers'];
$othersnipers = $otherF['snipers'];
$otherparatroopers = $otherF['paratrooper'];
$othernomads = $otherF['nomad'];
$othermavericks = $otherF['maverick'];
$otherlonghorns = $otherF['longhorn'];

$otherunits = $othersoldiers+$othersnipers+$otherparatroopers+$othernomads+$othermavericks+$otherlonghorns;
$userunits = $deploysoldiers+$deploysnipers+$deployparatroopers+$deploynomads+$deploymavericks+$deploylonghorns;

if($otherunits == 0 AND $userunits > 50) {
$raid = 1;
} if($userunits > 5000 AND $otherunits < 1000) {
$raid = 1;
} if(($userunits/$otherunits) > 2) {
$raid = 1;
}

$defrand = rand(30,60);
$othermobility = ($othersoldiers*2)+($othersnipers*1)+($otherparatroopers*3)+($othernomads*3)+($othermavericks*2)+($otherlonghorns*1.5);
if($otherF['combat'] != 1) {
$defense = ($othersoldiers*1)+($othersnipers*2)+($otherparatroopers*1)+($othernomads*1.5)+($othermavericks*2)+($otherlonghorns*6);
} if($otherF['combat'] == 1) {
$defense = ($othersoldiers*1.5)+($othersnipers*2)+($otherparatroopers*1)+($othernomads*1.5)+($othermavericks*2)+($otherlonghorns*6);
}
$othertotal = ($defense/$defrand)*$othermobility;

$othersolcas = round($othersoldiers/$casrand);
$othersnicas = round($othersnipers/$casrand);
$otherparcas = round($otherparatroopers/$casrand);
$othernomcas = round($othernomads/$casrand);
$othermavcas = round($othermavericks/$casrand);
$otherloncas = round($otherlonghorns/$casrand);

if($othersolcas*1.2 < $usersolcas) {
$usersolcas = $othersolcas*1.2;
} if($usersolcas*.95 < $othersolcas) {
$othersolcas = $usersolcas*.95;
} if($othersnicas*1.5 < $usersnicas) {
$usersnicas = $othersnicas*1.5;
} if($usersnicas*1.5 < $othersnicas) {
$othersnicas = $usersnicas*1.5;
} if($otherparcas*1.6 < $userparcas) {
$userparcas = $otherparcas*1.6;
} if($userparcas*1.3 < $otherparcas) {
$otherparcas = $userparcas*1.3;
} if($othernomcas*1.4 < $usernomcas) {
$usernomcas = $othernomcas*1.4;
} if($usernomcas*1.4 < $othernomcas) {
$othernomcas = $usernomcas*1.4;
} if($othermavcas*1.3 < $usermavcas) {
$usermavcas = $othermavcas*1.3;
} if($usermavcas*1.3 < $othermavcas) {
$othermavcas = $usermascas*1.3;
} if($otherloncas*1.2 < $userloncas) {
$userloncas = $otherloncas*1.2;
} if($userloncas*1.1 < $otherloncas) {
$otherloncas = $userloncas*1.1;
}

$usercasualties = round($usersolcas+$usersnicas+$userparcas+$usernomcas+$usermavcas+$userloncas);
$othercasualties = round($othersolcas+$othersnicas+$otherparcas+$othernomcas+$othermavcas+$otherloncas);

if($usertotal > $othertotal) {
$outcome = "lost";
$outcome2 = "losing";
$outcome3 = "won";
$outcome4 = "stealing";
$winner = $username;
$winnermoney = $userF['money'];
$loser = $otherman;
$losermoney = $otherF['money'];
$winnercasualties = $usercasualties+$userF['casualties'];
$losercasualties = $othercasualties+$otherF['casualties'];
$losercas = $othercasualties;
$winnersoldiers = round($userF['soldiers']-($usersolcas));
$winnersnipers = round($userF['snipers']-($usersnicas));
$winnerparatroopers = round($userF['paratrooper']-($userparcas));
$winnernomads = round($userF['nomad']-($usernomcas));
$winnermavericks = round($userF['maverick']-($usermavcas));
$winnerlonghorns = round($userF['longhorn']-($userloncas));

$losersoldiers = round($otherF['soldiers']-($othersolcas));
$losersnipers = round($otherF['snipers']-($othersnicas));
$loserparatroopers = round($otherF['paratrooper']-($otherparcas));
$losernomads = round($otherF['nomad']-($othernomcas));
$losermavericks = round($otherF['maverick']-($othermavcas));
$loserlonghorns = round($otherF['longhorn']-($otherloncas));
} else {
$outcome = "won";
$outcome2 = "stealing";
$outcome3 = "lost";
$outcome4 = "losing";
$winner = $otherman;
$winnermoney = $otherF['money'];
$loser = $username;
$losermoney = $userF['money'];
$winnercasualties = $othercasualties+$otherF['casualties'];
$losercasualties = $usercasualties+$userF['casualties'];
$losercas = $usercasualties;
$winnersoldiers = round($otherF['soldiers']-($othersolcas));
$winnersnipers = round($otherF['snipers']-($othersnicas));
$winnerparatroopers = round($otherF['paratrooper']-($otherparcas));
$winnernomads = round($otherF['nomad']-($othernomcas));
$winnermavericks = round($otherF['maverick']-($othermavcas));
$winnerlonghorns = round($otherF['longhorn']-($otherloncas));

$losersoldiers = round($userF['soldiers']-($usersolcas));
$losersnipers = round($userF['snipers']-($usersnicas));
$loserparatroopers = round($userF['paratrooper']-($userparcas));
$losernomads = round($userF['nomad']-($usernomcas));
$losermavericks = round($userF['maverick']-($usermavcas));
$loserlonghorns = round($userF['longhorn']-($userloncas));
}

$moneyrand = rand(50,150);
if($raid == 1) {
$moneyrand = rand(200,500);
$researchpoints = rand(50,250);
}
$moneyloss = $losercas*$moneyrand;
$winnermoney = $winnermoney+$moneyloss;
$losermoney = $losermoney-$moneyloss;

$date = date("c");

if($raid == 1) {
$winnerpoints = $userF['rpoints'] + $researchpoints;
$loserpoints = $otherF['rpoints'] - $researchpoints;
if($loserpoints < 0) {
$loserpoints = 0;
}
//destroy city zones
$othernation = $otherF['nation'];
$othercitycheck = mysql_query("SELECT * FROM cities WHERE nation='$othernation' ORDER BY population DESC LIMIT 1");
$othercityfetch = mysql_fetch_array($othercitycheck);
$rand1 = rand(1,30);
$rand2 = rand(1,30);
$rand3 = rand(1,30);
$rand4 = rand(1,30);
$rand5 = rand(1,750);
$newreszones = $othercityfetch['residential']-$rand1;
$newcomzones = $othercityfetch['commercial']-$rand2;
$newindzones = $othercityfetch['industrial']-$rand3;
$newcivzones = $othercityfetch['military']-$rand4;
$newland = $othercityfetch['land']-$rand5;
if($newreszones < 0) {
$newreszones = 0;
} if($newcomzones < 0) {
$newcomzones = 0;
} if($newindzones < 0) {
$newindzones = 0;
} if($newcivzones < 0) {
$newcivzones = 0;
} if($newland < 5) {
$newland = 5;
}
mysql_query("UPDATE cities SET residential='$newreszones', commercial='$newcomzones', industrial='$newindzones', military='$newcivzones', land='$newland' WHERE id='$othercityfetch[id]'");

$usercitycheck = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]' ORDER BY land ASC");
$usercityfetch = mysql_fetch_array($usercitycheck);
$newuserland = $usercityfetch['land']+$rand5;
mysql_query("UPDATE cities SET land='$newuserland' WHERE id='$usercityfetch[id]'");

$body = " ".$username." has engaged your forces in a ground attack! You ".$outcome." the battle, killing ".number_format($usercasualties)." enemies and ".$outcome2." $".number_format($moneyloss).". You lost ".number_format($othersolcas)." soldiers, ".number_format($othersnicas)." snipers, ".number_format($otherparcas)." paratroopers, ".number_format($othernomcas)." nomads, ".number_format($othermavcas)." mavericks, and ".number_format($otherloncas)." longhorns in the battle. Because you did not have enough defending units, your city of ".$othercityfetch['name']." was damaged and you lost ".$rand5." km of land. ".$researchpoints." research points were also stolen in the fight. Any previous peace offers have been automatically cancelled.";
mysql_query("UPDATE wars SET lastground='$username', defpeace='0', attpeace='0' WHERE id='$warID'");
mysql_query("UPDATE players SET money='$winnermoney', casualties='$winnercasualties', soldiers='$winnersoldiers', snipers='$winnersnipers', paratrooper='$winnerparatroopers', nomad='$winnernomads', maverick='$winnermavericks', longhorn='$winnerlonghorns', rpoints='$winnerpoints' WHERE username='$winner'");
mysql_query("UPDATE players SET money='$losermoney', casualties='$losercasualties', soldiers='$losersoldiers', snipers='$losersnipers', paratrooper='$loserparatroopers', nomad='$losernomads', maverick='$losermavericks', longhorn='$loserlonghorns', rpoints='$loserpoints' WHERE username='$loser'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherman', '$username', 'Ground Attack!', '$body', '$date', '0', '0')");

echo "You have engaged ".$otherman." in a ground attack! You ".$outcome3." the battle, killing ".number_format($othercasualties)." enemies and ".$outcome4." $".number_format($moneyloss).". You lost ".number_format($usersolcas)." soldiers, ".number_format($usersnicas)." snipers, ".number_format($userparcas)." paratroopers, ".number_format($usernomcas)." nomads, ".number_format($usermavcas)." mavericks, and ".number_format($userloncas)." longhorns in the battle. Your opponent did not have enough defending units, and you were able to partially destroy the city of ".$othercityfetch['name'].". You razed ".$rand1." residential zones, ".$rand2." commercial zones, ".$rand3." industrial zones, and ".$rand4." civic zones. You also captured ".$rand5." miles of land which was traded for new land in your city of ".$usercityfetch['name'].". You also stole ".$researchpoints." research points in the battle. Any peace offers have been automatically cancelled.";
}
if($raid != 1) {
$body = " ".$username." has engaged your forces in a ground attack! You ".$outcome." the battle, killing ".number_format($usercasualties)." enemies and ".$outcome2." $".number_format($moneyloss).". You lost ".number_format($othersolcas)." soldiers, ".number_format($othersnicas)." snipers, ".number_format($otherparcas)." paratroopers, ".number_format($othernomcas)." nomads, ".number_format($othermavcas)." mavericks, and ".number_format($otherloncas)." longhorns in the battle. Any previous peace offers have been automatically cancelled.";
mysql_query("UPDATE wars SET lastground='$username', defpeace='0', attpeace='0' WHERE id='$warID'");
mysql_query("UPDATE players SET money='$winnermoney', casualties='$winnercasualties', soldiers='$winnersoldiers', snipers='$winnersnipers', paratrooper='$winnerparatroopers', nomad='$winnernomads', maverick='$winnermavericks', longhorn='$winnerlonghorns' WHERE username='$winner'");
mysql_query("UPDATE players SET money='$losermoney', casualties='$losercasualties', soldiers='$losersoldiers', snipers='$losersnipers', paratrooper='$loserparatroopers', nomad='$losernomads', maverick='$losermavericks', longhorn='$loserlonghorns' WHERE username='$loser'");
mysql_query("INSERT INTO messages (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$otherman', '$username', 'Ground Attack!', '$body', '$date', '0', '0')");

echo "You have engaged ".$otherman." in a ground attack! You ".$outcome3." the battle, killing ".number_format($othercasualties)." enemies and ".$outcome4." $".number_format($moneyloss).". You lost ".number_format($usersolcas)." soldiers, ".number_format($usersnicas)." snipers, ".number_format($userparcas)." paratroopers, ".number_format($usernomcas)." nomads, ".number_format($usermavcas)." mavericks, and ".number_format($userloncas)." longhorns in the battle. Any peace offers have been automatically cancelled.";
}
} else {
echo "You received the following error(s):<br /><br />";
echo $error;
echo "<br /><br /><center><a href='index.php?id=30'>Go Back</a></center>";
}

} else {
//show form
echo "If you wish to engage in a ground battle (Infantry and Vehicles), you may do so. Attacks are turn based, so you won't be able to attack again until your opponent attacks you back. Please choose how many infantry and vehicles you wish to deploy for this battle.<br /><br />
<form action=\"index.php?id=34&wid=".$warID."\" method=\"post\">
<center><table>
<tr><td>Available Soldiers:</td><td>".number_format($userF['soldiers'])."</td></tr>
<tr><td>Soldiers to Deploy:</td><td><input type='text' name='soldiers' value='".$userF['soldiers']."'></td></tr>
<tr><td>Available Snipers:</td><td>".number_format($userF['snipers'])."</td></tr>
<tr><td>Snipers to Deploy:</td><td><input type='text' name='snipers' value='".$userF['snipers']."'></td></tr>
<tr><td>Available Paratroopers:</td><td>".number_format($userF['paratrooper'])."</td></tr>
<tr><td>Paratroopers to Deploy:</td><td><input type='text' name='paratroopers' value='".$userF['paratrooper']."'></td></tr>
<tr><td>Available Nomads:</td><td>".number_format($userF['nomad'])."</td></tr>
<tr><td>Nomads to Deploy:</td><td><input type='text' name='nomads' value='".$userF['nomad']."'></td></tr>
<tr><td>Available Mavericks:</td><td>".number_format($userF['maverick'])."</td></tr>
<tr><td>Mavericks to Deploy:</td><td><input type='text' name='mavericks' value='".$userF['maverick']."'></td></tr>
<tr><td>Available Longhorns:</td><td>".number_format($userF['longhorn'])."</td></tr>
<tr><td>Longhorns to Deploy:</td><td><input type='text' name='longhorns' value='".$userF['longhorn']."'></td></tr>
</table><br /><input type=\"submit\" name=\"attack\" value=\"Attack!\"></center>
</form>";

}
?>