
<div class="col-lg-12">
    <h1 class="page-header">Parts Coding System <i class="fa fa-cubes"></i></h1>
</div>
<div class="col-lg-12">    
    <table id="datatable-responsive" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>CODE ( AA part of PAT Coding )</th>
            </tr>
        </thead>
        <tbody>
	<?php 
		$query = "SELECT * FROM parts_coding_system";
		$result = mysqli_query($db_link, $query);
		$i=1;
		while($row = mysqli_fetch_array($result)) {
			echo'<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$row['maker_name'].'</td>';
				if($row['maker_code'] == 0)
					$maker_code = 'N/A';
				else
					$maker_code = $row['maker_code'];
				echo '<td>'.$maker_code.'</td>';
			echo'</tr>';
			$i++;	
		}
	?>
		</tbody>
	</table>	
</div>

