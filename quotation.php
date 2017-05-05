<?php
ob_start(); 
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

set_time_limit(120);

function get_navClass($step, $currentStep) 
{
	if($step == $currentStep)
		$navClass = 'active';
	else
		$navClass = 'disabled disabledTab';
	return $navClass;
}
?>
<style>
	.table-hover tbody tr:hover td { background: #fffae8; }
	.table-hover { font-size: 12px; }
	.table-hover a { color: #fff; }
	.nav-tabs>li>a { color: #ddd !important; }
	.nav-tabs>li.active>a { color: #73879C !important; }		 
</style>
<style type="text/css">
	.mSidebar { 
		width: 600px;
		position: absolute;
		top: 70px;
		right: 0px;
	}
</style>

<div class="col-lg-12">
    <h1 class="page-header">Quotation Generator <i class="fa fa-calculator"></i> </h1>
</div>
<div class="col-lg-12">
	<ul class="nav nav-tabs nav-justified" >
        <li role="presentation" class="<?php echo get_navClass('', $_GET['mode']); ?>">
        	<a href="#"><h4> STEP 1 : UPLOAD </h4></a>
        </li>        
        <li role="presentation" class="<?php echo get_navClass('preview', $_GET['mode']); ?>" >
        	<a href="#"><h4> STEP 2 : PREVIEW </h4></a>
        </li>
        <li role="presentation" class="<?php echo get_navClass('quote', $_GET['mode']); ?>">
        	<a href="#"><h4> STEP 3 : QUOTATION</h4></a>
        </li>
    </ul>
</div>
<div class="clearfix"></div> 
<br/><br/>  
  	
<?php
function get_price_radio($sPriceList, $oe_num, $iQty, $cube ,$vList = null) 
{
	if(isset($sPriceList[$oe_num]) && $sPriceList[$oe_num] != NULL) {
		$priceList = $sPriceList[$oe_num];

		foreach($vList AS $key) 
		{
			unset($priceList[$key]);
		}	
		ksort($priceList);
		if(count($priceList)>1)
			$min = min($priceList);
		else if(count($priceList) == 1) {
			$tempList = $priceList;
			$min = array_pop($tempList);
		}
		else {
			$min = 0;
			$lsName = '';
		}
		$sNames = array_keys($priceList);
		
		if(isset($_SESSION['sNameFullList'])) 
		{	
			foreach ($sNames as $name) {
				if(!in_array($name, $_SESSION['sNameFullList']))
					array_push($_SESSION['sNameFullList'], $name);
			}
		}
//##########################################################	
		
###############################################################//	
		$lowest = '';
		$html = '<table border=0 width="100%">
					<tr>';
		$i = 0;
		$pAmt = 0;		
		foreach($priceList AS $list)
		{
			if($list['price']== $min['price'] || count($priceList) == 1)
			{	
				$lowest = 'checked';
				$lsName = $sNames[$i];
				$pAmt = $list['price'] * $iQty;
				$tCbm = $cube * $iQty;
			}else 
				$lowest = '';
			
			$html .= '<td width="10%" style="border-right: 1px solid #ddd;">
						<table border=0 height="100%" width="100%" style="font-size:12px; text-align: center;">
							<tr>
								<td><input type="radio" name="'.$oe_num.'" '.$lowest.' ></td>
							</tr>	
							<tr>
								<td  height="40">'.$sNames[$i].'</td>
							</tr>
							<tr>
								<td> '.$list['currency'] .' '.$list['price'] .'</td>
							</tr>
							<tr>
								<td> ( '.date("Ymd", strtotime($list['date'])) .' )</td>
							</tr>
							<tr>
								<td>'.$list['pType'].'</td>
							</tr>
						</table>		
					</td>';				
			$i++;			
		}// EOF foreach($priceList AS $list)

//::::::::::::::::::::::::::::::::: If there is NO price ::::::::::::::::::::::::::::::::::::::
		if($i == 0) 
		{
			$tCbm = '';	
			$html .= '<td><div class="alert alert-warning">
		 				<p style="color:#fff;">
		 					<i class="fa fa-exclamation-triangle"></i> 
		 					&nbsp; Error : There is NO Price Infomation. <br/>
		 				</p>
		 			</div></td>';
		}	
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::		
			$html .='<td></td>
				</tr>
			</table>';		
		return array('html' => $html, 'min' => $min['price'], 'lsName' => $lsName, 'pAmt' => $pAmt, 'tCbm' => $tCbm);
	}
}

if(isset($_GET['mode']) && $_GET['mode'] == 'quote')
{

	if($_POST['oeNumList'] == NULL)
		header("location:quotation.php");
	else
		$oeNumListWithQty = $_POST['oeNumList'];

	if(!isset($_POST['action']))	
		$oeNumListWithQty = substr_replace( $_POST['oeNumList'], "", -3 );	

	$qInfo = explode(">>>",$oeNumListWithQty);
	
	$where = " WHERE (";	
	foreach($qInfo AS $infos) 
	{
		$qTemp = explode('@', $infos);
		$where .= "oe_num_short = '".trim($qTemp[0])."' OR ";
	}
	$where = substr_replace( $where, "", -3 );	
	$where .= ")";

	

	$piQuery = "SELECT oe_num_short, maker, part_name, model, model_year, oe_price_us,part_cube FROM parts";
	$piQuery .= $where;
	$piQuery .= " ORDER BY oe_num_short";
	$piResult = mysqli_query($db_link, $piQuery) or die(mysqli_error($db_link));
	while($piRow = mysqli_fetch_assoc($piResult))
	{
		$piList[$piRow['oe_num_short']]['maker'] = $piRow['maker'];
		$piList[$piRow['oe_num_short']]['part_name'] = $piRow['part_name'];
		$piList[$piRow['oe_num_short']]['model'] = $piRow['model'];
		$piList[$piRow['oe_num_short']]['model_year'] = $piRow['model_year'];
		$piList[$piRow['oe_num_short']]['cbm'] = $piRow['part_cube'];
		$piList[$piRow['oe_num_short']]['oe_price_us'] = $piRow['oe_price_us'];
	}
	
	$query = "SELECT oe_num_short, price, price_type, supplier_name, currency, update_date FROM prices_supplier";
	$query .= $where;
	$query .= " ORDER BY update_date";
	
	$result = mysqli_query($db_link, $query);
	while($row = mysqli_fetch_assoc($result)) 
	{
		$sPriceList[$row['oe_num_short']][$row['supplier_name']] = array('price' => $row['price'], 'currency' => $row['currency'], 'date' => $row['update_date'], 'pType' => $row['price_type'] );
	}

	if(isset($_POST['vender'])) 
	{
		if($_POST['action'] == 'remove') 
		{
			array_push($_SESSION['vList'], $_POST['vender']);
		}
		else if($_POST['action'] == 'add') 
		{
			foreach (array_keys($_SESSION['vList'], $_POST['vender']) as $key) {
 			   unset($_SESSION['vList'][$key]);
			}
		}
	}

	if(isset($_SESSION['vList']))
		$vList = $_SESSION['vList'];
	else	
		$vList = [];	
	echo'<div>
				<h2>Buyer : <u>'. $_POST['buyer'] .'</u></h2>
			</div>';
	echo'<div class="row">
			<div class="col-md-12">
			    <div class="clearfix"></div>';
			echo'<table class="table table-hover table-bordered" width="100%">
					<tr style="background: #774675; color: #fff;">
						<th>#</th>
						<th>OE NUM SHORT</th>
						<th>MAKER</th>
						<th>PART NAME</th>
						<th>QTY</th>
						<th>CBM</th>
						<th width="60%">PRICE</th>
						<th>OE Price (US)</th>
						<th>LOWEST</th>
					</tr>';							
			
			$sumVender = [];
			$tPrice = 0;
			$tQty = 0;
			$hasNoPrice = 0;
			for($i=0; $i<count($qInfo); $i++) 
			{
				$qList = explode('@', $qInfo[$i]);
				$oe_num_short = trim($qList[0]);
				$qty = $qList[1];
				
				if(isset($piList[$oe_num_short]) && $piList[$oe_num_short] != NULL) 
				{
					$maker = $piList[$oe_num_short]['maker'];
					$part_name = $piList[$oe_num_short]['part_name'];
					$cbm = $piList[$oe_num_short]['cbm'];
					$oe_price_us = $piList[$oe_num_short]['oe_price_us'];
				}	

				$price = get_price_radio($sPriceList, $oe_num_short, $qty, $cbm, $vList);			
				echo'<tr>
						<td>'.($i+1).'</td>
						<td>'.$oe_num_short.'</td>
						<td>'.$maker.'</td>
						<td>'.$part_name.'</td>
						<td style="text-align:center;"><h4>'.$qty.'</h4></td>
						<td>'.floatval($cbm).'<br/>x '.$qty.'<br/>= '. ($cbm*$qty) .'</td>';
				echo    '<td>'.$price['html'].'</td>';
				echo 	'<td>'.$oe_price_us.'</td>';
				echo 	'<td><h5>'.$price['lsName'].'</h5><h4>'.$price['min'].'</h4></td>';
				echo '</tr>';
				$tPrice += $price['pAmt'];
				$tQty += $qty;

				if($price['lsName'] != NULL) 
				{	
					if(isset($sumVender[$price['lsName']]['sumItem']) && $sumVender[$price['lsName']]['sumItem'] >= 0) 
					{
						$sumVender[$price['lsName']]['sumAmount'] += $price['pAmt'];
						$sumVender[$price['lsName']]['sumCBM'] += $price['tCbm'];
						$sumVender[$price['lsName']]['sumItem'] ++;
						$sumVender[$price['lsName']]['sumPCS'] += $qty;
					}
					else 
					{
						$sumVender[$price['lsName']]['sumAmount'] = $price['pAmt'];
						$sumVender[$price['lsName']]['sumCBM'] = $price['tCbm'];
						$sumVender[$price['lsName']]['sumItem'] = 1;	
						$sumVender[$price['lsName']]['sumPCS'] = $qty;	
					}
				}				
				else
					$hasNoPrice ++;
			}
			echo'</table>';
		echo'</div>';
		echo'<div class="col-md-3 col-md-offset-5">
        	<form action="quotation_list.php" method="POST">
        		<input type="submit" name="submit" class="btn btn-primary btn-lg" value="SAVE TO DATABASE"/>
        	</form>
        </div>';
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
										Summary Panel
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/	
		echo'<div class="mSidebar">
			    <div class="x_panel tile" >
		            <div class="x_title">
		            	<h2>Summary</h2>
		            	<ul class="nav navbar-right panel_toolbox">
				            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				        </ul>
						<div class="clearfix"></div>
		            </div>';
			echo	'<div class="x_content">';
				echo'<p> TOTAL: <font size="5em;" color="#AC2925">'. $i .'</font> items / <font size="5em;" color="#AC2925">'. number_format($tQty) .' </font>pcs</p>';
				echo'<p> AMOUNT: <font size="5em;" color="#AC2925">'. number_format($tPrice,2) .'</font> USD</p>';
				echo'<p> <font size="5em;" color="#AC2925">'. $hasNoPrice .'</font> items without price</p>';
				echo'<hr>';
				echo'<table class="table table-hover">
						<tr>
							<th></th>
							<th>MIN</th>
							<th>CBM</th>
							<th>CTNR</th>
							<th>PUR AMT</th>
							<th>ITEMS</th>
							<th>PCS</th>
						</tr>';
				foreach($_SESSION['sNameFullList'] AS $sList) 
				{	
					if(!isset($_SESSION['minAMT'][$sList]))	
						$_SESSION['minAMT'][$sList] = $sumVender[$sList]['sumItem'];
						 
					echo'<tr>';
					if(in_array($sList, $vList)) 
					{
					echo '<td>';	
						echo'<form action="?mode=quote" method="POST">';
							echo'<input type="hidden" name="vender" value="'.$sList.'">';
							echo'<input type="hidden" name="buyer" value="'.$_POST['buyer'].'">';
							echo'<input type="hidden" name="action" value="add">';
							echo'<input type="hidden" name="oeNumList" value="'.$oeNumListWithQty.'">';
							echo'<button type="submit" class="btn btn-default btn-xs" style="color:#b6c4d6;" >'.$sList.'</button>';
						echo'</form>';
					echo '</td>';
					echo'<td>'. $_SESSION['minAMT'][$sList] .'</td>';
					echo'<td colspan="5"></td>';	
					}
					else
					{
					echo'<td>';	
						echo'<form action="?mode=quote" method="POST">';
							echo'<input type="hidden" name="vender" value="'.$sList.'">';
							echo'<input type="hidden" name="buyer" value="'.$_POST['buyer'].'">';
							echo'<input type="hidden" name="action" value="remove">';
							echo'<input type="hidden" name="oeNumList" value="'.$oeNumListWithQty.'">';
							echo'<button type="submit" class="btn btn-success btn-xs" >'.$sList.'</button>';
						echo'</form>';
					echo'</td>';
					echo'<td>'. $_SESSION['minAMT'][$sList] .'</td>';
					echo'<td>'.number_format($sumVender[$sList]['sumCBM'], 2).'</td>';
					echo'<td>'.number_format($sumVender[$sList]['sumCBM']/65, 2).'</td>';			
					echo'<td>'.number_format($sumVender[$sList]['sumAmount'], 2).'</td>';
					echo'<td>'.$sumVender[$sList]['sumItem'].'</td>';
					echo'<td>'.$sumVender[$sList]['sumPCS'].'</td>';
					}
					echo'</tr>';
				}
				
			echo'</table>';	
			echo'</div>
			</div>
		</div>';
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	echo'</div>';
	echo '<br/>';	
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
											PREVIEW
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/	
}
elseif (isset($_GET['mode']) && $_GET['mode'] == 'preview') 
{
	if(isset($_POST['text']) && $_POST['text'] != NULL) {
		$text = preg_split('/[\r\n]+/', $_POST['text'], -1, PREG_SPLIT_NO_EMPTY);
		$list = ' WHERE (';
		foreach($text AS $line) 
		{
			$row = explode('@', $line);
			$list .= "oe_num_short = '".trim($row[0])."' OR ";
		}
		$list = substr_replace( $list, "", -3 );
		$list .= ')';
		
		$query = "SELECT oe_num_short, maker, part_desc FROM parts";
		$query .= $list;

		$result = mysqli_query($db_link, $query);
		if($result) 
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$info[$row['oe_num_short']] = array('maker' => $row['maker'], 'part_desc' => $row['part_desc']);
			}
		}	
		echo'<div>
				<h2>Buyer : <u>'. $_POST['buyer'] .'</u></h2>
			</div>';
		echo'<table class="table table-hover">
				<tr>
					<th>#</th>
					<th>OE NUM (SHORT)</th>
					<th>QTY</th>
					<th>MAKER</th>
					<th>PART DESCRIPTION</th>
				</tr>';
		$oeNumListWithQty = '';		
		for($i=0; $i<count($text);$i++) 
		{
			$oeNumListWithQty .= $text[$i];
			$oeNumListWithQty .= '>>>';
			$qInfo = explode('@', $text[$i]);
			$oeNum = trim($qInfo[0]);
			if(isset($qInfo[1]))
				$qty = $qInfo[1];
			else
				$qty = '';
			echo'<tr>
					<td>'.($i+1).'</td>
					<td>'. $oeNum .'</td>
					<td>'. $qty .'</td>';
			if(isset($info[$oeNum])) {		
				echo'<td>'. $info[$oeNum]['maker'] .'</td>
					<td>'. $info[$oeNum]['part_desc'] .'</td>';
			}else {	
				echo'<td colspan="2">
						<div class="alert alert-warning">
				 			<h4>
				 				<i class="fa fa-exclamation-triangle"></i> <u>'.$oeNum.'</u> is NOT in our DB SYSTEM. Please check the number. 
				 			</h4>
						</div>
					</td>';
			}	
			echo'</tr>';
		}
		echo 	'<tr>	
					<td colspan="5" style="text-align:center;">
					<br/><br/>
					<div class="btn-group" role="group">
						<form action="?mode=quote" method="POST">
						<button type=""submit" class="btn btn-danger btn-lg">
						<input type="hidden" name="buyer" value="'. $_POST['buyer'] .'" >
						<input type="hidden" name="oeNumList" value="'. $oeNumListWithQty .'" >
						<i class="fa fa-flask"></i> GENERATE A QUOTATION</button> 
						</form>
					</div>
					<div class="btn-group" role="group">	
						<button type="button" class="btn btn-default btn-lg" onclick="location.reload();">
						<i class="fa fa-refresh"></i> Reload this page</button>
					</div>	
					</td>
					
					
				</tr>';		
		echo'</table></br>';
	}
	else
	{
		header("location:quotation.php");
	}	
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 1 : UPLOAD PAGE (INSERT)
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/	
else 
{
	$_SESSION['sNameFullList'] = [];
	$_SESSION['vList'] = [];
	$_SESSION['minAMT'] = [];

	$query = "SELECT DISTINCT Buyer_company, Buyer_ID FROM buyers GROUP BY Buyer_company";
	$result = mysqli_query($db_link, $query);

	while($row=mysqli_fetch_assoc($result)) 
	{
		$bList[] = $row['Buyer_company'];
	}
?>
<div class="container"> 
     <div class="row">
    	<div class="col-md-3 col-md-offset-0">
    	<form action="?mode=preview" method="POST">
    		<label>Select a Buyer Name : </label>
    		<select class="select2 form-control" name="buyer" required="required">
    			<option></option>
    <?php
    	foreach($bList AS $list) 
    	{
    		echo'<option value="'. $list .'">'. $list .'</option>';
    	}
    ?>		
   		 	</select>	
    	</div>
    </div>
    <div class="clearfix"></br></div>
    <div class="row">	
        <div class="col-md-3 col-md-offset-0">
        	<label>Text Box</label>
        	<textarea name="text" class="form-control" rows="25" placeholder="PLEASE PASTE... 'OE NUMBERS(SHORT)@QTY'" required="required"></textarea>
        	<input type="hidden" name="resetVender" value="true" /><br/>
        	<input type="submit" name="submit" class="btn btn-warning btn-lg" value="GENERATE PREVIEW OF QUOTATION"/>
        </form>
        </div>	
        <div class="col-md-3 col-md-offset-0">
        	<h3>How to Generate A Quotation</h3>
        	<p>Users can add items by copying cells from an excel file</p>
        	<ol>
        		<li>Make 3 columns OE Number(SHORT), @ , and QTY at an excel file.
        			<table class="table">
        				<tr>
        					<td>65400ZP00A</td>
        					<td>@</td>
        					<td>12</td>
        				</tr>
        				<tr>	
        					<td>84992JK000</td>
        					<td>@</td>
        					<td>5</td>
        				</tr>
        				<tr>
        					<td>FBM261CB0A</td>
        					<td>@</td>
        					<td>7</td>
        				</tr>
        			</table>  
        		</li>	      		
        		<li>SELECT all the cells <kbd><kbd>ctrl</kbd> + <kbd>a</kbd></kbd> of 3 columns which made at #1.</li>
        		<li>COPY the selected cells  <kbd><kbd>ctrl</kbd> + <kbd>c</kbd></kbd> from excel file.</li>
        		<li>PASTE the copied cells  <kbd><kbd>ctrl</kbd> + <kbd>v</kbd></kbd> into the text box of Quotation Generator.</li>
        		<li>CLICK the 'GENERATE PREVIEW OF QUOTATION' button</li>
        	</ol>
        	<p>Important</p>
        	<p> *** OE Number MUST be in <u>SHORT FORM</u> ***</p>
        </div>
        <div class="col-md-3 col-md-offset-0">	
        	<br/><br/><br/>
        	<h4>RUNTIME of Quotation Generator</h4>
        	<table class="table">
        		<tr>
        			<td>No of Rows</td>
        			<td>Step1 -> Step2</td>
        			<td>Step2 -> Step3</td>
        			<td>Total</td>
        		</tr>
        		<tr>	
        			<td>1,000</td>
        			<td>6 sec</td>
        			<td>15 sec</td>
        			<td>21 sec</td>
        		</tr>
        		<tr>
        			<td>3,000</td>
        			<td>20 sec</td>
        			<td>35 sec</td>
        			<td>55 sec</td>
        		</tr>
        		<tr>
        			<td>5,000</td>
        			<td>35 sec</td>
        			<td>60 sec</td>
        			<td>1min 35 sec</td>
        		</tr>
        		<tr>
        			<td>10,000</td>
        			<td>20 sec</td>
        			<td>35 sec</td>
        			<td>55 sec</td>
        		</tr>
        
        
        	</table>  
        </div>
    </div>
</div>
<?php
}
?>

<script type="text/javascript">
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if (scroll > 400) {
		  	$('.mSidebar').css("position", "fixed");
		    $('.mSidebar').css("top", 5);
		    
		} else {
		  	$('.mSidebar').css("position", "absolute");
		    $('.mSidebar').css("top", 70);
		}
	});
</script>

<?php
ob_flush();
include('themes/gentelella/footer.php'); 
?>