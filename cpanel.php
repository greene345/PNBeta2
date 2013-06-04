<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$idcheck = mysql_query("SELECT * FROM players WHERE id='$id'");
$idfetch = mysql_fetch_array($idcheck);
$level = $idfetch['level'];
if($level < 2) {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=7">';
die();
}
?>
<div id="title">Control Panel</div>
<?php 
if($level > 1) {
?>
<h1>Normal Tools</h1>
<a href="index.php?id=78">Delete Player</a><br />
<a href="index.php?id=60">Reset Player</a><br />
<a href="index.php?id=92">Manage Banned Players</a><br />
<a href="index.php?id=95">Suspend Player</a><br />
<?php
} if($level > 2) {
?>
<h1>Advanced Tools</h1>
<a href="index.php?id=93">Edit Nation</a><br />
<a href="index.php?id=94">Manage Suspended Players</a><br />
<?php
} if($level > 3) {
?>
<h1>Admin Tools</h1>
<a href="index.php?id=96">Manage Moderators</a><br />
<?php
}
?>