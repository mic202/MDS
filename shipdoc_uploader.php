<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

?>

<div class="col-lg-12">
    <h1 class="page-header">ShipDoc Uploader <i class="fa fa-cloud-upload"></i></h1>
</div>
<div class="col-lg-12">
	.CSV file must have the following column's format. 
	<table class="table table-bordered" style="font-size: 10px;">
		<tr>
			<th>Shipper Name</th>
			<th>Supplier ID</th>
			<th>Shipper Address</th>
			<th>Consignee</th>
			<th>Buyer ID</th>
			<th>Consignee Address</th>
			<th>Notify Party ID</th>
			<th>Notify Party Adress</th>
			<th>Port of Loading</th>
			<th>Final Destination</th>
			<th>Vess</th>
			<th>Voy. No.</th>
			<th>Laden on Board</th>
			<th>Invoice Num</th>
			<th>Invoice Date</th>
			<th>LC No.</th>
			<th>LC date</th>
			<th>LC Bank</th>
			<th>COO</th>
			<th>CNT No</th>
			<th>Seal No</th>
			<th>PKGS</th>
			<th>Desc. Of Goods</th>
			<th>PCS</th>
			<th>U/Price</th>
			<th>Amount</th>
			<th>Price Type</th>
			<th>Net-Weight</th>
			<th>KGS</th>
			<th>CBM</th>
			<th>Remarks</th>
		</tr>
		<tr>
			<td></td>
			<td><a href="resources.php?page=supplier" target="_blank" style="color:red;">Link</a></td>
			<td></td>
			<td></td>
			<td><a href="resources.php?page=buyer" target="_blank" style="color:red;">Link</a></td>
			<td></td>
			<td><a href="resources.php?page=notify" target="_blank"  style="color:red;">Link</a></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>yyyy-mm-dd</td>
			<td></td>
			<td>yyyy-mm-dd</td>
			<td></td>
			<td>yyyy-mm-dd</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>	
	</table>
</div>

<img src="sources/images/underdevelopmentlogo.jpg" width="500">


<?php

$message = "";
if (isset($_POST['submit'])) {
    $allowed = array('csv');
    $filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        // show error message
        $message = 'Invalid file type, please use .CSV file!';
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "files/" . $_FILES['file']['name']);
 		
        $file = "files/" . $_FILES['file']['name'];
        $table = " test ";
        $col_names = "name,mobile,email";

        mysqli_query($db_link,'TRUNCATE TABLE test');
//*
        $query = "LOAD DATA LOCAL INFILE '$file'
         			INTO TABLE". $table .
         			"FIELDS TERMINATED BY ','
         			LINES TERMINATED BY '\n'
         			IGNORE 1 LINES
        			(".$col_names.")";

        if (!$result = mysqli_query($db_link, $query)) {
            exit(mysqli_error($db_link));
        }
//*/   
        $message = "CSV file successfully imported!";
    }
}
function display_table($db)
{ 
	// View records from the table
	$table = '<table class="table table-bordered">
				<tr>
				    <th>No</th>
				    <th>Name</th>
				    <th>Mobile</th>
				    <th>Email</th>
				</tr>
				';
	$query = "SELECT * FROM test";
	if (!$result = mysqli_query($db, $query)) {
	    exit(mysqli_error($db));
	}
	if (mysqli_num_rows($result) > 0) {
	    $number = 1;
	    while ($row = mysqli_fetch_assoc($result)) {
	        $table .= '<tr>
	            <td>' . $number . '</td>
	            <td>' . $row['name'] . '</td>
	            <td>' . $row['mobile'] . '</td>
	            <td>' . $row['email'] . '</td>
	        </tr>';
	        $number++;
	    }
	} else {
	    $table .= '<tr>
	        <td colspan="4">Records not found!</td>
	        </tr>';
	}
	$table .= '</table>';
}
?>
<!doctype html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <title>Import Data from CSV File to MySQL Tutorial</title>
	    <!-- Bootstrap CSS File  -->
	    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
	</head>
	<body>
		<div class="container">    
		    <div class="row">
		        <div class="col-md-6 col-md-offset-0">
		            <form enctype="multipart/form-data" method="post" action="?">
		                <div class="form-group">
		                    <label for="file">Select .CSV file to Import</label>
		                    <input name="file" type="file" class="form-control">
		                </div>
		                <div class="form-group">
		                    <?php echo $message; ?>
		                </div>
		                <div class="form-group">
		                    <input type="submit" name="submit" class="btn btn-primary" value="Submit"/>
		                </div>
		            </form>
		            <div class="form-group">
		                <?php echo display_table($db_link) ?>
		            </div>
		        </div>
		    </div>
		</div>
	</body>
</html>

<?php
include('themes/gentelella/footer.php');
?>	