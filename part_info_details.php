<?php
// Call database
require_once('admin/connect.ini.php');
$query = "SELECT oe_num, mic_num, oe_num_short, model, model_year, part_name, part_desc, part_group, part_code, oe_price_us, oe_price_ca, hs_code_us, part_cube, maker, comment, ss_num  FROM parts WHERE part_id = ".$_GET['pSearch']." ORDER BY ss_num DESC";
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
$info = '';
$ss_parts = '';
while($row = mysqli_fetch_assoc($result))
{
	if(isset($row['ss_num']) && $row['ss_num'] != null)
		$ss_parts .= $row['oe_num'] . " ( ". $row['oe_num_short'] ." ) <br/>";
	else
	{	
		$info .= "<br/>
				<tr>
					<th><i class='fa fa-angle-right'></i>  Part OE No.  </th>	
					<td>".$row['oe_num']." ( ".$row['oe_num_short']." )</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> MIC No. </th>
					<td>".$row['mic_num']."</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Model  </th>
					<td>".$row['model']."</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Model Year </th>
					<td>".$row['model_year']."</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Part Name </th>
					<td>".$row['part_name']."</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Part Description	</th>
					<td>".$row['part_desc']."</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Part Group </th>
					<td>".$row['part_group']."	( ". $row['part_code'] ." )</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> OE Price </th>
					<td>".$row['oe_price_us']."	( USD ) &nbsp;&nbsp;&nbsp;". $row['oe_price_ca'] ."( CAD )</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> HS CODE </th>
					<td>".$row['hs_code_us']."	( US )</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> CUBE </th>
					<td>".floatval($row['part_cube'])."	( US )</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Manufacturer </th>
					<td>".$row['maker']."</td>
				</tr>
				<tr>	
					<th><i class='fa fa-angle-right'></i> Comment </th>
					<td>".$row['comment']."</td>
				</tr>
				<tr>
					<th colspan=2 style='background-color: #fff;'><br/><br/>This is the current replacement for all of the part numbers listed below</th>
				</tr>
				<tr>
					<th colspan=2>". $ss_parts ."<br/></th>
				</tr>";
	}			
}	
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title" id="myModalLabel"><i class='fa fa-info-circle'></i> Part Information </h4>
</div>
<div class="modal-body">
	<table class="table table-hover">
	<?php echo $info; ?>
	</table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
 