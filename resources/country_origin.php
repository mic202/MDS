<div class="col-lg-12">
    <h1 class="page-header">Country of Origin List <i class="fa fa-flag fa-fw"></i></h1>
</div>
<div class="col-lg-12">    
    <table id="datatable-responsive" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" >
        <thead>
            <tr>
                <th width="70">#</th>
                <th>Countries</th>
                <th width="100"></th>
                
            </tr>
        </thead>
        <tbody>
	<?php
		$query = "SELECT Country_name FROM country_origin";
		$result = mysqli_query($db_link, $query);
		
		$i = 1;
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr>';
				echo'<td>'.$i.'</td>';
				echo'<td>'.$row['Country_name'].'</td>';
				echo'<td>
						<button type="submit" class="btn btn-primary btn-xs">Edit</button>
						<button type="submit" class="btn btn-danger btn-xs">Del</button>
					</td>';
			echo'</tr>';
			$i++;	
		}
	?>
		</tbody>
	</table>	
</div>

