<div id="title">My Wars</div>
<img src="images/mywars.jpg" class="center"><br />
Here you will see all of your wars and be able to launch attacks against other nations. Note, wars automatically expire after 5 days. If you wish to end a war, you can visit your opponent's nation and click the "Offer Peace" link.<br /><br />
<?php
require("loggedin.php");
$id = $_SESSION['id'];
$userS = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userS);
$username = $userF['username'];

//check for wars
$warS = mysql_query("SELECT * FROM wars WHERE attacker='$username' OR defender='$username'");
$warN = mysql_num_rows($warS);

echo "<table id='black'><tr id='black'><td id='black' class='center'><b>Attacker</b></td><td id='black' class='center'><b>Defender</b></td><td id='black' class='center'><b>Date Started</b></td><td id='black' class='center'><b>Ground Attack</b></td><td id='black' class='center'><b>Aerial Attack</b></td><td id='black' class='center'><b>Naval Attack</b></td><td id='black' class='center'><b>Ballistic Missile</b></td><td id='black' class='center'><b>Nuclear Attack</b></td></tr>";
if($warN != 0) {
while($wRow = mysql_fetch_array($warS)) {

$defS = mysql_query("SELECT * FROM players WHERE username='$wRow[defender]'");
$defF = mysql_fetch_array($defS);
$defID = $defF['id'];

$attS = mysql_query("SELECT * FROM players WHERE username='$wRow[attacker]'");
$attF = mysql_fetch_array($attS);
$attID = $attF['id'];

if($wRow['lastbm'] != $username) {
$bmattack = "Launch Missile";
} if($wRow['lastbm'] == $username) {
$bmattack = "</a>Opponent's Turn";
}

if($wRow['lastnuke'] != $username) {
$nukeattack = "Launch Warhead";
} if($wRow['lastnuke'] == $username) {
$nukeattack = "</a>Opponent's Turn";
}

if($wRow['lastground'] != $username) {
$groundattack = "Launch Attack";
} if($wRow['lastground'] == $username) {
$groundattack = "</a>Opponent's Turn";
}

if($wRow['lastsea'] != $username) {
$seaattack = "Launch Attack";
} if($wRow['lastsea'] == $username) {
$seaattack = "</a>Opponent's Turn";
}


if($wRow['lastair'] != $username) {
$airattack = "Launch Attack";
} if($wRow['lastair'] == $username) {
$airattack = "</a>Opponent's Turn";
}

if($wRow['active'] == 1) {
echo "<tr id='black'><td id='black' class='center'><a href='index.php?id=7&nid=".$attID."'>".$wRow['attacker']."</a></td><td id='black' class='center'><a href='index.php?id=7&nid=".$defID."'>".$wRow['defender']."</a></td><td id='black' class='center'>".date('m/d/y',strtotime($wRow['start_date']))."</td><td id='black'><a href='index.php?id=34&wid=".$wRow['id']."'>".$groundattack."</a></td><td id='black'><a href='index.php?id=36&wid=".$wRow['id']."'>".$airattack."</a></td><td id='black'><a href='index.php?id=35&wid=".$wRow['id']."'>".$seaattack."</a></td><td id='black'><a href='index.php?id=40&wid=".$wRow['id']."'>".$bmattack."</a></td><td id='black'><a href='index.php?id=37&wid=".$wRow['id']."'>".$nukeattack."</a></td></tr>";
} if($wRow['active'] == 0) {
echo "<tr id='black'><td id='black' class='center'><a href='index.php?id=7&nid=".$attID."'>".$wRow['attacker']."</a></td><td id='black' class='center'><a href='index.php?id=7&nid=".$defID."'>".$wRow['defender']."</a></td><td id='black' colspan='6' class='center'>War Expired</td></tr>";
}
}
} else {
echo "<tr id='black'><td id='black' colspan='8' class='center'>You are not currently involved in any wars.</td></tr>";
}
echo "</table>";