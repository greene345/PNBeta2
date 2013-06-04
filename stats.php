<div id="title">Pixel Nations Statistics</div>
<?php
$playerC = mysql_query("SELECT COUNT(*) FROM players");
$playerF = mysql_fetch_array($playerC);
$nations = $playerF[0];
$cityC = mysql_query("SELECT land, population FROM cities");
$cities = mysql_num_rows($cityC);
$allianceC = mysql_query("SELECT COUNT(*) FROM alliances");
$allianceF = mysql_fetch_array($allianceC);
$alliances = $allianceF[0];
$nukeC = mysql_query("SELECT COUNT(*) FROM nukes");
$nukeF = mysql_fetch_array($nukeC);
$nukes = $nukeF[0];
$totalp = mysql_query("SELECT id FROM players ORDER BY id DESC LIMIT 1");
$totalf = mysql_fetch_array($totalp);
$totalnations = $totalf['id'];
$peacecheck = mysql_query("SELECT id FROM players WHERE readiness='peace'");
$peacenations = mysql_num_rows($peacecheck);
$warnations = $nations-$peacenations;

//resources
$rubber = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Rubber'"));
$coal = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Coal'"));
$cod = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Cod'"));
$corn = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Corn'"));
$timber = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Timber'"));
$cotton = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Cotton'"));
$copper = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Copper'"));
$iron = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Iron'"));
$oil = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Crude Oil'"));
$water = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Fresh Water'"));
$chickens = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Chickens'"));
$composite = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Composite'"));
$silver = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Silver'"));
$gold = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Gold'"));
$gems = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Gems'"));
$coffee = mysql_num_rows(mysql_query("SELECT id FROM cities WHERE resource='Coffee Beans'"));
?>
<table id='black'>
<tr id='black'><td>Nations:</td><td><?php echo number_format($nations); ?></td></tr>
<tr id='black'><td>Cities:</td><td><?php echo number_format($cities); ?></td></tr>
<tr id='black'><td>Alliances:</td><td><?php echo number_format($alliances); ?></td></tr>
<tr id='black'><td>Global Amount of Nuclear Weapons:</td><td><?php echo number_format($nukes); ?></td></tr>
<tr id='black'><td>Total Nations Ever Signed Up:</td><td><?php echo number_format($totalnations); ?></td></tr>
</table>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Setting', 'Nations'],
          ['Peaceful',     <?php echo $peacenations; ?>],
          ['Wargoing',     <?php echo $warnations; ?>]
        ]);

        var options = {
          title: 'Peaceful vs Wargoing Nations'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

<div id="chart_div" style="width: 900px; height: 500px;"></div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Resource', 'Cities'],
          ['Rubber',     <?php echo $rubber; ?>],
          ['Coal',     <?php echo $coal; ?>],
		  ['Cod',     <?php echo $cod; ?>],
          ['Corn',     <?php echo $corn; ?>],
		  ['Timber',     <?php echo $timber; ?>],
          ['Cotton',     <?php echo $cotton; ?>],
		  ['Copper',     <?php echo $copper; ?>],
          ['Iron',     <?php echo $iron; ?>],
		  ['Composite',     <?php echo $composite; ?>],
          ['Crude Oil',     <?php echo $oil; ?>],
		  ['Fresh Water',     <?php echo $water; ?>],
          ['Chickens',     <?php echo $chickens; ?>],          
		  ['Silver',     <?php echo $silver; ?>],
          ['Gold',     <?php echo $gold; ?>],
		  ['Gems',     <?php echo $gems; ?>],
          ['Coffee Beans',     <?php echo $coffee; ?>]
        ]);

        var options = {
          title: 'Resource Distribution'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>

<div id="chart_div2" style="width: 900px; height: 500px;"></div>

