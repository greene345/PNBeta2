<?php
require("db.php");
//remove comment tags to make script useable
/*
$date = date("c");
mysql_query("DELETE FROM cities WHERE capital='0'");
mysql_query("UPDATE cities SET land='10000', population='1428000', residential='75', commercial='75', industrial='75', military='75', crime='0', unemployment='1', pollution='11228', literacy='80', happiness='91.9' WHERE capital='1'");
mysql_query("UPDATE players SET money='1500000', casualties='0', soldiers='250', snipers='0', paratrooper='0', nomad='0', maverick='0', longhorn='0', interceptor='0', sam='0', bomber='0', destroyers='0', subs='0', carriers='0', battleships='0', fighterjets='0', bmissiles='0', power='1.45', rpoints='0', alliance='None', skyscraper='0', guni='0', mhq='0', capb='0', gshrine='0', olympic='0', arcology='0', gobs='0', se='0', coinm='0', narmory='0', wtc='0', obank='0', sexch='0', misctrl='0', nwds='0', wtf='0', ss='0', ase='0', atomic='0', combat='0', eco='0', hydrop='0', fission='0', physics='0', recycling='0', rocketry='0', satellites='0', aero='0', radar='0', sonar='0', forensics='0', renewenergy='0', networking='0', internet='0', www='0', gems='0', corn='0', chickens='0', cotton='0', copper='0', rubber='0', coffee='0', composite='0', oil='0', water='0', iron='0', timber='0', cod='0', coal='0', gold='0', silver='0'");
mysql_query("DELETE FROM nukes");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$username', 'Admin', 'Nation Reset', '$bodymsg', '$date', '0', '0')");
mysql_query("DELETE FROM events");
mysql_query("DELETE FROM market");
mysql_query("DELETE FROM stats");
mysql_query("DELETE FROM bank");
mysql_query("DELETE FROM wars");
mysql_query("DELETE FROM alliances");
echo "Full game reset complete.<br />";
$row = mysql_query("SELECT username FROM players");
$bodymsg = mysql_real_escape_string("Hi there! I'm in the process of purchasing Pixel Nations from it's current owner, and as part of the transition we are doing a full game reset. I just wanted to make everyone aware of what is going on. Thanks!");
while($rrow = mysql_fetch_array($row)) {
$username = $rrow['username'];
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$username', 'Anson', 'Full Game Reset', '$bodymsg', '$date', '0', '0')");
}
echo "Messages sent.<br />";
echo "Full game reset, complete.<br />";
*/

?>