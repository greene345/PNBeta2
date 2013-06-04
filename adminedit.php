<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 3) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
$nation = mysql_real_escape_string(htmlentities($_GET['nation']));
$nationcheck = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$nationfetch = mysql_fetch_array($nationcheck);
?>
<div id="title">Control Panel Edit</div>
<?php
if($nation == null AND $level > 2 AND !isset($_POST['submit'])) {
echo "Nation Name: <form method='get' action='index.php?id=93'><input type='text' name='nation'> <input type='hidden' value='93' name='id'> <input type='submit' value='Go'></form>";
}
if($nation != null) {
?>
<form action="index.php?id=93" method="post">
<center><table>
<tr><td>Username:</td><td><?php echo $nationfetch['username']; ?></td></tr>
<tr><td>Nation Name:</td><td><?php echo $nationfetch['nation']; ?></td><tr>
<tr><td>IP Address:</td><td><?php echo $nationfetch['ip']; ?></td></tr>
<tr><td>Last Login:</td><td><?php echo $nationfetch['last_login']; ?></td></tr>
<tr><td>E-mail Address:</td><td><input type='text' name='email' value='<?php echo stripslashes($nationfetch['email']); ?>'></td></tr>
<tr><td>Alliance:</td><td><input type='text' name='alliance' value='<?php echo stripslashes($nationfetch['alliance']); ?>'></td></tr>
<tr><td>Alliance Position:</td><td><input type='text' name='alliancepos' value='<?php echo stripslashes($nationfetch['alliancepos']); ?>'></td></tr>
<tr><td>Nation Info:</td><td><input type='text' name='info' value='<?php echo stripslashes($nationfetch['info']); ?>'></td></tr>
<tr><td>Leader Title:</td><td><input type='text' name='title' value='<?php echo stripslashes($nationfetch['title']); ?>'></td></tr>
<tr><td>Government:</td><td><input type='text' name='gov' value='<?php echo stripslashes($nationfetch['government']); ?>'></td></tr>
<tr><td>Religion:</td><td><input type='text' name='religion' value='<?php echo stripslashes($nationfetch['religion']); ?>'></td></tr>
<tr><td>Ethnicity:</td><td><input type='text' name='race' value='<?php echo stripslashes($nationfetch['race']); ?>'></td></tr>
<tr><td>Money:</td><td><input type='text' name='money' value='<?php echo stripslashes($nationfetch['money']); ?>'></td></tr>
<tr><td>Research Points:</td><td><input type='text' name='rpoints' value='<?php echo stripslashes($nationfetch['rpoints']); ?>'></td></tr>
<tr><td>Peace/War:</td><td><input type='text' name='readiness' value='<?php echo stripslashes($nationfetch['readiness']); ?>'></td></tr>
<tr><td>Casualties:</td><td><input type='text' name='casualties' value='<?php echo stripslashes($nationfetch['casualties']); ?>'></td></tr>
<tr><td>Soldiers:</td><td><input type='text' name='soldiers' value='<?php echo stripslashes($nationfetch['soldiers']); ?>'></td></tr>
<tr><td>Snipers:</td><td><input type='text' name='snipers' value='<?php echo stripslashes($nationfetch['snipers']); ?>'></td></tr>
<tr><td>Paratroopers:</td><td><input type='text' name='paratrooper' value='<?php echo stripslashes($nationfetch['paratrooper']); ?>'></td></tr>
<tr><td>Nomads:</td><td><input type='text' name='nomad' value='<?php echo stripslashes($nationfetch['nomad']); ?>'></td></tr>
<tr><td>Mavericks:</td><td><input type='text' name='maverick' value='<?php echo stripslashes($nationfetch['maverick']); ?>'></td></tr>
<tr><td>Longhorns:</td><td><input type='text' name='longhorn' value='<?php echo stripslashes($nationfetch['longhorn']); ?>'></td></tr>
<tr><td>Fighter Jets:</td><td><input type='text' name='jets' value='<?php echo stripslashes($nationfetch['fighterjets']); ?>'></td></tr>
<tr><td>Interceptors:</td><td><input type='text' name='interceptor' value='<?php echo stripslashes($nationfetch['interceptor']); ?>'></td></tr>
<tr><td>Bombers:</td><td><input type='text' name='bomber' value='<?php echo stripslashes($nationfetch['bomber']); ?>'></td></tr>
<tr><td>SAM Turrets:</td><td><input type='text' name='sam' value='<?php echo stripslashes($nationfetch['sam']); ?>'></td></tr>
<tr><td>Battleships:</td><td><input type='text' name='battleships' value='<?php echo stripslashes($nationfetch['battleships']); ?>'></td></tr>
<tr><td>Destroyers:</td><td><input type='text' name='destroyers' value='<?php echo stripslashes($nationfetch['destroyers']); ?>'></td></tr>
<tr><td>Submarines:</td><td><input type='text' name='submarines' value='<?php echo stripslashes($nationfetch['subs']); ?>'></td></tr>
<tr><td>Carriers:</td><td><input type='text' name='carriers' value='<?php echo stripslashes($nationfetch['carriers']); ?>'></td></tr>
<tr><td>Ballistic Missiles:</td><td><input type='text' name='bmissiles' value='<?php echo stripslashes($nationfetch['bmissiles']); ?>'></td></tr>
<tr><td>Advanced Structural Engineering:</td><td><input type='text' name='ase' value='<?php echo stripslashes($nationfetch['ase']); ?>'></td></tr>
<tr><td>Atomic Theory:</td><td><input type='text' name='atomic' value='<?php echo stripslashes($nationfetch['atomic']); ?>'></td></tr>
<tr><td>Advanced Hand-to-Hand Combat Training:</td><td><input type='text' name='combat' value='<?php echo stripslashes($nationfetch['combat']); ?>'></td></tr>
<tr><td>Ecology:</td><td><input type='text' name='eco' value='<?php echo stripslashes($nationfetch['eco']); ?>'></td></tr>
<tr><td>Hydroponics:</td><td><input type='text' name='hydrop' value='<?php echo stripslashes($nationfetch['hydrop']); ?>'></td></tr>
<tr><td>Nuclear Fission:</td><td><input type='text' name='fission' value='<?php echo stripslashes($nationfetch['fission']); ?>'></td></tr>
<tr><td>Phyiscs:</td><td><input type='text' name='physics' value='<?php echo stripslashes($nationfetch['physics']); ?>'></td></tr>
<tr><td>Recycling:</td><td><input type='text' name='recycling' value='<?php echo stripslashes($nationfetch['recycling']); ?>'></td></tr>
<tr><td>Rocketry:</td><td><input type='text' name='rocketry' value='<?php echo stripslashes($nationfetch['rocketry']); ?>'></td></tr>
<tr><td>Satellites:</td><td><input type='text' name='sattelites' value='<?php echo stripslashes($nationfetch['satellites']); ?>'></td></tr>
<tr><td>Aerodynamics:</td><td><input type='text' name='aero' value='<?php echo stripslashes($nationfetch['aero']); ?>'></td></tr>
<tr><td>Radar:</td><td><input type='text' name='radar' value='<?php echo stripslashes($nationfetch['radar']); ?>'></td></tr>
<tr><td>Sonar:</td><td><input type='text' name='sonar' value='<?php echo stripslashes($nationfetch['sonar']); ?>'></td></tr>
<tr><td>Forensics:</td><td><input type='text' name='forensics' value='<?php echo stripslashes($nationfetch['forensics']); ?>'></td></tr>
<tr><td>Renewable Energy:</td><td><input type='text' name='renew' value='<?php echo stripslashes($nationfetch['renewenergy']); ?>'></td></tr>
<tr><td>Networking:</td><td><input type='text' name='networking' value='<?php echo stripslashes($nationfetch['networking']); ?>'></td></tr>
<tr><td>Internet:</td><td><input type='text' name='internet' value='<?php echo stripslashes($nationfetch['internet']); ?>'></td></tr>
<tr><td>World Wide Web:</td><td><input type='text' name='www' value='<?php echo stripslashes($nationfetch['www']); ?>'></td></tr>
<tr><td>Online Banking:</td><td><input type='text' name='obank' value='<?php echo stripslashes($nationfetch['obank']); ?>'></td></tr>
<tr><td>Rubber:</td><td><input type='text' name='rubber' value='<?php echo stripslashes($nationfetch['rubber']); ?>'></td></tr>
<tr><td>Coal:</td><td><input type='text' name='coal' value='<?php echo stripslashes($nationfetch['coal']); ?>'></td></tr>
<tr><td>Cod:</td><td><input type='text' name='cod' value='<?php echo stripslashes($nationfetch['cod']); ?>'></td></tr>
<tr><td>Corn:</td><td><input type='text' name='corn' value='<?php echo stripslashes($nationfetch['corn']); ?>'></td></tr>
<tr><td>Timber:</td><td><input type='text' name='timber' value='<?php echo stripslashes($nationfetch['timber']); ?>'></td></tr>
<tr><td>Copper:</td><td><input type='text' name='copper' value='<?php echo stripslashes($nationfetch['copper']); ?>'></td></tr>
<tr><td>Iron:</td><td><input type='text' name='iron' value='<?php echo stripslashes($nationfetch['iron']); ?>'></td></tr>
<tr><td>Crude Oil:</td><td><input type='text' name='oil' value='<?php echo stripslashes($nationfetch['oil']); ?>'></td></tr>
<tr><td>Chickens:</td><td><input type='text' name='chickens' value='<?php echo stripslashes($nationfetch['chickens']); ?>'></td></tr>
<tr><td>Fresh Water:</td><td><input type='text' name='water' value='<?php echo stripslashes($nationfetch['water']); ?>'></td></tr>
<tr><td>Composite:</td><td><input type='text' name='composite' value='<?php echo stripslashes($nationfetch['composite']); ?>'></td></tr>
<tr><td>Cotton:</td><td><input type='text' name='cotton' value='<?php echo stripslashes($nationfetch['cotton']); ?>'></td></tr>
<tr><td>Silver:</td><td><input type='text' name='silver' value='<?php echo stripslashes($nationfetch['silver']); ?>'></td></tr>
<tr><td>Gold:</td><td><input type='text' name='gold' value='<?php echo stripslashes($nationfetch['gold']); ?>'></td></tr>
<tr><td>Gems:</td><td><input type='text' name='gems' value='<?php echo stripslashes($nationfetch['gems']); ?>'></td></tr>
<tr><td>Coffee Beans:</td><td><input type='text' name='coffee' value='<?php echo stripslashes($nationfetch['coffee']); ?>'></td></tr>
</table>
<input type='hidden' name='nation' value='<?php echo $nationfetch['nation']; ?>'>
<br />
<input type='submit' name='submit' value='Update Nation'>
</center>
</form>
<?php 
} if(isset($_POST['submit']) AND $level > 2) {
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));
$email = mysql_real_escape_string(htmlentities($_POST['email']));
$alliance = mysql_real_escape_string(htmlentities($_POST['alliance']));
$alliancepos = mysql_real_escape_string(htmlentities($_POST['alliancepos']));
$info = mysql_real_escape_string(htmlentities($_POST['info']));
$title = mysql_real_escape_string(htmlentities($_POST['title']));
$gov = mysql_real_escape_string(htmlentities($_POST['gov']));
$religion = mysql_real_escape_string(htmlentities($_POST['religion']));
$race = mysql_real_escape_string(htmlentities($_POST['race']));
$money = mysql_real_escape_string(htmlentities($_POST['money']));
$rpoints = mysql_real_escape_string(htmlentities($_POST['rpoints']));
$readiness = mysql_real_escape_string(htmlentities($_POST['readiness']));
$casualties = mysql_real_escape_string(htmlentities($_POST['casualties']));
$soldiers = mysql_real_escape_string(htmlentities($_POST['soldiers']));
$snipers = mysql_real_escape_string(htmlentities($_POST['snipers']));
$paratrooper = mysql_real_escape_string(htmlentities($_POST['paratrooper']));
$nomad = mysql_real_escape_string(htmlentities($_POST['nomad']));
$maverick = mysql_real_escape_string(htmlentities($_POST['maverick']));
$longhorn = mysql_real_escape_string(htmlentities($_POST['longhorn']));
$fighterjets = mysql_real_escape_string(htmlentities($_POST['jets']));
$interceptor = mysql_real_escape_string(htmlentities($_POST['interceptor']));
$bomber = mysql_real_escape_string(htmlentities($_POST['bomber']));
$sam = mysql_real_escape_string(htmlentities($_POST['sam']));
$battleships = mysql_real_escape_string(htmlentities($_POST['battleships']));
$destroyers = mysql_real_escape_string(htmlentities($_POST['destroyers']));
$submarines = mysql_real_escape_string(htmlentities($_POST['submarines']));
$carriers = mysql_real_escape_string(htmlentities($_POST['carriers']));
$bmissiles = mysql_real_escape_string(htmlentities($_POST['bmissiles']));
$ase = mysql_real_escape_string(htmlentities($_POST['ase']));
$atomic = mysql_real_escape_string(htmlentities($_POST['atomic']));
$combat = mysql_real_escape_string(htmlentities($_POST['combat']));
$eco = mysql_real_escape_string(htmlentities($_POST['eco']));
$hydrop = mysql_real_escape_string(htmlentities($_POST['hydrop']));
$fission = mysql_real_escape_string(htmlentities($_POST['fission']));
$physics = mysql_real_escape_string(htmlentities($_POST['physics']));
$recycling = mysql_real_escape_string(htmlentities($_POST['recycling']));
$rocketry = mysql_real_escape_string(htmlentities($_POST['rocketry']));
$sattelites = mysql_real_escape_string(htmlentities($_POST['sattelites']));
$radar = mysql_real_escape_string(htmlentities($_POST['radar']));
$aero = mysql_real_escape_string(htmlentities($_POST['aero']));
$sonar = mysql_real_escape_string(htmlentities($_POST['sonar']));
$forensics = mysql_real_escape_string(htmlentities($_POST['forensics']));
$renewenergy = mysql_real_escape_string(htmlentities($_POST['renew']));
$networking = mysql_real_escape_string(htmlentities($_POST['networking']));
$internet = mysql_real_escape_string(htmlentities($_POST['internet']));
$www = mysql_real_escape_string(htmlentities($_POST['www']));
$obank = mysql_real_escape_string(htmlentities($_POST['obank']));
$rubber = mysql_real_escape_string(htmlentities($_POST['rubber']));
$coal = mysql_real_escape_string(htmlentities($_POST['coal']));
$cod = mysql_real_escape_string(htmlentities($_POST['cod']));
$corn = mysql_real_escape_string(htmlentities($_POST['corn']));
$timber = mysql_real_escape_string(htmlentities($_POST['timber']));
$copper = mysql_real_escape_string(htmlentities($_POST['copper']));
$iron = mysql_real_escape_string(htmlentities($_POST['iron']));
$oil = mysql_real_escape_string(htmlentities($_POST['oil']));
$chickens = mysql_real_escape_string(htmlentities($_POST['chickens']));
$water = mysql_real_escape_string(htmlentities($_POST['water']));
$composite = mysql_real_escape_string(htmlentities($_POST['composite']));
$cotton = mysql_real_escape_string(htmlentities($_POST['cotton']));
$silver = mysql_real_escape_string(htmlentities($_POST['silver']));
$gold = mysql_real_escape_string(htmlentities($_POST['gold']));
$gems = mysql_real_escape_string(htmlentities($_POST['gems']));
$coffee = mysql_real_escape_string(htmlentities($_POST['coffee']));
$date = $nationfetch['join_date'];
if($alliance != $nationfetch['alliance']) {
$date = date("c");
} 

mysql_query("UPDATE players SET email='$email', alliance='$alliance', alliancepos='$alliancepos', join_date='$date', info='$info', title='$title', government='$gov', religion='$religion', race='$race', money='$money', rpoints='$rpoints', readiness='$readiness', casualties='$casualties', soldiers='$soldiers', snipers='$snipers', paratrooper='$paratrooper', nomad='$nomad', maverick='$maverick', longhorn='$longhorn', fighterjets='$fighterjets', interceptor='$interceptor', sam='$sam', bomber='$bomber', battleships='$battleships', destroyers='$destroyers', subs='$submarines', carriers='$carriers', bmissiles='$bmissiles', ase='$ase', atomic='$atomic', combat='$combat', eco='$eco', hydrop='$hydrop', fission='$fission', physics='$physics', recycling='$recycling', rocketry='$rocketry', satellites='$sattelites', aero='$aero', radar='$radar', sonar='$sonar', forensics='$forensics', renewenergy='$renewenergy', networking='$networking', www='$www', obank='$obank', rubber='$rubber', coal='$coal', cod='$cod', cotton='$cotton', corn='$corn', timber='$timber', composite='$composite', water='$water', oil='$oil', chickens='$chickens', copper='$copper', iron='$iron', silver='$silver', gold='$gold', gems='$gems', coffee='$coffee' WHERE nation='$nation'");
mysql_error();
echo "Nation updated.<br />";
}
?>
