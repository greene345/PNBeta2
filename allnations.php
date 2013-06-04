<div id="title">World View</div>
<?php 
require("loggedin.php");

$result = mysql_query("SELECT COUNT(*) FROM `players`");
$r = mysql_fetch_row($result);
$numrows = $r[0];

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


$order = "DESC";
$orderby = "power";
$ob = mysql_real_escape_string(htmlentities($_GET['ob']));
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$od = mysql_real_escape_string(htmlentities($_GET['od']));
if($ob == "pow") {
$orderby = "power";
} if($ob == "nat") {
$orderby = "nation";
} if($ob == "usr") {
$orderby = "username";
} if($ob == "dat") {
$orderby = "date_reg";
}

if($od == "asc") {
$order = "ASC";
} if($od == "desc") {
$order = "DESC";
} 

//get nation rank
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


$natCheck = mysql_query("SELECT * FROM `players` ORDER BY ". $orderby ." " .$order. " LIMIT " .$offset. ", " .$rowsperpage ." ");

?>
<table id="black">
<tr id="black">
<td id="black" class="center"><b>Rank</b></td>
<td id="black" class="center"><b>Leader Name</b> <a href="index.php?id=10&od=asc&ob=usr&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=10&od=desc&ob=usr&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></td>
<td id="black" class="center"><b>Nation Name</b> <a href="index.php?id=10&od=asc&ob=nat&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=10&od=desc&ob=nat&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></td>
<td id="black" class="center"><b>Date Created</b> <a href="index.php?id=10&od=asc&ob=dat&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=10&od=desc&ob=dat&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></td>
<td id="black" class="center"><b>Alliance</b></td>
<td id="black" class="center"><b>Power <a href="index.php?id=10&od=asc&ob=pow&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=10&od=desc&ob=pow&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></b></td></tr>

<?php
$i = 1;
while($nCheck = mysql_fetch_array($natCheck)) {
if($nCheck['alliance'] != "None") {
$aSelect = mysql_query("SELECT id FROM alliances WHERE name='$nCheck[alliance]'");
$aFetch = mysql_fetch_array($aSelect);
$aID = $aFetch['id'];
}
echo "<tr id='black'><td id='black'> # ";
echo getUserRank($nCheck[power]);
echo "</td><td id='black'><a href='index.php?id=5&to=" .stripslashes($nCheck['username']). "'>";
echo stripslashes($nCheck['username']);
echo "</a></td><td id='black'><a href='index.php?id=7&nid=" .$nCheck['id']. "'>";
echo stripslashes($nCheck['nation']);
echo "</a></td><td id='black' class='center'>";
echo date("m/d/y",strtotime($nCheck['date_reg']));
echo "</td><td id='black'><a href='index.php?id=16&nid=".$aID."'>";
echo stripslashes($nCheck['alliance']); 
echo "</a></td><td id='black' class='right'>";
echo number_format($nCheck['power'],2);
echo "</td></tr>";
}
echo "</table><br />";
echo "<center>Showing ";
echo $offset;
echo "-";
echo $offset+$rowsperpage;
echo " Nations of ";
echo $numrows;
echo " Nations<br />";
if($currentpage > 1) {
echo " <a href='index.php?id=10&od=" .$od. "&ob=" .$ob. "&currentpage=1'>First</a> |";
} if($previous > 1) {
echo " <a href='index.php?id=10&od=" .$od. "&ob=" .$ob. "&currentpage=".$previous."'>Previous</a> |";
} echo " Page ".$currentpage." ";
if($next < $totalpages) {
echo "| <a href='index.php?id=10&od=" .$od. "&ob=" .$ob. "&currentpage=".$next."'>Next</a> ";
} if($currentpage < $totalpages) {
echo "| <a href='index.php?id=10&od=" .$od. "&ob=" .$ob. "&currentpage=".$totalpages."'>Last</a></center>";
}
?>
<center>
<table class="center"><form action="index.php" method="get">
<tr><td>Search for: <select name="type"><option value="username">Username</option><option value="nation">Nation</option><option value="alliance">Alliance</option><option value="war">War</option></select> Name: <input type="text" name="name"> <input type="submit" value="Go"></td></tr></table>
<input type="hidden" name="id" value="28">
</form></center>