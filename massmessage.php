<?php
require("db.php");
$date = date("c");
$row = mysql_query("SELECT username FROM players");
$bodymsg = mysql_real_escape_string("Sorry about the multiple messages about the game getting reset, this will be the last one. Pixel Nations has been completely reset. All alliances must be re-created, and all nations are back to 'brand new'. I will soon be the new admin, so please take up all concerns with me. Thanks.");
while($rrow = mysql_fetch_array($row)) {
$username = $rrow['username'];
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$username', 'Anson', 'Game-Wide Reset', '$bodymsg', '$date', '0', '0')");
}
echo "Messages sent.";
?>
