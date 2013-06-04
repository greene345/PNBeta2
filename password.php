<?php
$password = "noblesix";
$salt = "oLLy16jeeerKy84";
$password = md5($salt.$password);
echo $password;
?>