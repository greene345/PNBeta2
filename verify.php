<div id="title">Account Validation</div>
<?php
if(isset($_GET['val'])) {
$val = mysql_real_escape_string(htmlentities($_GET['val']));
if(!is_numeric($val)) {
$error .= "Error001 - There was an error validating your account. Try <a href='index.php?id=1'>logging in</a>.<br />";
} if(strlen($val) != 8) {
$error .= "Error003 - There was an error validating your account. Try <a href='index.php?id=1'>logging in</a>.<br />";
} 
if($error == null) {
$verCheck = mysql_query("SELECT * FROM players WHERE verify='$val'");
$verNum = mysql_num_rows($verCheck);
if($verNum == 1) {
mysql_query("UPDATE players SET verify='0' WHERE verify='$val'");
echo "Congratulations! Your account has been successfully validated. You may now <a href='index.php?id=1'>log in</a>.<br />";
} else {
$error .= "Error004 - Your account has already been validated or you did not go to the correct link. Try <a href='index.php?id=1'>logging in</a>. If you still cannot log in, please go back to your e-mail and try clicking the link again.<br />";
} echo $error;
} else {
echo $error;
}
} else {
echo "Error002 - There was an error validating your account. Try <a href='index.php?id=1'>logging in</a>.<br />";
}
?>