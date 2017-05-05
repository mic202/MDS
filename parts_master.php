<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

require ('app/paginator.php');

$aColumns = array('id', 'part_id','maker', 'oe_num_short', 'ss_num', 'mic_num', 'model', 'model_year', 'part_desc', 'part_name', 'comment');
	
/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "maker";
	
/* DB table to use */
$sTable = "parts";

require('app/mTable.php');

?>

<style>
.table-hover tbody tr:hover td {
    background: #d8f0ff;
}
.table-hover {
	 font-size: 12px;
}
.table-hover a {
	color: #fff;
}	 
</style>

<div class="col-lg-12">
    <h1 class="page-header">PARTS MASTER <i class="fa fa-gears"></i> <small>Ver 3.2 </small></h1>
</div>


<?php
	$url = '&iSortCol='.$_GET['iSortCol'].'&sSortDir='.$_GET['pSortDir'].'&pSortDir='.$_GET['pSortDir'].'&sSearch='.$_GET['sSearch']; 
	echo mPagination(5, 'pagination', $mTotal, $url); 

	$sortVar = "sSortDir=". $_GET['sSortDir']. "&pSortDir=". $_GET['pSortDir'].'&sSearch='.$_GET['sSearch'];
?>

<table width="100%">
	<tr>
		<td><?php echo page_length_list(); ?></td>
		<td align="right"><?php echo display_search_bar(); ?></td>
	<tr>	
</table>
<br/>
<table class="table table-hover">
	<thead>
		<tr style="background: #404040; color:#fff;">
			<th>
				<a href="?iSortCol=1&<?php echo $sortVar; ?>">
					Part ID <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],1);?>
				</a>
			</th>
			<th>
				<a href="?iSortCol=2&<?php echo $sortVar; ?>">
					MAKER <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],2);?>
				</a>
			</th>
			<th>
				<a href="?iSortCol=3&<?php echo $sortVar; ?>">
					OE SHORT<?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],3);?>
				</a>
			</th>
			<th>
				<a href="?iSortCol=4&<?php echo $sortVar; ?>">
					S/S<?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],4);?>
				</a>	
			</th>
			<th>
				<a href="?iSortCol=5&<?php echo $sortVar; ?>">
					MIC NUM <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],5);?>
				</a>
			</th>
			<th>
				<a href="?iSortCol=6&<?php echo $sortVar; ?>">
					MODEL <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],6);?>
				</a>
			</th>
			<th>
				<a href="?iSortCol=7&<?php echo $sortVar; ?>">
					YR <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],7);?>
				</a>
			</th>
			<th width="25%">
				<a href="?iSortCol=8&<?php echo $sortVar; ?>">
					DESCRIPTION <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],8);?>
				</a>
			</th>
			<th width="10%">
				<a href="?iSortCol=9&<?php echo $sortVar; ?>">
					PART NAME <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],9);?>
				</a>
			</th>
			<th>
				<a href="?iSortCol=10&<?php echo $sortVar; ?>">
					COMMENT <?php echo sIcon($_GET['sSortDir'],$_GET['iSortCol'],10);?>
				</a>
			</th>			
						
						
			<th colspan="2">
				
			</th>
		</tr>
	</thead>
	
	<tbody>	
<?php
	//$special_format = array("row"=>"part_cube", "value"=>("floatval($aRow[ $aColumns[$i] ])"));
	echo $tableRows;

?>

	</tbody>
</table>



<br/>

<?php


echo mPagination(5, 'pagination', $mTotal, $url); 

include('themes/gentelella/footer.php'); 
?>