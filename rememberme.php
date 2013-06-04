<?php
//remember me
$userIP = mysql_real_escape_string(htmlentities($_SERVER['REMOTE_ADDR']));
if(!isset($_SESSION['id'])) {
$remembermeCheck = mysql_query("SELECT id, last_login FROM players WHERE loginip='$userIP'");
if(mysql_num_rows($remembermeCheck) == 1) {
$remembermeFetch = mysql_fetch_array($remembermeCheck);
$diff = abs(strtotime($remembermeFetch['last_login']) - strtotime(date(c)));
$days = round($diff/60/60/24);
if($days < 7) {
$_SESSION['id'] = $remembermeFetch['id'];
}
}
}