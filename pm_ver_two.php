<?php
include('themes/gentelella/header.php'); 
?>
<style>
.table-hover tbody tr:hover td {
    background: #1ABB9C;
    color: #fff;
}
.table-hover {
	 font-size: 12px;
}
.table-hover a {
	color: #fff;
}	 
</style>
<div class="col-lg-12">
    <h1 class="page-header">Ver 2.0 <i class="fa fa-list-alt"></i>&nbsp;&nbsp;&nbsp;<code>With Server-side DataTables</code></h1>
</div>

<table id="parts" class="table table-striped table-hover" cellspacing="0" width="100%">
	<thead style="background: #405467; color:#fff;">
		<tr>
			<th>LI</th>
			<th>MAKER</th>
			<th>OE LONG</th>
			<th>OE SHORT</th>
			<th>MIC NUM</th>
			<th>MODEL</th>
			<th>YEAR</th>
			<th>DESCRIPTION</th>
			<th>NAME</th>
			<th>CODE</th>
			<th>GROUP</th>
			<th>CUBE</th>
			<th>HS CODE</th>
			<th>OE PRICE</th>
		</tr>
	</thead>
	<tfoot style="background: #405467; color:#fff;">
		<tr>
			<th>LI</th>
			<th>MAKER</th>
			<th>OE LONG</th>
			<th>OE SHORT</th>
			<th>MIC NUM</th>
			<th>MODEL</th>
			<th>YEAR</th>
			<th>DESCRIPTION</th>
			<th>NAME</th>
			<th>CODE</th>
			<th>GROUP</th>
			<th>CUBE</th>
			<th>HS CODE</th>
			<th>OE PRICE</th>
		</tr>
	</tfoot>
	<tbody>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready( function () {
		$('#parts').DataTable( {
			"order"		 : [[1, "asc"]],	
			"lengthMenu" : [100, 500, 1000, 5000, 10000],
			"pageLength" : 100,
			"bProcessing": true,
			"bSearchable": true,
		    "bServerSide": true,
   			"sAjaxSource": "app/datatables_server_processing.php"  		
		} );
	});	
</script>




<?php
include('themes/gentelella/footer.php'); 