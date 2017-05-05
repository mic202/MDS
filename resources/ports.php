<?php
// Call database
require_once('admin/connect.ini.php');

if(isset($_GET['action'])) 
{
	$port_name = trim($_POST['port_name']);
	
	if(isset($_POST['port_id']))
		$port_id = $_POST['port_id'];

	switch($_GET['action'])
	{
		case 'add';
		$query = "INSERT INTO ports 
					(Port_name)
				VALUES 
					(UPPER('$port_name'))";
		if($port_id != null)			
			$result = mysqli_query($db_link, $query);	
				
		break;

		case 'update';
		

		$query = "UPDATE ports SET
					Port_name = UPPER('$port_name')
				WHERE 
					Port_ID = '$port_id'";
				
		$result = mysqli_query($db_link, $query);			
		break;			
	}
	
	header('location:ports.php');
}
?>
<div class="col-lg-12">
    <h1 class="page-header">Ports List <i class="fa fa-anchor fa-fw"></i></h1>
</div>
<div class="col-lg-12">    
    <table id="datatable-responsive" class="table table-striped table-bordered table-hover" cellspacing="0" >
        <thead>
            <tr>
                <th width="70">#</th>
                <th>Ports</th>
                <th ></th>
			</tr>
        </thead>
        <tbody>
        	<form action="?page=port&action=add" method="POST"> 
        	<tr class="danger">
        		<td><i class="fa fa-plus fa-fw"></i> </td>
        		<td><input class="form-control" size="100" name="port_name"></td>
        		<td><button type="submit" class="btn btn-success">Add</button></td>
        	</tr>
        	</form>
	<?php
		$query = "SELECT Port_ID, Port_name FROM ports";
		$result = mysqli_query($db_link, $query);
		
		$i = 1;
		while($row = mysqli_fetch_assoc($result)) {
			if(isset($_GET['mode']) && $_GET['mode'] == 'edit' && $_GET['row'] == $row['Port_ID']) 
			{
			echo '<form action="?page=port&action=update" method="POST">';
			echo '<input type="hidden" name="port_id" value="'. $row['Port_ID'] .'" >';
			echo '<tr>';
				echo'<td>'.$i.'</td>';
				echo'<td><input class="form-control" value="'.$row['Port_name'].'" name="port_name" ></td>';
				echo'<td>
						<button type="submit" class="btn btn-info">Update</button>
					</td>';
			echo '</tr>
				</form>';	
			}
			else 
			{	
			echo '<tr>';
				echo'<td>'.$i.'</td>';
				echo'<td>'.$row['Port_name'].'</td>';
				echo'<td>
						<a href=?page=port&mode=edit&row='. $row['Port_ID'] .'><button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-fw"></i> Edit </button></a>
						<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-times fa-fw"></i> Del </button>
					</td>';
			echo'</tr>';
			}
			$i++;	
		}
	?>

		</tbody>
	</table>	
</div>
