<?php
ob_start(); 
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');
set_time_limit(120);
$tQuery = "SELECT id FROM parts_temp";
$tResult = mysqli_query($db_link, $tQuery);
$tRows = mysqli_num_rows($tResult);
if(isset($_SESSION['start']))
	$start = $_SESSION['start'];
else
	$start = 0;

$limitCtl = $start;
$limit = 30;

$query = "SELECT oe_num_short, op_us_date FROM parts_temp ORDER BY id LIMIT $start, $limit";
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
if($limitCtl < $tRows ) 
	echo '<h3>Wait...  <i class="fa fa-spinner fa-spin"></i></h3>';
else
	echo 'Update is DONE !!!';

while($row = mysqli_fetch_assoc($result)) 
{
	echo $oe_num_short = $row['oe_num_short'];
	echo ' - ';
	echo $op_us_date = $row['op_us_date'];
	$uQuery = "UPDATE parts SET op_us_date = '$op_us_date' WHERE oe_num_short = '$oe_num_short'";
	$uResult = mysqli_query($db_link, $uQuery) or die(mysqli_error($db_link));

	echo ':::> UPDATED';
	echo '</br>';
}
echo '<br/>';
echo '<h3><font color="red">' . ($tRows - $start) . '</font> left to Update!!! (Appox. '. number_format(($tRows - $start)/300) .' mins)</h3>'; 
$start += $limit;

if($limitCtl < $tRows ) {
	$_SESSION['start'] = $start;
	header("Refresh:1");
}


ob_flush(); 
include('themes/gentelella/footer.php'); 
