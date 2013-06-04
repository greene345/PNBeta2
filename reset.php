<div id="title">Reset Nation</div>
<?php
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];

if($level < 2) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta">';
die();
}

if(!isset($_POST['sent'])) {
$pre = mysql_real_escape_string(htmlentities($_GET['pre']));
echo "<form action='index.php?id=60' method='post'>Nation Name: <input type='text' name='nation' value='".$pre."'> <input type='submit' name='sent' value='Go'><br /></form>";
} if(isset($_POST['sent'])) {
$nation = mysql_real_escape_string(htmlentities($_POST['nation']));

if($level < 2) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta">';
die();
}

if($level > 1) {
$resetCheck = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$resetFetch = mysql_fetch_array($resetCheck);
$resetNum = mysql_num_rows($resetCheck);
$username = $resetFetch['username'];
$nation = $resetFetch['nation'];

if($resetNum == 1) {
$bodymsg = "Hello. I am sorry to inform you that your nation has been reset, either upon request or because you were exploiting the game to get an unfair advantage over other players.";
$date = date("c");

mysql_query("DELETE FROM cities WHERE nation='$nation' AND capital='0'");
mysql_query("UPDATE cities SET land='10000', population='1425100', residential='75', commercial='75', industrial='75', military='75', crime='0.3', unemployment='4.8', pollution='11228', literacy='80', happiness='91.9', police='0', prison='0', landfill='0', subway='0', sanitation='0', zoo='0', hospital='0', stadium='0', library='0', university='0', researchlab='0' WHERE capital='1' AND nation='$nation'");
mysql_query("UPDATE players SET money='1500000', casualties='0', soldiers='250', snipers='0', paratrooper='0', nomad='0', maverick='0', longhorn='0', interceptor='0', sam='0', bomber='0', destroyers='0', subs='0', carriers='0', battleships='0', fighterjets='0', bmissiles='0', power='1.45', rpoints='0', skyscraper='0', guni='0', mhq='0', capb='0', gshrine='0', olympic='0', arcology='0', gobs='0', se='0', coinm='0', narmory='0', wtc='0', obank='0', sexch='0', misctrl='0', nwds='0', wtf='0', ss='0', ase='0', atomic='0', combat='0', eco='0', hydrop='0', fission='0', physics='0', recycling='0', rocketry='0', satellites='0', aero='0', radar='0', sonar='0', forensics='0', renewenergy='0', networking='0', internet='0', www='0', corn='0', chickens='0', cotton='0', copper='0', rubber='0', coffee='0', composite='0', oil='0', water='0', iron='0', timber='0', cod='0', coal='0', gold='0', silver='0' WHERE nation='$nation'");
mysql_query("DELETE FROM nukes WHERE nation='$nation'");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$username', 'Admin', 'Nation Reset', '$bodymsg', '$date', '0', '0')");
mysql_query("DELETE FROM events WHERE nation='$nation'");
mysql_query("DELETE FROM market WHERE 
echo "Nation reset.";
/*
//reset everything
mysql_query("DELETE FROM cities WHERE capital='0'");
mysql_query("UPDATE cities SET land='10000', population='1428000', residential='75', commercial='75', industrial='75', military='75', crime='0', unemployment='1', pollution='11228', literacy='80', happiness='91.9' WHERE capital='1'");
mysql_query("UPDATE players SET money='200000', soldiers='250', snipers='0', paratrooper='0', nomad='0', maverick='0', longhorn='0', interceptor='0', sam='0', bomber='0', destroyers='0', subs='0', carriers='0', battleships='0', fighterjets='0', bmissiles='0', alliance='None', power='1.45', ");
mysql_query("DELETE FROM nukes");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$username', 'Admin', 'Nation Reset', '$bodymsg', '$date', '0', '0')");
mysql_query("DELETE FROM events");
mysql_query("DELETE FROM market");
echo "Nation reset.";
*/
} else {
echo "Nation did not exist.";
}
}
}
?>
