<div class="col-lg-12">
    <h1 class="page-header">Buyers List</h1>
</div>
<div class="col-lg-12">    
 	<table id="datatable-responsive" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" >
        <thead>
            <tr>
                <th>#</th>
                <th>Buyer Name</th>
                <th>Company Name</th>
                <th>Address</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
	<?php 
		$query = "SELECT Buyer_ID, Buyer_name, Buyer_company, Buyer_location FROM buyers";
		$result = mysqli_query($db_link, $query);
		$i=1;
		while($row = mysqli_fetch_array($result)) {
			echo'<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$row['Buyer_name'].'</td>';
				echo '<td>'.$row['Buyer_company'].'</td>';
				echo '<td>'.get_address($db_link, 'Buyer_ID', $row['Buyer_ID']).'</td>';
				echo '<td>'. $row['Buyer_location'] .'</td>';
			echo'</tr>';
			$i++;	
		}
	?>
		</tbody>
	</table>	
</div>
