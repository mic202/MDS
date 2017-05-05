<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

require ('app/paginator.php');


/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
												VENDERS LIST
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$snlQuery = "SELECT DISTINCT supplier_id, supplier_name FROM prices_supplier GROUP BY supplier_id ORDER BY supplier_name";
$snlResult = mysqli_query($db_link, $snlQuery);
$snList = '';
while($snlRow = mysqli_fetch_assoc($snlResult))
{
	$snList .= '<li role="presentation"><a href="prices_list_vender.php?id='.$snlRow['supplier_id'].'">'.$snlRow['supplier_name'].'</a></li>'; 
}
?>
<style>
	.table-hover tbody tr:hover td {     background: #EDEDED;   }
	.table-hover {	 font-size: 12px; }
</style>

<div class="col-lg-12">
    <h1 class="page-header">Prices Master <i class="fa fa-tags"></i></h1>
</div>

<ul class="nav nav-tabs" style="font-size: 12px;">
	<li role="presentation" class="active"><a href="#">ALL</a></li>
	<?php echo $snList; ?>
</ul>
<br/>


<?php
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
function get_part_prices($sPriceList, $partId, $oeNumShort) 
{
	$priceList = $sPriceList[$partId];
	ksort($priceList);
	$sNames = array_keys($priceList);
	foreach($priceList AS $list) 
	{
		if(isset($_SESSION[$list['currency']]) && $_SESSION[$list['currency']] > 0)
			$minList[] = ($list['price']+($list['price']*($list['comm_rate']/100)))/$_SESSION[$list['currency']];
		else			
			$minList[] = $list['price']+($list['price']*($list['comm_rate']/100));		
	
	}
	sort($minList);
	$min = $minList['0'];
	
	$lowest = '';
	$html = '<table width="100%"> 
				<tr>';
	$i = 0;
	foreach($priceList AS $list)
	{
		if(isset($_SESSION[$list['currency']]))
			$currency = $_SESSION[$list['currency']];
		else
			$currency = 1;
		
		if(($list['price']+($list['price']*($list['comm_rate']/100)))/$currency == $min)
			$lowest = 'style="color:red;"';
		else
			$lowest = '';
	
		if($list['currency'] != 'USD')
			$conv_usd =  '= USD '.number_format(($list['price']/$currency),2);
		else
			$conv_usd = '';
	
		if($list['comm_rate'] != 0) 
		{
			if($list['comm_rate'] > 0) 
				$comm_rate = abs($list['comm_rate']) .'% +';
			else	 
				$comm_rate = abs($list['comm_rate']) .'% -'; 
		
			$comm = $list['price']*($list['comm_rate']/100);
			$finalPrice = $list['price'] + $comm;
			$conv_usd =  '= USD '.number_format(($finalPrice/$currency),2);
			$finalPrice = '( '.number_format($finalPrice,2) .' )';
		}
		else
		{
			$comm_rate = '';			
			$finalPrice = '';
		}	

		$html .= '<td width="10%"  style="border-right: 1px solid #ddd;">
					<table width="100%" style="text-align:center;">
						<tr><td height="50"><a href="prices_list_vender.php?id='.$list['supplier_id'].'&q='.$list['oe_num_short'].'"><b>'.$sNames[$i].'</b> <font color="red">'. $comm_rate .'</font></td></tr>
						<tr>
							<td height="60" '.$lowest.'>
								<p >'.$list['currency'].'  '.number_format($list['price'],2) .'</p>
								<p style="font-style: italic;">'.$finalPrice.'</p>
								<p style="font-style: italic;">'. $conv_usd .'</p>
							</tr>
						<tr><td>('.date("ymd",strtotime($list['update_date'])).')</tr>
						<tr><td>'.$list['price_type'].'</tr>
					</table>		
				</td>';
		$i++;			
	}
	for($c=$i; $c<10;$c++) 
	{
		$html .= '<td width="10%"></td>';
	}
	$html .= '</tr>
		</table>';
	return $html;
}
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
											SEARCH INPUT
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
echo'<div class="row">
		<form class="form-horizontal" action="?" method="GET">		
		<div class="col-md-6 col-md-offset-3">
    		<div class="input-group">
				<input type="text" class="form-control" name="q" id="q" placeholder="Search for... ">
				<span class="input-group-btn">
	        		<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
	      		</span>		
	  		</div>
		</div>
		</form>
	</div>';

$oeQuery = "SELECT DISTINCT oe_num_short, part_id, maker FROM prices_supplier";

if(isset($_GET['q']) && $_GET['q'] != null)
{	
	$q = trim($_GET['q']);
	$url = "&q=". $q;
	if(strtoupper($q) == 'NEW')
		$oeQuery .= " WHERE maker = '' ";
	else	
		$oeQuery .= " WHERE oe_num_short LIKE '%". $q ."%' OR maker LIKE '%". $q ."%' ";
}
else
	$url = '';

//$oeQuery .= " GROUP BY oe_num_short";

//if(mysqli_num_rows(mysqli_query($db_link, $oeQuery)) > 0) 
if($paginator = new Paginator($db_link, $oeQuery)) 
{
	if(isset($_POST['set_rate']))
	{
		if(isset($_POST['CAD']) && $_POST['CAD'] != null)
			$_SESSION['CAD'] = $_POST['CAD'];
		if(isset($_POST['EURO']) && $_POST['EURO'] != null)
			$_SESSION['EURO'] = $_POST['EURO'];
		if(isset($_POST['JPY']) && $_POST['JPY'] != null)
			$_SESSION['JPY'] = $_POST['JPY'];
		if(isset($_POST['WON']) && $_POST['WON'] != null)
			$_SESSION['WON'] = $_POST['WON'];
	}
	if(isset($_SESSION['CAD']))
		$cad_rate = $_SESSION['CAD'];
	else
		$cad_rate = '';
	if(isset($_SESSION['EURO']))
		$euro_rate = $_SESSION['EURO'];
	else
		$euro_rate = '';
	if(isset($_SESSION['JPY']))
		$jpy_rate = $_SESSION['JPY'];
	else
		$jpy_rate = '';
	if(isset($_SESSION['WON']))
		$won_rate = $_SESSION['WON'];
	else
		$won_rate = '';

	//__ constructor is called. Connect to DB and call it to get total number of rows
	//$paginator = new Paginator($db_link, $oeQuery); 
	$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 50; // Number of rows per page
	$page = (isset($_GET['page'])) ? $_GET['page'] : 1; // starting page
	$links = 5;
	$result = $paginator->getData($limit, $page);
	
	$rowStart = ($page-1)*$limit;

	$oeQuery .= " LIMIT $rowStart, $limit";

	echo "<br/>";
	echo '<table class="table table-hover">
			<thead>
			<form action="?'.$_SERVER['QUERY_STRING'].'" method="POST">
				<input type="hidden" name="set_rate" value="true" >
				<tr style="background: #44777b; color: #fff; vertical-align: middle;">
					<th>#</th>
					<th>OE Num Short</th>
					<th>Maker</th>
					<th>Description</th>
					<th width="65%">
						Prices  (&nbsp;  
						USD 1 = <input  type="text" name="CAD" size="5" style="color:#73879C;" placeholder="'.$cad_rate.'"> CAD 
						&nbsp; / &nbsp;
						<input type="text" name="EURO" size="5" style="color:#73879C;" placeholder="'.$euro_rate.'"> EURO 
						&nbsp; / &nbsp;
						<input type="text" name="JPY" size="5" style="color:#73879C;" placeholder="'.$jpy_rate.'"> JPY 
						&nbsp; / &nbsp;
						<input type="text" name="WON" size="5" style="color:#73879C;" placeholder="'.$won_rate.'"> WON 
							&nbsp;) &nbsp;&nbsp;	
						<input type="submit" value="Update" style="color: #44777b;">		
					</th>
				</tr>
			</form>	
			</thead>';

	$oeResult = mysqli_query($db_link, $oeQuery);
	while($oeRow = mysqli_fetch_assoc($oeResult))
	{
		$oeNumList[] = $oeRow['oe_num_short'];
	}	

	$filter = " WHERE (";
	foreach($oeNumList AS $oeList)
	{
		$filter .= "oe_num_short='". $oeList ."' OR ";
	}
	$filter = substr_replace( $filter, "", -3 );
	$filter .= ")";
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
												Price Array
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$paQuery = "SELECT part_id, oe_num_short, price, supplier_name, supplier_id, price, currency, price_type, update_date, comm_rate FROM prices_supplier";

if(isset($_GET['q']) && $_GET['q'] != null)
{	
	
	$paQuery .= " WHERE oe_num_short LIKE '%".$q."%'"; 
}else {
	$paQuery .= $filter;
}	

$paQuery .= " ORDER BY update_date";
$paResult = mysqli_query($db_link, $paQuery) or die(mysqli_error($db_link));
while($paRow = mysqli_fetch_assoc($paResult)) 
{
	$sPriceList[$paRow['part_id']][$paRow['supplier_name']] = array('oe_num_short' => $paRow['oe_num_short'],'supplier_id' => $paRow['supplier_id'], 'price' => $paRow['price'], 'currency' => $paRow['currency'], 'price_type' => $paRow['price_type'], 'update_date' => $paRow['update_date'], 'comm_rate' => $paRow['comm_rate']);	
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
											Part Info Array
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
$iaQuery = "SELECT part_id, oe_num_short, part_desc, ss_date, ss_num FROM parts";
$iaQuery .= $filter;
$iaQuery .= " ORDER BY part_id";
$iaResult = mysqli_query($db_link, $iaQuery);
$pre_part_id = 0;
while($iaRow = mysqli_fetch_assoc($iaResult))
{
	
	if($iaRow['part_id'] == $pre_part_id && $iaRow['oe_num_short'] == $pre_oe_num_short)
		$iaRow['part_desc'] .= '<br/><br/>'. $pre_part_desc;
	
	$pInfoList[$iaRow['part_id']][$iaRow['oe_num_short']] = $iaRow['part_desc'];

	$pre_part_id = $iaRow['part_id'];
	$pre_oe_num_short = $iaRow['oe_num_short'];
	$pre_part_desc = $iaRow['part_desc'];

	if($iaRow['ss_num'] != null) {
		$ssLinkList[$iaRow['oe_num_short']] = '<br/><a href="'. $_SERVER['PHP_SELF'] .'?q='.$iaRow['ss_num'].'" style="color:#73879C;" target="_blank"><div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Error:</span>
				  S/S : This part has been replaced by <br/>
				'.$iaRow['ss_num'].' ('.date("mdy", strtotime($iaRow['ss_date'])).') <i class="fa fa-long-arrow-left"></i> Click</div></a>';
	}
	else 
	{
		$ssLinkList[$iaRow['oe_num_short']] = '';
	}

}
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

	$oeResult = mysqli_query($db_link, $oeQuery);
	while($oeRow = mysqli_fetch_array($oeResult)) 
	{
		if(array_key_exists($oeRow['oe_num_short'], $ssLinkList))
			$ssLink = $ssLinkList[$oeRow['oe_num_short']];
		else
			$ssLink = '';
		echo "<tr>
				<td>".($rowStart+1)."</td>
				<td>".$oeRow['oe_num_short']."</td>
				<td>".$oeRow['maker']."</td>";
		if(array_key_exists($oeRow['part_id'], $pInfoList)) 
		{	
			echo'<td style="border-right: 1px solid #ddd;">
					<a href="part_details.php?id='.$oeRow['part_id'].'"  style="color:#73879C;">
						'.$pInfoList[$oeRow['part_id']][$oeRow['oe_num_short']].'
					</a><br/>'. $ssLink. '
				</td>';
		}
		else
		{	
			echo '<td style="border-right: 1px solid #ddd;">
					<div class="alert alert-warning">
		 				<p style="color:#fff;">
		 					<i class="fa fa-exclamation-triangle"></i> 
		 					&nbsp; Error : There is NO Infomation for this Part. <br/> In order to get the right price for this part, you need to ADD Part information first. 
		 				</p>
		 			</div>
		 		</td>';
		} 		
			echo "<td>".get_part_prices($sPriceList, $oeRow['part_id'], $oeRow['oe_num_short'])."</td>";
		echo "</tr>";
		$rowStart++;	
	}
	echo'</table>';
	echo'<br/>';
	if($result->data != null)
	echo $paginator->createLinks($links, 'pagination', $url);
}
else
{
	echo '<div class="alert alert-warning">
		 	<p style="color:#fff;">
		 		<i class="fa fa-exclamation-triangle"></i> <font style="color:black;">There is NO result with <u><a href="parts_master.php?sSearch='.$_GET['q'].'">'.$_GET['q'].'</a></u> </p>
		</div>';
}

include('themes/gentelella/footer.php'); 
?>