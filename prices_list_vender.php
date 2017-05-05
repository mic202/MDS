<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

require ('app/paginator.php');
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$snlQuery = "SELECT DISTINCT supplier_id, supplier_name FROM prices_supplier GROUP BY supplier_id ORDER BY supplier_name";
$snlResult = mysqli_query($db_link, $snlQuery);
$snList = '';
while($snlRow = mysqli_fetch_assoc($snlResult))
{
	if($snlRow['supplier_id'] == $_GET['id'])
		$active = 'class="active"';
	else
		$active = '';

	$snList .= '<li role="presentation" '.$active.'><a href="prices_list_vender.php?id='.$snlRow['supplier_id'].'">'.$snlRow['supplier_name'].'</a></li>'; 
}

?>
<style>
.table-hover tbody tr:hover td {
    background: #e8e8e8;
}
.table-hover {
	 font-size: 12px;
} 
</style>

<ul class="nav nav-tabs" style="font-size: 12px;">
	<li role="presentation" ><a href="prices_list.php">ALL</a></li>
	<?php echo $snList; ?>
</ul>
<br/>

<?php
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
						UPDATED DATE of PRICES
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$udQuery = "SELECT DISTINCT update_date FROM prices_supplier WHERE  supplier_id = '$_GET[id]' ORDER BY update_date DESC";
$udResult = mysqli_query($db_link, $udQuery);
while($udRow = mysqli_fetch_assoc($udResult)) 
{
	$udList[] = $udRow['update_date'];
}
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
							PART's PRICES
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$pQuery = "SELECT price, currency, price_type, oe_num_short, update_date FROM prices_supplier WHERE  supplier_id = '$_GET[id]' ORDER BY oe_num_short, update_date DESC";
$pResult = mysqli_query($db_link, $pQuery);
while($pRow = mysqli_fetch_assoc($pResult)) 
{
	$pList[$pRow['oe_num_short']][$pRow['update_date']] = array('price' => $pRow['price'], 'currency' => $pRow['currency'], 'price_type' => $pRow['price_type']);
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
							PART's INFO
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$piQuery = "SELECT oe_num_short, model, part_desc FROM parts ORDER BY oe_num_short";
$piResult = mysqli_query($db_link, $piQuery);
while($piRow = mysqli_fetch_assoc($piResult))
{
	$piList[$piRow['oe_num_short']]['model'] = $piRow['model'];
	$piList[$piRow['oe_num_short']]['part_desc'] = $piRow['part_desc'];	
}
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
//$oeQuery = "SELECT DISTINCT part_id, oe_num_short, maker FROM prices_supplier";
$oeQuery = "SELECT DISTINCT part_id, oe_num_short, maker FROM prices_supplier WHERE supplier_id = '$_GET[id]'";

if(isset($_REQUEST['q']) && $_REQUEST['q'] != null)
	$oeQuery .= " AND oe_num_short LIKE '%". $_REQUEST['q'] ."%'";

//__ constructor is called. Connect to DB and call it to get total number of rows
	$paginator = new Paginator($db_link, $oeQuery); 
	$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 100; // Number of rows per page
	$page = (isset($_GET['page'])) ? $_GET['page'] : 1; // starting page
	$links = 5;
	$result = $paginator->getData($limit, $page);

	$rowStart = ($page-1)*$limit;

	$oeQuery .= " LIMIT $rowStart, $limit";

$oeResult = mysqli_query($db_link, $oeQuery);

$venderName = mysqli_fetch_assoc(mysqli_query($db_link, "SELECT supplier_name FROM prices_supplier WHERE supplier_id = $_GET[id] LIMIT 0, 1"));

?>
<div class="col-lg-12">
    <h1 class="page-header"><small><i class="fa fa-truck"></i> Vender : </small><?php echo $venderName['supplier_name']; ?> </h1>
</div>
<div class="row">
	<form class="form-horizontal" action="?id=<?php echo $_GET['id']; ?>" method="POST">		
	<div class="col-md-6 col-md-offset-3">
   		<div class="input-group">
			<input type="text" class="form-control" name="q" id="q" placeholder="Search for... ">
			<span class="input-group-btn">
        		<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
      		</span>		
  		</div>
	</div>
	</form>
</div>
<table border=0 class="table table-hover">
	<tr style="background: #a6d8a6; color:#425160; ">
		<th width="5%">#</th>
		<th  width="7%" style="text-align:center;">OE Number <br/><small> (SHORT) </small></th>
		<th>MAKER</th>
		<th>MODEL</th>
		<th>DESCRIPTION</th>
		<th width="5%" style="text-align:center;">Currency</th>
		<th width="7%" style="text-align:center; background: #e0e0e0;">Prev. Price</th>
		<th width="7%" style="text-align:center; background: #bec8d6; ">RECENTLY <br/>Price</th>
		<th width="6%" style="text-align:center; background: #ffff96">COMP. <br/><small>OLD & NEW</small></th>
		<th></th>		
	</tr>
		
<?php

$ln = 1;
while($oeRow = mysqli_fetch_assoc($oeResult))
{
	$dList = array_keys($pList[$oeRow['oe_num_short']]); // Array of update date list
	
	for($i=0; $i<count($dList); $i++) 
	{
		if(count($dList) == 1) 
		{
			$prevDate = '';	
			$lastDate = $dList['0'];	
		}else if(count($dList) > 1) 
		{
			$prevDate = $dList['1'];	
			$lastDate = $dList['0'];
		}
	}
	if($prevDate != '')
		$prevPrice = $pList[$oeRow['oe_num_short']][$prevDate];
	else
		$prevPrice = array('price' => '', 'currency' => '', 'price_type' => '');
	
	$lastPrice = $pList[$oeRow['oe_num_short']][$lastDate];
	
	if(isset($prevPrice) AND $prevPrice['price'] != '') {
		$compRate = number_format((($lastPrice['price'] - $prevPrice['price'])/$prevPrice['price']*100),2);
		if($compRate < 0)
			$compRate = ($compRate * -1) . ' % <i class="fa fa-long-arrow-down" style="color:#C73834;"></i>' ;
		else if($compRate == 0)
			$compRate .= ' % &nbsp;&nbsp;';
		else
			$compRate .= ' % <i class="fa fa-long-arrow-up" style="color:#205387;"></i>'; 
		$prevPrice['price'] = number_format($prevPrice['price'],2);
	}
	else
	{
		$compRate = '';
	}
	
	if($prevDate != '')
		$prevDate = '('.date('ymd', strtotime($prevDate)).')';

echo'<tr>';
	echo "<td>".$ln."</td>";
	$oe_num_short = $oeRow['oe_num_short'];
	echo '<td><a href="prices_list.php?q='.$oe_num_short.'">'.$oe_num_short.'</a></td>';
	echo "<td>".$oeRow['maker']."</td>";
	echo "<td>".$piList[$oeRow['oe_num_short']]['model']."</td>";
	echo "<td>".$piList[$oeRow['oe_num_short']]['part_desc']."</td>";
	echo "<td style='text-align:center;'><h5>".$lastPrice['currency']."</h5></td>";
	echo "<td style='text-align:right;'>
			<h5>".$prevPrice['price']."</h5>
			<h6>".$prevDate. "</h6>
			<h6>".$prevPrice['price_type']."</h6>
		</td>";
	echo "<td style='text-align:right;'>
			<h5>".number_format($lastPrice['price'],2)."</h5>
			<h6>(".date('ymd', strtotime($lastDate)). ")</h6>
			<h6>".$lastPrice['price_type']."</h6>
		</td>";
	echo "<td style='text-align:right; background: #ffff96'><h5>".$compRate."</h5></td>";
	echo "<td></td>";
echo'</tr>';
	$ln++;

}	
?>
</table>
<br/>

<?php

$url = "&id=". $_GET['id'];
if($result->data != null)
	echo $paginator->createLinks($links, 'pagination', $url);

include('themes/gentelella/footer.php'); 
?>