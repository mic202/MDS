<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

if(isset($_POST['action']) && $_POST['action'] == 'update')
{
	$id = $_GET['id'];
	$part_id = trim($_POST['part_id']);
	$mic_num = trim($_POST['mic_num']);
	$oe_num = trim($_POST['oe_num']);
	$oe_num_short = str_replace("-", "", $_POST['oe_num']);
	$oe_num_short = str_replace(" ", "", $_POST['oe_num']);
	$maker = trim($_POST['maker']);
	$model = trim($_POST['model']);
	$model_year = trim($_POST['model_year']);
	$part_desc = trim($_POST['part_desc']);
	$part_name = trim($_POST['part_name']);
	$part_group = trim($_POST['part_group']);

	$oe_price_us = $_POST['oe_price_us'];
	if($_POST['oe_price_us_old'] == $_POST['oe_price_us']) 
		$op_us_date = $_POST['op_us_date'];
	else
		$op_us_date = date('Y-m-d');

	$oe_price_ca = $_POST['oe_price_ca'];
	if($_POST['oe_price_ca_old'] == $_POST['oe_price_ca']) 
		$op_ca_date = $_POST['op_ca_date'];
	else
		$op_ca_date = date('Y-m-d');
	
	$hs_code_us = trim($_POST['hs_code_us']);
	$part_cube = $_POST['part_cube'];
	$ss_num = trim($_POST['ss_num']);
	$ss_date = $_POST['ss_date'];
	$comment = trim($_POST['comment']);
	$query = "UPDATE parts SET
				part_id = '$part_id',
				mic_num = '$mic_num',
				oe_num = '$oe_num',
				oe_num_short = '$oe_num_short',
				maker = '$maker',
				model = '$model',
				model_year = '$model_year',
				part_desc = '$part_desc',
				part_name = '$part_name',
				part_group = '$part_group',
				oe_price_us = '$oe_price_us',
				op_us_date = '$op_us_date',
				oe_price_ca = '$oe_price_ca',
				op_ca_date = '$op_ca_date',
				hs_code_us = '$hs_code_us',
				part_cube = '$part_cube',
				ss_num = '$ss_num',
				ss_date = '$ss_date',
				comment = '$comment'
			WHERE id = 	$id";
	$result = mysqli_query($db_link, $query);	

	$cArray = array('bg-success', 'bg-warning', 'bg-primary', 'bg-info', 'bg-danger');
	echo '<br/><br/><br/><div class="'.$cArray[array_rand($cArray)].'" style="text-align:center;"><br/>&nbsp;&nbsp;&nbsp;Part Infomation has been UPDATED <br/><br/></div>';
}


$query = "SELECT part_id, maker, model, model_year, part_desc, part_name, part_group, part_code, part_cube, mic_num, oe_num, oe_num_short, oe_price_us, op_us_date, oe_price_ca, op_ca_date, hs_code_us, ss_num, ss_date, comment 
			FROM parts WHERE id = ". $_GET['id'];
$result = mysqli_query($db_link, $query);
$row = mysqli_fetch_assoc($result);
?>
<div class="row">
	<ol class="breadcrumb">
	  <li><a href="parts_master.php">Parts Master</a></li>
	  <li><a href="parts_master.php?sSearch=<?php echo $row['maker']; ?>"><?php echo $row['maker'] ?></a></li>
	  <li><a href="parts_master.php?sSearch=<?php echo $row['model']; ?>"><?php echo $row['model'] ?></a></li>
	  <li class="active"><?php echo $row['oe_num_short'] ?></li>
	</ol>
</div>	
<div class="row">
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
            	<h2>UPDATE Part Information</h2>
            	<div class="clearfix"></div>
            </div>
			<div class="x_content">
				<table class="table table-hover">
				<form action="?id=<?php echo $_GET['id']; ?>" method="POST" >
					<input type="hidden" name="action" value="update" >
					<tr>
						<td>
							<div class="form-group">
								<label for="part_id"> Part ID : </label>
								<input type="text" class="form-control" name="part_id" required="required" value="<?php echo $row['part_id']; ?>" >
							</div>	
						</td>
						<td>	
							<div class="form-group">
								<label for="mic_num"> MIC Number : </label>
								<input type="text" class="form-control" id="mic_num" name="mic_num" required="required" value="<?php echo $row['mic_num']; ?>" >
							</div>
						</td>
						<td colspan="2">	
							<div class="form-group">	
								<label for="oe_num">OE Number <small>(Short form will be generated automatically) </small> : </label>
								<input type="text" class="form-control" name="oe_num" required="required" value="<?php echo $row['oe_num']; ?>" > 
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="maker"> Maker : </label>
								<input type="text" class="form-control" name="maker" required="required" value="<?php echo $row['maker']; ?>" >
							</div>
						</td>	
						<td colspan="2">
							<div class="form-group">
								<label for="model">Model : </label>
								<input type="text" class="form-control" name="model" required="required" value="<?php echo $row['model']; ?>" >
							</div>	
						</td>
						<td>
							<div class="form-group">
								<label for="model_year"> Model Year : </label>
								<input type="text" class="form-control" required="required" data-inputmask="'mask': '99-99'" name="model_year" value="<?php echo $row['model_year']; ?>">
							</div>	
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="form-group">
								<label for="part_desc">Part Description: </label>
								<input type="text" class="form-control" name="part_desc" value="<?php echo $row['part_desc']; ?>">
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="part_name">Part Name: </label>
								<input type="text" class="form-control" name="part_name" value="<?php echo $row['part_name']; ?>">
							</div>
						</td>		
						<td>
							<div class="form-group">
								<label for="part_group">Group Name : </label>
								<input type="text" class="form-control" name="part_group" value="<?php echo $row['part_group']; ?>">
							</div>
						</td>
						<td>		
							<div class="form-group">	
								<label for="part_group">Group Code : </label>
								<input type="text" class="form-control" name="part_code" value="<?php echo $row['part_code']; ?>">
							</div>	
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="oe_price_us">OE Price (US) : </label>
								<input type="hidden" name="oe_price_us_old" value="<?php echo $row['oe_price_us']; ?>">
								<input type="text" class="form-control" name="oe_price_us" value="<?php echo $row['oe_price_us']; ?>">
							</div>
						</td>
						<td>
							<div class="form-group">
								<label for="op_us_date"> Date : </label>
								<input type="text" class="form-control" data-inputmask="'mask': '9999-99-99'" name="op_us_date" value="<?php echo $row['op_us_date']; ?>">
							</div>
						</td>
						<td>
							<div class="form-group">
								<label for="oe_price_ca">OE Price (CA) : </label>
								<input type="hidden" name="oe_price_ca_old" value="<?php echo $row['oe_price_ca']; ?>">
								<input type="text" class="form-control" name="oe_price_ca" value="<?php echo $row['oe_price_ca']; ?>">
							</div>
						</td>
						<td>
							<div class="form-group">
								<label for="op_ca_date"> Date : </label>
								<input type="text" class="form-control" data-inputmask="'mask': '9999-99-99'" name="op_ca_date" value="<?php echo $row['op_ca_date']; ?>">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="hs_code_us">HS Code (US) : </label>
								<input type="text" class="form-control" name="hs_code_us" value="<?php $row['hs_code_us']; ?>">
							</div>	
						</td>
						<td>
							<div class="form-group">
								<label for="hs_code_us">CUBE : </label>
								<input type="text" class="form-control" name="part_cube" value="<?php echo floatval($row['part_cube']); ?>">
							</div>	
						</td>
						<td>
							<div class="form-group">
								<label for="ss_num">Supersede (OE No Short) : </label>
								<input type="text" class="form-control" name="ss_num" value="<?php echo $row['ss_num']; ?>">
							</div>
						</td>	
						<td>
							<div class="form-group">
								<label for="ss_date"> Date : </label>
								<input type="text" class="form-control" data-inputmask="'mask': '9999-99-99'" name="ss_date" value="<?php echo $row['ss_date']; ?>">
							</div>	
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="form-group">
								<label for="comment"> Comment :  </label>
								<input type="text" class="form-control" name="comment" value="<?php echo $row['comment'] ?>">
							</div>	
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Update</button>
							<button class="btn btn-default" onclick="window.close()">
								<i class="fa fa-close"></i> Close
							</button>
						</td>
					</tr>
					</form>
				</table>
			</div>
		</div>
	</div>
</div>	

<?php



include('themes/gentelella/footer.php'); 
?>