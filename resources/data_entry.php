<?php
include 'header.php';
// Call database
require_once('../admin/connect.ini.php');
?>

<div id="page-wrapper">
	<div class="col-lg-12">
        <h1 class="page-header">Data Entry</h1>
  	 	<div class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Select a Database Name
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			   	<li><a href="?db=address">address</a></li>
			    <li><a href="?db=buyers">buyers</a></li>
			    <li><a href="?db=suppliers">suppliers</a></li>
			    <li><a href="?db=users">users</a></li>
			</ul>
		</div>
	</div>			
	
<?php
if(isset($_REQUEST['db'])) 
{
?>	
	<div class="col-lg-12">
		</br>
		<table class="table">
			<tr>

	<?php
		


		$query = "SHOW COLUMNS FROM ".$_REQUEST['db'];
		if($result = mysqli_query($db_link, $query))
		{	
			$num_col = 0;
		    while ($row = mysqli_fetch_assoc($result)) {
		        echo '<th>'.$row['Field'].'</th>';
		        $input_name[] = $row['Field'];
		        $num_col++;
		    }
		}
		else
		{
			$input_name[0] = '';
		}    
	?>
				
			</tr>
			<form action="?action=add" method="POST">
				<input type="hidden" name='db' value="<?php echo $_REQUEST['db']; ?>" />
	<?php
		for($i=0; $i<10;$i++) {
			echo'<tr>';
				echo'<td></td>';
			for($c=1; $c<$num_col;$c++) 
			{
				echo'<td><input type="text" class="form-control" name="'.$input_name[$c].'['.$i.']" placeholder="'.$input_name[$c].'['.$i.']" ></td>';
			}
			echo'</tr>';
		}
	?>		
			<tr>
				<td colspan="<?php echo $num_col; ?>">
					<input class="btn btn-primary" type="submit" value="Save to Database">
				</td>
			</tr>
			</form>
		</table>   
	</div>	
<?php
}
print_r($input_name);
include 'footer.php';
