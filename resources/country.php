<?php
include '../themes/SBAdmin2/pages/header.php';
// Call database
require_once('../admin/connect.ini.php');
?>

<div id="page-wrapper">
	<div class="col-lg-12">
        <h1 class="page-header">Countries List <i class="fa fa-flag fa-fw"></i></h1>
    </div>
    
    <table id="datatable-responsive" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" >
        <thead>
            <tr>
                <th>#</th>
                <th>FIPS</th>
                <th>ISO</th>
                <th>TLD</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
	<?php
		$query = "SELECT * FROM country";
		$result = mysqli_query($db_link, $query);
		
		$i = 1;
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr>';
				echo'<td>'.$i.'</td>';
			foreach($row as $td_value) {
				echo'<td>'.$td_value.'</td>';
			}
			echo'</tr>';
			$i++;	
		}
	?>
		</tbody>
	</table>	
</div>


<?php
include '../themes/SBAdmin2/pages/footer.php';
?>