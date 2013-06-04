<div id="title">Search</div>
<table class="center"><form action="index.php" method="get">
<tr><td>Search for: <select name="type"><option value="username">Username</option><option value="nation">Nation</option><option value="alliance">Alliance</option><option value="war">War</option><option value="gift">Shipment</option></select> Name: <input type="text" name="name"> <input type="submit" value="Go"></td></tr></table>
<input type="hidden" name="id" value="28">
</form>
<?php
if(isset($_GET['type']) && isset($_GET['name'])) {
$type = mysql_real_escape_string(htmlentities($_GET['type']));
$name = mysql_real_escape_string(htmlentities($_GET['name']));
$ob = mysql_real_escape_string(htmlentities($_GET['ob']));
$od = mysql_real_escape_string(htmlentities($_GET['od']));

$orderby = "power";
if($ob == "pow") {
$orderby = "power";
} if($ob == "nat") {
$orderby = "nation";
} if($ob == "usr") {
$orderby = "username";
} if($ob == "dat") {
$orderby = "date_reg";
} if($ob == "wdat") {
$orderby = "start_date";
} if($ob == "att") {
$orderby = "attacker";
} if($ob == "def") {
$orderby = "defender";
} if($ob == "sen") {
$orderby = "sender";
} if($ob == "rec") {
$orderby = "receiver";
} if($ob == "mon") {
$orderby = "money";
} if($ob == "sol") {
$orderby = "soldiers";
} if($ob == "adat") {
$orderby = "date";
} if($ob == "dat" AND $type == "alliance") {
$orderby = "join_date";
}

$order = "DESC";
if($od == "asc") {
$order = "ASC";
} if($od == "desc") {
$order = "DESC";
} 

if($type != "alliance" && $type != "username" && $type != "nation" && $type != "war" && $type != "gift") {
$type = "nation";
}
$pattern = '/^([A-Za-zÀ-ÖØ-Þà-öø-ÿ](([A-Za-zÀ-ÖØ-öø-ÿ0-9]*[\'-]?)*[A-Za-zÀ-ÖØ-öø-ÿ0-9]+)*\\.?)( [A-Za-zÀ-ÖØ-Þà-öø-ÿ0-9](([A-Za-zÀ-ÖØ-öø-ÿ0-9]*[\'-]?)*[A-Za-zÀ-ÖØ-öø-ÿ0-9]+)*\\.?)*$/';
if(!preg_match($pattern, $name)) {
$error = "<br /><center>No results. Try again?</center><br /><br />";
}

if($error == null) {
if($type == "username" OR $type == "nation" OR $type == "alliance") {
$table = "players";
$selectS = mysql_query("SELECT * FROM players WHERE $type LIKE '%".$name."%'");
} if($type == "war") {
$table = "wars";
$selectS = mysql_query("SELECT * FROM wars WHERE defender='$name' OR attacker='$name'");
} if($type == "gift") {
$table = "aid";
$selectS = mysql_query("SELECT * FROM aid WHERE sender LIKE '%".$name."%' OR receiver LIKE '%".$name."%'");
} if($type == "alliance") {
$selectS = mysql_query("SELECT * FROM players WHERE $type LIKE '%".$name."%' AND alliancepos <> 'Applicant'");
}

$numrows = mysql_num_rows($selectS);

// number of rows to show per page
$rowsperpage = 15;
// find out total pages
$totalpages = ceil($numrows / $rowsperpage);

// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   // cast var as int
   $currentpage = (int) $_GET['currentpage'];
} else {
   // default page num
   $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   // set current page to last page
   $currentpage = $totalpages;
} // end if
// if current page is less than first page...
if ($currentpage < 1) {
   // set current page to first page
   $currentpage = 1;
} // end if

// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;
// previous page
$previous = ($currentpage - 1);
// next page
$next = ($currentpage + 1);

if($numrows < 1) {
$error = "<br /><center>No results. Try again?</center><br /><br />";
}
if($error == null) {
if($table == "players") {
$selectS = mysql_query("SELECT * FROM players WHERE ".$type." LIKE '%".$name."%' ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$rowsperpage." ");
if($type == "alliance") {
//for applicants to alliances
$selectS = mysql_query("SELECT * FROM players WHERE ".$type." LIKE '%".$name."%' AND alliancepos <> 'Applicant' ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$rowsperpage." ");
}
function getUserRank($power){
$sql1 = "SET @rownum := 0";
$sql2 = "SELECT rank, power FROM (
                    SELECT @rownum := @rownum + 1 AS rank, power, id
                    FROM `players` ORDER BY power DESC
                    ) as result WHERE power='$power'";
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
if($type == "alliance") {
$datetype = "Join Date";
} else {
$datetype = "Date Created";
}
echo "<table id='black'><tr id='black'><td id='black' class='center'><b>Rank</b></td>
<td id='black' class='center'><b>Username</b> <a href='index.php?id=28&od=asc&ob=usr&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=usr&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Nation Name</b> <a href='index.php?id=28&od=asc&ob=nat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=nat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>".$datetype."</b> <a href='index.php?id=28&od=asc&ob=dat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=dat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Alliance</b></td>
<td id='black' class='center'><b>Power</b> <a href='index.php?id=28&od=asc&ob=pow&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=pow&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td></tr>";
while($sRow = mysql_fetch_array($selectS)) {
$aSelect = mysql_query("SELECT id FROM alliances WHERE name='$sRow[alliance]'");
$aFetch = mysql_fetch_array($aSelect);
$aID = $aFetch['id'];
$alliance = $sRow['alliance'];
if($type == "alliance") {
$listdate = date("m/d/y",strtotime($sRow['join_date']));
} else {
$listdate = date("m/d/y",strtotime($sRow['date_reg']));
}
if($alliance == "None") {
$alliance = "</a>None<a href='#'>";
$listdate = date("m/d/y",strtotime($sRow['date_reg']));
}
echo "<tr id='black'><td id='black'># ".getUserRank($sRow['power'])." </td><td id='black'><a href='index.php?id=5&to=".$sRow['username']."'>".$sRow['username']."</a></td><td id='black'><a href='index.php?id=7&nid=".$sRow['id']."'>".$sRow['nation']."</a> (".ucfirst($sRow['readiness']).")</td><td id='black' class='center'>".$listdate."</td><td id='black'><a href='index.php?id=16&nid=".$aID."'>".$alliance."</a></td><td id='black' class='right'>".number_format($sRow['power'],2)."</td></tr>";
}
echo "</table>";

}
if($table == "wars") {
if($orderby == "power") {
$orderby = "start_date";
}
$alliance = mysql_real_escape_string(htmlentities($_GET['alliance']));
if($alliance != null) {
echo "<table id='black'><tr id='black'>
<td id='black' class='center'><b>Attacker</b> <a href='index.php?id=28&od=asc&ob=att&currentpage=".$currentpage."&name=admin&type=".$type."&alliance=".$alliance."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=att&currentpage=".$currentpage."&name=admin&type=".$type."&alliance=".$alliance."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Defender</b> <a href='index.php?id=28&od=asc&ob=def&currentpage=".$currentpage."&name=admin&type=".$type."&alliance=".$alliance."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=def&currentpage=".$currentpage."&name=admin&type=".$type."&alliance=".$alliance."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Date Started</b> <a href='index.php?id=28&od=asc&ob=wdat&currentpage=".$currentpage."&name=admin&type=".$type."&alliance=".$alliance."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=wdat&currentpage=".$currentpage."&name=admin&type=".$type."&alliance=".$alliance."'><img src='images/downarrow.png' class='middle'></a></td></tr>";
$afetchid = mysql_query("SELECT username FROM players WHERE alliance='$alliance'");
while($nameFetch = mysql_fetch_array($afetchid)) {
$name = $nameFetch['username'];
$selectS = mysql_query("SELECT attacker, defender, start_date FROM wars WHERE defender='$name' OR attacker='$name' ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$rowsperpage." ");

while($sRow = mysql_fetch_array($selectS)) {
$defs = mysql_query("SELECT id, nation, alliance FROM players WHERE username='$sRow[defender]'");
$deff = mysql_fetch_array($defs);
$atts = mysql_query("SELECT id, nation, alliance FROM players WHERE username='$sRow[attacker]'");
$attf = mysql_fetch_array($atts);
echo "<tr id='black'><td id='black' class='center'>".$sRow['attacker']."<br /><a href='index.php?id=7&nid=".$attf['id']."'>".$attf['nation']."</a><br />".$attf['alliance']."</td><td id='black' class='center'>".$sRow['defender']."<br /><a href='index.php?id=7&nid=".$deff['id']."'>".$deff['nation']."</a><br />".$deff['alliance']."</td><td id='black' class='center'>".date("m/d/y",strtotime($sRow['start_date']))."</td></tr>";
}
}
} if($alliance == null) {
$selectS = mysql_query("SELECT attacker, defender, start_date FROM wars WHERE defender='$name' OR attacker='$name' ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$rowsperpage." ");
echo "<table id='black'><tr id='black'>
<td id='black' class='center'><b>Attacker</b> <a href='index.php?id=28&od=asc&ob=att&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=att&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Defender</b> <a href='index.php?id=28&od=asc&ob=def&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=def&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Date Started</b> <a href='index.php?id=28&od=asc&ob=wdat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=wdat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td></tr>";

while($sRow = mysql_fetch_array($selectS)) {
$defs = mysql_query("SELECT id, nation FROM players WHERE username='$sRow[defender]'");
$deff = mysql_fetch_array($defs);
$atts = mysql_query("SELECT id, nation FROM players WHERE username='$sRow[attacker]'");
$attf = mysql_fetch_array($atts);
echo "<tr id='black'><td id='black' class='center'>".$sRow['attacker']."<br /><a href='index.php?id=7&nid=".$attf['id']."'>".$attf['nation']."</a></td><td id='black' class='center'>".$sRow['defender']."<br /><a href='index.php?id=7&nid=".$deff['id']."'>".$deff['nation']."</a></td><td id='black' class='center'>".date("m/d/y",strtotime($sRow['start_date']))."</td></tr>";
}
}

echo "</table>";

}
if($table == "aid") {
if($orderby == "power") {
$orderby = "date";
}
$selectS = mysql_query("SELECT * FROM aid WHERE sender LIKE '%".$name."%' OR receiver LIKE '%".$name."%' ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$rowsperpage." ");

echo "<table id='black'><tr id='black'>
<td id='black' class='center'><b>Sender</b> <a href='index.php?id=28&od=asc&ob=sen&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=sen&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Receiver</b> <a href='index.php?id=28&od=asc&ob=rec&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=rec&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Date Sent</b> <a href='index.php?id=28&od=asc&ob=adat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=adat&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Money</b> <a href='index.php?id=28&od=asc&ob=mon&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=mon&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Soldiers</b> <a href='index.php?id=28&od=asc&ob=sol&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/uparrow.png' class='middle'></a> <a href='index.php?id=28&od=desc&ob=sol&currentpage=".$currentpage."&name=".$name."&type=".$type."'><img src='images/downarrow.png' class='middle'></a></td>
<td id='black' class='center'><b>Resources</b></td></tr>";
while($sRow = mysql_fetch_array($selectS)) {
$defs = mysql_query("SELECT id, nation FROM players WHERE username='$sRow[receiver]'");
$deff = mysql_fetch_array($defs);
$atts = mysql_query("SELECT id, nation FROM players WHERE username='$sRow[sender]'");
$attf = mysql_fetch_array($atts);
echo "<tr id='black'><td id='black' class='center'>".$sRow['sender']."<br /><a href='index.php?id=7&nid=".$attf['id']."'>".$attf['nation']."</a></td><td id='black' class='center'>".$sRow['receiver']."<br /><a href='index.php?id=7&nid=".$deff['id']."'>".$deff['nation']."</a></td><td id='black' class='center'>".date("m/d/y",strtotime($sRow['date']))."</td><td id='black' class='center'>$".number_format($sRow['money'])."</td><td id='black' class='center'>".number_format($sRow['soldiers'])."</td><td id='black' class='center'>".number_format($sRow['resources'])."</td></tr>";
}
echo "</table>";

}
} else {
echo $error;
}
} else {
echo $error;


}
echo "<center>Showing ";
echo $offset;
echo "-";
echo $offset+$rowsperpage;
echo " Results of ";
echo $numrows;
echo " Results<br />";
if($currentpage > 1) {
echo " <a href='index.php?id=28&od=" .$od. "&ob=" .$ob. "&currentpage=1&name=".$name."&type=".$type."'>First</a> |";
} if($previous > 1) {
echo " <a href='index.php?id=28&od=" .$od. "&ob=" .$ob. "&currentpage=".$previous."&name=".$name."&type=".$type."'>Previous</a> |";
} echo " Page ".$currentpage." ";
if($next < $totalpages) {
echo "| <a href='index.php?id=28&od=" .$od. "&ob=" .$ob. "&currentpage=".$next."&name=".$name."&type=".$type."'>Next</a> ";
} if($currentpage < $totalpages) {
echo "| <a href='index.php?id=28&od=" .$od. "&ob=" .$ob. "&currentpage=".$totalpages."&name=".$name."&type=".$type."'>Last</a></center>";
}
}

?>