<div id="title">Budget</div>
Below you can take a good look at your nations revenue and expenses. Every hour your nation will gain or lose an amount of money, and this amount will continue to rollover until you collect your revenues and pay your expenses. The amount you make will freeze after 72 hours, so make sure to collect at least once every 3 days.<br /><br />
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));

$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userA = mysql_fetch_array($userC);
$popCheck = mysql_query("SELECT * FROM cities WHERE nation='$userA[nation]'");
$popNum = mysql_num_rows($popCheck);
$nation = $userA['nation'];
while($cCheck = mysql_fetch_array($popCheck)) {
$population = $population+$cCheck['population'];
$land = $land+$cCheck['land'];
$happiness = $happiness+($cCheck['population']*$cCheck['happiness']);
$unemployment = $unemployment+($cCheck['population']*$cCheck['unemployment']);
$literacy = $literacy+($cCheck['population']*$cCheck['literacy']);
$crime = $crime+($cCheck['population']*$cCheck['crime']);
$pollution = $pollution+$cCheck['pollution'];
$residential = $residential+$cCheck['residential'];
$civic = $civic+$cCheck['military'];
$libraries = $libraries+$cCheck['researchlab'];
$universities = $universities+$cCheck['university'];
}
$cities = $popNum;
if($userA['cod'] >= $cities) {
$population = $population*1.001;
} if($userA['corn'] >= $cities) {
$population = $population*1.002;
}

$nukeC = mysql_query("SELECT * FROM nukes WHERE nation='$userA[nation]'");
$nukes = mysql_num_rows($nukeC);

$happiness=$happiness/$population;
$unemployment=$unemployment/$population;
$literacy=$literacy/$population;
$crime=$crime/$population;

//gems
if($userA['gems'] >= $cities) {
$happiness = $happiness+1;
}

//coffee
if($userA['coffee'] >= $cities) {
$happiness = $happiness+1;
}

//oil pollution
if($userA['oil'] >= $cities) {
$pollution = $pollution*1.01;
}

//fresh water
if($userA['water'] >= $cities) {
$pollution = $pollution*.99;
$population = $population*1.001;
}

// new player bonus
$diff2 = abs(strtotime($userA['date_reg']) - strtotime(date(c)));
$hours2 = round($diff2/60/60/24);
if($hours2 < 8) {
$happiness = $happiness+10;
}

$infantry = $userA['soldiers']+$userA['snipers']+$userA['paratrooper'];
$vehicles = $userA['nomad']+$userA['maverick']+$userA['longhorn'];
$aircraft = $userA['fighterjets']+$userA['interceptor']+$userA['sam']+$userA['bomber'];
$navy = $userA['battleships']+$userA['subs']+$userA['destroyers']+$userA['carriers'];

//marvels affecting happiness
if($userA['skyscraper'] == 1) {
$happiness = $happiness+0.25;
} if($userA['gshrine'] == 1) {
$happiness = $happiness+0.75;
} if($userA['olympic'] == 1) {
$happiness = $happiness+0.5;
} if($userA['ss'] == 1) {
$happiness = $happiness+0.1;
} if($userA['se'] == 1) {
$happiness = $happiness+0.25;
} if($userA['guni'] == 1) {
$happiness = $happiness+1.5;
} if($userA['gobs'] == 1) {
$happiness = $happiness+0.5;
}

//atomic theory
if($userA['atomic'] == 1) {
$happiness = $happiness+1;
}


//taxrate
if($userA['tax'] > 10) {
$happiness = $happiness-3;
} if($userA['tax'] > 13) {
$happiness = $happiness-3;
} if($userA['tax'] > 16) {
$happiness = $happiness-3;
} if($userA['tax'] > 19) {
$happiness = $happiness-3;
}

//high soldier check
$soldierratio = $infantry/$population;
if($soldierratio > .05) {
$happiness = $happiness-10;
}

//hydroponics
if($userA['hydrop'] == 1) {
$pollution = $pollution*.9;
}

//nuclear chaos
$nukehit = $userA['nukehit'];
$diff10 = abs(strtotime($nukehit) - strtotime(date(c)));
$hours10 = round($diff10/60/60/24);
if($hours10 < 3) {
$happiness = round($happiness-30,1);
} 

//forensics
if($userA['forensics'] == 1) {
$happiness = $happiness+.5;
}

//world wide web
if($userA['www'] == 1) {
$happiness = $happiness+.5;
}

//events
include("event.php");

if($happiness > 100) {
$happiness = 100;
} if($happiness < 0) {
$happiness = 0;
}

$employment = round(100-$unemployment);
$employedpop = $population*($employment/100);

$avgincome = .5+(.005*$happiness)+$avgincome;

if($userA['skyscraper'] == 1) {
$avgincome = $avgincome+.05;
} if($userA['olympic'] == 1) {
$avgincome = $avgincome+.01;
} if($userA['sexch'] == 1) {
$avgincome = $avgincome+.10;
} if($userA['coinm'] == 1) {
$avgincome = $avgincome+.05;
}

//silver and gold
if($userA['silver'] >= $cities) {
$avgincome = $avgincome+.01;
} if($userA['gold'] >= $cities) {
$avgincome = $avgincome+.02;
}

$taxrate = $userA['tax'];
$revenue = round(($avgincome*$employedpop)*($taxrate/100));

//pollution
if($userA['nwds'] == 1) {
$pollution = $pollution*.9;
} if($userA['renewenergy'] == 1) {
$pollution = $pollution*.85;
}

// debts
$infracost = round($residential*(300+($residential/500)));
$govcost = round($population*(0.0225+($population/10000000000)));
$civcost = round($civic*250);
$healthcare = round($population*(0.015+($population/10000000000)));
$environment = round($pollution*1.5);
$soldierscost = round($infantry*2);
$tankcost = round($vehicles*6);
$jetcost = round($aircraft*15);
$bshipcost = round($navy*15);
$missilecost = round($userA['bmissiles']*75000);
$nukecost = $nukes*3250000;



//internet
if($userA['internet'] == 1) {
$infracost = $infracost*.99;
}

//lead event
if($leadevent == 1) {
$tankcost = $tankcost*.98;
$jetcost = $jetcost*.98;
$bshipcost = $bshipcost*.98;
}

//oil resource
if($userA['oil'] >= $cities) {
$tankcost = $tankcost*.95;
$jetcost = $jetcost*.95;
$bshipcost = $bshipcost*.95;
}

//recycling & ecology
if($userA['recycling'] == 1) {
$environment = round($pollution*1.4);
} if($userA['eco'] == 1) {
$environment = round($pollution*1.25);
}

//military hq marvel
if($userA['mhq'] == 1) {
$soldierscost = $soldierscost-($soldierscost*0.03);
$tankcost = $tankcost-($tankcost*0.03);
$jetcost = $jetcost-($jetcost*0.03);
$bshipcost = $bshipcost-($bshipcost*0.03);
$missilecost = $missilecost-($missilecost*0.03);
$nukecost = $nukecost-($nukecost*0.03);
}



//capitol building marvel 
if($userA['capb'] == 1) {
$govcost = $govcost*0.98;
}

$totalcost = $infracost+$govcost+$civcost+$healthcare+$environment+$soldierscost+$tankcost+$jetcost+$bshipcost+$missilecost+$nukecost;

$diff = abs(strtotime($userA['lastcollect']) - strtotime(date(c)));
$hours = round(($diff/60)+1);
if($hours > 4320) {
$hours = 4320;
}
if($hours < 60) {
$error .= "You must wait at least 1 hour before you can collect.";
}
$collecthours = round(($hours/60)-.5);
$minutes = round($hours-($collecthours*60));
$nettotal = ($revenue-$totalcost)*$collecthours;

if($userA['readiness'] == "peace") {
if($userA['power'] > 100) {
$power = 100;
} else {
$power = $userA['power'];
}
$nettotal = $nettotal-($nettotal*($power/100));
}

//research points
$libpoints = $libraries*4*$collecthours;
$unipoints = $universities*3*$collecthours;
$totalpoints = $libpoints+$unipoints;
$newpoints = $totalpoints+$userA['rpoints'];

//resources
$coalC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='coal'");
$cottonC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='cotton'");
$copperC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='copper'");
$oilC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='Crude Oil'");
$ironC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='iron'");
$waterC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='Fresh Water'");
$chickensC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='chickens'");
$codC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='cod'");
$rubberC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='rubber'");
$cornC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='corn'");
$timberC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='timber'");
$goldC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='gold'");
$silverC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='silver'");
$gemsC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='gems'");
$compositeC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='composite'");
$coffeeC = mysql_query("SELECT id FROM cities WHERE nation='$nation' AND resource='Coffee Beans'");

$coal = max(((mysql_num_rows($coalC)*10*$collecthours)+$userA['coal']-($cities*$collecthours)), 0);
$cotton = max(((mysql_num_rows($cottonC)*10*$collecthours)+$userA['cotton']-($cities*$collecthours)), 0);
$copper = max(((mysql_num_rows($copperC)*10*$collecthours)+$userA['copper']-($cities*$collecthours)), 0);
$oil = max(((mysql_num_rows($oilC)*10*$collecthours)+$userA['oil']-($cities*$collecthours)), 0);
$iron = max(((mysql_num_rows($ironC)*10*$collecthours)+$userA['iron']-($cities*$collecthours)), 0);
$water = max(((mysql_num_rows($waterC)*10*$collecthours)+$userA['water']-($cities*$collecthours)), 0);
$chickens= max(((mysql_num_rows($chickensC)*10*$collecthours)+$userA['chickens']-($cities*$collecthours)), 0);
$cod= max(((mysql_num_rows($codC)*10*$collecthours)+$userA['cod']-($cities*$collecthours)), 0);
$rubber = max(((mysql_num_rows($rubberC)*10*$collecthours)+$userA['rubber']-($cities*$collecthours)), 0);
$corn = max(((mysql_num_rows($cornC)*10*$collecthours)+$userA['corn']-($cities*$collecthours)), 0);
$timber = max(((mysql_num_rows($timberC)*10*$collecthours)+$userA['timber']-($cities*$collecthours)), 0);
$gold = max(((mysql_num_rows($goldC)*10*$collecthours)+$userA['gold']-($cities*$collecthours)), 0);
$silver = max(((mysql_num_rows($silverC)*10*$collecthours)+$userA['silver']-($cities*$collecthours)), 0);
$gems = max(((mysql_num_rows($gemsC)*10*$collecthours)+$userA['gems']-($cities*$collecthours)), 0);
$composite = max(((mysql_num_rows($compositeC)*10*$collecthours)+$userA['composite']-($cities*$collecthours)), 0);
$coffee = max(((mysql_num_rows($coffeeC)*10*$collecthours)+$userA['coffee']-($cities*$collecthours)), 0);

if(isset($_POST['send'])) {
if($error == null) {
$date = date("c");

//trigger events
$eventrand = rand(1,3);
if($eventrand == 3) {
$eventrand = rand(0,22);
$eA[0] = "earthquake";
$eA[1] = "drought";
$eA[2] = "sheep";
$eA[3] = "tsunami";
$eA[4] = "tornado";
$eA[5] = "housing";
$eA[6] = "wildfire";
$eA[7] = "reserve";
$eA[8] = "spill";
$eA[9] = "lead";
$eA[10] = "food";
$eA[11] = "criminal";
$eA[12] = "manufacturing";
$eA[13] = "sporting";
$eA[14] = "celebrity";
$eA[15] = "hitsong";
$eA[16] = "nobel";
$eA[17] = "reading";
$eA[18] = "druguse";
$eA[19] = "influenza";
$eA[20] = "antibiotic";
$eA[21] = "river";
$eA[22] = "cold";
$eventcheck = mysql_query("SELECT * FROM events WHERE nation='$nation'");
$eventnum = mysql_num_rows($eventcheck);
if($eventnum < 3) {
$name = $eA[$eventrand];
mysql_query("INSERT INTO events (name, date, nation) VALUES ('$name', '$date', '$nation')");
}
}



$token = mysql_real_escape_string(htmlentities($_POST['token']));
if($token == $_SESSION['token']) {
$balance = $nettotal+$userA['money'];
if($balance > 0) {

mysql_query("UPDATE players SET lastcollect='$date', money='$balance', rpoints='$newpoints', coal='$coal', gems='$gems', oil='$oil', coffee='$coffee', composite='$composite', silver='$silver', rubber='$rubber', cod='$cod', corn='$corn', timber='$timber', copper='$copper', iron='$iron', chickens='$chickens', water='$water', gold='$gold', cotton='$cotton' WHERE id='$id'");
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=24">';
} else {
echo "Error: You cannot collect your net total because it puts you in debt. Descrease your expenses and try again.<br /><br />";
}
}
} else {
echo "<br />";
echo $error;
}
} else {


$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
?>
<form action="index.php?id=24" method="post">

<b>New Resource Totals</b>
<table id="black">
<tr id="black"><td id="black"><img src="images/icons/coal.png" title="Reduces the cost of zones by 1%"><b>Coal:</b></td><td id="black"><?php echo number_format($coal); echo " (+".max(((mysql_num_rows($coalC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/cod.png" title="Increases population by 0.1%"><b>Cod:</b></td><td id="black"><?php echo number_format($cod); echo " (+".max(((mysql_num_rows($codC)*10*$collecthours)-($cities*$collecthours)), 0).")";?></td><td id="black"><img src="images/icons/cotton.png" title="Reduce cost of soldiers by 1%"><b>Cotton:</b></td><td id="black"><?php echo number_format($cotton); echo " (+".max(((mysql_num_rows($cottonC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/oil.png" title="Increases pollution by 1%, decreases vehicle, aircraft, and naval upkeep by 5%"><b>Crude Oil:</b></td><td id="black"><?php echo number_format($oil); echo " (+".max(((mysql_num_rows($oilC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td></tr>
<tr id="black"><td id="black"><img src="images/icons/coffee.png" title="Increaes happiness by 1%"><b>Coffee Beans:</b></td><td id="black"><?php echo number_format($coffee); echo " (+".max(((mysql_num_rows($coffeeC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/composite.png" title="Reduces the cost of aircraft by 5%"><b>Composite:</b></td><td id="black"><?php echo number_format($composite); echo " (+".max(((mysql_num_rows($compositeC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/gold.png" title="Increases average income by $0.02"><b>Gold:</b></td><td id="black"><?php echo number_format($gold); echo " (+".max(((mysql_num_rows($goldC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/chickens.png" title="Reduces cost of soldiers by 3%"><b>Chickens:</b></td><td id="black"><?php echo number_format($chickens); echo " (+".max(((mysql_num_rows($chickensC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td></tr>
<td id="black"><img src="images/icons/corn.png" title="Increases population by 0.2%"><b>Corn:</b></td><td id="black"><?php echo number_format($corn); echo " (+".max(((mysql_num_rows($cornC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/copper.png" title="Reduces the cost of zones by 2%"><b>Copper:</b></td><td id="black"><?php echo number_format($copper); echo " (+".max(((mysql_num_rows($copperC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/iron.png" title="Decreases cost of naval vessels by 1%"><b>Iron:</b></td><td id="black"><?php echo number_format($iron); echo " (+".max(((mysql_num_rows($ironC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/gems.png" title="Increases happiness by 1%"><b>Gems:</b></td><td id="black"><?php echo number_format($gems); echo " (+".max(((mysql_num_rows($gemsC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td>
<tr id="black"><td id="black"><img src="images/icons/rubber.png" title="Reduces the cost of vehicles by 3%"><b>Rubber:</b></td><td id="black"><?php echo number_format($rubber); echo " (+".max(((mysql_num_rows($rubberC)*10*$collecthours))-($cities*$collecthours), 0).")"; ?></td><td id="black"><img src="images/icons/silver.png" title="Increases average income by $0.01"><b>Silver:</b></td><td id="black"><?php echo number_format($silver); echo " (+".max(((mysql_num_rows($silverC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/timber.png" title="Reduces the cost of zones by 1%"><b>Timber:</b></td><td id="black"><?php echo number_format($timber); echo " (+".max(((mysql_num_rows($timberC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td><td id="black"><img src="images/icons/water.png" title="Reduces pollution by 1%, increases population by 0.1%"><b>Fresh Water:</b></td><td id="black"><?php echo number_format($water); echo " (+".max(((mysql_num_rows($waterC)*10*$collecthours)-($cities*$collecthours)), 0).")"; ?></td></tr>
</table>
<br />
<b>Research Points</b>
<table id="black">
<tr id="black"><td id="black" width="30%"><b>Points From Research Labs:</b></td><td id="black" class="right" width="20%"><?php echo number_format($libpoints); ?></td><td id="black" width="30%"><b>Points From Universities:</b></td><td id="black" class="right"><?php echo number_format($unipoints); ?></td></tr>
<tr id="black"><td id="black" width="30%"><b>Points to be Collected:</b></td><td id="black" class="right" width="20%"><?php echo number_format($totalpoints); ?></td><td id="black" width="30%"><b>New Point Total:</b></td><td id="black" class="right"><?php echo number_format($newpoints); ?></td></tr>
</table>
<br />
<b>Income</b>
<table id="black">
<tr id="black"><td id="black" width="30%"><b>Population:</b></td><td id="black" class="right" width="20%"><?php echo number_format($population); ?></td><td id="black" width="30%"><b>Average Income:</b></td><td id="black" class="right">$<?php echo number_format($avgincome,2); ?></td></tr>
<tr id="black"><td id="black"><b>Working Population:</b></td><td id="black" class="right"><?php echo number_format($employedpop); ?></td><td id="black"><b>Happiness:</b></td><td id="black" class="right"><?php echo number_format($happiness,1); ?>%</td></tr>
<tr id="black"><td id="black"><b>Tax Rate:</b></td><td id="black" class="right"><?php echo number_format($taxrate); ?>%</td><td id="black"><b>Tax Revenue:</b></td><td id="black" class="right">$<?php echo number_format($revenue); ?></td></tr>
</table>
<br />
<b>Expenses</b>
<table id="black">
<tr id="black"><td id="black" width="30%"><b>Infantry Upkeep:</b></td><td id="black" class="right" width="20%">$<?php echo number_format($soldierscost); ?></td><td id="black" width="30%"><b>Infrastructure Maintainence:</b></td><td id="black" class="right">$<?php echo number_format($infracost); ?></td></tr>
<tr id="black"><td id="black"><b>Vehicle Upkeep:</b></td><td id="black" class="right">$<?php echo number_format($tankcost); ?></td><td id="black"><b>Government Costs:</b></td><td id="black" class="right">$<?php echo number_format($govcost); ?></td></tr>
<tr id="black"><td id="black"><b>Aircraft Upkeep:</b></td><td id="black" class="right">$<?php echo number_format($jetcost); ?></td><td id="black"><b>Civil Services:</b></td><td id="black" class="right">$<?php echo number_format($civcost); ?></td></tr>
<tr id="black"><td id="black"><b>Navy Upkeep:</b></td><td id="black" class="right">$<?php echo number_format($bshipcost); ?></td><td id="black"><b>Healthcare:</b></td><td id="black" class="right">$<?php echo number_format($healthcare); ?></td></tr>
<tr id="black"><td id="black"><b>Ballistic Missile Upkeep:</b></td><td id="black" class="right">$<?php echo number_format($missilecost); ?></td><td id="black"><b>Environment:</b></td><td id="black" class="right">$<?php echo number_format($environment); ?></td></tr>
<tr id="black"><td id="black"><b>Nuclear Weapons Upkeep:</b></td><td id="black" class="right">$<?php echo number_format($nukecost); ?></td><td id="black"><b>Total Expense:</b></td><td id="black" class="right">$<?php echo number_format($totalcost); ?></td></tr>
</table>
<br />
<b>Totals</b>
<table id="black">
<tr id="black"><td id="black" width="30%"><b>Gross Revenue:</b></td><td id="black" class="right" width="20%">$<?php echo number_format($revenue); ?></td><td id="black" width="30%"><b>Gross Expense:</b></td><td id="black" class="right">$<?php echo number_format($totalcost); ?></td></tr>
<tr id="black"><td id="black"><b>Time Since Collection:</b></td><td id="black" class="right"><?php echo "".number_format($collecthours)." hours, ".number_format($minutes)." minutes"; ?></td><td id="black"><b>Net Surplus:</b></td><td id="black" class="right">$<?php echo number_format(($revenue-$totalcost)); ?></td></tr>
<tr id="black"><td id="black"><b>Net Total:</b></td><td id="black" class="right">$<?php echo number_format($nettotal); ?></td><td id="black"><b>New Balance:</b></td><td id="black" class="right">$<?php echo number_format($nettotal+$userA['money']); ?></td></tr>
</table><br />
<?php
if($userA['readiness'] == "peace") {
echo "Because you are a peaceful nation, you are losing ".$power."% of your net total.<br /><br />";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
<center><input type="submit" name="send" value="Collect Net Total"></center><br />
</form>
<?php
}
?>