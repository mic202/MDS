<?php
/*---------------------------------------------------------
| 
|	$link = mysqli_connect("127.0.0.1", "my_user", "my_password", "my_db");
|
|	
-------------------------------------------------------------*/

$db_link = mysqli_connect("127.0.0.1", "root", "", "mds");

if (!$db_link) 
    echo "Error: Unable to connect to MySQL." . PHP_EOL;


//include( "../sources/Editor-1.6.1/php/DataTables.php" );
 
//use DataTables\Editor;


function make_URL_list($string) 
{
	$url_list = '';
	$URL_array = explode(",", $string);
	foreach($URL_array as $url)
	{
		$url_list.= '<a href="http://'.$url.'" target="_blank">'.$url.'</a></br>';
	}
	return $url_list;
}

function get_address($db, $ref_type, $ref_num, $address=null) 
{
	$query = "SELECT Street_num, Street_name, City, Province, Postal_code, Country FROM address WHERE ref_type = '$ref_type' AND ref_num = '$ref_num'";
	if($result = mysqli_query($db, $query)) 
	{
	// Return Street_num, Street name, City, Province, Postal_code, Country, 
		while($row = mysqli_fetch_assoc($result))
		{	
			$address = vsprintf("%s\n %s, %s, %s, %s, %s\n ", $row);
		}	
	}
	return $address;	
}
/**
//Country of origin
$query = "SELECT Country_name FROM country_origin ORDER BY Country_name";
$result = mysqli_query($db_link, $query);			
while($row = mysqli_fetch_assoc($result)) 
{
	$coo_list[] = $row['Country_name'];	
}
**/
function convert_date($date) {
	$new_date = explode('/',$date);
	if($date == null)
		return "0000-00-00";
	else
		return $new_date[2].'-'.$new_date[0].'-'.$new_date[1];
}

