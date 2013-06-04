<div id="title">Remove Members from Alliance</div>
<?php
 require("loggedin.php");
 $id = mysql_real_escape_string(htmlentities($_SESSION['id']));
 $userS = mysql_query("SELECT * FROM players WHERE id='$id'");
 $userF = mysql_fetch_array($userS);
 
 $alliance = $userF['alliance'];
 $joindate = $userF['join_date'];
 
 $aid = mysql_real_escape_string(htmlentities($_GET['aid']));
 $allS = mysql_query("SELECT * FROM alliances WHERE id='$aid'");
 $allN = mysql_num_rows($allS);
 $allF = mysql_fetch_array($allS);
 
 if(isset($_POST['submit'])) {
 
 $member = mysql_real_escape_string(htmlentities($_POST['member']));
 
 $memC = mysql_query("SELECT * FROM players WHERE username='$member'");
 $memN = mysql_num_rows($memC);
 $memF = mysql_fetch_array($memC);
 
  if($allF['name'] != $alliance) {
 $error .= "Error02 - You are not in this alliance.<br />";
 } if($userF['alliancepos'] != "Agent" AND $userF['alliancepos'] != "Founder") {
 $error .= "Error03 - You cannot remove members from this alliance because you are not an Agent or a Founder.<br />";
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
 } if($memF['alliancepos'] == "Agent" AND $userF['alliancepos'] != "Founder") {
 $error .= "Error06 - You cannot remove that member because they are an Agent.<br />";
 } if($memF['alliancepos'] == "Founder") {
 $error .= "Error07 - You cannot remove that member because they are a Founder.<br />";
 } if($userF['alliance'] != $memF['alliance']) {
 $error .= "Error08 - That member is not in the same alliance as you.<br />";
 }
 
 if($error == null AND $_POST['submit'] == "Remove Member") {
 mysql_query("UPDATE players SET alliance='None', alliancepos='None' WHERE username='$member'");
 echo "The player ".$member." has successfully been removed from ".$alliance.".";
 } else {
 echo "<p>You have received the following error(s):</p>";
 echo $error;
 }
 } else {
 echo "<p>If you want to remove a member from your alliance, you may do so. Note that you must have Agent or Founder permissions to remove a member from your alliance.</p>";
 echo "<form action='index.php?id=80&aid=".$allF['id']."' method='post'><center>Member to Remove<br /><input type='text' name='member' required><br /><input type='submit' name='submit' value='Remove Member'></form></center>";
 }
 ?>