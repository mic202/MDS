<?php
include('themes/gentelella/header.php'); 

// Call database
require_once('admin/connect.ini.php');

function get_company_address($db, $type, $index_num) 
{
	if($type != 'notify')
		$table = $type.'s';
	else
		$table = $type.'_party';
	$index = ucfirst($type).'_ID';
	$address = ucfirst($type).'_address';
	$location = ucfirst($type).'_location';
	$country = ucfirst($type).'_country';
	$pc = ucfirst($type).'_pc';
	$company = ucfirst($type).'_company';



	$query = "SELECT $address, $location, $country, $pc, $company FROM $table WHERE $index = $index_num";
	$result = mysqli_query($db, $query) or die("Error: ".mysqli_error($db));
	$row = mysqli_fetch_array($result);
	if($type != 'notify')
		echo $row[$address]. '</br>' .$row[$location].', '.$row[$pc].' '. $row[$country];
	else
		echo '<h4>'.$row[$company]. '</h4>' .$row[$address]. '</br>' .$row[$location].', '.$row[$pc].' '. $row[$country];
}

function print_address($address) 
{
	$temp = explode(';', $address);
	foreach($temp as $print) 
	{
		echo $print;
		echo '<br/>';
	}	
}

$query = "SELECT * FROM shipping_doc_list";
if(isset($_REQUEST['id']) && $_REQUEST['id'] != null) 
	$join = " WHERE Ship_doc_ID =".$_REQUEST['id'];
else
	$join = ' ORDER BY Ship_doc_ID DESC';

$Qjoin = $query.$join;
$result = mysqli_query($db_link, $Qjoin) or die("Error: ".mysqli_error($db_link));
$row = mysqli_fetch_array($result);

?>

<style>
	table {border-collapse: collapse;}
	td  {padding: 5px;}	
	th  {padding: 5px;}	
</style>

<div class="x_content">
    <div class="" role="tabpanel" data-example-id="togglable-tabs">
    	<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active">
            	<a href="#tab_content1" id="commercial-tab" role="tab" data-toggle="tab" aria-expanded="true">Commercial Invoice</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="packing-tab" data-toggle="tab" aria-expanded="false">Packing List</a></li>

            <li role="presentation" class="" >
            	<a href="#tab_content3" role="tab" id="isf-tab" data-toggle="tab" aria-expanded="false"  style="background: #8CE9FF;">ISF 
            &nbsp;&nbsp;<span class="label label-success pull-right">Coming Soon</span></a></li>
            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="bl-tab" data-toggle="tab" aria-expanded="false">B/L 
            &nbsp;&nbsp;<span class="label label-success pull-right">Coming Soon</span></a></li>
            <li role="presentation" class=""><a href="#tab_content5" role="tab" id="shipped-tab" data-toggle="tab" aria-expanded="false">Shipped Detail 
            &nbsp;&nbsp;<span class="label label-success pull-right">Coming Soon</span></a></li>
			<li role="presentation" class="">
				<a href="#tab_content6" role="tab" id="packslip-tab" data-toggle="tab" aria-expanded="false"  style="background: #FEFF49;">Packing Slip 
            &nbsp;&nbsp;<span class="label label-success pull-right">Coming Soon</span></a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
        	<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="commercial-tab">
    <!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    														COMMERCIAL INVOICE
    ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->    	
				<div class="form-group col-lg-8" style="background: #fff;">
					<div class="form-group col-md-4 col-md-offset-4" style="font-size:20px; font-weight: bold; ">
						<br/>COMMERCIAL INVOICE
					</div>
					<table border=1 width="100%" >
						<tr>
							<th colspan="2" width="50%">1) SHIPPER/EXPORTER</th>
							<th colspan="4" width="50%">8) INVOICE NO. & DATE</th>
						</tr>
						<tr>
							<td colspan="2" rowspan="4" style="padding: 5px 25px;" >
								<h4><?php echo $row['Shipper_name']; ?></h4>
								<h5><?php print_address($row['Shipper_address']); ?></h5>
					
						</br></br>	TEL:65-6226-3636 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      FAX: 65-6334-2222	
							</td>
							<td colspan="4" style="padding: 5px 25px;">
								<p>INV# <?php echo $row['Invoice_num']; ?>, <?php echo date("M d, Y", strtotime($row['Invoice_date'])); ?></p>
							</td>
						</tr>
						<tr>
							<th  colspan="4">9) L/C NO. & DATE</th>
						</tr>
						<tr>
							<td colspan="4" style="padding: 5px 25px;">
								<p><?php echo $row['LC_num']; ?>, 
					<?php
							if($row['LC_date'] == '0000-00-00')
								echo '';
							else	 
								echo date("M d, Y", strtotime($row['LC_date'])); 
					?>						
								</p>
							</td>
						</tr>
						<tr>
							<th colspan="4"> 10) L/C ISSUING BANK</th> <!-- ONLY FOR COMMERCE INVOICE -->
						</tr>
						<tr>
							<th colspan="2"> 2) FOR ACCOUNT & RISK OF MESSRS.</th>

							<td colspan="4" rowspan="2" style="padding: 5px 25px;">
								<p><?php echo $row['LC_bank']; ?></p> <!-- ONLY FOR COMMERCE INVOICE -->
							</td>
						</tr>	
							<td colspan="2" rowspan="3" style="padding: 5px 25px;"  colspan="2">
								<h4><?php echo $row['Importer_name']; ?></h4>
								<h5><?php print_address($row['Importer_address']); ?></h5>
						</br></br>	TEL:973-725-7767
							</td>
							
						</tr>
						<tr>
							<th colspan="4">11) COUNTRY OF ORIGIN</th> <!-- ONLY FOR COMMERCE INVOICE -->
						</tr>
						<tr>
							<td colspan="4" style="padding: 5px 25px;">
								<p><?php echo $row['Country_origin'] ?></p>
							</td>
						</tr>
						<tr>
							<th colspan="2"> 3) NOTIFY PARTY </th>
							<th colspan="4"> 12) REMARKS</th> <!-- ONLY FOR COMMERCE INVOICE -->
						</tr>
						<tr>
							<td colspan="2" style="padding: 5px 25px;"  colspan="2">
					<?php 		
								get_company_address($db_link, 'notify', $row['Notify_ID']);
					 ?>
								</br>	TEL:615-885-0020 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FAX: 615-885-1465
							</td>

							<td colspan="4" rowspan="5" style="padding: 5px 25px; font-size:18px; font-style: italic; ">
							<br/><br/>
								* CONT'T NO : <?php echo $row['Container_num']; ?></br>
								* SEAL NO : <?php echo $row['Seal_num']; ?></br>
								* <?php echo $row['Remarks']; ?> <!-- ONLY FOR COMMERCE INVOICE -->
							<br/><br/><br/><br/>
							</td>

						</tr>
						<tr>
							<th >4) PORT OF LOADING</th>
							<th >5) FINAL DESTINATION</th>
						</tr>
						<tr>
							<td style="padding: 5px 25px;">
								<p><?php echo $row['Port_loading']; ?></p>
							</td>
							<td style="padding: 5px 25px;">
								<p><?php echo $row['Final_dest']; ?></p>
							</td>
						</tr>
						<tr>
							<th>6) VESS. & VOY. NO.</th>
							<th>7) LADEN ON BOARD</th>
						</tr>
						<tr>
							<td style="padding: 5px 25px;">
								<p><?php echo $row['Vess'] . $row['Voy_num']; ?></p>
							</td>
							<td style="padding: 5px 25px;">
								<p><?php echo date('M d, Y', strtotime($row['Laden_date'])); ?></p>
							</td>
							
						</tr>
						<tr>
							<th>13) MARKS & NOS</br>OF PKGS</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS --> 
							<th>14) DESCRIPTION OF GOODS</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>15) Q'TY</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>16) U/PRICE</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>17) AMOUNT</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
						</tr>
					</table>
					</br>
					<div class="form-group col-md-9 col-md-offset-3" style="font-size:14px; ">
					 	<table border=0 width="100%">
					 		<tr>
					 			<td colspan="4">
					 				<b><u>GENERAL(AUTOMOTIVE REPLACEMENT PARTS)</u></b>
					 			</td>
					 		</tr>
					 		<tr>
					 			<td width="35%">		 
					 				<p style="font-size:14px; ">- <?php echo $row['Price_type']; ?> </p>
					 			</td>
					 			<td>
					 				<?php echo $row['Qty']; ?> PCS
					 			</td>
					 			<td align="right">
					 				USD
					 			</td>
					 			<td align="right">
					 				<?php echo number_format($row['Amount'],2); ?>
					 			</td>
					 		</tr>
					 	</table>			
					</div>

					<div class="form-group col-md-9 col-md-offset-3" style="font-size:14px; ">
						<table border=0 width="100%">
							<tr>
								<td colspan="4" style="font-size:14px; ">
									- DETAILS ARE AS PER ATTACHED SHEET 
								</td>
							</tr>	
							<tr style="border-top: solid 1px #2A3F54;">
					 			<td style="font-size:14px; text-align: center;" width="35%"><b> TOTAL </b></td>
					 			<td>
					 				<b><?php echo $row['Qty']; ?> PCS</b>
					 			</td>
					 			<td align="right">
					 				<b>USD</b>
					 			</td>
					 			<td align="right">
					 				<b><?php echo number_format($row['Amount'],2); ?></b>
					 			</td>
					 		</tr>
					 	</table>			
					</div>

					<div class="form-group col-md-6 col-md-offset-8" style="font-size:18px; font-weight: bold;">
						<br/><br/>MOTOR IMPACT OF CANADA	
					</div>
					<div class="form-group col-md-6 col-md-offset-8" >
						<br/>SIGNED BY &nbsp;&nbsp;&nbsp;<img src="sources/images/ceo_sign.jpg">
					</div>

				</div>	 	
			</div>
<!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
			<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="packing-tab">
				<div class="form-group col-lg-8" style="background: #fff;">
					<div class="form-group col-md-4 col-md-offset-4" style="font-size:20px; font-weight: bold;">
				 	<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PACKING LIST
					</div>
					<table border=1 width="100%">
						<tr>
							<th colspan="2" width="50%">1) SHIPPER/EXPORTER</th>
							<th colspan="4" width="50%">8) INVOICE NO. & DATE</th>
						</tr>
						<tr>
							<td colspan="2" rowspan="4" style="padding: 5px 25px;" >
								<h4><?php echo $row['Shipper_name']; ?></h4>
					<?php 				
								get_company_address($db_link, 'supplier', $row['Supplier_ID']); 
					?>
						</br></br>	TEL:65-6226-3636 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      FAX: 65-6334-2222	
							</td>
							<td colspan="4" style="padding: 5px 25px;">
								<p>INV# <?php echo $row['Invoice_num']; ?>, <?php echo date("M d, Y", strtotime($row['Invoice_date'])); ?></p>
							</td>
						</tr>
						<tr>
							<th  colspan="4">9) L/C NO. & DATE</th>
						</tr>
						<tr>
							<td colspan="4" style="padding: 5px 25px;">
								<p><?php echo $row['LC_num']; ?>, 
					<?php
							if($row['LC_date'] == '0000-00-00')
								echo '';
							else	 
								echo date("M d, Y", strtotime($row['LC_date'])); 
					?>						
								</p>
							</td>
						</tr>
						<tr>
							<th colspan="4"> 10) REMARKS</th> 
						</tr>
						<tr>
							<th colspan="2"> 2) FOR ACCOUNT & RISK OF MESSRS.</th>

							<td colspan="4" rowspan="8" style="padding: 5px 25px; font-size:18px; font-style: italic; ">
							<br/><br/>
								* CONT'T NO : <?php echo $row['Container_num']; ?></br>
								* SEAL NO : <?php echo $row['Seal_num']; ?></br>
								* <?php echo $row['Remarks']; ?> <!-- ONLY FOR COMMERCE INVOICE -->
							<br/><br/><br/><br/>
							</td>
							
						</tr>	
							<td colspan="2" style="padding: 5px 25px;"  colspan="2">
								<h4><?php echo $row['Importer_name']; ?></h4>
					<?php 		
								get_company_address($db_link, 'buyer', $row['Buyer_ID']);
					 ?>
						</br></br>	TEL:973-725-7767
							</td>
							
						</tr>
						
						<tr>
							<th colspan="2"> 3) NOTIFY PARTY </th>
							
						</tr>
						<tr>
							<td colspan="2" style="padding: 5px 25px;"  colspan="2">
					<?php 		
								get_company_address($db_link, 'notify', $row['Notify_ID']);
					 ?>
								</br>	TEL:615-885-0020 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FAX: 615-885-1465
							</td>
						</tr>
						<tr>
							<th >4) PORT OF LOADING</th>
							<th >5) FINAL DESTINATION</th>
						</tr>
						<tr>
							<td style="padding: 5px 25px;">
								<p><?php echo $row['Port_loading']; ?></p>
							</td>
							<td style="padding: 5px 25px;">
								<p><?php echo $row['Final_dest']; ?></p>
							</td>
						</tr>
						<tr>
							<th>6) VESS. & VOY. NO.</th>
							<th>7) LADEN ON BOARD</th>
						</tr>
						<tr>
							<td style="padding: 5px 25px;">
								<p><?php echo $row['Vess'] . $row['Voy_num']; ?></p>
							</td>
							<td style="padding: 5px 25px;">
								<p><?php echo date('M d, Y', strtotime($row['Laden_date'])); ?></p>
							</td>
							
						</tr>
						<tr>
							<th>11) MARKS & NOS</br>OF PKGS</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS --> 
							<th>12) DESCRIPTION OF GOODS</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>13) Q'TY</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>14) Net-<br/>Weight</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>15) Gross-<br/>Weight</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
							<th>16) Measure-<br/>ment</th> <!-- NO. HAS TO BE CHANGED FOR OTHER FORMS -->
						</tr>
					</table>
					</br>
					<div class="form-group col-md-9 col-md-offset-3" style="font-size:14px; ">
					 	<table border=0 width="100%">
					 		<tr>
					 			<td colspan="4">
					 				<b><u>GENERAL(AUTOMOTIVE REPLACEMENT PARTS)</u></b>
					 			</td>
					 		</tr>
					 		<tr>
					 			<td width="35%">		 
					 				<p style="font-size:14px; ">- <?php echo $row['Price_type']; ?> </p>
					 			</td>
					 			<td>
					 				<?php echo $row['Qty']; ?> PCS
					 			</td>
					 			
					 		</tr>
					 	</table>			
					</div>

					<div class="form-group col-md-9 col-md-offset-3" style="font-size:14px; ">
						<table border=0 width="100%">
							<tr>
								<td colspan="4" style="font-size:14px; ">
									- DETAILS ARE AS PER ATTACHED SHEET 
								</td>
							</tr>	
							<tr style="border-top: solid 1px #2A3F54;">
					 			<td style="font-size:14px; text-align: center;" width="35%"><b> TOTAL </b></td>
					 			<td>
					 				<b><?php echo $row['Qty']; ?> PCS</b>
					 			</td>
					 			<td align="right">
					 				<b><?php echo $row['Weight_gross']; ?> KGS</b>
					 			</td>
					 			<td align="right">
					 				<b><?php echo number_format($row['CBM'],2); ?> CBM</b>
					 			</td>
					 		</tr>
					 	</table>			
					</div>

					<div class="form-group col-md-6 col-md-offset-8" style="font-size:18px; font-weight: bold;">
						<br/><br/>MOTOR IMPACT OF CANADA	
					</div>
					<div class="form-group col-md-6 col-md-offset-8" >
						<br/>SIGNED BY &nbsp;&nbsp;&nbsp;<img src="sources/images/ceo_sign.jpg">
					</div>

				</div>	 	
			</div>

<!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->		    

		    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="isf-tab">
				<br/><br/><img src="sources/images/isf_sample.jpg"> 
		    </div>

		    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="bl-tab">
				<br/><br/><img src="sources/images/bl_sample.jpg"> 
		    </div>
		    
		    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="shipped-tab">
				<br/><br/><img src="sources/images/shipdetail_sample.jpg"> 
		    </div>

		    <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="packslip-tab">
				<br/><br/><img src="sources/images/packslip_sample.jpg"> 
		    </div>
    	</div>
    </div>

</div>




<?php

include('themes/gentelella/footer.php');
