<div id="title">Global Market</div>
<?php
require("loggedin.php");
$id = $_SESSION['id'];
$resource = mysql_real_escape_string(htmlentities($_GET['resource']));
$bs = mysql_real_escape_string(htmlentities($_GET['bs']));
$sort = mysql_real_escape_string(htmlentities($_GET['sort']));
$idcheck = mysql_query("SELECT username FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
?>
Here is the global market where you can buy and sell resources. You can also submit your own offer to the market for others to complete.<br /><br />
<b>Narrow Search:</b> <form action="index.php?id=88" method="get">
<select name="resource" id="resources">
<option value="all" <?php if($resource == "all") { echo "selected"; } ?>>All</option>
<option value="cotton" <?php if($resource == "cotton") { echo "selected"; } ?>>Cotton</option>
<option value="rubber" <?php if($resource == "rubber") { echo "selected"; } ?>>Rubber</option>
<option value="coal" <?php if($resource == "coal") { echo "selected"; } ?>>Coal</option>
<option value="cod" <?php if($resource == "cod") { echo "selected"; } ?>>Cod</option>
<option value="timber" <?php if($resource == "timber") { echo "selected"; } ?>>Timber</option>
<option value="corn" <?php if($resource == "corn") { echo "selected"; } ?>>Corn</option>
<option value="copper" <?php if($resource == "copper") { echo "selected"; } ?>>Copper</option>
<option value="composite" <?php if($resource == "composite") { echo "selected"; } ?>>Composite</option>
<option value="iron" <?php if($resource == "iron") { echo "selected"; } ?>>Iron</option>
<option value="oil" <?php if($resource == "oil") { echo "selected"; } ?>>Crude Oil</option>
<option value="chickens" <?php if($resource == "chickens") { echo "selected"; } ?>>Chickens</option>
<option value="water" <?php if($resource == "water") { echo "selected"; } ?>>Fresh Water</option>
<option value="silver" <?php if($resource == "silver") { echo "selected"; } ?>>Silver</option>
<option value="gold" <?php if($resource == "gold") { echo "selected"; } ?>>Gold</option>
<option value="gems" <?php if($resource == "gems") { echo "selected"; } ?>>Gems</option>
<option value="coffee" <?php if($resource == "coffee") { echo "selected"; } ?>>Coffee Beans</option>
</select> 
<select name="bs">
<option value="buy" <?php if($bs == "buy") { echo "selected"; } ?>>Buy</option>
<option value="sell" <?php if($bs == "sell") { echo "selected"; } ?>>Sell</option>
</select> 
<select name="sort">
<option value="old" <?php if($sort == "old") { echo "selected"; } ?>>Sort By...</option>
<option value="new" <?php if($sort == "new") { echo "selected"; } ?>>Newest</option>
<option value="big" <?php if($sort == "big") { echo "selected"; } ?>>Bulk Amount</option>
<option value="small" <?php if($sort == "small") { echo "selected"; } ?>>Small Amount</option>
<option value="low" <?php if($sort == "low") { echo "selected"; } ?>>Lowest Price</option>
<option value="high" <?php if($sort == "high") { echo "selected"; } ?>>Highest Price</option>
</select>
<input type="hidden" value="88" name="id"><input type="submit" value="Go!"></form>
<br />
<table class="black">
<tr class="black">
<th class="black" id="thickblack">Resource</th><th class="black" id="thickblack">Buy/Sell</th><th class="black" id="thickblack">Price Per Unit</th><th class="black" id="thickblack">Amount</th><th class="black" id="thickblack">Total</th>
</tr>
<?php

if($resource == null AND $bs == null AND $sort == null) {
$null = 1;
}

$sortarray = array("old", "new", "big", "small", "high", "low");
$resources = array("all", "cotton", "rubber", "coal", "cod", "corn", "timber", "copper", "iron", "oil", "chickens", "water", "composite", "silver", "coffee", "gems", "gold");
if(!in_array($resource, $resources)) {
$resource = $resources[rand(0,15)];
} if($bs != "buy" AND $bs != "sell") {
$bs = "sell";
} if(!in_array($sort, $sortarray)) {
$sort = "old";
}

$sortget["old"] = "date DESC";
$sortget["new"] = "date ASC";
$sortget["big"] = "amount DESC";
$sortget["small"] = "amount ASC";
$sortget["high"] = "price DESC";
$sortget["low"] = "price ASC";
$sort = $sortget[$sort];

$salt = "10j3a8G2O3C587I77Fv34nFSlYbn66";
$realcode = substr(md5($id.$salt), 0, 8);

if($null == 1) {
$getmarket = mysql_query("SELECT * FROM market WHERE completed='0' ORDER BY date DESC LIMIT 30");
} else {
$getmarket = mysql_query("SELECT * FROM market WHERE completed='0' AND resource='".$resource."' AND buysell='".$bs."' ORDER BY ".$sort." LIMIT 30");
} 
if($resource == "all") {
$getmarket = mysql_query("SELECT * FROM market WHERE completed='0' AND buysell='".$bs."' ORDER BY ".$sort." LIMIT 30");
}
while($row = mysql_fetch_array($getmarket)) {
$rowresource = $row['resource'];
if($rowresource == "water") {
$rowresource = "Fresh Water";
} if($rowresource == "oil") {
$rowresource = "Crude Oil";
} if($rowresource == "coffee") {
$rowresource = "Coffee Beans";
}
$youroffer = "";
if($idfetch['username'] == $row['username']) {
$youroffer = "(Your Offer)";
}
echo "<tr class='black'><td class='black'><a href='http://pn.referata.com/wiki/Resources#".ucfirst($rowresource)."'>".ucfirst($rowresource)."</a></td><td class='center' id='black'><a href='index.php?id=87&marketid=".$row['id']."&ver=".$realcode."'>".ucfirst($row['buysell'])."</td><td class='right' id='black'>$".number_format($row['price'],2)."</td><td class='right' id='black'>".number_format($row['amount'])."</td><td class='right' id='black'>$".number_format($row['amount']*$row['price'],2)." ".$youroffer."</td></tr>";
} if(mysql_num_rows($getmarket) == 0) {
echo "<tr class='black'><td id='black' class='center' colspan='5'>Sorry, No Results</td></tr>";
}
?>
</table>
<p style="text-align:center;"><a href='index.php?id=86'>Submit New Offer</a></p>
