<script>
window.onload = function () {
  var zones, data, inputs, name, onChange, ix, formatCost;
  
  // This method is horribly inefficient.
  formatCost = function (cost) {
    var ret, ix, jx, str, isPositive;
    
    isPositive = cost >= 0;
    str = isPositive ? String(cost) : String(cost).slice(1);
    
    ret = "";
    for (ix = str.length - 1, jx = 0; ix >= 0; ix--, jx++) {
      ret += str[ix];
      if (jx % 3 === 2) ret += ",";
    }
    
    ret = ret.split("").reverse();
    if (ret[0] === ",") ret.shift();
    return (isPositive ? "$" : "-$") + ret.join("");
  }

  zones = document.getElementById("zones");

  data = {
    names : [],
    sellPrice : [10000, 10000, 10000, 10000, 100],
    inputs : [],
    subtotals : [],
    prices : [],
    total : document.getElementById("total")
  };

  onChange = function () {
    var zones, total, ix;

    for (ix = 0, total = 0; ix < data.inputs.length; ix++) {
      zones = Number(data.inputs[ix].value);
      
      if (zones >= 0) {
data.subtotals[ix].innerHTML = formatCost(zones * data.prices[ix]);
total += zones * data.prices[ix];
      } else {
        data.subtotals[ix].innerHTML = formatCost(zones * data.sellPrice[ix]);
        total += zones * data.sellPrice[ix];
      }
    }

    data.total.innerHTML = formatCost(total);
  };

  var moneyFilter = /[$,]/g;
  var moneyToNumber = function (money) {
    return Number(money.replace(moneyFilter, ""));
  };

  inputs = zones.getElementsByTagName("input");
  for (ix = 0; ix < inputs.length; ix++) {
    if (inputs[ix].type === "number" || inputs[ix].type === "text") {
      name = inputs[ix].getAttribute("name");

      data.names.push(name);
      data.inputs.push(inputs[ix]); // Filters and makes the list non-live.
      data.subtotals.push(document.getElementById(name + "Subtotal"));
      data.prices.push(moneyToNumber(document.getElementById(name + "Price").innerHTML));

      if (inputs[ix].addEventListener) {
        inputs[ix].addEventListener("change", onChange, true);
      } else {
        inputs[ix].attachEvent("change", onChange);
      }
    }
  }
};

</script>

<?php
$cid = mysql_real_escape_string(htmlentities(trim($_GET['cid'])));
if($cid == null) {
$id = $_SESSION['id'];
} else {
if(is_numeric($cid)) {
$cidCheck = mysql_query("SELECT * FROM `cities` WHERE id='$cid'");
$cidNum = mysql_num_rows($cidCheck);
if($cidNum == 1) {
$id = $cid;
} else {
$id =$_SESSION['id'];
}
} else {
$id = $_SESSION['id'];
}
}
$userCheck = mysql_query("SELECT * FROM `players` WHERE id='$_SESSION[id]'");
$userF = mysql_fetch_array($userCheck);

if($id == $_SESSION['id']) {
$capCheck = mysql_query("SELECT * FROM `cities` WHERE name='$userF[capital]'");
$capFetch = mysql_fetch_array($capCheck);
$id = $capFetch['id'];
}

function updateCity() {
$citychecker = mysql_query("SELECT * FROM cities WHERE id='$id'");
$cityfetcher = mysql_fetch_array($citychecker);
$nation = $cityfetcher['nation'];
$nationchecker = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$nationfetcher = mysql_fetch_array($nationchecker);

$population = ($cityfetcher['residential']*10000)+($cityfetcher['commercial']*2400)+($cityfetcher['industrial']*2600)+($cityfetcher['military']*4000)+100;
$literacy = 80+($cityfetcher['university']*3)+($cityfetcher['library']*2);
$lithap = 100-$literacy;
$crime = ($cityfetcher['residential']*.329)+($cityfetcher['commercial']*.317)+($cityfetcher['industrial']*.201)-($cityfetcher['military']);
if($crime > 10) {
$crime = 10;
}
$crime = $crime-(($cityfetcher['police']*.25)+($cityfetcher['prison']*.5)+($cityfetcher['supremecourt']*.75));
if($crime < 0) {
$crime = 0;
}

$unemployment = ($cityfetcher['residential']*1.09)-(($cityfetcher['commercial']*.5)+($cityfetcher['industrial']*.7));
if($unemployment < 1) {
$unemployment = 1;
} if($unemployment > 20) {
$unemployment = 20;
}

$pollution = ($cityfetcher['residential']*100)+($cityfetcher['commercial']*60)+($cityfetcher['industrial']*140)-($cityfetcher['military']*20);
if($pollution < 0) {
$pollution = 0;
}
$pollutionbonus = ($cityfetcher['landfill']*1)+($cityfetcher['sanitation']*4)+($cityfetcher['subway']*10);
$pollution = $pollution-($pollution*($pollutionbonus/100));
//pollution 
if($nationfetcher['hydrop'] == 1) {
$pollution = $pollution*.9;
} if($nationfetcher['nwds'] == 1) {
$pollution = $pollution*.9;
}


$density = round($cityfetcher['population']/($cityfetcher['land']+1));
if($density < 51) {
$densitybonus = 1;
} if($density > 50 AND $density < 151) {
$densitybonus = 0;
} if($density > 150 AND $density < 201) {
$densitybonus = -2;
} if($density > 200 AND $density < 351) {
$densitybonus = -5;
} if($density > 350) {
$densitybonus = -8;
} 
 if($density > 500) {
$densitybonus = -25;
} if($density > 750) {
$densitybonus = -50;
} if($density > 1000) {
$densitybonus = -65;
} if($density > 1300) {
$densitybonus = -80;
} if($density > 1600) {
$densitybonus = -90;
} if($density > 10000) {
$densitybonus = -99;
}

$happiness = round((100)-($cityfetcher['crime']+$lithap+$cityfetcher['unemployment'])+(($cityfetcher['hospital']*.75)+($cityfetcher['zoo']*.5)+($cityfetcher['stadium']*1)+$densitybonus),1);
if($happiness < 0) {
$happiness = 0;
} if($happiness > 100) {
$happiness = 100;
}

$cityRank = "Hamlet";
if($population >= 20000) {
$cityRank = "Village";
} if($population >= 100000) {
$cityRank = "Suburb";
} if($population >= 1000000) {
$cityRank = "Town";
} if($population >= 3000000) {
$cityRank = "City";
} if($population >= 10000000) {
$cityRank = "Metropolis";
}

mysql_query("UPDATE cities SET population='$population', literacy='$literacy', crime='$crime', pollution='$pollution', happiness='$happiness', unemployment='$unemployment', rank='$cityRank' WHERE id='$id'");

if($nationfetcher['skyscraper'] == 1) {
$happiness = $happiness+0.25;
} if($nationfetcher['gshrine'] == 1) {
$happiness = $happiness+0.75;
} if($nationfetcher['olympic'] == 1) {
$happiness = $happiness+0.5;
} if($nationfetcher['ss'] == 1) {
$happiness = $happiness+0.1;
} if($nationfetcher['se'] == 1) {
$happiness = $happiness+0.25;
}

if($happiness < 0) {
$happiness = 0;
} if($happiness > 100) {
$happiness = 100;
}

//nuclear chaos
$nukehit = $nationfetcher['nukehit'];
$diff10 = abs(strtotime($nukehit) - strtotime(date(c)));
$hours10 = round($diff10/60/60/24);
if($hours10 < 2) {
$happiness = round($happiness-30);
}
}


$citychecker = mysql_query("SELECT * FROM cities WHERE id='$id'");
$cityfetcher = mysql_fetch_array($citychecker);
$nation = $cityfetcher['nation'];
$nationchecker = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$nationfetcher = mysql_fetch_array($nationchecker);

//cities
$cityC = mysql_query("SELECT id FROM cities WHERE nation='$nation'");
$cities = mysql_num_rows($cityC);

$population = ($cityfetcher['residential']*10000)+($cityfetcher['commercial']*2400)+($cityfetcher['industrial']*2600)+($cityfetcher['military']*4000)+100;
$literacy = 80+($cityfetcher['university']*3)+($cityfetcher['library']*2);
$lithap = 100-$literacy;
$crime = ($cityfetcher['residential']*.329)+($cityfetcher['commercial']*.317)+($cityfetcher['industrial']*.201)-($cityfetcher['military']);
if($crime > 10) {
$crime = 10;
}
$crime = $crime-(($cityfetcher['police']*.25)+($cityfetcher['prison']*.5)+($cityfetcher['supremecourt']*.75));
if($crime < 0) {
$crime = 0;
}

$unemployment = ($cityfetcher['residential']*1.09)-(($cityfetcher['commercial']*.5)+($cityfetcher['industrial']*.7));
if($unemployment < 1) {
$unemployment = 1;
} if($unemployment > 20) {
$unemployment = 20;
}

$pollution = ($cityfetcher['residential']*100)+($cityfetcher['commercial']*60)+($cityfetcher['industrial']*140)-($cityfetcher['military']*20);
if($pollution < 0) {
$pollution = 0;
}
$pollutionbonus = ($cityfetcher['landfill']*1)+($cityfetcher['sanitation']*4)+($cityfetcher['subway']*10);
$pollution = $pollution-($pollution*($pollutionbonus/100));

if($nationfetcher['hydrop'] == 1) {
$pollution = $pollution*.9;
} if($nationfetcher['nwds'] == 1) {
$pollution = $pollution*.9;
}

$density = round($cityfetcher['population']/$cityfetcher['land']);
if($density < 51) {
$densitybonus = 1;
} if($density > 50 AND $density < 151) {
$densitybonus = 0;
} if($density > 150 AND $density < 201) {
$densitybonus = -2;
} if($density > 200 AND $density < 351) {
$densitybonus = -5;
} if($density > 350) {
$densitybonus = -8;
} 
 if($density > 500) {
$densitybonus = -25;
} if($density > 750) {
$densitybonus = -50;
} if($density > 1000) {
$densitybonus = -65;
} if($density > 1300) {
$densitybonus = -80;
} if($density > 1600) {
$densitybonus = -90;
} if($density > 10000) {
$densitybonus = -99;
}

$happiness = round((100)-($cityfetcher['crime']+$lithap+$cityfetcher['unemployment'])+(($cityfetcher['hospital']*.75)+($cityfetcher['zoo']*.5)+($cityfetcher['stadium']*1)+$densitybonus),1);
if($happiness < 0) {
$happiness = 0;
} if($happiness > 100) {
$happiness = 100;
}

$cityRank = "Hamlet";
if($population >= 20000) {
$cityRank = "Village";
} if($population >= 100000) {
$cityRank = "Suburb";
} if($population >= 1000000) {
$cityRank = "Town";
} if($population >= 3000000) {
$cityRank = "City";
} if($population >= 10000000) {
$cityRank = "Metropolis";
}

mysql_query("UPDATE cities SET population='$population', literacy='$literacy', crime='$crime', pollution='$pollution', happiness='$happiness', unemployment='$unemployment', rank='$cityRank' WHERE id='$id'");


if($nationfetcher['skyscraper'] == 1) {
$happiness = $happiness+0.25;
} if($nationfetcher['gshrine'] == 1) {
$happiness = $happiness+0.75;
} if($nationfetcher['olympic'] == 1) {
$happiness = $happiness+0.5;
} if($nationfetcher['ss'] == 1) {
$happiness = $happiness+0.1;
} if($nationfetcher['se'] == 1) {
$happiness = $happiness+0.25;
}

if($happiness < 0) {
$happiness = 0;
} if($happiness > 100) {
$happiness = 100;
}

//nuclear chaos
$nukehit = $nationfetcher['nukehit'];
$diff10 = abs(strtotime($nukehit) - strtotime(date(c)));
$hours10 = round($diff10/60/60/24);
if($hours10 < 2) {
$happiness = round($happiness-30);
}


$cityCheck = mysql_query("SELECT * FROM cities WHERE id='$id'");
$cityFetch = mysql_fetch_array($cityCheck);
$cityNum = mysql_num_rows($cityCheck);

$resprice = 20000+($cityFetch['residential']*502)+($cityNum*1000);
$comprice = 18000+($cityFetch['commercial']*506)+($cityNum*1000);
$indprice = 23000+($cityFetch['industrial']*508)+($cityNum*1000);
$landprice = 600+($cityFetch['land']*.001);
$milprice = 25000+($cityFetch['military']*512)+($cityNum*1000);

//ASE Research
if($userF['ase'] == 1) {
$resprice = $resprice*.96;
$comprice = $comprice*.96;
$indprice = $indprice*.96;
$milprice = $milprice*.96;
}

//arcology wonder
if($userFetch['arcology'] == 1) {
$resprice = $resprice-($resprice*0.03);
$comprice = $comprice-($comprice*0.03);
$indprice = $indprice-($indprice*0.03);
$milprice = $milprice-($milprice*0.03);
}

//coal resource
if($userFetch['coal'] >= $cities) {
$resprice = $resprice-($resprice*0.01);
$comprice = $comprice-($comprice*0.01);
$indprice = $indprice-($indprice*0.01);
$milprice = $milprice-($milprice*0.01);
}

//coal resource
if($userFetch['copper'] >= $cities) {
$resprice = $resprice-($resprice*0.02);
$comprice = $comprice-($comprice*0.02);
$indprice = $indprice-($indprice*0.02);
$milprice = $milprice-($milprice*0.02);
}

//timber resource
if($userFetch['timber'] >= $cities) {
$resprice = $resprice-($resprice*0.01);
$comprice = $comprice-($comprice*0.01);
$indprice = $indprice-($indprice*0.01);
$milprice = $milprice-($milprice*0.01);
}

echo "<div id='title'>City View of ".$cityFetch['name']."</div>";
//update city
updateCity();
//services
//police
if(isset($_POST['police'])) {
$money = $userF['money'];
$price += 1500000;
$current = $cityfetcher['police'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Police Station.<br />";
} if($current == 3) {
$error .= "You already have 3 Police Stations.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET police='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//prison
if(isset($_POST['prison'])) {
$money = $userF['money'];
$price += 3000000;
$current = $cityfetcher['prison'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Prison.<br />";
} if($current == 1) {
$error .= "You already have a Prison.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET prison='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//subway
if(isset($_POST['subway'])) {
$money = $userF['money'];
$price += 10000000;
$current = $cityfetcher['subway'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Subway System.<br />";
} if($current == 1) {
$error .= "You already have a Subway System.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET subway='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//landfill
if(isset($_POST['landfill'])) {
$money = $userF['money'];
$price += 1000000;
$current = $cityfetcher['landfill'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Landfill.<br />";
} if($current == 2) {
$error .= "You already have two landfills.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET landfill='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//library
if(isset($_POST['library'])) {
$money = $userF['money'];
$price += 2000000;
$current = $cityfetcher['library'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Library.<br />";
} if($current == 4) {
$error .= "You already have 4 Libraries.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET library='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//university
if(isset($_POST['university'])) {
$money = $userF['money'];
$price += 3000000;
$current = $cityfetcher['university'];
if($price > $money) {
$error .= "You do not have enough money to purchase a University.<br />";
} if($current == 3) {
$error .= "You already have 3 Universities.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET university='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//research lab
if(isset($_POST['research'])) {
$money = $userF['money'];
$price += 6000000;
$current = $cityfetcher['researchlab'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Research Lab.<br />";
} if($current == 2) {
$error .= "You already have 2 Research Labs.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET researchlab='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//supreme court
if(isset($_POST['supreme'])) {
$money = $userF['money'];
$price += 4500000;
$current = $cityfetcher['supremecourt'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Supreme Court<br />";
} if($current == 1) {
$error .= "You already have a Supreme Court in this city.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET supremecourt='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//sanitation plant
if(isset($_POST['sanitation'])) {
$money = $userF['money'];
$price += 4000000;
$current = $cityfetcher['sanitation'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Sanitation Plant.<br />";
} if($current == 2) {
$error .= "You already have 2 Sanitation Plants.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET sanitation='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//hospital
if(isset($_POST['hospital'])) {
$money = $userF['money'];
$price += 5000000;
$current = $cityfetcher['hospital'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Hospital.<br />";
} if($current == 3) {
$error .= "You already have 3 Hospitals.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET hospital='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//zoo
if(isset($_POST['zoo'])) {
$money = $userF['money'];
$price += 2500000;
$current = $cityfetcher['zoo'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Zoo.<br />";
} if($current == 3) {
$error .= "You already have 3 Zoos.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET zoo='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}
//stadium
if(isset($_POST['stadium'])) {
$money = $userF['money'];
$price += 7500000;
$current = $cityfetcher['stadium'];
if($price > $money) {
$error .= "You do not have enough money to purchase a Stadium.<br />";
} if($current == 3) {
$error .= "You already have 3 Stadiums.<br />";
}
if($error == null) {
$newmoney = $money-$price;
$newamount = $current+1;
mysql_query("UPDATE cities SET stadium='$newamount' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");
}
}

if(isset($_POST['buy'])) {
$token = mysql_real_escape_string(htmlentities($_POST['token']));
if($token != $_SESSION['token']) {
$error .= "Error001 - There has been an invalid entry. Please try again.<br />";
}
if($error == null) {
$residential = round(mysql_real_escape_string(htmlentities($_POST['residential'])));
$commercial = round(mysql_real_escape_string(htmlentities($_POST['commercial'])));
$industrial = round(mysql_real_escape_string(htmlentities($_POST['industrial'])));
$land = round(mysql_real_escape_string(htmlentities($_POST['land'])),1);
$military = round(mysql_real_escape_string(htmlentities($_POST['military'])));
$newres = $cityfetcher['residential']+$residential;
$newcom = $cityfetcher['commercial']+$commercial;
$newind = $cityfetcher['industrial']+$industrial;
$newland = $cityfetcher['land']+$land;
$newmil = $cityfetcher['military']+$military;
$money = $userF['money'];
$newpop = ($newres*10000)+($newcom*2400)+($newind*2600)+($newmil*4000)+100;


if($residential < 0) {
$resprice = 10000;
} if($commercial < 0) {
$comprice = 10000;
} if($industrial < 0) {
$indprice = 10000;
} if($land < 0) {
$landprice = (100);
} if($military < 0) {
$milprice = (10000);
}
$cost = round(($resprice*$residential)+($comprice*$commercial)+($indprice*$industrial)+($landprice*$land)+($milprice*$military));

$cityRank = "Hamlet";
if($newpop >= 20000) {
$cityRank = "Village";
} if($newpop >= 100000) {
$cityRank = "Suburb";
} if($newpop >= 1000000) {
$cityRank = "Town";
} if($newpop >= 3000000) {
$cityRank = "City";
} if($newpop >= 10000000) {
$cityRank = "Metropolis";
}


if($newres > 10000 OR $newcom > 10000 OR $newind > 10000 OR $newmil > 10000) {
$error .= "Error002 - You can not purchase more than 10,000 zones per category.<br />";
} if($newland < 1) {
$error .= "Error003 - You cannot have less than 1 square kilometers of land area.<br />";
} if($newres < 0 OR $newcom < 0 OR $newind < 0 OR $newmil < 0) {
$error .= "Error004 - You cannot have less than 0 zones in any category.<br />";
} if($cost > $money-1 AND $cost > 0) {
$error .= "Error005 - You cannot make this purchase because you do not have enough money.<br />";
} if($residential > 50 OR $commercial > 50 OR $industry > 50 OR $military > 50) {
$error .= "Error006 - You can not purchase more than 50 zones per category at a time.<br />";
}



if($error == null) { 

$newmoney = round($money-$cost);
mysql_query("UPDATE cities SET residential='$newres', commercial='$newcom', industrial='$newind', land='$newland', military='$newmil', population='$newpop', rank='$cityRank', crime='$crime', unemployment='$unemployment', happiness='$happiness', pollution='$pollution' WHERE id='$id'");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$_SESSION[id]'");

updateCity();
}
updateCity();
}
}
updateCity();
$cityCheck = mysql_query("SELECT * FROM cities WHERE id='$id'");
$cityFetch = mysql_fetch_array($cityCheck);

if($cityFetch['capital'] == "1") {
echo "<img src='http://www.pixelnations.net/beta/images/Capitol.jpg' class='center'><hr>";
} else {
echo "<img src='http://www.pixelnations.net/beta/images/" .$cityFetch['rank']. ".jpg' class='center'><hr>";
}
echo $error;
if($cityFetch['nation'] == $userF['nation']) {
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;

$cityCheck2 = mysql_query("SELECT * FROM `cities` WHERE id='$id'");
$cityFetch = mysql_fetch_array($cityCheck2);
$cityNum = mysql_num_rows($cityCheck2);
$nation = $cityFetch['nation'];
$userC2 = mysql_query("SELECT * FROM players WHERE nation='$nation'");
$userA = mysql_fetch_array($userC2);
$userCheck = mysql_query("SELECT * FROM `players` WHERE id='$_SESSION[id]'");
$userFetch = mysql_fetch_array($userCheck);
$resprice = 20000+($cityFetch['residential']*502)+($cityNum*1000);
$comprice = 18000+($cityFetch['commercial']*506)+($cityNum*1000);
$indprice = 23000+($cityFetch['industrial']*508)+($cityNum*1000);
$landprice = 600+($cityFetch['land']*.001);
$milprice = 25000+($cityFetch['military']*512)+($cityNum*1000);

//ASE Research
if($userA['ase'] == 1) {
$resprice = $resprice*.96;
$comprice = $comprice*.96;
$indprice = $indprice*.96;
$milprice = $milprice*.96;
}

//arcology wonder
if($userFetch['arcology'] == 1) {
$resprice = $resprice-($resprice*0.03);
$comprice = $comprice-($comprice*0.03);
$indprice = $indprice-($indprice*0.03);
$milprice = $milprice-($milprice*0.03);
}

//coal resource
if($userFetch['coal'] >= $cities) {
$resprice = $resprice-($resprice*0.01);
$comprice = $comprice-($comprice*0.01);
$indprice = $indprice-($indprice*0.01);
$milprice = $milprice-($milprice*0.01);
}

//coal resource
if($userFetch['copper'] >= $cities) {
$resprice = $resprice-($resprice*0.02);
$comprice = $comprice-($comprice*0.02);
$indprice = $indprice-($indprice*0.02);
$milprice = $milprice-($milprice*0.02);
}

//timber resource
if($userFetch['timber'] >= $cities) {
$resprice = $resprice-($resprice*0.01);
$comprice = $comprice-($comprice*0.01);
$indprice = $indprice-($indprice*0.01);
$milprice = $milprice-($milprice*0.01);
}

updateCity();

$cityCheck2 = mysql_query("SELECT * FROM `cities` WHERE id='$id'");
$cityFetch = mysql_fetch_array($cityCheck2);
?>
<b>City Building Tips:</b> To increase your population, purchase residential zones. To lower unemployment, purchase commercial and industrial zones. To lower the crime rate, purchase civic zones. Try to maintain a good balance. City upgrades will lower pollution, and offer other benefits.<br />
<form action="index.php?id=8&cid=<?php echo $id; ?>" method="post" id="zones">
<?php
}
?>
<table class="center" width="90%">
<tr>
<td> </td>
<th width="17%">Residential Zones</th>
<th width="17%">Commercial Zones</th>
<th width="17%">Industrial Zones</th>
<th width="17%">Civic Zones</th>
<th width="17%">Land Area</th>
<tr>
<th class="right">Current Amount:</th>
<td><?php echo number_format($cityFetch['residential']); ?></td>
<td><?php echo number_format($cityFetch['commercial']); ?></td>
<td><?php echo number_format($cityFetch['industrial']); ?></td>
<td><?php echo number_format($cityFetch['military']); ?></td>
<td><?php echo number_format($cityFetch['land'],1); ?> sq. km</td>
</tr>
<?php
if($cityFetch['nation'] == $userF['nation']) {
?>
<tr>
<th class="right">Price per Zone:</th>
<td id="residentialPrice">$<?php echo number_format($resprice); ?></td>
<td id="commercialPrice">$<?php echo number_format($comprice); ?></td>
<td id="industrialPrice">$<?php echo number_format($indprice); ?></td>
<td id="militaryPrice">$<?php echo number_format($milprice); ?></td>
<td id="landPrice">$<?php echo number_format($landprice); ?></td>
</tr>
<tr>
<th class="right">Buy/Sell Amount:</th>
<td><input type="number" name="residential" maxlength="4" value="0" size="4"></td>
<td><input type="number" name="commercial" maxlength="4" size="4" value="0"></td>
<td><input type="number" name="industrial" maxlength="4" size="4" value="0"></td>
<td><input type="number" name="military" maxlength="4" size="4" value="0"></td>
<td><input type="number" name="land" maxlength="6" size="6" value="0"></td></tr>
<tr>
  <th class="right">Subtotal:</th>
  <td id="residentialSubtotal">$0</td>
  <td id="commercialSubtotal">$0</td>
  <td id="industrialSubtotal">$0</td>
  <td id="militarySubtotal">$0</td>
  <td id="landSubtotal">$0</td>
</tr>
<tr>
  <th class="right">Total:</th>
  <td id="total">$0</td>
  <th class="right">Current Balance:</th>
  <td>$<?php echo number_format($userA['money']); ?></td>
  <td colspan="2"><input type="submit" name="buy" value="Purchase"></td>
</tr>
<input type="hidden" name="token" value="<?php echo $token; ?>">
<?php 
}
?>
</table>
</form>
<p style='text-align:center;'>Resource: <a href='http://pixelnations.referata.com/wiki/Resource#<?php echo $cityFetch['resource']; ?>'><?php echo $cityFetch['resource']; ?></a></p>
<hr>
<?php
updateCity();

$citycheck = mysql_query("SELECT * FROM cities WHERE id='$id'");
$cityfetcher = mysql_fetch_array($citycheck);

$literacy = 80+($cityfetcher['university']*3)+($cityfetcher['library']*2);
$lithap = 100-$literacy;
$crime = ($cityfetcher['residential']*.329)+($cityfetcher['commercial']*.317)+($cityfetcher['industrial']*.201)-($cityfetcher['military']);
if($crime > 10) {
$crime = 10;
}
$crime = $crime-(($cityfetcher['police']*.25)+($cityfetcher['prison']*.5)+($cityfetcher['supremecourt']*.75));
if($crime < 0) {
$crime = 0;
}

$unemployment = ($cityfetcher['residential']*1.09)-(($cityfetcher['commercial']*.5)+($cityfetcher['industrial']*.7));
if($unemployment < 1) {
$unemployment = 1;
} if($unemployment > 20) {
$unemployment = 20;
}

$density = round($cityfetcher['population']/($cityfetcher['land']+1));
if($density < 51) {
$densitybonus = 1;
} if($density > 50 AND $density < 151) {
$densitybonus = 0;
} if($density > 150 AND $density < 201) {
$densitybonus = -2;
} if($density > 200 AND $density < 351) {
$densitybonus = -5;
} if($density > 350) {
$densitybonus = -8;
} 
 if($density > 500) {
$densitybonus = -25;
} if($density > 750) {
$densitybonus = -50;
} if($density > 1000) {
$densitybonus = -65;
} if($density > 1300) {
$densitybonus = -80;
} if($density > 1600) {
$densitybonus = -90;
} if($density > 10000) {
$densitybonus = -99;
}

$happiness = round((100)-($cityfetcher['crime']+$lithap+$cityfetcher['unemployment'])+(($cityfetcher['hospital']*.75)+($cityfetcher['zoo']*.5)+($cityfetcher['stadium']*1)+$densitybonus),1);
if($happiness < 0) {
$happiness = 0;
} if($happiness > 100) {
$happiness = 100;
}

$pollution = ($cityfetcher['residential']*100)+($cityfetcher['commercial']*60)+($cityfetcher['industrial']*140)-($cityfetcher['military']*20);
if($pollution < 0) {
$pollution = 0;
}
$pollutionbonus = ($cityfetcher['landfill']*1)+($cityfetcher['sanitation']*4)+($cityfetcher['subway']*10);
$pollution = $pollution-($pollution*($pollutionbonus/100));

if($nationfetcher['hydrop'] == 1) {
$pollution = $pollution*.9;
} if($nationfetcher['nwds'] == 1) {
$pollution = $pollution*.9;
}

mysql_query("UPDATE cities SET crime='$crime', unemployment='$unemployment', literacy='$literacy', happiness='$happiness', pollution='$pollution' WHERE id='$id'");

$cityCheck = mysql_query("SELECT * FROM cities WHERE id='$id'");
$cityFetch = mysql_fetch_array($cityCheck);

$pollution = $cityFetch['pollution'];
?>
<table id="black">
<tr id="black"><td id="black" width="auto"><img src="images/icons/nation.png"><b>Nation:</b></td><td id="black" width="auto"><?php echo stripslashes($cityFetch['nation']); ?></td><td id="black" width="auto"><img src="images/icons/happiness.png"><b>Happiness:</b></td><td id="black" width="13%"><?php echo number_format($happiness,1); ?>%</td></tr>
<tr id="black"><td id="black"><img src="images/icons/star.png"><b>Rank:</b></td><td id="black"><?php echo $cityFetch['rank']; ?></td><td id="black"><img src="images/icons/literacy.png"><b>Literacy:</b></td><td id="black"><?php echo number_format($literacy,1); ?>%</td></tr>
<tr id="black"><td id="black"><img src="images/icons/population.png"><b>Population:</b></td><td id="black"><?php echo number_format($cityFetch['population']); ?></td><td id="black"><img src="images/icons/crime.png"><b>Crime:</b></td><td id="black"><?php echo number_format($crime,1); ?>%</td></tr>
<tr id="black"><td id="black"><img src="images/icons/land.png"><b>Land:</b></td><td id="black"><?php echo number_format($cityFetch['land']); ?> sq. km</td><td id="black"><img src="images/icons/unemployment.png"><b>Unemployment:</b></td><td id="black"><?php echo number_format($unemployment,1); ?>%</td></tr>
<tr id="black"><td id="black"><img src="images/icons/density.png"><b>Population Density:</b></td><td id="black"><?php echo number_format($population/$cityFetch['land']); ?> people per sq. km</td><td id="black"><img src="images/icons/pollution.png"><b>Pollution:</b></td><td id="black"><?php echo number_format($pollution); ?> tons</td></tr>
</table>
<?php
if($cityFetch['nation'] == $userF['nation']) {
?>
<hr>
<b>Services</b><br /><br />
<table id="black"><form action="index.php?id=8&cid=<?php echo $id; ?>" method="post">
<tr id="black">
<td id="black" class="center">Police Station<br /><img src="images/policestation.jpg"><br />Price: $1,500,000<br />Maximum: 3<br />Built: <?php echo $cityFetch['police']; ?><br /><input type="submit" value="Build New" name="police"></td>
<td id="black" class="center">Prison<br /><img src="images/prison.jpg"><br />Price: $3,000,000<br />Maximum: 1<br />Built: <?php echo $cityFetch['prison']; ?><br /><input type="submit" value="Build New" name="prison"></td>
<td id="black" class="center">Supreme Court<br /><img src="images/supreme.jpg"><br />Price: $4,500,000<br />Maximum: 1<br />Built: <?php echo $cityFetch['supremecourt']; ?><br /><input type="submit" value="Build New" name="supreme"></td>
</tr><tr id="black">
<td id="black" class="center">Library<br /><img src="images/library.jpg"><br />Price: $2,000,000<br />Maximum: 4<br />Built: <?php echo $cityFetch['library']; ?><br /><input type="submit" value="Build New" name="library"></td>
<td id="black" class="center">University<br /><img src="images/college.jpg"><br />Price: $3,000,000<br />Maximum: 3<br />Built: <?php echo $cityFetch['university']; ?><br /><input type="submit" value="Build New" name="university"></td>
<td id="black" class="center">Research Lab<br /><img src="images/research.jpg"><br />Price: $6,000,000<br />Maximum: 2<br />Built: <?php echo $cityFetch['researchlab']; ?><br /><input type="submit" value="Build New" name="research"></td>
</tr><tr id="black">
<td id="black" class="center">Landfill<br /><img src="images/landfill.jpg"><br />Price: $1,000,000<br />Maximum: 2<br />Built: <?php echo $cityFetch['landfill']; ?><br /><input type="submit" value="Build New" name="landfill"></td>
<td id="black" class="center">Sanitation Plant<br /><img src="images/sanitation.jpg"><br />Price: $4,000,000<br />Maximum: 2<br />Built: <?php echo $cityFetch['sanitation']; ?><br /><input type="submit" value="Build New" name="sanitation"></td>
<td id="black" class="center">Subway System<br /><img src="images/subway.jpg"><br />Price: $10,000,000<br />Maximum: 1<br />Built: <?php echo $cityFetch['subway']; ?><br /><input type="submit" value="Build New" name="subway"></td>
</tr><tr id="black">
<td id="black" class="center">Hospital<br /><img src="images/hospital.jpg"><br />Price: $5,000,000<br />Maximum: 3<br />Built: <?php echo $cityFetch['hospital']; ?><br /><input type="submit" value="Build New" name="hospital"></td>
<td id="black" class="center">Zoo<br /><img src="images/zoo.jpg"><br />Price: $2,500,000<br />Maximum: 3<br />Built: <?php echo $cityFetch['zoo']; ?><br /><input type="submit" value="Build New" name="zoo"></td>
<td id="black" class="center">Stadium<br /><img src="images/stadium.jpg"><br />Price: $7,500,000<br />Maximum: 3<br />Built: <?php echo $cityFetch['stadium']; ?><br /><input type="submit" value="Build New" name="stadium"></td>
</tr><tr id="black">
</table><center>
<?php
}

?>