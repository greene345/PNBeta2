<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
?>
<div id="title">Alliance Wars</div>
<table class='black'>
<tr class='black'><th class='thickblack'>Attacker</th><th class='thickblack'>Defender</th><th class='thickblack'>Date Started</th></tr>
<?php
$alliance = mysql_real_escape_string(htmlentities($_GET['alliance']));
$query = mysql_query("SELECT * FROM wars WHERE defalliance='$alliance' OR offalliance='$alliance'");
$qrows = mysql_num_rows($query);
while($qrow = mysql_fetch_array($query)) {
$nids = mysql_query("SELECT id FROM players WHERE username='$qrow[attacker]'");
$nidf = mysql_fetch_array($nids);
$nid = $nidf['id'];

$aids = mysql_query("SELECT id FROM alliances WHERE name='$qrow[offalliance]'");
$aidf = mysql_fetch_array($aids);
$aid = $aidf['id'];

$dnids = mysql_query("SELECT id FROM players WHERE username='$qrow[defender]'");
$dnidf = mysql_fetch_array($dnids);
$dnid = $dnidf['id'];

$daids = mysql_query("SELECT id FROM alliances WHERE name='$qrow[defalliance]'");
$daidf = mysql_fetch_array($daids);
$daid = $daidf['id'];

echo "<tr class='black'><td id='black' class='center'><a href='index.php?id=7&nid=".$nid."'>".$qrow['attacker']."</a><br /><a href='index.php?id=16&nid=".$aid."'>".$qrow['offalliance']."</a></td><td class='center' id='black'><a href='index.php?id=7&nid=".$dnid."'>".$qrow['defender']."</a><br /><a href='index.php?id=16&nid=".$daid."'>".$qrow['defalliance']."</td><td class='center' id='black'>".date("m/d/y",strtotime($qrow['start_date']))."</td></tr>";
}
if($qrows == 0) {
echo "<tr class='black'><td id='black' class='center' colspan='3'>No Wars to Show</td></tr>";
}
echo "</table>";

?>