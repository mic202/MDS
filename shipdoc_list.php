<?php
include('themes/gentelella/header.php'); 

// Call database
require_once('admin/connect.ini.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#default_table').dataTable(
        {
            "columnDefs":
            [{
                "searchable": false, "targets": 0,
                "searchable": false, "targets": -1,
                "orderable": false, "targets": 0,
                "orderable": false, "targets": -1
            }],
             "pageLength": 25
        });
    });
</script>


<div class="col-lg-12">
    <h1 class="page-header">ShipDoc List <i class="fa fa-list-alt"></i></h1>
</div>
 <table id="default_table" class="table table-striped table-bordered table-hover" cellspacing="0" >
    <thead>
        <tr>
            <th width="70">#</th>
            <th>Invoce #</th>
            <th>CNTR #</th>
            <th>SEAL #</th>
            <th>SHIPPER/EXPORTER</th>
            <th>CONSIGNEE</th>
            <th>PORT OF LOADING</th>
            <th>FINAL DESTINATION</th>
            <th>LADEN ON BOARD</th>
            <th></th>
		</tr>
    </thead>
    <tbody>
<?php
	$query = "SELECT * FROM shipping_doc_list";
	$result = mysqli_query($db_link, $query);
	$i = 1;
	while($row = mysqli_fetch_array($result)) 
	{
		echo'<tr>';
			echo'<td>'.$i.'</td>';
			echo'<td>'. $row['Invoice_num'] .'</td>';
			echo'<td>'. $row['Container_num'] .'</td>';
			echo'<td>'. $row['Seal_num'] .'</td>';
			echo'<td>'. $row['Shipper_name'] .'</td>';
			echo'<td>'. $row['Importer_name'] .'</td>';
			echo'<td>'. $row['Port_loading'] .'</td>';
			echo'<td>'. $row['Final_dest'] .'</td>';
			echo'<td>'. date("M d, Y", strtotime($row['Laden_date'])) .'</td>';
			echo'<td><a href="shipdoc_view.php?id='. $row['Ship_doc_ID'] .'"><i class="fa fa-copy"></i></td>';
		echo'</tr>';	
		$i++;	
	}     
?>
    </tbody>
</table>        



<?php
include('themes/gentelella/footer.php');
?>