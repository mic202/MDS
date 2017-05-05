<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

require ('app/paginator.php');
?>
<style>
.table-hover tbody tr:hover td {
    background: #1ABB9C;
    color: #fff;
}
.table-hover {
	 font-size: 12px;
}
.table-hover a {
	color: #fff;
}	 
</style>
<div class="col-lg-12">
    <h1 class="page-header">Ver 1.0 <i class="fa fa-list-alt"></i></h1>
</div>
<?php
		


$db_col_names = array('id', 'maker', 'oe_num', 'oe_num_short', 'mic_num', 'model', 'model_year', 'part_desc', 'part_name', 'part_code', 'part_group', 'part_cube', 'hs_code_us', 'oe_price_usa');
$table_header = array('LI', 'MAKER', 'OE LONG', 'OE SHORT','MIC NUMBER', 'MODEL', 'M YR', 'DESCRIPTION', 'PART NAME', 'CODE', 'GROUP', 'CBM', 'HS CODE','OE PRICE');

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'ASC';
$col_num = (isset($_GET['col_num'])) ? $_GET['col_num'] : 0;
$order = ' ORDER BY '. $db_col_names[$col_num] .' '. $sort;
$url = '&sort='.$sort.'&col_num='. $col_num;
if($sort == 'DESC') 
{
	$sort_icon = ' <i class="fa fa-sort-amount-desc"></i>'; 	
	$sort = 'ASC';
}
else
{	
	$sort_icon = ' <i class="fa fa-sort-amount-asc"></i>'; 
	$sort = 'DESC';
}

if(isset($_REQUEST['col_name'])) 
{
	$col_name = $_REQUEST['col_name'];
	$q = $_REQUEST['q'];
	$s_condition = " WHERE ".$col_name. " LIKE '%".$q."%' ";
	$query = "SELECT * FROM parts " . $s_condition;
}
else
	$query = "SELECT * FROM parts ".$order;

//These variables are passed via URL
$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 100; // Number of rows per page
$page = (isset($_GET['page'])) ? $_GET['page'] : 1; // starting page
$links = 5;

$paginator = new Paginator($db_link, $query); //__ constructor is called. Connect to DB and call it to get total number of rows
$result = $paginator->getData($limit, $page);
//if(!isset($results->data)) {
//	throw new Exception('Division by zero.');
//}	
//print_r($results);die; $results is an object, $result->data is an array

//print_r($results->data);die; //array

echo $paginator->createLinks($links, 'pagination', $url);

?>
<table width="100%">
	<tr>	
		<td>
			<form class="form-inline" action="?" method="POST">
				<div class="form-group">
				    <label for="limit">Show </label>
				 	<select class="form-control" name="limit" id="limit" onchange="this.form.submit()">
	<?php
			$rpp_list = array(100, 500, 1000);
			foreach($rpp_list as $rpp) 
			{
				if($_REQUEST['limit'] == $rpp)
					echo '<option selected>'.$rpp.'</option>';
				else
					echo '<option>'.$rpp.'</option>';
			}
	?>				</select>
					<label for="rpp"> entries</label>
				</div>
			</form>		
		</td>
		<td align="right">
			<form class="form-inline" action="?" method="POST">
				<div class="form-group">
				    <label for="col_name">Search: </label>
				    <select name="col_name" class="form-control">
				    	<option></option>
	<?php
			for($i=0; $i<count($table_header); $i++) 
			{
				
				echo'<option value="'. $db_col_names[$i] .'">'. $table_header[$i] .'</option>';
			}
	?>			    	
				    </select>
					<input class="form-control" name="q">
				</div>
			</form>		
		</td>
	</tr>
</table><br/>		
<?php		
 
echo'<table  class="table table-hover ">';
echo '<thead style="background: #405467; color:#fff;">
		<tr >';
for($i=0; $i<count($table_header); $i++) 
{
	if($col_num == $i)
		echo'<th style="background: #C9302C; max-width:10%;"><a href="?sort='.$sort.'&col_num='.$i.'&limit='.$limit.'">'. $table_header[$i] . $sort_icon .'</a></th>';
	else
		echo '<th style="max-width:10%;"><a href="?sort='.$sort.'&col_num='.$i.'&limit='.$limit.'">'. $table_header[$i] .'</a></th>';
}
		echo '<th></th>';
echo	'</tr>
	</thead>';
echo'<tbody>';	

$row_style = array('','','','','','','','','','align="right"','','align="right"','','align="right"');

foreach($result->data as $rows) 
{
	echo'<tr>';
		$index = 0;
		foreach($rows as $row) 
		{
			if($index==11)
			echo '<td '. $row_style[$index] .'>'. floatval($row) .'</td>';
			else
			echo '<td '. $row_style[$index] .' >'. $row .'</td>';
			$index ++;
		}

	echo'</tr>';
}	
echo'</tbody>
</table>';

echo $paginator->createLinks($links, 'pagination', $url);

include('themes/gentelella/footer.php'); 
