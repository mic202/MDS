<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="index.php" class="site_title"><i class="fa fa-tasks"></i> MIC Database</a>
		</div>
		
		<div class="clearfix"></div>
	
		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
                <img src="sources/images/MIC_logo.jpg" alt="..." class="img-circle profile_img">
            </div>
			<div class="profile_info">
				<span>Welcome,</span>
				<h2>
					<?php echo  $_SESSION['user_fname'].' '. $_SESSION['user_lname']; ?>   
				</h2>
			</div>
		</div>
		<!-- /menu profile quick info -->
		
		<br />

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<h3>General</h3>
				<ul class="nav side-menu">
					<li><a><i class="fa fa-calculator"></i> Quotations <span class="fa fa-chevron-down"></span></a>
					  <ul class="nav child_menu">
						<li><a href="quotation.php">Quotation Generator</a></li>
						<li><a href="quotation_list.php">Quotation List</a></li>	
					  </ul>
					</li>

					<li><a><i class="fa fa-shopping-cart"></i> Purchase Orders <span class="fa fa-chevron-down"></span></a>
					  <ul class="nav child_menu">
						<li><a href="#"><span class="label label-success pull-right">Coming Soon</span></a></li>
					  </ul>
					</li>

					<li><a><i class="fa fa-edit"></i> Shipping Documents <span class="fa fa-chevron-down"></span></a>
					  <ul class="nav child_menu">
						<li><a href="shipping_form.php">ShipDoc Generator</a></li>
						<li><a href="shipdoc_uploader.php">ShipDoc UPLOADER</a></li>
						<li><a href="shipdoc_list.php">Shipping Doc List</a></li>
						<li><a href="shipdoc_view.php">Shipping Doc View</a></li>
				
					  </ul>
					</li>
					<li><a><i class="fa fa-desktop"></i> Masters Files<span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="parts_master.php"><i class="fa fa-gears"></i> Parts Master Ver3.0</a></li>
							<li><a href="prices_list.php"><i class="fa fa-tags"></i> Prices Master Ver1.0</a></li>
							<li><a href="#">PO Master<span class="label label-success pull-right">Coming Soon</span></a></li>
							<li><a href="#">SO Master<span class="label label-success pull-right">Coming Soon</span></a></li>
							
						</ul>
					</li>

					<li><a><i class="fa fa-bar-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
					  <ul class="nav child_menu">
						<li><a href="#"><span class="label label-success pull-right">Coming Soon</span></a></li>
					  </ul>
					</li>

					<li><a><i class="fa fa-folder-o"></i> Resources <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="resources.php?page=buyer">Buyers List</a></li>
							<li><a href="resources.php?page=supplier">Suppliers List</a></li>
							<li><a href="resources.php?page=notify">Notify Parties List</a></li>
							<li><a href="resources.php?page=coo">Country of Origin</a></li>
							<li><a href="resources.php?page=port">Ports</a></li>
							<li><a href="resources.php?page=pcoding">Parts Coding System</a></li>
							
						</ul>
					</li>
				</ul>	
			</div>	
			<div class="menu_section">	
				<h3>Admin</h3>
				<ul class="nav side-menu">	
					<li><a><i class="fa fa-unlock-alt"></i> Deveopment <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="pm_ver_two.php">Parts Master Ver2.0</a></li>
							<li><a href="pm_ver_one.php">Parts Master Ver1.0</a></li>
							<li><a href="data_merge.php">Data Merge</a></li>
							<li><a href="csv_uploader.php">CSV UPLOADER</a></li>
							<li><a href="test.php">Test Page</a></li>
							<li><a href="blank.php">Blank Page</a></li>
						</ul>
					</li>
				</ul>
				<!-- eof class="nav side-menu" -->
			</div>
			<!-- eof class="menu_section"  -->
		</div>
		<!-- /sidebar menu -->
    
		<!-- /menu footer buttons -->
		<div class="sidebar-footer hidden-small">
			<a data-toggle="tooltip" data-placement="top" title="Settings">
				<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="FullScreen">
				<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Lock">
				<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
				<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
			</a>
		</div>
		<!-- /menu footer buttons -->
	</div>
	<!-- class="left_col scroll-view" -->
</div>
<!-- class="col-md-3 left_col" -->