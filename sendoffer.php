<div id="title">Submit Offer</div>
<?php
require("loggedin.php");
$token = mysql_real_escape_string(htmlentities($_POST['token']));
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userC = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
if($_POST['submit'] == "Submit Offer" AND $_SESSION['token'] == $token) {

$resource = mysql_real_escape_string(htmlentities($_POST['resource']));
$amount = mysql_real_escape_string(htmlentities($_POST['amount']));
$buysell = mysql_real_escape_string(htmlentities($_POST['buysell']));
$price = mysql_real_escape_string(htmlentities($_POST['price']));
$total = round($amount)*round($price,2);




$resources = array("cotton", "rubber", "coal", "cod", "corn", "timber", "copper", "iron", "oil", "chickens", "water", "composite", "silver", "coffee", "gems", "gold");
if(!in_array($resource, $resources)) {
$error .= "You did not choose a valid resource.<br />";
} if(!is_numeric($amount)) {
$error .= "You did not enter a numeric value for the amount of resources you wish to buy/sell.<br />";
} if($buysell != "sell" AND $buysell != "buy") {
$error .= "You did not choose to buy/sell your resource.<br />";
} if(!is_numeric($price)) {
$error .= "You did not enter a numeric value for the price per unit field.<br />";
} if($price < 1) {
$error .= "You cannot enter a price less than 1.<br />";
} if($amount < 10) {
$error .= "You cannot sell less than 10 of a resource at a time.<br />";
} if($price > 10000000) {
$error .= "You cannot list the price per unit higher than $10,000,000.<br />";
}

if($buysell == "buy") {
if($total > $userF['money']) {
$error .= "You do not have enough money to make that offer.<br />";
}
} if($buysell == "sell") {
$resourceavailable = $userF[$resource];
if($amount > $resourceavailable) {
$error .= "You do not have that much resources to offer.<br />";
}
}

if($error == null) {
$date = date("c");
if($buysell == "buy") {
$newmoney = $userF['money']-$total;
mysql_query("INSERT INTO `market` (date, username, resource, buysell, amount, price, completed) VALUES ('$date', '$userF[username]', '$resource', 'buy', '$amount', '$price', '0')");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$userF[id]'");
echo "You have successfully listed a buy offer for ".number_format($amount)." ".ucfirst($resource)." at $".number_format($price,2)." per unit for a total of $".number_format($total,2).".";
}

if($buysell == "sell") {
$newresource = $userF[$resource]-$amount;
mysql_query("INSERT INTO `market` (date, username, resource, buysell, amount, price, completed) VALUES ('$date', '$userF[username]', '$resource', 'sell', '$amount', '$price', '0')");
mysql_query("UPDATE players SET ".$resource."='$newresource' WHERE id='$userF[id]'");
echo "You have successfully listed a sell offer for ".number_format($amount)." ".ucfirst($resource)." at $".number_format($price,2)." per unit for a total of $".number_format($total,2).".";
}


} else {
echo "You received the following errors:<br /><br />";
echo $error;
}
} else {
?>

Here you can submit offers to the Global Market where other players can choose to transact your offer. You may want to check the market to see if you can get the resources/money you need before submitting an offer.<br /><br />
<script src="pn-util.js"></script>
<script>
window.onload = function () {
  var elements, onChange;

  elements = {
    amount : document.getElementById("amount"),
    ppu: document.getElementById("ppu"),
    buy: document.getElementById("buy"),
    sell: document.getElementById("sell"),
  };

  onChange = function () {
    var total = elements.amount.value * elements.ppu.value;
    document.getElementById("total").innerHTML = formatCost(total);
  };

  for (input in elements) {
    if (elements.hasOwnProperty(input)) {
      if (elements[input].attachEvent) {
        elements[input].attachEvent("change", onChange);
      } else {
        elements[input].addEventListener("change", onChange, true);
      }
    }
  }
};
</script>

<form action='index.php?id=86' method='post' id='post-resources'>
<center><table class="black">
<tr class="black">
<td class="black">Resource <select name="resource" id="resources"><option value="cotton">Cotton</option><option value="rubber">Rubber</option><option value="coal">Coal</option><option value="cod">Cod</option><option value="timber">Timber</option><option value="corn">Corn</option><option value="copper">Copper</option><option value="composite">Composite</option><option value="iron">Iron</option><option value="oil">Crude Oil</option><option value="chickens">Chickens</option><option value="water">Fresh Water</option><option value="silver">Silver</option><option value="gold">Gold</option><option value="gems">Gems</option><option value="coffee">Coffee Beans</option></select> </td>
<td class="black">Amount  <input type="number" name="amount" max="10000" min="0" required id="amount"></td>
<td class="black">Buy <input type="radio" id="buy" name="buysell" value="buy"> Sell <input type="radio" id="sell" name="buysell" value="sell"></td>
<td class="black">Price per Unit  $<input type="number" id="ppu" name="price" min="0" max="10000000" required></td>
<td class="black">Total <span id="total">$0</span></td>
</tr>
</table><br />
<?php
$token = md5(rand(99999,999999));
$_SESSION['token'] = $token;
?>
<input type='hidden' name='token' value='<?php echo $token; ?>'>
<input type='submit' name='submit' value='Submit Offer'></center></form>
<p style="text-align:center;">Money $<?php echo number_format($userF['money']); ?></p>
<table class="black">
<tr class="black"><td class="black" width="25%"><img src="images/icons/coal.png" title="Reduces the cost of zones by 1%"><b>Coal:</b></td><td class="black"><?php echo number_format($userF['coal']); ?></td><td class="black" width="25%"><img src="images/icons/cod.png" title="Increases population by 0.1%"><b>Cod:</b></td><td class="black"><?php echo number_format($userF['cod']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/coffee.png" title="Increaes happiness by 1%"><b>Coffee Beans:</b></td><td class="black"><?php echo number_format($userF['coffee']); ?></td><td class="black"><img src="images/icons/composite.png" title="Reduces the cost of aircraft by 5%"><b>Composite:</b></td><td class="black"><?php echo number_format($userF['composite']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/corn.png" title="Increases population by 0.2%"><b>Corn:</b></td><td class="black"><?php echo number_format($userF['corn']); ?></td><td class="black"><img src="images/icons/copper.png" title="Reduces the cost of zones by 2%"><b>Copper:</b></td><td class="black"><?php echo number_format($userF['copper']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/oil.png" title="Increases pollution by 1%, decreases vehicle, aircraft, and naval upkeep by 5%"><b>Crude Oil:</b></td><td class="black"><?php echo number_format($userF['oil']); ?></td><td class="black"><img src="images/icons/chickens.png" title="Reduces cost of soldiers by 3%"><b>Chickens:</b></td><td class="black"><?php echo number_format($userF['chickens']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/gems.png" title="Increases happiness by 1%"><b>Gems:</b></td><td class="black"><?php echo number_format($userF['gems']); ?></td><td class="black"><img src="images/icons/gold.png" title="Increases average income by $0.02"><b>Gold:</b></td><td class="black"><?php echo number_format($userF['gold']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/iron.png" title="Decreases cost of naval vessels by 1%"><b>Iron:</b></td><td class="black"><?php echo number_format($userF['iron']); ?></td><td class="black"><img src="images/icons/water.png" title="Reduces pollution by 1%, increases population by 0.1%"> <b>Fresh Water:</b></td><td class="black"><?php echo number_format($userF['water']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/rubber.png" title="Reduces the cost of vehicles by 3%"><b>Rubber:</b></td><td class="black"><?php echo number_format($userF['rubber']); ?></td><td class="black"><img src="images/icons/silver.png" title="Increases average income by $0.01"><b>Silver:</b></td><td class="black"><?php echo number_format($userF['silver']); ?></td></tr>
<tr class="black"><td class="black"><img src="images/icons/timber.png" title="Reduces the cost of zones by 1%"><b>Timber:</b></td><td class="black"><?php echo number_format($userF['timber']); ?></td><td class="black"><img src="images/icons/cotton.png" title="Reduce cost of soldiers by 1%"><b>Cotton:</b></td><td class="black"><?php echo number_format($userF['cotton']); ?></td></tr>
</table>
<?php
}
?>