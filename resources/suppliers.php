<div class="col-lg-12">
    <h1 class="page-header">Suppliers List</h1>
 </div>
 <div class="col-lg-12">   
    <table id="datatable-responsive" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" >
        <thead>
            <tr>
                <th>#</th>
                <th>Supplier Name</th>
                <th>Company Name</th>
                <th>Address</th>
                <th>Web Site</th>
            </tr>
        </thead>
        <tbody>
	<?php 
		$query = "SELECT * FROM Suppliers";
		$result = mysqli_query($db_link, $query);
		$i=1;
		while($row = mysqli_fetch_array($result)) {
			echo'<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$row['Supplier_name'].'</td>';
				echo '<td>'.$row['Supplier_company'].'</td>';
				echo '<td>'.get_address($db_link, 'Supplier_ID', $row['Supplier_ID']).'</td>';
				echo '<td>'.make_URL_list($row['Supplier_website']).'</td>';
			echo'</tr>';
			$i++;	
		}
	?>
		</tbody>
	</table>	
</div>

