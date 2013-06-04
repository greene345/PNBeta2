<div id="title">Nation View</div>
<?php
$gid = mysql_real_escape_string(htmlentities(trim($_GET['nid'])));
if($gid == null) {
$id = $_SESSION['id'];
} else {
if(is_numeric($gid)) {
$gidCheck = mysql_query("SELECT * FROM players WHERE id='$gid'");
$gidNum = mysql_num_rows($gidCheck);
if($gidNum == 1) {
$id = $gid;
} else {
$id =$_SESSION['id'];
}
} else {
$id = $_SESSION['id'];
}
}
$userCheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userCheck);
$nation = $userF['nation'];

if($userF['speech'] == "yes") {
$speech = "They enjoy freedom of speech, along with other fundamental rights. ";
} else {
$speech = "They have restricted freedoms, and can be imprisoned for speaking out against the government. ";
}

$tax = "tolerable";
if($userF['tax'] > 14) {
$tax = "high";
} if($userF['tax'] > 18) {
$tax = "extremely high";
} if($userF['tax'] < 10) {
$tax = "moderately low";
}

if($userF['sat'] == 1) {
$sat = "very";
} else {
$sat = "hardly";
}


//get nation rank
function getUserRank($power){
$sql1 = "SET @rownum := 0";
$sql2 = "SELECT rank, power FROM (
                    SELECT @rownum := @rownum + 1 AS rank, power, id
                    FROM `players` ORDER BY power DESC
                    ) as result WHERE power='$power'";

        mysql_query($sql1); /*as mysql_query function can execute one query at a time */
        $result = mysql_query($sql2);
        $rows = '';
        $data = array();
        if (!empty($result))
            $rows      =  mysql_num_rows($result);
        else
            $rows      =  '';
 
        if (!empty($rows)){
            while ($rows = mysql_fetch_assoc($result)){
                $data[]   = $rows;
            }
        }
 
        //rank of the user
        if (empty($data[0]['rank']))
            return 1;
        return $data[0]['rank'];
}
$rank = getUserRank($userF['power']);

$popCheck = mysql_query("SELECT * FROM cities WHERE nation='$userF[nation]'");
$popNum = mysql_num_rows($popCheck);
while($cCheck = mysql_fetch_array($popCheck)) {
$population = $population+$cCheck['population'];
$land = $land+$cCheck['land'];
$happiness = $happiness+($cCheck['population']*$cCheck['happiness']);
$unemployment = $unemployment+($cCheck['population']*$cCheck['unemployment']);
$literacy = $literacy+($cCheck['population']*$cCheck['literacy']);
$crime = $crime+($cCheck['population']*$cCheck['crime']);
$pollution = $pollution+$cCheck['pollution'];
}
if($popNum < 1) {
$popNum = 1;
}
$happiness=$happiness/($population+1);
$unemployment=$unemployment/($population+1);
$literacy=$literacy/($population+1);
$crime=$crime/($population+1);
$cities = $popNum;
//events 
include("event.php");

if($userF['cod'] >= $cities) {
$population = $population*1.001;
} if($userF['corn'] >= $cities) {
$population = $population*1.002;
}

//gems and coffee
if($userF['gems'] >= $cities) {
$happiness = $happiness+1;
} if($userF['coffee'] >= $cities) {
$happiness = $happiness+1;
}

//oil pollution
if($userF['oil'] >= $cities) {
$pollution = $pollution*1.01;
}

//fresh water
if($userF['water'] >= $cities) {
$pollution = $pollution*.99;
$population = $population*1.001;
}

//atomic theory
if($userF['atomic'] == 1) {
$literacy = $literacy+1;
$happiness = $happiness+1;
}

//forensics
if($userF['forensics'] == 1) {
$crime = $crime*.95;
}
//world wide web
if($userF['www'] == 1) {
$happiness = $happiness+.5;
}

//pollution
if($userF['nwds'] == 1) {
$pollution = $pollution*.9;
} if($userF['renewenergy'] == 1) {
$pollution = $pollution*0.85;
}

//hydroponics
if($userF['hydrop'] == 1) {
$pollution = $pollution*.9;
}

//nuclear chaos
$nukehit = $userF['nukehit'];
$diff10 = abs(strtotime($nukehit) - strtotime(date(c)));
$hours10 = round($diff10/60/60/24);
if($hours10 < 3) {
$happiness = round($happiness-30,1);
}

//nation age
$agediff = abs(strtotime($userF['date_reg']) - strtotime(date(c)));
$nationage = round($agediff/60/60/24);

//nation age
if($nationage < 8) {
$happiness = $happiness+10;
$nationnews .= "<span id='green'>Your nation is brand new! The people are celebrating your nation's existence, which has resulted in a +10 happiness bonus!</span><br />";
}

$nation = $userF['nation'];
$capital = $userF['capital'];
$capCheck = mysql_query("SELECT * FROM cities WHERE nation='$nation' AND capital='1'");
$capFetch = mysql_fetch_array($capCheck);
$showmoney = "$".number_format($userF['money'])." ";

$size = "tiny";
if($population >= "10000000") {
$size = "small";
} if($population >= "30000000") {
$size = "medium sized";
} if($population >= "80000000") {
$size = "large";
} if($population >= "300000000") {
$size = "massive";
} if($population >= "1000000000") {
$size = "humongous";
} if($population >= "2500000000") {
$size = "monstrous";
}

$race = ucfirst($userF['race']);
if($race == "Mixed") {
$race = "Mixed Ethnicites";
}

//military
$soldiers = $userF['soldiers']+$userF['snipers']+$userF['paratrooper'];
$aircraft = $userF['fighterjets']+$userF['bomber']+$userF['interceptor'];
$missiles = $userF['bmissiles'];
$vehicles = $userF['nomad']+$userF['longhorn']+$userF['maverick'];
$navy = $userF['battleships']+$userF['subs']+$userF['carriers']+$userF['destroyers'];
$casualties = $userF['casualties'];

//high soldier check
$soldierratio = $soldiers/$population;
if($soldierratio > .05) {
$nationnews .= "<span id='red'>Your nation has a very large amount of soldiers in comparison to population. This is affecting your national happiness by -10%.</span><br />";
$happiness = $happiness-10;
}

//nukes
$nukeC = mysql_query("SELECT * FROM nukes WHERE nation='$userF[nation]'");
$nukes = mysql_num_rows($nukeC);

//alliance check
$allC = mysql_query("SELECT * FROM alliances WHERE name='$userF[alliance]'");
$allF = mysql_fetch_array($allC);

//marvels
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
} if($userF['guni'] == 1) {
$happiness = $happiness+1.5;
}
if($happiness > 100) {
$happiness = 100;
}

//taxrate
if($userF['tax'] > 10) {
$happiness = $happiness-3;
} if($userF['tax'] > 13) {
$happiness = $happiness-3;
} if($userF['tax'] > 16) {
$happiness = $happiness-3;
} if($userF['tax'] > 19) {
$happiness = $happiness-3;
}

if($happiness < 0) {
$happiness = 0;
}

//marvels affecting literacy
if($userF['guni'] == 1) {
$literacy = $literacy+1.5;
} if($userF['gobs'] == 1) {
$literacy = $literacy+.5;
}

//nation news check
if($nationnews == null) {
$nationnews = "There are currently no pressing matters in your nation.<br />";
}

$newpower = round(($population/1000000)+($soldiers/10000)+($vehicles/1000)+($navy/10)+($aircraft/10)+($missiles*.25)+($nukes*2),2);
if($userF['level'] > 0) {
$newpower = 0.5;
}
mysql_query("UPDATE players SET power='$newpower' WHERE id='$id'");

//check for stats
$newpower = round(($population/1000000)+($soldiers/10000)+($vehicles/1000)+($navy/10)+($aircraft/10)+($missiles*.25)+($nukes*2),2);
$statdate = date("Y-m-d");
$checkforstats = mysql_query("SELECT * FROM stats WHERE type='nation' AND name='$nation' AND date='$statdate'");
if(mysql_num_rows($checkforstats) == 1) {
mysql_query("UPDATE stats SET power='$newpower' WHERE type='nation' AND name='$nation' AND date='$statdate'");
} if(mysql_num_rows($checkforstats) == 0) {
mysql_query("INSERT INTO stats (date, name, type, power) VALUES ('$statdate', '$nation', 'nation', '$newpower')");
}

if($newpower >= 5) {
$refer = $userF['refer'];
$referCheck = mysql_query("SELECT * FROM players WHERE username='$refer'");
$referNum = mysql_num_rows($referCheck);
if($referNum == 1) {
$referFetch = mysql_fetch_array($referCheck);
$bonus = 2000000;
$newcash = $referFetch['money']+$bonus;
$date = date("c");
$refermsg = "Congratulations! You have received a $".number_format($bonus)." bonus because ".$userF['username']." listed you as their referral and has reached 5 power!";
mysql_query("UPDATE players SET money='$newcash' WHERE username='$refer'");
mysql_query("UPDATE players SET refer='0' WHERE username='$userF[username]'");
mysql_query("INSERT INTO `messages` (receiver, sender, subject, body, date, readmsg, reported) VALUES ('$refer', '$userF[username]', 'Referral Bonus', '$refermsg', '$date', '0', '0')");
}
}

echo "<table><tr><td class='top'><img src='images/flags/".$userF['flag']."'></td><td class='top'>";
echo "At ".$nationage." days old, the nation of " .stripslashes($userF['nation']). " is a " .$size. " country, with a population of ".number_format($population)." people. The " .stripslashes($userF['title']). ", ".stripslashes($userF['username']).", has pushed the nation forward in a 
direction favoring " .$userF['principle']. ". The majority of the people in ".stripslashes($userF['nation'])." are of ".ucwords($race)." ethnicity and practice ".stripslashes(ucwords($userF['religion'])).". ".stripslashes($userF['nation'])." has a 
".$userF['economy']." economy, and its citizens pay ".$tax." taxes. The government of ".stripslashes($userF['nation'])." is ".$sat." concerned with the happiness of its citizens. " .$speech. "<a name='fb_share'></a> 
<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share'
        type='text/javascript'>
</script></td></tr>";
if($userF['info'] != null) {
echo "<td colspan='2'><b>Additional Info:</b> ".stripslashes($userF['info'])."</td></tr>";
} if($id == $_SESSION['id']) {
echo "<td colspan='2'><b>News:</b> ".$nationnews."</td></tr>";
}
echo "</table>";

$diff = abs(strtotime($userF['date_reg']) - strtotime(date(c)));
$nationage = round($diff/60/60/24);

if($id == $_SESSION['id'] AND $nationage < 2) {
echo "<br /><hr><b>Tips/Help</b><br />Welcome to Pixel Nations! This is your nation page. In a few days this help display will go away, but in the meantime take full advantage of it. You might be confused by all the links on the sidebar, so to help you out, the important stuff is detailed here.<br />
<a href='index.php?id=2'>Mailbox</a> - Here you can read messages from other players.<br />
<a href='index.php?id=27'>Policies</a> - Here you can update your nation, changing your flag, government type, religion, peace/war setting, and other options.<br />
<a href='index.php?id=8&cid=".$capFetch['id']."'>Your Capital City</a> - This is your capital city. You can add different zones and upgrades to increase your population and improve the quality of life in your nation.<br />
<a href='index.php?id=9'>Your Cities</a> - Here you can view all of your cities and create new cities if you so desire.<br />
<a href='index.php?id=24'>Budget</a> - Your budget details exactly how much money you're making and losing every hours. If your revenues exceed your debts, you can collect more money every hour.<br />
<a href='index.php?id=19'>Soldiers</a> - Here you can purchase soldiers which increase the military capabilities of your nation. Soldiers are used to defend against attacks from other nations and can be used to attack other nations.<br />
<a href='index.php?id=13'>My Alliance</a> - Here you can view your alliance, or create/join an alliance if you are not in one.<br />";

}
if($id != $_SESSION['id']) { 
$accID = mysql_real_escape_string($_SESSION['id']);
$accC = mysql_query("SELECT * FROM players WHERE id='$accID'");
$accF = mysql_fetch_array($accC);
$accName = $accF['username'];
$war1 = mysql_query("SELECT * FROM wars WHERE attacker='$userF[username]' AND defender='$accName' AND active='1'");
$war2 = mysql_query("SELECT * FROM wars WHERE defender='$userF[username]' AND attacker='$accName' AND active='1'");
if(mysql_num_rows($war1) == 1 OR mysql_num_rows($war2) == 1) {
$declarepeace = "<a href='index.php?id=42&nat=".$userF['nation']."'>Offer Peace</a>";
} else {
$declarepeace = "<a href='index.php?id=29&att=".$userF['username']."'>Declare War</a>";
}

echo "<br /><center><a href='index.php?id=5&to=".$userF['username']."'>Send Message</a> | <a href='index.php?id=61&to=".$userF['username']."'>Send Shipment</a> | ".$declarepeace." | <a href='index.php?id=28&currentpage=1&name=".$userF['username']."&type=war'>View Wars</a> | <a href='index.php?id=28&currentpage=1&name=".$userF['username']."&type=gift'>View Gifts</a></center>";
}

if($crime < 0) {
$crime = 0;
}
$sid = mysql_real_escape_string($_SESSION['id']);
$viewerC = mysql_query("SELECT * FROM players WHERE id='$sid'");
$viewerF = mysql_fetch_array($viewerC);
?>

<hr>
<table id="black">
<tr id="black"><th id="thickblack" colspan="4" class="center">Domestic</th></tr>
<tr id="black"><td id="black"><img src="images/icons/user.png"><b>Leader Name:</b></td><td id="black"><?php echo stripslashes($userF['username']); ?></td><td id="black"><img src="images/icons/population.png"><b>Population:</b></td><td id="black"><?php echo number_format($population); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/nation.png"><b>Nation Name:</b></td><td id="black"><?php echo stripslashes($userF['nation']); ?></td><td id="black"><img src="images/icons/land.png"><b>Land Area:</b></td><td id="black"><?php echo number_format($land); ?> sq. kilometers</td></tr>
<tr id="black"><td id="black"><img src="images/icons/goverment2.png"><b>Government Type:</b></td><td id="black"><?php echo stripslashes($userF['government']); ?></td><td id="black"><img src="images/icons/density.png"><b>Population Density:</b></td><td id="black"><?php echo number_format($population/$land); ?> people per sq. km</td></tr>
<tr id="black"><td id="black"><img src="images/icons/alliance.png"><b>Alliance:</b></td><td id="black"><a href="index.php?id=16&nid=<?php echo $allF['id']; ?>"><?php echo stripslashes($userF['alliance']); ?></a></td><td id="black"><img src="images/icons/pollution.png"><b>Pollution:</b></td><td id="black"><?php echo number_format($pollution); ?> tons</td></tr>
<tr id="black"><td id="black"><img src="images/icons/ethnicity.png"><b>Ethnicity:</b></td><td id="black"><?php echo stripslashes(ucwords($userF['race'])); ?></td><td id="black"><img src="images/icons/literacy.png"><b>Literacy Rate:</b></td><td id="black"><?php echo number_format($literacy,1); ?>%</td></tr>
<tr id="black"><td id="black"><img src="images/icons/religion.png"><b>Religion:</b></td><td id="black"><?php echo stripslashes(ucwords($userF['religion'])); ?></td><td id="black"><img src="images/icons/crime.png"><b>Crime Rate:</b></td><td id="black"><?php echo number_format($crime,1); ?>%</td></tr>
<tr id="black"><td id="black"><img src="images/icons/happiness.png"><b>Happiness:</b></td><td id="black"><?php echo number_format($happiness,1); ?>%</td><td id="black"><img src="images/icons/unemployment.png"><b>Unemployment Rate:</b></td><td id="black"><?php echo number_format($unemployment,1); ?>%</td></tr>
<tr id="black"><th id="thickblack" colspan="4" class="center">Military</th></tr>
<tr id="black"><td id="black"><img src="images/icons/soldiers.png"><b>Soldiers:</b></td><td id="black"><?php echo number_format($soldiers); ?></td><td id="black"><img src="images/icons/tank.png"><b>Vehicles:</b></td><td id="black"><?php echo number_format($vehicles); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/airplanes2.png"><b>Aircraft:</b></td><td id="black"><?php echo number_format($aircraft); ?></td><td id="black"><img src="images/icons/battleship.png"><b>Naval Vessels:</b></td><td id="black"><?php echo number_format($navy); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/bm.png"><b>Ballistic Missiles:</b></td><td id="black"><?php echo number_format($missiles); ?></td><td id="black"><img src="images/icons/sad.png"><b>Casualties:</b></td><td id="black"><?php echo number_format($casualties); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/nuke.png"><b>Nuclear Weapons:</b></td><td id="black"><?php echo number_format($nukes); ?></td><td id="black"><img src="images/icons/peacewar.png"><b>Peace/War Setting:</b></td><td id="black"><?php echo ucfirst($userF['readiness']); ?></td></tr>
<tr id="black"><th id="thickblack" colspan="4" class="center">Economic</th></tr>
<?php if($_SESSION['id'] == $userF['id'] OR $viewerF['level'] > 0) { ?>
<tr id="black"><td id="black"><img src="images/icons/money.png"><b>Money:</b></td><td id="black">$<?php echo number_format($userF['money']); ?></td><td id="black"><img src="images/icons/research.png"><b>Research Points:</b></td><td id="black"><?php echo number_format($userF['rpoints']); ?></td></tr>
<?php } ?>
<tr id="black"><td id="black"><img src="images/icons/coal.png" title="Reduces the cost of zones by 1%"><b>Coal:</b></td><td id="black"><?php echo number_format($userF['coal']); ?></td><td id="black"><img src="images/icons/cod.png" title="Increases population by 0.1%"><b>Cod:</b></td><td id="black"><?php echo number_format($userF['cod']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/coffee.png" title="Increases happiness by 1%"><b>Coffee Beans:</b></td><td id="black"><?php echo number_format($userF['coffee']); ?></td><td id="black"><img src="images/icons/composite.png" title="Reduces the cost of aircraft by 5%"><b>Composite:</b></td><td id="black"><?php echo number_format($userF['composite']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/corn.png" title="Increases population by 0.2%"><b>Corn:</b></td><td id="black"><?php echo number_format($userF['corn']); ?></td><td id="black"><img src="images/icons/copper.png" title="Reduces the cost of zones by 2%"><b>Copper:</b></td><td id="black"><?php echo number_format($userF['copper']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/oil.png" title="Increases pollution by 1%, decreases vehicle, aircraft, and naval upkeep by 5%"><b>Crude Oil:</b></td><td id="black"><?php echo number_format($userF['oil']); ?></td><td id="black"><img src="images/icons/chickens.png" title="Reduces cost of soldiers by 3%"><b>Chickens:</b></td><td id="black"><?php echo number_format($userF['chickens']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/gems.png" title="Increases happiness by 1%"><b>Gems:</b></td><td id="black"><?php echo number_format($userF['gems']); ?></td><td id="black"><img src="images/icons/gold.png" title="Increases average income by $0.02"><b>Gold:</b></td><td id="black"><?php echo number_format($userF['gold']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/iron.png" title="Decreases cost of naval vessels by 1%"><b>Iron:</b></td><td id="black"><?php echo number_format($userF['iron']); ?></td><td id="black"><img src="images/icons/water.png" title="Reduces pollution by 1%, increases population by 0.1%"> <b>Fresh Water:</b></td><td id="black"><?php echo number_format($userF['water']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/rubber.png" title="Reduces the cost of vehicles by 3%"><b>Rubber:</b></td><td id="black"><?php echo number_format($userF['rubber']); ?></td><td id="black"><img src="images/icons/silver.png" title="Increases average income by $0.01"><b>Silver:</b></td><td id="black"><?php echo number_format($userF['silver']); ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/timber.png" title="Reduces the cost of zones by 1%"><b>Timber:</b></td><td id="black"><?php echo number_format($userF['timber']); ?></td><td id="black"><img src="images/icons/cotton.png" title="Reduce cost of soldiers by 1%"><b>Cotton:</b></td><td id="black"><?php echo number_format($userF['cotton']); ?></td></tr>

<tr id="black"><td id="black"><img src="images/icons/star.png"><b>Nation Rank:<b></td><td id="black"> #<?php echo number_format($rank); ?></td><td id="black"><img src="images/icons/war.png"><b>Power:</b></td><td id="black"><?php echo number_format($userF['power'],2); ?></td></tr>
</table>
<hr>
<?php
if($_GET['display'] != "power" AND $_GET['display'] != "growth") {
echo "<b>Cities</b> | <a href='index.php?id=7&nid=".$id."&display=power'>Power</a> | <a href='index.php?id=7&nid=".$id."&display=growth'>Growth</a><br />";
?>
<table id="black">
<tr id="black"><td id="black" class="center"><b>City Name</b></td><td id="black" class="center"><b>Rank</b></td><td id="black" class="center"><b>Land Area</b></td><td id="black" class="center"><b>Population</b></td><td id="black" class="center"><b>Resource</b></td></tr>
<tr id="black"><td id="black"><a href='index.php?id=8&cid=<?php echo $capFetch['id']; ?>'><?php echo stripslashes($userF['capital']); ?></a></td><td id="black">Capital</td><td id="black"><?php echo number_format($capFetch['land'],2); ?> sq. km</td><td id="black"><?php echo number_format($capFetch['population']); ?></td><td id="black"><?php echo $capFetch['resource']; ?></tr>
<?php
$cityCheck = mysql_query("SELECT * FROM `cities` WHERE nation='$nation' AND capital='0' ORDER BY population DESC LIMIT 0,9");
$citynumcheck = mysql_query("SELECT name FROM `cities` WHERE nation='$nation'");
while($cCheck = mysql_fetch_array($cityCheck)) {
echo "<tr id='black'><td id='black'><a href='index.php?id=8&cid=" .$cCheck['id']. "'>";
echo $cCheck['name'];
echo "</a></td><td id='black'>";
echo $cCheck['rank'];
echo "</td><td id='black'>";
echo number_format($cCheck['land'],2); 
echo " sq. km</td><td id='black'>";
echo number_format($cCheck['population']); 
echo "</td><td id='black'>".$cCheck['resource']."</tr>";
}
?>
</table>
<?php 
echo "<p style='text-align:center;'>".number_format(mysql_num_rows($citynumcheck))." Cities</p>";
} if($_GET['display'] == "power") {
echo "<a href='index.php?id=7&nid=".$id."'>Cities</a> | <b>Power</b> | <a href='index.php?id=7&nid=".$id."&display=growth'>Growth</a><br />";
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Section', 'Amount'],
          ['Population',    <?php echo ($population/1000000); ?>],
          ['Soldiers',      <?php echo ($soldiers/10000); ?>],
          ['Vehicles',  <?php echo ($vehicles/1000); ?>],
          ['Navy', <?php echo ($navy/10); ?>],
          ['Aircraft',    <?php echo ($aircraft/10); ?>],
		  ['Ballistic Missiles', <?php echo ($missiles*0.25); ?>],
		  ['Nukes',    <?php echo ($nukes*2); ?>]
        ]);

        var options = {
          title: 'Power Breakdown'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id="chart_div" style="width: 900px; height: 500px;"></div>
<?php
} if($_GET['display'] == "growth") {
echo "<a href='index.php?id=7&nid=".$id."'>Cities</a> | <a href='index.php?id=7&nid=".$id."&display=power'>Power</a> | <b>Growth</b><br />";
//get stats
//old query $getstats = mysql_query("SELECT * FROM stats WHERE type='nation' AND name='$nation' ORDER BY date ASC LIMIT 30");
$getstats = mysql_query("select *
from (
   select *
   from `stats`
   where type='nation' AND name='$nation'
   order by `date` DESC
   limit 30
) as source
order by `id` ASC");
$statrows = mysql_num_rows($getstats);
$countrows = 0;
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['Date', 'Power'],
		<?php 
		while($rstats = mysql_fetch_array($getstats)) {
          echo "['".$rstats['date']."', ".$rstats['power']."]";
		  $countrows = $countrows+1;
		  if($countrows < $statrows) {
		  echo ",";
		  }
		  }
?>
        ]);

        var options = {
          title: '30 Day Nation Growth',
		  colors:['red','#004411']
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
	<div id="chart_div2" style="width: 900px; height: 500px;"></div>
<?php
} if($viewerF['level'] > 0) {
echo "<center><a href='index.php?id=95&nation=".$userF['nation']."'>Suspend Player</a> | <a href='index.php?id=78&preban=".$userF['nation']."'>Delete Nation</a> | <a href='index.php?id=60&pre=".$userF['nation']."'>Reset Nation</a> | <a href='index.php?id=93&nation=".$userF['nation']."'>Edit Nation</a></center>";
}
?>
