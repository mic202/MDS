<?php
include('themes/gentelella/header.php'); 

// Call database
require_once('admin/connect.ini.php');
?>
<script type="text/javascript">
	$(.datepicker).datepicker();
</script>

<div class="col-lg-12">
    <h1 class="page-header">ShipDoc Generator <i class="fa fa-cog fa-spin"></i></h1>
 </div>

<!-- Smart Wizard -->
<div id="wizard" class="form_wizard wizard_horizontal">
	<ul class="wizard_steps">
        <li>
			<a href="#step-1">
				<span class="step_no">1</span>
				<span class="step_descr">
                    Step 1<br />
                    <small>SHIPPER/EXPORTER</small>
                </span>
			</a>
        </li>
        <li>
			<a href="#step-2">
				<span class="step_no">2</span>
				<span class="step_descr">
					Step 2<br />
					<small>CONSIGNEE</small>
				</span>
			</a>
        </li>
        <li>
			<a href="#step-3">
				<span class="step_no">3</span>
				<span class="step_descr">
					Step 3<br />
					<small>NOTIFY PARTY</small>
				</span>
			</a>
        </li>
        <li>
			<a href="#step-4">
				<span class="step_no">4</span>
				<span class="step_descr">
					Step 4<br />
					<small>SHIPPING INFO</small>
				</span>
			</a>
        </li>
		<li>
			<a href="#step-5">
				<span class="step_no">5</span>
				<span class="step_descr">
					Step 5<br />
					<small>INVOICE INFO</small>
				</span>
			</a>
        </li>
		<li>
			<a href="#step-6">
				<span class="step_no">6</span>
				<span class="step_descr">
					Step 6<br />
					<small>CON'T INFO</small>
				</span>
			</a>
        </li>
        <li>
			<a href="#step-7">
				<span class="step_no">7</span>
				<span class="step_descr">
					FINAL Step<br />
					<small>REMARKS</small>
				</span>
			</a>
        </li>
    </ul>
	
<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 1
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	
	<div id="step-1">
		<div class="form-group col-lg-12">
        	<h2 class="StepTitle">Step 1: SHIPPER / EXPORTER Information </h2>
		</div>		
		<div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="shipper_name">
				Company Name <span class="required">*</span>
            </label>
            
            <select class="select2 form-control" id="shipper_name" name="shipper_name" form="shipdoc">
				<option></option>
				<option value="MOTOR IMPACT OF CANADA">MOTOR IMPACT OF CANADA</option>
				<option value="PLATINUM AUTO TRENDS INC.">PLATINUM AUTO TRENDS INC.</option>
				<option value="MOTOR IMPACT FZE">MOTOR IMPACT FZE</option>
			<?php
				$query = "SELECT DISTINCT Supplier_company FROM suppliers ORDER BY Supplier_company";
				$result = mysqli_query($db_link, $query);
				while($row = mysqli_fetch_array($result)) 
				{
					echo'<option value="'.$row['Supplier_company'].'">'. $row['Supplier_company'] .'</option>';
				}
			?>					  
			</select>
        </div>
        
        <div class="form-group col-lg-12"></div>

        <div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="shipper_info">
				Address <span class="required">*</span>
            </label>
            <select class="select2 form-control" id="shipper_info" name="shipper_info" form="shipdoc">
				<option></option>
					
				<?php
					$query = "SELECT Supplier_ID, Supplier_address, Supplier_location, Supplier_country FROM suppliers WHERE Supplier_address != ' ' ORDER BY Supplier_address";
					$result = mysqli_query($db_link, $query);
					while($row = mysqli_fetch_array($result)) 
					{
						$S_address = $row['Supplier_address'] .' '. $row['Supplier_location'] .' '. $row['Supplier_country']; 
						echo'<option value="'. $row['Supplier_ID'] .'@'. $S_address .'">'. $S_address .'</option>';
					}
				?>					  
			</select>
        </div>
    </div>

<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 2
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	    
	<div id="step-2">
		<div class="form-group col-lg-12">
        	<h2 class="StepTitle">Step 2: FOR ACCOUNT & RISK OF MESSRS. </h2>
		</div>
        <div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="importer_name">
				Company Name <span class="required">*</span>
            </label>
			<select class="select2 form-control" id="importer_name" name="importer_name" form="shipdoc">
				<option></option>
	<?php
		$query = "SELECT DISTINCT Buyer_company FROM buyers ORDER BY Buyer_company";
		$result = mysqli_query($db_link, $query);
		while($row = mysqli_fetch_array($result)) 
		{
			echo'<option value="'.$row['Buyer_company'].'">'. $row['Buyer_company'] .'</option>';
		}
	?>					  
			</select>
        </div>
        
        <div class="form-group col-lg-12"></div>
        
        <div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="importer_info">
				Address <span class="required">*</span>
            </label>
            
           	<select class="select2 form-control" id="importer_info" name="importer_info" form="shipdoc">
				<option></option>
							
	<?php
		$query = "SELECT Buyer_ID, Buyer_address, Buyer_location, Buyer_country FROM buyers WHERE Buyer_address != ' ' ORDER BY Buyer_address";
		$result = mysqli_query($db_link, $query);
		while($row = mysqli_fetch_array($result)) 
		{
			$I_address = $row['Buyer_address'] .' '. $row['Buyer_location'] .' '. $row['Buyer_country'];
			echo'<option value="'. $row['Buyer_ID'] .'@'. $I_address .'">'. $I_address .'</option>';
		}
	?>					  
			</select>
          </div>
    </div>
<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 3
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	
	<div id="step-3">
		<div class="form-group col-lg-12">
        	<h2 class="StepTitle">Step 3: NOTIFY PARTY </h2>
		</div>	
        <div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="notify_info">
				Company Name <span class="required">*</span>
            </label>
			<select class="select2 form-control" id="notify_info" name="notify_info" form="shipdoc">
				<option></option>
							
	<?php
		$query = "SELECT Notify_ID, Notify_company, Notify_address, Notify_location, Notify_country FROM notify_party ORDER BY Notify_company";
		$result = mysqli_query($db_link, $query)or die("Error: ".mysqli_error($db));
		while($row = mysqli_fetch_array($result)) 
		{
			$N_address = $row['Notify_address'] .', '. $row['Notify_location'] .' '. $row['Notify_country'] . ', '. $row['Notify_pc'];
			echo'<option value="'.$row['Notify_ID'].'@'. $N_address .'">'. $row['Notify_company'] .' [ '. $N_address .' ]</option>';
		}
	?>					  
			</select>
        </div>         
    </div>
<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 4
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	

	<div id="step-4">
		<div class="form-group col-lg-12">
        	<h2 class="StepTitle">Step 4: Shipping Infomation </h2>
        </div>	
<!-- PORT OF LOADING -->	
        <div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="port">
				Port of Loading <span class="required">*</span>
            </label>
			<select class="select2 form-control" id="port" name="port" form="shipdoc">
				<option></option>
							
		<?php
			$query = "SELECT Port_name FROM Ports ORDER BY Port_name";
			$result = mysqli_query($db_link, $query);
			while($row = mysqli_fetch_array($result)) 
			{
				echo'<option value="'.$row['Port_name'].'">'. $row['Port_name'] .'</option>';
			}
		?>					  
			</select>
		</div>	
<!-- FINAL DESTINATION -->
		<div class="form-group col-md-3">
            <label class="control-label col-xs-6" for="final_dest">
				Final Destination <span class="required">*</span>
            </label>
         		<select class="select2 form-control" id="final_dest" name="final_dest" form="shipdoc">
					<option></option>
		<?php
			$query = "SELECT Buyer_location, Buyer_country FROM Buyers WHERE Buyer_location != ' ' ORDER BY Buyer_location";
			$result = mysqli_query($db_link, $query);
			while($row = mysqli_fetch_array($result)) 
			{
				echo'<option>'. $row['Buyer_location'] .', '. $row['Buyer_country'] .'</option>';
			}
		?>					  
				</select>
	    </div> 

	    <div class="form-group col-lg-12"></div>

<!-- VESS -->
        <div class="form-group col-md-2 col-md-offset-3">
            <label class="control-label col-xs-12" for="vess">
				VESS.<span class="required">*</span>
            </label>
            
				<select class="select2 form-control" id="vess" name="vess" form="shipdoc">
					<option></option>
							
		<?php
			$query = "SELECT Vess_name FROM Vess ORDER BY Vess_name";
			$result = mysqli_query($db_link, $query);
			while($row = mysqli_fetch_array($result)) 
			{
				echo'<option value="'.$row['Vess_name'].'">'. $row['Vess_name'] .'</option>';
			}
		?>					  
				</select>
		</div>
<!-- VOY. NO. -->
		<div class="form-group col-md-1">
			 <label class="control-label col-xs-12" for="voy_num">
				VOY. NO.<span class="required">*</span>
            </label>
			<input class="form-control" id="voy_num" name="voy_num" form="shipdoc">
		</div>
<!-- LADEN ON BOARD -->		
		<div class="form-group col-md-3">	
         	<label class="control-label col-xs-12" for="laden_date">
				Laden on Board <span class="required">*</span>
            </label>
            <input data-provide="datepicker" class="form-control" name="laden_date" id="laden_date" form="shipdoc">
		</div>
		<div class="form-group col-lg-12"></div>
    </div>
<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 5
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	
	<div id="step-5">
		<div class="form-group col-lg-12">
    	    <h2 class="StepTitle">Step 5: Invoice Information</h2>
    	</div>    
<!-- INVOICE NUMBER -->	
        <div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="invoice_num">Invoice No. <span class="required">*</span></label>
            <input class="form-control" name="invoice_num" id="invoice_num" placeholder="Please insert only number" form="shipdoc">
		</div>	
<!-- INVOICE DATE -->
		<div class="form-group col-md-3">
            <label class="control-label col-xs-6" for="invoice_date">Date (Invoice) <span class="required">*</span></label>
            <input data-provide="datepicker"  class="form-control" name="invoice_date" id="invoice_date" form="shipdoc">
        </div> 
	    <div class="form-group col-lg-12"></div>

<!-- L/C NUMBER -->	
        <div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="LC_num">L/C No. <span class="required">*</span></label>
            <input class="form-control" name="LC_num" id="LC_num" form="shipdoc">
		</div>	
<!-- L/C DATE -->
		<div class="form-group col-md-3">
            <label class="control-label col-xs-6" for="LC_date">Date (L/C) <span class="required">*</span></label>
            <input data-provide="datepicker" class="form-control" name="LC_date" id="LC_date" form="shipdoc">
        </div> 
	    <div class="form-group col-lg-12"></div>		

<!-- L/C BANK -->	
        <div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="LC_bank">L/C Issuing Bank. <span class="required">*</span></label>
            <input class="form-control" name="LC_bank" id="LC_bank" form="shipdoc">
		</div>
	</div>	
<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									STEP 6
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	
	<div id="step-6">
		<div class="form-group col-lg-12">
    	    <h2 class="StepTitle">Step 6: Container Information </h2>
    	</div>    
<!-- Container Number-->	
        <div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="cntr_num">Container No. <span class="required">*</span></label>
            <input class="form-control" name="cntr_num" id="cntr_num" form="shipdoc">
		</div>	
<!-- SEAL NUMBER -->
		<div class="form-group col-md-3">
            <label class="control-label col-xs-6" for="seal_num">Seal No. <span class="required">*</span></label>
            <input class="form-control" name="seal_num" id="seal_num" form="shipdoc">
        </div> 
	    <div class="form-group col-lg-12"></div>

<!-- NUMBER OF PKGS-->	
        <div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="num_pkgs">No. Of PKGS </label>
            <input class="form-control" name="num_pkgs" id="num_pkgs" form="shipdoc">
		</div>	
<!-- NUMBER OF PCS -->
		<div class="form-group col-md-3">
            <label class="control-label col-xs-6" for="num_pcs">No. Of PCS <span class="required">*</span></label>
            <input class="form-control" name="num_pcs" id="num_pcs" form="shipdoc">
        </div> 
	    <div class="form-group col-lg-12"></div>

<!-- PRICE TYPE-->	
		<div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="price_type">P. Type <span class="required">*</span></label>
            <select class="select2 form-control" name="price_type" id="price_type" form="shipdoc">
	            <option></option>
	            <option value="F.O.B. PRICE">F.O.B. PRICE</option>
	            <option value="EX WORK PRICE">EX WORK PRICE</option>
            </select>
        </div> 		
<!-- AMOUNT -->
		<div class="form-group col-md-3 ">
            <label class="control-label col-xs-6" for="amount">Amount <span class="required">*</span></label>
            <input class="form-control" name="amount" id="amount" form="shipdoc" >
		</div>
	    <div class="form-group col-lg-12"></div>	

<!-- WEIGHT kgs-->	
		<div class="form-group col-md-3 col-md-offset-3">
            <label class="control-label col-xs-6" for="kgs">KGS <span class="required">*</span></label>
           	<input class="form-control" name="kgs" id="kgs" form="shipdoc">
        </div> 		
<!-- CBM -->
		<div class="form-group col-md-3 ">
            <label class="control-label col-xs-6" for="cbm">CBM <span class="required">*</span></label>
            <input class="form-control" name="cbm" id="cbm" form="shipdoc">
		</div>
	    <div class="form-group col-lg-12"></div>	
<!-- Counties of origin -->	
        <div class="form-group col-md-6 col-md-offset-3">
            <label class="control-label col-xs-12" for="country_origin">Country of Origin <span class="required">*</span></label>
            <select class="select2 form-control" name="country_origin[]" id="country_origin" multiple form="shipdoc">
            	<option></option>
    <?php
    	$query = "SELECT Country_name FROM country_origin ORDER BY Country_name";
    	$result = mysqli_query($db_link, $query);
    	while($row = mysqli_fetch_array($result)) 
    	{
    		echo'<option value="'. $row['Country_name'] .'">'. $row['Country_name'] .'</option>';
    	}	
    ?>        	
            </select>
		</div>	    
	</div>
<!--:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									FINAL STEP 7
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->	
	<div id="step-7">
		<div class="form-group col-lg-12">
        	<h2 class="StepTitle">Final Step: Remarks </h2>
        </div>

		<!-- Remarks -->	
        <div class="form-group col-md-6 col-md-offset-3">
        	<label class="control-label col-xs-12" for="remarks">Remarks <span class="required">*</span></label> 
        	<textarea class="form-control" name="remarks" id="remarks" form="shipdoc"></textarea>
        	<p>ex) FREIGHT COLLECT</p>
        </div>
    	
    	<div class="form-group col-md-6 col-md-offset-3">
		    <form action="shipdoc_gen.php" method="POST" id="shipdoc">
			    <button class="form-control btn btn-danger">GENERATE SHIPDOC</button>
			</form>
		</div>	        
    </div>	
 <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->   
</div>
<!-- End SmartWizard Content -->
</div>
<?php
include('themes/gentelella/footer.php');
?>