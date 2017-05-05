<?php
ob_start(); 
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');
//$query = "UPDATE parts SET op_us_"
//$query = "SELECT oe_number.oe_num FROM parts RIGHT JOIN  oe_number ON parts.oe_num_short = oe_number.oe_num WHERE parts.oe_num_short IS NULL";
//$query = "UPDATE prices_supplier, parts SET prices_supplier.part_id = parts.id WHERE prices_supplier.part_id = '0' AND prices_supplier.oe_num_short = parts.oe_num_short";
//$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
$aQuery = "SELECT part_id, oe_num_short, maker FROM parts ORDER BY oe_num_short";
$aResult = mysqli_query($db_link, $aQuery) or die(mysqli_error($db_link));
while($aRow = mysqli_fetch_assoc($aResult)) 
{
	$pList[$aRow['oe_num_short']] = $aRow['part_id'];
	$mList[$aRow['oe_num_short']] = $aRow['maker'];
} 
//$query = "UPDATE `prices_supplier` SET `oe_num_short` = REPLACE(`oe_num_short`, ' ', '')";
//$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
$query = "SELECT oe_num_short FROM prices_supplier WHERE part_id = '0' AND maker = '' ORDER BY oe_num_short";
$result = mysqli_query($db_link, $query);
while ($row = mysqli_fetch_assoc($result))
{
	$oeList[] = $row['oe_num_short']; 
}
echo '<h1>Wait...  <i class="fa fa-spinner fa-spin"></i></h1>';
$i = 0;
$count = 1;
foreach($oeList AS $list) 
{
	if(array_key_exists($list, $pList)) 
	{
		$part_id = $pList[$list];
		$maker = $mList[$list];
		
		$uQuery = "UPDATE prices_supplier SET part_id = '$part_id', maker = '$maker' WHERE oe_num_short = '$list'";
		$uResult = mysqli_query($db_link, $uQuery) or die(mysqli_error($db_link));
		
		if($i == 50)
			break;
		$i++;
	}else {
		echo $count.') Error : '.$list. '</br>';	
		$count ++;
	}
}
echo 'Add '.count($oeList). ' lines more.... approx. '.number_format((count($oeList)/120)).' mins  ';
if($i>0)
	header("Refresh:2");

/**
$query = "SELECT oe_num_short FROM prices_supplier WHERE part_id = '0'";
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
$i = 0;
echo"<table>";
while($row = mysqli_fetch_assoc($result)) 
{
	$oe_num_short = $row['oe_num_short'];
	$part_id = $pList[$oe_num_short];
	$maker = $mList[$oe_num_short];
	if($part_id != null) 
	{
		$uQuery = "UPDATE prices_supplier SET part_id = '$part_id', maker = '$maker' WHERE oe_num_short = '$oe_num_short'";
		$uResult = mysqli_query($db_link, $uQuery) or die(mysqli_error($db_link));
	
		echo "<tr>";
			echo "<td>". $row['oe_num_short'] ." ----> UPADATED !!!</td>";
		//	echo "<td>". $row['price'] ."</td>";
		//if($row['price'] != $pList[$row['oe_num_short']])
		//	echo '<td style="color:red;">'. $pList[$row['oe_num_short']] .'</td>';
		//else
		//	echo "<td>". $pList[$row['oe_num_short']] ."</td>";

		echo "</tr>";

		
	}

	if($i == 50)
		break;

	$i ++;
}
echo"</table>";

header("Refresh:2");
*/
echo '<a href="main.php" target="_new"> OPEN IN </a>';
include('themes/gentelella/footer.php'); 
ob_flush(); 
?>

