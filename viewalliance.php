<div id="title">Alliance View</div>
<?php
$gid = mysql_real_escape_string(htmlentities(trim($_GET['nid'])));
if($gid == null) {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
} else {
if(is_numeric($gid)) {
$gidCheck = mysql_query("SELECT * FROM alliances WHERE id='$gid'");
$gidNum = mysql_num_rows($gidCheck);
if($gidNum == 1) {
$id = $gid;
} else {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
}
} else {
echo '<meta http-equiv="REFRESH" content="0;url=index.php?id=13">';
}
}
$userCheck = mysql_query("SELECT * FROM alliances WHERE id='$id'");
$aF = mysql_fetch_array($userCheck);
$alliance = $aF['name'];



function getUserRank($id){
$sql1 = "SET @rownum := 0";
$sql2 = "SELECT rank, power FROM (
                    SELECT @rownum := @rownum + 1 AS rank, power, id
                    FROM alliances ORDER BY power DESC
                    ) as result WHERE id='$id'";

        mysql_query($sql1); /*as mysql_query function can execute one query at a time */
        $result = mysql_query($sql2);
        $rows = '';
        $data = array();
        if (!empty($result))
            $rows      =  mysql_num_rows($result);
        else
            $rows      =  '';
 
        if (!empty($rows)){
            while ($rows = mysql_fetch_assoc($result)){
                $data[]   = $rows;
            }
        }
 
        //rank of the user
        if (empty($data[0]['rank']))
            return 1;
        return $data[0]['rank'];
}
$rank = getUserRank($id);

$aliCheck = mysql_query("SELECT * FROM players WHERE alliance='$aF[name]' AND alliancepos <> 'Applicant'");
$members = mysql_num_rows($aliCheck);
while($cCheck = mysql_fetch_array($aliCheck)) {
$power = round($power+$cCheck['power'],2);
$soldiers = $soldiers+$cCheck['soldiers']+$cCheck['paratrooper']+$cCheck['snipers'];
$tanks = $tanks+$cCheck['nomad']+$cCheck['maverick']+$cCheck['longhorn'];
$fighters = $fighters+$cCheck['fighterjets']+$cCheck['sam']+$cCheck['bomber']+$cCheck['interceptor'];
$battleships = $battleships+$cCheck['battleships']+$cCheck['subs']+$cCheck['carriers']+$cCheck['destroyers'];
$bmissiles = $bmissiles+$cCheck['bmissiles'];
//nukes
$nukeC = mysql_query("SELECT * FROM nukes WHERE nation='$cCheck[nation]'");
$nukeN = mysql_num_rows($nukeC);
$nukes = $nukes+$nukeN;
}
//check stats
$statdate = date("Y-m-d");
$checkforstats = mysql_query("SELECT * FROM stats WHERE type='alliance' AND name='$alliance' AND date='$statdate'");
if(mysql_num_rows($checkforstats) == 1) {
mysql_query("UPDATE stats SET power='$power' WHERE type='alliance' AND name='$alliance' AND date='$statdate'");
} if(mysql_num_rows($checkforstats) == 0) {
mysql_query("INSERT INTO stats (date, name, type, power) VALUES ('$statdate', '$alliance', 'alliance', '$power')");
}
if($aF['name'] == "PN") {
$power = 1;
}
$userID = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userS = mysql_query("SELECT * FROM players WHERE id='$userID'");
$userF = mysql_fetch_array($userS);
//update power
mysql_query("UPDATE alliances SET power='$power', members='$members' WHERE id='$id'");
if($aF['neutral'] == 1) {
$neutral = "(Neutral Alliance)";
}
echo "<center><img src='images/flags/".$aF['flag']."'><br /><b>".$aF['name']."</b><br /><i>".stripslashes($aF['phrase'])." ".$neutral."</i><br /><a href='index.php?id=28&type=alliance&name=".$aF['name']."'>View Nations</a> | <a href='index.php?id=97&alliance=".$aF['name']."'>View Wars</a>";
if($aF['name'] == $userF['alliance']) {
echo " | <a href='index.php?id=98'>Bank</a>";
}
echo "</center><hr>";
?>
<table id="black">
<tr id="black"><td id="black" class="center"><b>Rank</b></td><td id="black" class="center"><b>Creator</b></td><td id="black" class="center"><b>Members</b></td><td id="black" class="center"><b>Minimum Power</b></td><td id="black" class="center"><b>Average Power</b></td><td id="black" class="center"><b>Power</b></td></tr>
<tr id="black"><td id="black" class="center"> # <?php echo $rank; ?></td><td id="black" class="center"><?php echo $aF['founder']; ?></td><td id="black" class="right"><?php echo number_format($members); ?></td><td id="black" class="right"><?php echo number_format($aF['min_power']); ?></td><td id="black" class="right"><?php echo number_format($power/$members); ?></td><td id="black" class="right"><?php echo number_format($power,2); ?></td></tr>
<tr id="black"><td id="black" class="center"><b>Infantry</b></td><td id="black" class="center"><b>Vehicles</b></td><td id="black" class="center"><b>Aircraft</b></td><td id="black" class="center"><b>Navy</b></td><td id="black" class="center"><b>Ballistic Missiles</b></td><td id="black" class="center"><b>Nuclear Weapons</b></td></tr>
<tr id="black"><td id="black" class="right"><?php echo number_format($soldiers); ?></td><td id="black" class="right"><?php echo number_format($tanks); ?></td><td id="black" class="right"><?php echo number_format($fighters); ?></td><td id="black" class="right"><?php echo number_format($battleships); ?></td><td id="black" class="right"><?php echo number_format($bmissiles); ?></td><td id="black" class="right"><?php echo number_format($nukes); ?></td></tr>
</table>
<br />
<center>
<?php
if($aF['irc'] != null) {
echo "<a href='".stripslashes($aF['irc'])."'>IRC Channel</a> | ";
}
echo "<a href='http://pixelnations.referata.com/wiki/".$aF['name']."'>Wiki</a> ";
if($aF['forums'] != null) {
echo "| <a href='".stripslashes($aF['forums'])."'>Offsite Forums</a>";
}
?>
</center>
<br />
<b>About <?php echo $aF['name']; ?></b><hr>
<?php echo stripslashes($aF['about']); ?><br /><br />
<b>Founders:</b> <?php
$foundercheck = mysql_query("SELECT * FROM players WHERE alliance='$aF[name]' AND alliancepos='Founder'");
$agentcheck = mysql_query("SELECT * FROM players WHERE alliance='$aF[name]' AND alliancepos='Agent'");
while($founderRow = mysql_fetch_array($foundercheck)) {
echo " <a href='index.php?id=7&nid=".$founderRow['id']."'>".$founderRow['username']."</a> ";
}
?> <b>Agents:</b> <?php
while($agentRow = mysql_fetch_array($agentcheck)) {
echo " <a href='index.php?id=7&nid=".$agentRow['id']."'>".$agentRow['username']."</a> ";
}
?><br /><br />
<center>
<?php

if($userF['alliance'] != $aF['name']) {
echo '<a href="index.php?id=17&aid='.$aF[id].'">Join Alliance</a>';
}
if($userF['alliance'] == $aF['name']) {
if($userF['alliancepos'] == "Agent" OR $userF['alliancepos'] == "Founder") {
echo "<a href='index.php?id=33&aid=".$aF['id']."'>Edit Alliance</a> | <a href='index.php?id=99'>Mass Message to All Alliance Members</a><br /><hr>";
echo "</center><p>If you want to remove a member from your alliance, you may do so. Note that you must have Agent or Founder permissions to remove a member from your alliance.</p>";
echo "<form action='index.php?id=80&aid=".$aF['id']."' method='post'><center>Member to Remove<br /><input type='text' name='member' required><br /><input type='submit' name='submit' value='Remove Member'></form></center>";
}
if($userF['alliancepos'] == "Founder") {
 echo "<hr><p>If you want to update the permissions of a member of your alliance, you can do so here. Note, you must have Founder permissions to make other Founders and Agents.</p>";
 echo "<form action='index.php?id=81&aid=".$aF['id']."' method='post'><center>Player Username: <input type='text' name='member' required><br />Permissions: <select name='permission'><option value='Applicant'>Applicant</option><option value='Member'>Member</option><option value='Agent'>Agent</option><option value='Founder'>Founder</option></select><br /><input type='submit' name='submit' value='Update Permissions'></form></center>";
 echo "<br /><b>Applicants:</b> ";
 $applicantcheck = mysql_query("SELECT * FROM players WHERE alliance='$aF[name]' AND alliancepos='Applicant'");
 while($approw = mysql_fetch_array($applicantcheck)) {
echo "<a href='index.php?id=7&nid=".$approw['id']."'>".$approw['username']."</a> ";
}
 }
 }
 //get stats
// old query $getstats = mysql_query("SELECT * FROM stats WHERE type='alliance' AND name='$alliance' ORDER BY date ASC LIMIT 30");
$getstats = mysql_query("select *
from (
   select *
   from `stats`
   where type='alliance' AND name='$alliance'
   order by `date` DESC
   limit 30
) as source
order by `id` ASC");
$statrows = mysql_num_rows($getstats);
$countrows = 0;
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Power'],
		  <?php
		while($rstats = mysql_fetch_array($getstats)) {
          echo "['".$rstats['date']."', ".$rstats['power']."]";
		  $countrows = $countrows+1;
		  if($countrows < $statrows) {
		  echo ",";
		  }
		  }
		  ?>
        ]);

        var options = {
          title: '30 Day Alliance Growth',
		  colors:['red','#004411']
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<div id="chart_div" style="width: 900px; height: 500px;"></div>

</center>