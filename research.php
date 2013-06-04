<div id="title">Research</div>
<?php
require("loggedin.php");

if(!isset($_GET['rid'])) {
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$rCheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$rFetch = mysql_fetch_array($rCheck);
$points = $rFetch['rpoints'];

if($rFetch['combat'] == 1) {
$h2h = "Researched";
} if($rFetch['ase'] == 1) {
$ase = "Researched";
} if($rFetch['aero'] == 1) {
$aero = "Researched";
} if($rFetch['atomic'] == 1) {
$atomic = "Researched";
} if($rFetch['eco'] == 1) {
$eco = "Researched";
} if($rFetch['forensics'] == 1) {
$forensics = "Researched";
} if($rFetch['hydrop'] == 1) {
$hydrop = "Researched";
} if($rFetch['internet'] == 1) {
$internet = "Researched";
} if($rFetch['networking'] == 1) {
$networking = "Researched";
} if($rFetch['fission'] == 1) {
$fission = "Researched";
} if($rFetch['physics'] == 1) {
$physics = "Researched";
} if($rFetch['radar'] == 1) {
$radar = "Researched";
} if($rFetch['recycling'] == 1) {
$recycling = "Researched";
} if($rFetch['renewenergy'] == 1) {
$renewenergy = "Researched";
} if($rFetch['rocketry'] == 1) {
$rocketry = "Researched";
} if($rFetch['satellites'] == 1) {
$sat = "Researched";
} if($rFetch['sonar'] == 1) {
$sonar = "Researched";
} if($rFetch['www'] == 1) {
$www = "Researched";
} if($rFetch['obank'] == 1) {
$obank = "Researched";
}

echo "<p style='text-align:center;'><b>Research Points Available:</b> ".number_format($points)."</p>";
//display links
echo "<center><table width='100%'><tr><td class='center' width='30%'><b>Research Item</b></td><td class='center' width='20%'><b>Requirements</b></td><td class='center' width='20%'><b>Cost</b></td><td class='center' width='10%'><b>Status</b></td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=0'>Advanced Hand-to-Hand Combat Training</a></td><td>None</td><td>2,000 Research Points</td><td>".$h2h."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=1'>Advanced Structural Engineering</a></td><td>None</td><td>1,000 Research Points</td><td>".$ase."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=10'>Aerodynamics</a></td><td>Physics</td><td>2,000 Research Points</td><td>".$aero."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=2'>Atomic Theory</a></td><td>Physics</td><td>6,000 Research Points</td><td>".$atomic."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=3'>Ecology</a></td><td>Recycling</td><td>2,500 Research Points</td><td>".$eco."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=13'>Forensics</a></td><td>None</td><td>2,500 Research points</td><td>".$forensics."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=4'>Hydroponics</a></td><td>Ecology</td><td>3,500 Research Points</td><td>".$hydrop."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=11'>Internet</a></td><td>Networking</td><td>7,500 Research points</td><td>".$internet."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=12'>Networking</a></td><td>None</td><td>4,000 Research points</td><td>".$networking."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=18'>Online Banking</a></td><td>Internet</td><td>14,000 Research points</td><td>".$obank."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=5'>Nuclear Fission</a></td><td>Atomic Theory, Rocketry</td><td>10,000 Research Points</td><td>".$fission."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=6'>Physics</a></td><td>None</td><td>1,500 Research Points</td><td>".$physics."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=17'>RADAR</a></td><td>Physics</td><td>5,000 Research points</td><td>".$radar."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=7'>Recycling</a></td><td>None</td><td>1,000 Research Points</td><td>".$recycling."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=15'>Renewable Energy</a></td><td>Ecology</td><td>6,000 Research points</td><td>".$renewenergy."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=8'>Rocketry</a></td><td>Aerodynamics, RADAR</td><td>4,500 Research Points</td><td>".$rocketry."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=9'>Satellites</a></td><td>Rocketry</td><td>6,500 Research points</td><td>".$sat."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=16'>SONAR</a></td><td>Radar</td><td>5,000 Research points</td><td>".$sonar."</td></tr>";
echo "<tr><td><a href='index.php?id=82&rid=14'>World Wide Web</a></td><td>Internet</td><td>9,000 Research points</td><td>".$www."</td></tr>";
echo "</table></center>";
}

if(isset($_GET['rid'])) {
$rp[0] = "research/combat.php";
$rp[1] = "research/ase.php";
$rp[2] = "research/atomic.php";
$rp[3] = "research/ecology.php";
$rp[4] = "research/hydrop.php";
$rp[5] = "research/fission.php";
$rp[6] = "research/physics.php";
$rp[7] = "research/recycling.php";
$rp[8] = "research/rocketry.php";
$rp[9] = "research/satellites.php";
$rp[10] = "research/aerodynamics.php";
$rp[11] = "research/internet.php";
$rp[12] = "research/networking.php";
$rp[13] = "research/forensics.php";
$rp[14] = "research/www.php";
$rp[15] = "research/renewenergy.php";
$rp[16] = "research/sonar.php";
$rp[17] = "research/radar.php";
$rp[18] = "research/obank.php";

$rinclude = $rp[$_GET['rid']];
include($rinclude);
}