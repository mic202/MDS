<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');
$query = "SELECT maker, model, model_year, part_desc, part_name, part_group, part_code, part_cube, mic_num, oe_num, oe_num_short, oe_price_us, op_us_date, oe_price_ca, op_ca_date, comment 
			FROM parts WHERE id = ". $_GET['id'];
$result = mysqli_query($db_link, $query);
$row = mysqli_fetch_assoc($result);
$oe_num_short = $row['oe_num_short'];
?>
<style>
.table-hover tbody tr:hover td {
    background: #d8ffd8;
}
.table-hover {
	 font-size: 12px;
}

</style>
<ol class="breadcrumb">
  <li><a href="parts_master.php">Parts Master</a></li>
  <li><a href="parts_master.php?sSearch=<?php echo $row['maker']; ?>"><?php echo $row['maker'] ?></a></li>
  <li><a href="parts_master.php?sSearch=<?php echo $row['model']; ?>"><?php echo $row['model'] ?></a></li>
  <li class="active"><?php echo $row['oe_num_short'] ?></li>
</ol>

<div class="row">
	<div class="col-xs-6 col-md-3">
	    <a href="#" class="thumbnail">
	      <img src="sources/images/mic_logo.jpg" alt="" width="200">
	    </a>
	</div>
 	<div class="col-xs-6 col-md-6">
		<table class="table table-hover">
			<tr>
				<th >MIC Number : </th>
				<td><?php echo $row['mic_num']; ?></td>
			</tr>
			<tr>
				<th>OE Number (Short) : </th>
				<td><?php echo $row['oe_num']; ?> ( <?php echo $row['oe_num_short']; ?> ) </td>
			</tr>
			<tr>
				<th>Maker : </th>
				<td><?php echo $row['maker']; ?></td>
			</tr>
			<tr>
				<th>Model (Year) : </th>
				<td><?php echo $row['model']; ?> ( <?php echo $row['model_year']; ?> )</td>
			</tr>
			<tr>
				<th>Part Description : </th>
				<td><?php echo $row['part_desc']; ?></td>
			</tr>
			<tr>
				<th>Part Name : </th>
				<td><?php echo $row['part_name']; ?></td>
			</tr>
			<tr>
				<th>Group (Code) : </th>
				<td><?php echo $row['part_group']; ?> ( <?php echo $row['part_code']; ?> )</td>
			</tr>
			<tr>
				<th>OE Prices ( USD / CAD ): </th>
				<td>USD <?php echo number_format($row['oe_price_us'],2) . '( ' . date("m/d/y", strtotime($row['op_us_date'])); ?> ) / CAD <?php echo number_format($row['oe_price_ca'],2). '( ' . date("m/d/y", strtotime($row['op_ca_date'])); ?> )</td>
			</tr>
			<tr>
				<th>CUBE : </th>
				<td><?php echo floatval($row['part_cube']); ?></td>
			</tr>
			<tr>
				<th>Comment :  </th>
				<td><?php echo $row['comment'] ?></td>
			</tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-6 col-md-offset-3">
		<a href="part_details_edit.php?id=<?php echo $_GET['id']; ?>" target="_blank">
			<button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</button>
		</a>
	</div>
</div>
<br/>

<?php

$pQuery = "SELECT supplier_name, price, price_type, currency, update_date FROM prices_supplier WHERE oe_num_short = '$oe_num_short'";
$pResult = mysqli_query($db_link, $pQuery);
while($pRow = mysqli_fetch_assoc($pResult))
{
	$uDate = date("m/d/y", strtotime($pRow['update_date']));
	$pList[$pRow['supplier_name']] = $pRow['currency'] .' '. $pRow['price'] . "<br/>". $pRow['price_type'] ."<br/>( ". $uDate ." )";
	
}	
if(!isset($pList)) 
{
	echo '<div class="alert alert-warning" role="alert"><b><i class="fa fa-minus-circle"></i> There is NO price list for this item. If you want to add new price for this item, please  <a href="#"> click here </a></b></div>';
}
else
{	
?>
	<div class="row">
		<table class="table table-hover">
			<tr>
				<th width="10%">OE Price (USD)</th>
				<th width="10%">OE Price (CAD)</th>
	<?php
		$sList = array_keys($pList);
		for($i=0; $i<count($pList); $i++)
		{
			echo'<th width="8%">'. $sList[$i] .'</th>';
		}	
		for($c=$i; $c<10; $c++)
		{
			echo'<th width="8%"></th>';
		}
	?>			
			</tr>
			<tr>
				<td><?php echo $row['oe_price_us']; ?><br/>( <?php echo date("m/d/y", strtotime($row['op_us_date'])); ?> )</td>
				<td><?php echo $row['oe_price_ca']; ?><br/>( <?php echo date("m/d/y", strtotime($row['op_ca_date'])); ?> )</td>
	<?php
		for($i=0; $i<count($pList); $i++)
		{
			echo'<td>'. $pList[$sList[$i]] .'</td>';
		}	
	?>						
				<td></td>
			</tr>
		</table>
	</div>

<?php
}
include('themes/gentelella/footer.php'); 
?>