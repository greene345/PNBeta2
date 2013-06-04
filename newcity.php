<div id="title">Found New City</div>
<?php
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userCheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$userFetch = mysql_fetch_array($userCheck);
$title = $userFetch['title'];
$nation = $userFetch['nation'];
$cityCheck = mysql_query("SELECT * FROM cities WHERE nation='$nation'");
$cityNum = mysql_num_rows($cityCheck);
$price = (pow($cityNum, (4/3))-$cityNum+1)*1000000;
$sent = mysql_real_escape_string(htmlentities($_POST['sent']));

$money=$userFetch['money'];


if($sent == "Construct") {
$token = mysql_real_escape_string(htmlentities($_POST['token']));
if($token != $_SESSION['token']) {
$error .= "Error01 - There was an unexpected error. Please try again. <br />";
}
$cityname = mysql_real_escape_string(htmlentities($_POST['name']));
$pattern = '#^[a-z0-9\x20]+$#i';
if(!preg_match($pattern, $cityname)) {
$error .= "Error02 - Your city name can only contain alphanumeric characters and spaces.<br /> ";
} if(strlen($cityname) > 14) {
$error .= "Error03 - Your city name cannot be longer than 14 characters.<br />";
} if(strlen($cityname) < 5) {
$error .= "Error04 - Your city name cannot be less than 5 characters.<br />";
} if($price > $money) {
$error .= "Error05 - You do not have enough money to construct a new city.<br />";
}
if($error == null) {
//determine resource
$basic = array("Rubber", "Coal", "Cod", "Corn", "Timber", "Cotton");
$medium = array("Copper", "Iron", "Crude Oil", "Chickens", "Fresh Water", "Composite");
$rare = array("Silver", "Gold", "Gems", "Coffee Beans");
$rand1 = rand(1,100);
if($rand1 < 75) {
$resource = $basic[rand(0, (count($basic)-1))];
} if($rand1 > 74 AND $rand1 < 95) {
$resource = $medium[rand(0, (count($medium)-1))];
} if($rand1 > 94) {
$resource = $rare[rand(0, (count($rare)-1))];
}

$newmoney = $money-$price;
$date = date("c");
mysql_query("INSERT INTO `cities` (name, found_date, nation, capital, rank, population, land, residential, commercial, industrial, military, happiness, literacy, unemployment, crime, resource) VALUES ('$cityname', '$date', '$nation', '0', 'Hamlet', '500', '3500', '1', '1', '1', '1', '70.4', '91.2', '9.1', '2.1', '$resource')");
mysql_query("UPDATE players SET money='$newmoney' WHERE id='$id'");
echo "Congratulations! The city of " .$cityname. " has been founded!<br />";
$newcityCheck = mysql_query("SELECT * FROM `cities` WHERE name='$cityname' AND nation='$nation'");
$newcityFetch = mysql_fetch_array($newcityCheck);
echo "<br /><center><a href='index.php?id=8&cid=".$newcityFetch['id']."'>View New City</a></center>";
} else {
echo $error;
echo "<br /><br /><center><a href='index.php?id=9'>Back</a></center>";
}
} else {
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
//display form
?>
<center><img src="images/newcity.jpg"></center>
<br />
<form action="index.php?id=12" method="post">
As <?php echo stripslashes($title); ?> of the nation of <?php echo $nation; ?> you have chosen to construct a new settlement for your citizens to live in, expanding your borders and growing your nation as a whole. You have decided to name this new city <input type="text" maxlength="14" name="name">.
<br /><br />
Founding this new city will cost $<?php echo number_format($price); ?> and expand your land borders by 3,500 square kilometers.
<br /><br /><center><input type="submit" name="sent" value="Construct">
<br /><input type="hidden" name="token" value="<?php echo $token; ?>">
</center>
</form>
<?php
}
?>