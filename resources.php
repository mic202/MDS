<?php

include('themes/gentelella/header.php'); 

// Call database
require_once('admin/connect.ini.php');

switch($_REQUEST['page']) 
{
	case 'buyer';
	include ('resources/buyers.php');
	break;

	case 'supplier';
	include ('resources/suppliers.php');
	break;

	case 'notify';
	include ('resources/notify.php');
	break;

	case 'coo';
	include ('resources/country_origin.php');
	break;

	case 'port';
	include ('resources/ports.php');
	break;

	case 'pcoding';
	include ('resources/parts_coding_system.php');
	break;
}
include('themes/gentelella/footer.php');
?>	