<?php
// Call database
require_once('admin/connect.ini.php');

var_dump($_POST);

$shipper_name = $_POST["shipper_name"];
$shipper_info = explode('@', $_POST['shipper_info']);
$supplier_ID = $shipper_info[0];
$shipper_address = $shipper_info[1];
$importer_name = $_POST["importer_name"];
$importer_info = explode('@', $_POST['importer_info']);
$buyer_ID = $importer_info[0];
$importer_address = $importer_info[1];
$notify_info = explode('@', $_POST['notify_info']);
$notify_ID = $notify_info[0];
$notify_address = $notify_info[1];
$port = $_POST["port"];
$final_dest = $_POST["final_dest"];
$vess = $_POST["vess"];
$voy_num = $_POST["voy_num"];
$laden_date = convert_date($_POST["laden_date"]);
$invoice_num = $_POST["invoice_num"];
$invoice_date = convert_date($_POST["invoice_date"]);
$LC_num = $_POST["LC_num"];
$LC_date = convert_date($_POST["LC_date"]);
$LC_bank = $_POST["LC_bank"];
$cntr_num = $_POST["cntr_num"];
$seal_num = $_POST["seal_num"];
$num_pkgs = $_POST["num_pkgs"];
$num_pcs = $_POST["num_pcs"];
$price_type = $_POST["price_type"];
$amount = $_POST["amount"];
$kgs = $_POST["kgs"];
$cbm = $_POST["cbm"];
$remarks = $_POST["remarks"]; 
$country_origin = '';

foreach($_POST["country_origin"] as $country)
{
	$country_origin.= $country . ' ';
}


$query = "INSERT INTO shipping_doc_list
			(Shipper_name, Supplier_ID, Shipper_address, Importer_name, Buyer_ID, Importer_address, Notify_ID, Notify_address, Port_loading, Final_dest, Vess, Voy_num, Laden_date, Invoice_num, Invoice_date, LC_num, LC_date, LC_bank, Country_origin, Container_num, Seal_num, Num_pkgs, Qty, Amount, Price_type, Weight_gross, CBM, Remarks)
		VALUES
			('$shipper_name','$supplier_ID','$shipper_address','$importer_name','$buyer_ID','$importer_address','$notify_ID', '$notify_address', $port','$final_dest','$vess','$voy_num', '$laden_date','$invoice_num','$invoice_date','$LC_num','$LC_date','$LC_bank','$country_origin','$cntr_num','$seal_num','$num_pkgs','$num_pcs','$amount','$price_type','$kgs','$cbm','$remarks')";
$result = mysqli_query($db_link, $query) or die("Error: ".mysqli_error($db_link));			

header('location:shipdoc_view.php');