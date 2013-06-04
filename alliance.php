<div id="title">Alliance View</div>
<?php 
require("loggedin.php");
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userCheck = mysql_query("SELECT * FROM `players` WHERE id='$id'");
$userFetch = mysql_fetch_array($userCheck);
$alliance = $userFetch['alliance'];
if($alliance != "None") {
$allianceCheck = mysql_query("SELECT * FROM alliances WHERE name='$alliance'");
$allianceFetch = mysql_fetch_array($allianceCheck);
$diff1 = abs(strtotime($allianceFetch['date']) - strtotime(date(c)));
$days1 = round($diff1/60/60/24);
$diff = abs(strtotime($userFetch['join_date']) - strtotime(date(c)));
$days = round($diff/60/60/24);
echo "<table id='black'><tr id='black'><td id='black' class='center' colspan='4'><b>My Alliance</b></td></tr>
<tr id='black'><td id='black'><b>Name:</b></td><td id='black'><a href='index.php?id=16&nid=".$allianceFetch['id']."'>" .$alliance. "</a></td><td id='black'><b>Founder:</b></td><td id='black'>".$allianceFetch['founder']."</td></tr>
<tr id='black'><td id='black'><b>Age:</b></td><td id='black'>" .number_format($days1). " days</td><td id='black'><b>Seniority:</b></td><td id='black'>".number_format($days)." days</td></tr>
<tr id='black'><td id='black'><b>Members:</b></td><td id='black'>" .number_format($allianceFetch['members']). "</td><td id='black'><b>Power:</b></td><td id='black'>".number_format($allianceFetch['power'])."</td></tr>
</table><br /><center><a href='index.php?id=14'>Leave Alliance</a> | <a href='index.php?id=98'>Alliance Bank</a></center>";
} else {
echo "<center><a href='index.php?id=18'>Create Alliance</a> | <a href='index.php?id=15'>View All Alliances</a></center>";
}
?>
<hr>
<?php
if($_GET['display'] != "chart") {
?>
<table id='black'><tr><td id='black' class='center' colspan='6'><b>Top 10 Alliances</b> | <a href='index.php?id=13&display=chart'>Chart</a></td></tr>
<tr id='black'><td id='black' class='center'><b>Rank</b></td><td id='black' class='center'><b>Name</b></td><td id='black' class='center'><b>Age</b></td><td id='black' class='center'><b>Members</b></td><td id='black' class='center'><b>Average Power</b></td><td id='black' class='center'><b>Power</b></td></tr>
<?php
$top10check = mysql_query("SELECT * FROM alliances ORDER BY power DESC LIMIT 0,10");
$i = 1;
while($fetch10 = mysql_fetch_array($top10check)) {
$diff = abs(strtotime($fetch10['date']) - strtotime(date(c)));
$days = round($diff/60/60/24);
echo "<tr id='black'><td id='black'># ".$i."<td id='black'><a href='index.php?id=16&nid=".$fetch10['id']."'>".$fetch10['name']."</a></td><td id='black' class='right'>".$days." days old</td><td id='black' class='right'>".$fetch10['members']."</td><td id='black' class='right'>".number_format($fetch10['power']/$fetch10['members'],2)."<td id='black' class='right'>".number_format($fetch10['power'],2)."</td></tr>";
$i = $i+1;
}
?>
</table>
<?php
} if($_GET['display'] == "chart") {
$top10check = mysql_query("SELECT * FROM alliances ORDER BY power DESC LIMIT 0,10");
$statrows = mysql_num_rows($top10check);
$countrows = 0;
echo "<p style='text-align:center;'><a href='index.php?id=13'>Table</a></p>";
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Alliance', 'Power', 'Average Power', 'Members'],
		  <?php
		  while($fetch10 = mysql_fetch_array($top10check)) {
          echo "['".$fetch10['name']."', ".round($fetch10['power'],2).", ".round($fetch10['power']/$fetch10['members'],2).", ".$fetch10['members']."]";
		  $countrows = $countrows+1;
		  if($countrows < $statrows) {
		  echo ",";
		  }
		  }
		  ?>
        ]);

        var options = {
          title: 'Alliance Ranking',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<div id="chart_div" style="width: 900px; height: 500px;"></div>
<?php
}
?>