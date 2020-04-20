<section id="login_layer_top" style="background-color: #FFFFFF;">
	<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 pull-right">
					     	<ul class="navbar-nav pull-right header-menu" style="list-style-type: none;">

									 <li class="pull-right" style="padding-left:10px;"> <a href="register.php" style="color: #555555";>Register</a></li>

					         <li id="fat-menu" class="dropdown pull-right">
					          <a href="#" class="dropdown-toggle singnincolors" data-toggle="dropdown" style="background-color:#ffffff;">
					             Sign In</b>
					          </a>
					          <ul class="dropdown-menu center pull-right list-unstyled" style="min-width:300px; padding:10px; list-style-type: none;">
											<li>
											<h1 style="color:#555555; margin-top:0px">Sign In</h1>
											<div class="status alert alert-success" style="display: none"></div>
											<form action="<?php echo  htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8");?>" method="post">
												<div class="form-group">
													<input type="email" class="form-control" id="InputEmail1" placeholder="email when sign up" name="username">
												</div>
												<div class="form-group">
													<input type="password" class="form-control" id="InputPassword1" autocomplete="off" placeholder="Your FORGEBox password" name="password">
													
												</div>

												<input type="hidden" name="anticsrf" value="<?php echo $anticsrf?>"/>

												<button type="submit" class="btn btn-default">Sign In</button>
												<br><a href="forgot_my_pass.php" style="font-size: 12px; color:#555555; text-decoration: none;">Forgot my password :(</a>
											</form>
										</li>
										<br/>
										  
											
					          </ul>
					         </li>


								</ul>
							</div>
						</div>

			</div>

<br>
</section>



