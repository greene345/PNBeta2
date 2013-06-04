<div id="title">All Cities View</div>
<?php 
require("loggedin.php");
$result = mysql_query("SELECT COUNT(*) FROM `cities`");
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
$orderby = "population";
$ob = mysql_real_escape_string(htmlentities($_GET['ob']));
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$od = mysql_real_escape_string(htmlentities($_GET['od']));
if($ob == "pop") {
$orderby = "population";
} if($ob == "nat") {
$orderby = "nation";
} if($ob == "nam") {
$orderby = "name";
}

if($od == "asc") {
$order = "ASC";
} if($od == "desc") {
$order = "DESC";
} 
$natCheck = mysql_query("SELECT * FROM `cities` WHERE nation <> 'Sylthrim' AND nation <> 'The Dark Blade' AND nation <> 'Dorack' AND nation <> 'City Wok' AND nation <> 'Ausrotten' AND nation <> 'Egypt' AND nation <> 'Swedish Empire' AND nation <> 'Flubb Land' AND nation <> 'Texas' ORDER BY ". $orderby ." " .$order. " LIMIT " .$offset. ", " .$rowsperpage ." ");
?>
<table id="black"><tr id="black">
<td id="black" class="center"><b>City Name</b> <a href="index.php?id=11&od=asc&ob=nam&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=11&od=desc&ob=nam&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></td>
<td id="black" class="center"><b>Nation Name</b> <a href="index.php?id=11&od=asc&ob=nat&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=11&od=desc&ob=nat&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></td>
<td id="black" class="center"><b>Rank</b></td><td id="black" class="center"><b>Population <a href="index.php?id=11&od=asc&ob=pop&currentpage=<?php echo $currentpage; ?>"><img src="images/uparrow.png" class="middle"></a> <a href="index.php?id=11&od=desc&ob=pop&currentpage=<?php echo $currentpage; ?>"><img src="images/downarrow.png" class="middle"></a></b></td></tr>

<?php
$i = 1;
while($nCheck = mysql_fetch_array($natCheck)) {
$newpop = ($nCheck['residential']*$nCheck['residential']*49999)+500;
$cityRank = "Hamlet";
if($newpop >= 20000) {
$cityRank = "Village";
} if($newpop >= 100000) {
$cityRank = "Suburb";
} if($newpop >= 1000000) {
$cityRank = "Town";
} if($newpop >= 3000000) {
$cityRank = "City";
} if($newpop >= 1000000) {
$cityRank = "Metropolis";
}


$nat2Check = mysql_query("SELECT id FROM players WHERE nation='$nCheck[nation]'");
$nat2Fetch = mysql_fetch_array($nat2Check);
$nID = $nat2Fetch['id'];

echo "<tr id='black'><td id='black'>";
echo "<a href='index.php?id=8&cid=" .$nCheck['id']. "'>";
echo stripslashes($nCheck['name']);
echo "</a></td><td id='black'><a href='index.php?id=7&nid=".$nID."'>";
echo stripslashes($nCheck['nation']);
echo "</a></td><td id='black'>";
echo $cityRank; 
echo "</td><td id='black'>";
echo number_format($nCheck['population']);
echo "</td></tr>";
$i = $i+1;
}
echo "</table><br />";
echo "<center>";
if($currentpage > 1) {
echo " <a href='index.php?id=11&od=" .$od. "&ob=" .$ob. "&currentpage=1'>First</a> |";
} if($previous > 1) {
echo " <a href='index.php?id=11&od=" .$od. "&ob=" .$ob. "&currentpage=".$previous."'>Previous</a> |";
} echo " Page ".$currentpage." ";
if($next < $totalpages) {
echo "| <a href='index.php?id=11&od=" .$od. "&ob=" .$ob. "&currentpage=".$next."'>Next</a> ";
} if($currentpage < $totalpages) {
echo "| <a href='index.php?id=11&od=" .$od. "&ob=" .$ob. "&currentpage=".$totalpages."'>Last</a></center>";
}
?>