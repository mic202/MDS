<div class="col-lg-12">
    <h1 class="page-header">Notify Parties</h1>
</div>
<div class="col-lg-12">    
 	<table id="datatable-responsive" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" >
        <thead>
            <tr>
                <th>#</th>
                <th>Notify Party</th>
                <th>Adress</th>                
                <th>Tel</th>                
                <th>Fax</th>                
                <th>Email</th>                
            </tr>
        </thead>
        <tbody>
	<?php 
		$query = "SELECT * FROM notify_party";
		$result = mysqli_query($db_link, $query);
		$i=1;
		while($row = mysqli_fetch_array($result)) {
			echo'<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$row['Notify_company'].'</td>';
				echo '<td>'.$row['Notify_address'].', '.$row['Notify_location'].', '.$row['Notify_country'].', '.$row['Notify_pc'].' </td>';
				echo '<td>'.$row['Notify_tel'].'</td>';
				echo '<td>'.$row['Notify_fax'].'</td>';
				echo '<td>'.$row['Notify_email'].'</td>';
			echo'</tr>';
			$i++;	
		}
	?>
		</tbody>
	</table>	
</div>
