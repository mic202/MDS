<?php
ob_start(); 
include('themes/gentelella/header.php'); 
//header_remove(); 
// Call database
require_once('admin/connect.ini.php');
//ini_set('memory_limit', '1500M');
//set_time_limit(120);

$iaQuery = "SELECT part_id, oe_num_short, maker FROM parts ORDER BY part_id";
$iaResult = mysqli_query($db_link, $iaQuery);
while($iaRow = mysqli_fetch_assoc($iaResult))
{
	$pInfo = $iaRow['part_id'] .">>>". $iaRow['maker'];
	$pInfoList[$iaRow['oe_num_short']] = $pInfo;
}



if(($file = fopen("parts.csv", "r")) !== FALSE) 
{
	$rowNum = 1;
	echo '<table class="table table-hover">';
	while(! feof($file)) 
	{
		echo '<tr>';
			echo "<td>".($rowNum)." ) </td>";
		$lines = fgetcsv($file);
		for($i=0; $i<count($lines); $i++) 
		{
			
			if($i == 0) 
			{
				if(array_key_exists($lines['0'], $pInfoList)) { 
					$newInfo = explode(">>>", $pInfoList[$lines['0']]);
					echo "<td>".$newInfo['0']."</td>";
					echo "<td>".$newInfo['1']."</td>";
					$newLine['0'] = $newInfo['0'];
					$newLine['1'] = $newInfo['1'];
				}
				else
				{
					echo '<td></td>';
					echo '<td></td>';
					$newLine['0'] = NULL;
					$newLine['1'] = NULL;
				}	
			}	
			$c = $i+2;
			echo '<td>'.$lines[$i].'</td>';
			
			if($lines['0'] != NULL)
				$newLine[$c] = $lines[$i];

		}
		echo '</tr>';
		
		if(empty($newLine))
			echo 'I am empty';
		if($newLine != NULL)
			$newLines[] = $newLine;

		$rowNum ++;	
	}	
	echo '</table><br/>';
}
fclose($file);

echo'<div>
		<form action="?mode=upload" method="POST">';
		echo'<button class="btn btn-primary" type="submit" >Upload to Database</button>
		</form>
	</div>';



if(isset($_GET['mode']) && $_GET['mode'] == 'upload') 
{
	
	if(empty($newLines)) 
	{
		echo 'CSV File is Empty!!!';
	}
	else 
	{
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//								Rewrite CSV File
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
		if(($file = fopen("parts.csv", "w")) !== FALSE) 
		{
			if(isset($newLines) && count($newLines)>0) {
				foreach($newLines as $line)
				{
					fputcsv($file, $line);
				}
			}
		}
		fclose($file);


		///* IGNORE 1 LINES
		$fileName = 'parts.csv';
		$tableName = 'prices_supplier';
		$fieldNames = "`part_id`, `maker`, `oe_num_short`, `supplier_id`, `supplier_name`, `price`, `currency`, `price_type`, `update_date`";
		//Upload to Database
		$query = "LOAD DATA LOCAL INFILE '".$fileName."'
		INTO TABLE `".$tableName."`
		FIELDS TERMINATED BY ','
		LINES TERMINATED BY '\n'
		(".$fieldNames.")";

		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

		//Make Empty file
		if(($file = fopen("parts.csv", "w")) !== FALSE) 
		{
			fclose($file);	 
		}

		$query = "UPDATE `".$tableName."` SET supplier_name = REPLACE(supplier_name, '\"',''), price_type = REPLACE(price_type, '\"','')";
		$result = mysqli_query($db_link, $query);

		$query = "DELETE FROM prices_supplier WHERE oe_num_short = ''";
		$result = mysqli_query($db_link, $query);
	}
	
}

//*/

/*
LOAD DATA LOCAL INFILE '../htdocs/MDS/parts.csv' 
INTO TABLE `parts_temp` FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n' 
(`maker`, `oe_num`, `oe_num_short`, `mic_num`, `model`, `model_year`, `part_desc`, `part_name`, `part_code`, `part_group`, `part_cube`, `oe_price_us`, `oe_price_ca`, `comment`)
*/

/*

UPDATE `parts_temp` SET `part_desc` = REPLACE(`part_desc`,';',' ') WHERE `part_desc` LIKE '%;%'

*/


//function csv_sql($csv_file, $query, $result)
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
							READ CSV FILE
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

$index = 1;
$line_input = 300;

if(($file = fopen("parts.csv", "r")) !== FALSE) 
{
	//var_dump(($line = fgetcsv($file, 100000, ",")));
	//CSV file is empty
	//if(($line = fgetcsv($file, 100000, ",")) == null);
	//	$is_empty = true;
	//CSV file is NOT empty	
	while(($line = fgetcsv($file, 100000, ",")) !== FALSE) 
	{
		$total_lines_page = count($line);
/*::::::::::::::::::::::::::::::::::::::::::::::::
			  UPDATE to DATABASE	
::::::::::::::::::::::::::::::::::::::::::::::::::		
		$oe_num_short = $line['0'];
		$price = $line['3'];
		$currency = $line['4'];
		$price_type = $line['5'];
		$update_date = $line['6'];

		$query = "UPDATE prices_supplier SET 
			price = '$price',
			currency = '$currency',
			price_type = '$price_type',
			update_date = '$update_date'
				WHERE oe_num_short = '$oe_num_short'";
//::::::::::::::::::::::::::::::::::::::::::::::::::

/*::::::::::::::::::::::::::::::::::::::::::::::::
			  INSERT to DATABASE	
::::::::::::::::::::::::::::::::::::::::::::::::::					
		//$id = $line['0']; 
		$maker = $line['0'];
		$oe_num = $line['1']; 
		$oe_num_short = $line['2']; 
		$mic_num = $line['3']; 
		$model = $line['4']; 
		$model_year = $line['5']; 
		$part_desc = $line['6'];
		$part_name = $line['7'];
		$part_code = $line['8'];
		$part_group = $line['9'];
		$part_cube = $line['10'];
		$hs_code_us = $line['11'];
		$oe_price_us = $line['12'];
		$oe_price_ca = $line['13'];

		$query = "INSERT INTO parts
					(maker, oe_num, oe_num_short, mic_num, model, model_year, part_desc, part_name, part_code, part_group, part_cube, hs_code_us, oe_price_us, oe_price_ca) 
				VALUES 
					('$maker', '$oe_num', '$oe_num_short', '$mic_num', '$model', '$model_year', '$part_desc', '$part_name', '$part_code', '$part_group', '$part_cube', '$hs_code_us', '$oe_price_us', '$oe_price_ca')";		
/*::::::::::::::::::::::::::::::::::::::::::::::::::
		$oe_num = $line['0'];
		$query = "INSERT INTO oe_number
					(oe_num)
				VALUES
					('$oe_num')";			
//::::::::::::::::::::::::::::::::::::::::::::::::::
		if($index <= $line_input) 
		//	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));	
		else
			$lines[] = $line;
		
		$index ++;
	}
}
fclose($file);


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
					 		WRITE CSV FILE
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

if(($file = fopen("parts.csv", "w")) !== FALSE) 
{
	if(isset($lines) && count($lines)>0) {
		foreach($lines as $line)
		{
			fputcsv($file, $line);
		}
		fclose($file);
	 
		header("Refresh:2");
	}
}


if(isset($lines) && count($lines)>0) {
	$time = ((count($lines)/$line_input)*30)/60;
	echo '<h3>Please wait... We need to add <font color=red>'. count($lines) . '</font> lines more!!!<br/>
			 Expecting waitting time is '. number_format($time) .' mins (Estimated)</h3><br/>';
	echo '<h1>Wait...  <i class="fa fa-spinner fa-spin"></i></h1>';

}else {
	echo 'Congratulation!!! It is DONE!!!';
}
*/
ob_flush(); 
include('themes/gentelella/footer.php'); 
