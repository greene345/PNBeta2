<div id="title">Affairs</div>
<img src="images/affairs.jpg" class="center"><br />
Below you will be able to see all of your recent Affairs and make judgement calls and decisions that will affect your nation.<br /><br />
<?php
require("loggedin.php");
$id = $_SESSION['id'];
$userS = mysql_query("SELECT * FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userS);
$username = $userF['username'];