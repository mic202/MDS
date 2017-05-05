<?php

function total_num_parts($db) 
{
	$query = "SELECT COUNT(`id`) FROM parts";
	$result = mysqli_query( $db, $query ) or die(mysqli_error($db));
	$row = mysqli_fetch_array($result);
	
	return $row[0];
}

function num_parts_with_prices($db) 
{
	$query = "SELECT DISTINCT oe_num_short FROM prices_supplier GROUP BY oe_num_short";
	$result = mysqli_query($db ,$query);

	return mysqli_num_rows($result);
}

function num_parts_without_info($db, $info) 
{
	$query = "SELECT COUNT(`id`) FROM parts WHERE $info = '' OR $info = 0";
	$result = mysqli_query($db ,$query);
	$row = mysqli_fetch_array($result);
	
	return $row[0];
}

function num_parts_by_group($db, $group) 
{
	$query = "SELECT $group, COUNT(`id`) FROM parts GROUP BY $group ORDER BY COUNT(`id`) DESC";
	$result = mysqli_query( $db, $query ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	while($row = mysqli_fetch_array($result)) 
	{
		$list[] = $row['0'] .'<<<'. $row['1']; 
	}
	return $list;
}

?>