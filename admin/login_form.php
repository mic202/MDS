<?php 
include 'header.php';
?>
<div class="container" style="margin-top:60px">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<form role="form" action="login_auth.php" method="POST">
						<fieldset>
							<div class="row">
								<div class="center-block" align="center">
									<img src="../sources/images/MIC_logo.jpg" width="200" ></br></br>
								</div>
							</div>
	
							<div class="row">
								<div class="col-sm-12 col-md-10  col-md-offset-1 ">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-envelope"></i>
											</span> 
											<input class="form-control" placeholder="Enter your email" name="email" type="text" required="required" />
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-lock"></i>
											</span>
											<input class="form-control" placeholder="Password" name="password" type="password" required="required"/>
										</div>
									</div>
									<div class="form-group">
										<input type="submit" class="btn btn-lg btn-primary btn-block" value="Log in">
									</div>

									<div>Usernam: admin@mic.ca</div>
									<div>Password: admin</div>

								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="panel-footer ">
					Don't have an account! <a href="#" onClick=""> Sign Up Here </a>
				</div>
            </div>
		</div>
	</div>
</div>	