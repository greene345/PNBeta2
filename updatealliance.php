<div id="title">Update Alliance Permissions</div>
<?php
 require("loggedin.php");
 $id = mysql_real_escape_string(htmlentities($_SESSION['id']));
 $userS = mysql_query("SELECT * FROM players WHERE id='$id'");
 $userF = mysql_fetch_array($userS);
 
 $alliance = $userF['alliance'];
 
 $aid = mysql_real_escape_string(htmlentities($_GET['aid']));
 $allS = mysql_query("SELECT * FROM alliances WHERE id='$aid'");
 $allN = mysql_num_rows($allS);
 $allF = mysql_fetch_array($allS);
 
 if(isset($_POST['submit'])) {
 
 $member = mysql_real_escape_string(htmlentities($_POST['member']));
 $permission = mysql_real_escape_string(htmlentities($_POST['permission']));
 
 $memC = mysql_query("SELECT * FROM players WHERE username='$member'");
 $memN = mysql_num_rows($memC);
 $memF = mysql_fetch_array($memC);
 
  if($allF['name'] != $alliance) {
 $error .= "Error02 - You are not in this alliance.<br />";
 } if($userF['alliancepos'] != "Founder") {
 $error .= "Error03 - You change permissions of others in this alliance because you are not a founder.<br />";
 } if($allF['founder'] == $userF['username']) {
 $error = null;
 } if($userF['username'] == "Admin") {
 $error = null;
 } if($allN != 1) {
 $error .= "Error01 - That alliance does not exist.<br />";
 } if($memN != 1) {
 $error .= "Error04 - You cannot remove that member because they do not exist.<br />";
 } if($memF['alliance'] != $allF['name']) {
 $error .= "Error05 - You cannot remove that member because they are not in your alliance.<br />";
 } if($memF['alliancepos'] == "Founder") {
 $error .= "Error06 - You cannot change that member because they are a Founder.<br />";
 } if($memF['alliance'] == $allF['name'] && $memF['alliancepos'] == "Founder" && $memF['username'] == $userF['username']) {
 $error = null;
 }
 
 if($permission != "Founder" AND $permission != "Agent" AND $permission != "Member" AND $permission != "Applicant") {
 $error .= "Error07 - There has been an unexpected error. Please go back and try again.<br />";
 }
 
 if($error == null) {
 mysql_query("UPDATE players SET alliance='$alliance', alliancepos='$permission' WHERE username='$member'");
 echo "The player ".$member." has successfully been given ".$permission." permissions.";
 } else {
 echo "<p>You have received the following error(s):</p>";
 echo $error;
 }
 } else {
 echo "<p>If you want to update the permissions of a member of your alliance, you can do so here. Note, you must have Founder permissions to make other Founders and Agents.</p>";
 echo "<form action='index.php?id=81&aid=".$allF['id']."' method='post'><center>Player Username: <input type='text' name='member' required><br />Permissions: <select name='permission'><option value='Applicant'>Applicant</option><option value='Member'>Member</option><option value='Agent'>Agent</option><option value='Founder'>Founder</option></select><br /><input type='submit' name='submit' value='Update Permissions'></form></center>";
 }
 ?>