<?php
include('themes/gentelella/header.php'); 

// Call database
require_once('admin/connect.ini.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
       
              
    } );
} );

</script>
<div class="col-lg-12">
    <h1 class="page-header">Grand Master</h1>
</div>
<div class="col-lg-12">
	<table id="example" class="table table-striped table-bordered table-hover"  width="100%" cellspacing="0"  style="font-size:12px;">
        <thead >
            <tr>
                <th>#</th>
                <th>COO</th>
                <th>Maker</th>
    	        <th>MIC Number</th>
    	        <th>MIC Old #</th>
                <th>OE Number</th>
                <th>Description</th>
                <th>REF Number</th>
                <th>OE LIST</br>(USA)</th>
                <th>OE LIST</br>(CAD)</th>
                <th>OE Month</th>
                <th>Model</th>
                <th>Model Year</th>
               
            </tr>
        </thead>
        <tbody>
<?php
	$query = "SELECT * FROM parts";
	//$result = mysqli_query($db_link, $query);
	

	while($row = mysqli_fetch_assoc($result)) {
		echo '<tr>';
		foreach($row as $td_value) {
			echo'<td>'.$td_value.'</td>';
		}
		echo'</tr>';
	}
?>
		</tbody>
    </table>    
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#grand').dataTable({"columnDefs": [{ "searchable": false, "targets": 0 }]});
    });
</script>

<?php
include('themes/gentelella/footer.php');
?>