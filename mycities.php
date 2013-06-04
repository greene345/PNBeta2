<div id="title">My Cities</div>
<?php 
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
?>
<table id="black">
<tr id="black"><td id="black" class="center"><b>City Name</b></td><td id="black" class="center"><b>Rank</b></td><td id="black" class="center"><b>Land Area</b></td><td id="black" class="center"><b>Population</b></td><td id="black" class="center"><b>Pop. Density</b></td><td id="black" class="center"><b>Happiness</b></td><th id="black" class="center">Resource</th></tr>
<?php
$userCheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userCheck);
$userFetch = mysql_fetch_array($userCheck);
$nation = $userF['nation'];
$capital = $userF['capital'];
$capCheck = mysql_query("SELECT * FROM `cities` WHERE nation='$nation' AND capital='1'");
$capFetch = mysql_fetch_array($capCheck);
$happiness = $capFetch['happiness'];
if($userFetch['tax'] > 9) {
$happiness = $happiness-6;
} if($userFetch['tax'] > 13) {
$happiness = $happiness-7;
} if($userFetch['tax'] > 17) {
$happiness = $happiness-8;
} if($userFetch['tax'] > 19) {
$happiness = $happiness-9;
}
if($userF['skyscraper'] == 1) {
$happiness = $happiness+0.25;
} if($gshrine == 1) {
$happiness = $happiness+0.75;
} if($userF['olympic'] == 1) {
$happiness = $happiness+0.5;
} if($userF['ss'] == 1) {
$happiness = $happiness+0.1;
} if($userF['se'] == 1) {
$happiness = $happiness+0.25;
}
if($happiness > 100) {
$happiness = 100;
} if($happiness < 0) {
$happiness = 0;
}
?>
<tr id="black"><td id="black"><a href="index.php?id=8&cid=<?php echo $capFetch['id']; ?>"><?php echo stripslashes($userF['capital']); ?></a></td><td id="black">Capital</td><td id="black" class="right"><?php echo number_format($capFetch['land'],2); ?> sq. km</td><td id="black" class="right"><?php echo number_format($capFetch['population']); ?></td><td id="black" class="right"><?php echo number_format($capFetch['population']/$capFetch['land']); ?></td><td id="black" class="right"><?php echo number_format($happiness,1); ?>%</td><td id='black' class='center'><a href='http://pn.referata.com/wiki/Resources#<?php echo $capFetch['resource']; ?>'><?php echo $capFetch['resource']; ?></a></td></tr>
<?php
$cityCheck = mysql_query("SELECT * FROM `cities` WHERE nation='$nation' AND capital='0' ORDER BY population DESC");
$cityNum = mysql_num_rows($cityCheck)+1;
while($cCheck = mysql_fetch_array($cityCheck)) {
$happiness = $cCheck['happiness'];
if($userFetch['tax'] > 9) {
$happiness = $happiness-6;
} if($userFetch['tax'] > 13) {
$happiness = $happiness-7;
} if($userFetch['tax'] > 17) {
$happiness = $happiness-8;
} if($userFetch['tax'] > 19) {
$happiness = $happiness-9;
}
if($userF['skyscraper'] == 1) {
$happiness = $happiness+0.25;
} if($userF['gshrine'] == 1) {
$happiness = $happiness+0.75;
} if($userF['olympic'] == 1) {
$happiness = $happiness+0.5;
} if($userF['ss'] == 1) {
$happiness = $happiness+0.1;
} if($userF['se'] == 1) {
$happiness = $happiness+0.25;
}
if($happiness > 100) {
$happiness = 100;
} if($happiness < 0) {
$happiness = 0;
}
echo "<tr id='black'><td id='black'><a href='index.php?id=8&cid=" .$cCheck['id']. "'>";
echo $cCheck['name'];
echo "</a></td><td id='black'>";
echo $cCheck['rank'];
echo "</td><td id='black' class='right'>";
echo number_format($cCheck['land'],2); 
echo " sq. km</td><td id='black' class='right'>";
echo number_format($cCheck['population']); 
echo "</td><td id='black' class='right'>".number_format($cCheck['population']/$cCheck['land'])."</td><td id='black' class='right'>".number_format($happiness,1)."%</td><td id='black' class='center'><a href='http://pn.referata.com/wiki/Resources#".$cCheck['resource']."'>".$cCheck['resource']."</a></td></tr>";
}
?>
</table><br />
<center>Showing All <?php echo $cityNum; ?> Cities<br /><a href='index.php?id=12'>Found New City</a></center>