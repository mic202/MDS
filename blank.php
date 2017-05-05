<?php
include('themes/gentelella/header.php'); 
// Call database
require_once('admin/connect.ini.php');

$query = "DELETE FROM prices_supplier WHERE id > '555995'";
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

include('themes/gentelella/footer.php'); 
?>