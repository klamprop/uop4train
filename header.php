<!DOCTYPE html>
<?php

error_reporting( E_ERROR );
ini_set('display_errors', 1);


include "functions/conf.php";
include "functions/session.php";
include "functions/functions.php";

include "functions/access_role.php";
$url_lrs_endpoint='';

if($_SESSION['USERID']>0 && $_SESSION['UROLE_ID']!=7){
			
	/*
	$_SESSION['lrs_name']="";
	$_SESSION['lrs_endpoint_url']="";
	$_SESSION['lrs_username']="";
	$_SESSION['lrs_password']="";
			
	$Select_lrs="SELECT lrs_name, endpoint_url, username, password FROM lrs_details WHERE id=12";	
	$result_lrs = $connection->query($Select_lrs);

	while($row_lrs = $result_lrs->fetch_array()){
		$_SESSION['lrs_name']=$row_lrs[0];
		$_SESSION['lrs_endpoint_url']='http://'.$row_lrs[1];
		$_SESSION['lrs_username']=$row_lrs[2];
		$_SESSION['lrs_password']=$row_lrs[3];
		$_SESSION['lrs_login_record']=1;
	}
	*/
	

	//$url_lrs_endpoint = '?endpoint='.rawurlencode($lrs_endpoint).'&auth=Basic%20'.urlencode(base64_encode($lrs_authUser.":".$lrs_authPassword));
}
		
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="product" content="FORGEBox">
    <meta name="description" content="FORGEBox">
    <meta name="author" content="NAM ECE UoP">
	<!-- fonts -->

	<link href='//fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>


	<!-- New Header Bootstrap Start -->
	<!-- <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> 
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> -->
	 <link href="css/font-awesome.css" rel="stylesheet">
	<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">	
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<!-- End Bootstrap -->
	
    <!-- metro css and js removed -->
	<!--
	<link href="css/metro-bootstrap.css" rel="stylesheet"> 
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet"> 
    <link href="css/docs.css" rel="stylesheet"> 
	<link href="css/nameceupatras.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet"> 
    <link href="css/jquery-ui.css" rel="stylesheet"> 
	-->
	<!--
	<script src="js/run_prettify.js"></script>
-->
    <!-- Load JavaScript Libraries -->

   <!-- <script src="js/jquery/jquery.min.js"></script>   
    <script src="js/jquery/jquery-ui.min.js"></script> 	  --> 
 <!--  	<script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/prettify/prettify.js"></script>
	-->
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>  
	<script src="js/bootstrap.min.js"></script>
	<script src="js/list.js"></script>
	<script src="js/list.pagination.js"></script>	
	<script src="js/carousel.js"></script>
	<script src="js/collapse.js"></script>	
	<script src="js/popover.js"></script>	
	<script src="js/tab.js"></script>	
	<script src="js/modernizr.custom.js"></script>
	<script type="text/javascript" src="js/jquery.form.min.js"></script>
	
	
	<script src="js/base64.js"></script>
	
	<script src="js/tincanapi/TinCanJS/build/tincan-min.js"></script>
	<script src="js/tincanapi/common.js" ></script>
    <script src="js/tincanapi/contentfunctions.js" ></script>
	<!-- <script src="js/tincanapi/BrowserPrep.js"></script> -->
	
    <!-- Metro UI CSS JavaScript plugins -->
    <!-- 
	<script src="js/load-metro.js"></script>
-->
	
	
    <!-- Local JavaScript -->
    <!--
	<script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>
	
	<script src="js/jquery.mixitup.min.js"></script>
-->
	<!-- include libries(jQuery, bootstrap, fontawesome) -->
	<!-- <script src="summernote/jquery-1.9.1.min.js"></script> -->
	<link href="summernote/font-awesome.min.css" rel="stylesheet">
	<!-- <link href="summernote/bootstrap.no-icons.min.css" rel="stylesheet"> -->
	<!-- <script src="summernote/bootstrap.min.js"></script>   -->
	 
	<!-- include summernote css/js -->
	<link href="summernote/summernote.css" / rel="stylesheet">
	<script src="summernote/summernote.min.js"></script>
	
	<!-- <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/jquery.steps.css">
    <script src="js/modernizr-2.6.2.min.js"></script> -->
    <!-- <script src="../lib/jquery-1.9.1.min.js"></script> -->
    <!-- <script src="js/jquery.cookie-1.3.1.js"></script>
    <script src="js/jquery.steps.js"></script> -->
	
	
	
	<link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="css/rating.min.css">
	
	
	 
	 
	<style type="text/css">
		.black, .black a {
		  color: #000;
		}
	</style>
	
	
	<?php
	if(isset($_GET['lang']))
	{
		switch ($_GET['lang']) 
		{		
			case 'en':
				$lang_file = 'en.php';
				break;
			case 'gr':
				$lang_file = 'gr.php';
				break;
			default:
				$lang_file = 'en.php';
				break;
		}
	}

	?>
    <title>FORGEBox</title>
		
</head>
<body>

	
	<?php			
		
		//is_logged_in();
		if(strpos(basename($_SERVER['REQUEST_URI']),'?'))
		{
			$split_url = explode('?',basename($_SERVER['REQUEST_URI']));
		}
		else
		{
			$split_url[0] = basename($_SERVER['REQUEST_URI']);
		}
		if(isset($_SESSION["UROLE_ID"]))
		{
			$urole_id = str_replace('/',',',$_SESSION["UROLE_ID"]);
		}
		else
		{
			$urole_id=7;
		}

	?>
	<!-- start Header -->       
	<section id="FORGEBoxHeaderMenuLogo" style="background-color:#333333" >
		<div class="container" > 

		<nav class="row navigation-bar dark" style="height:60px">
			<nav class="navbar-content">
				<a href="index.php" class="element" style="text-decoration:none; color:#FFFFFF;"><img src="images/FORGE_Logo_toolbar.png" style="margin-top: 5px;"/><br>at <?php echo $InstallationSite;?></a>
			</nav>
		</nav>
		</div>
	</section>
	<section id="FORGEBoxHeaderMenu" style="background-color:#666666" > 
		<!-- <div class="container" >-->


			<div class="navbar navbar-forgebox navbar-static-top" role="navigation" style="background-color:#666666; border-color: #666666;">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						  <span class="sr-only">Toggle navigation</span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>
						</button>	
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav nav-forgebox">
						<?php
							if(accessRole("VIEW_ALL_COURSES",$connection) || accessRole("VIEW_MY_COURSES",$connection) || accessRole("VIEW_PRESENTATION",$connection) || accessRole("VIEW_INTERACTIVE_COURSE",$connection) || accessRole("VIEW_CATEGORY_COURSE",$connection) || accessRole("VIEW_COURSE_SUPPORT_SERVICES",$connection) || accessRole("INSTALL_COURSE_FROM_FORGESTORE",$connection))
							{
						?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Courses <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
								<?php
									if(accessRole("VIEW_ALL_COURSES",$connection))
									{
								?>
									<li class="divider"></li>
									<li><a href="all_course.php">All Course Modules</a></li>
								<?php
									}
									if(accessRole("VIEW_MY_COURSES",$connection))
									{
								?>
									<li class="divider"></li>
									<li><a href="mycourse.php">My Course Modules</a></li>
									<?php
									
									}
									if(accessRole("VIEW_PRESENTATION",$connection))
									{
									?>
									<li class="divider"></li>
									<li><a href="mypresentation.php">Course Presentation Parts</a></li>
									<?php
									}
									if(accessRole("VIEW_INTERACTIVE_COURSE",$connection))
									{
									?>
									<li class="divider"></li>
									<li><a href="my_interactive_courses_part.php">Course Interactive Parts</a></li>
									<?php
									}
									if(accessRole("VIEW_CATEGORY_COURSE",$connection))
									{
									?>
									<li class="divider"></li>
									<li><a href="course_category.php">Categories</a></li>
									<?php
									}
									if(accessRole("VIEW_COURSE_SUPPORT_SERVICES",$connection))
									{
									?>
									<li class="divider"></li>
									<li><a href="course_support_services.php">Course Support Services</a></li>
									<?php
									}
									
									if(accessRole("INSTALL_COURSE_FROM_FORGESTORE",$connection))
									{
									?>
									<li class="divider"></li>
									<li><a href="marketplace_courses.php">Install Course from FORGEStore</a></li>
									<?php
									}
									?>
									<li class="divider"></li>
								</ul>
							</li>
							<?php
							
							}
							if(accessRole("INSTALLED_MY_WIDGET",$connection) || accessRole("INSTALL_WIDGETS",$connection) || accessRole("VIEW_MY_WIDGET",$connection))
							{
				
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Widgets <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php
										if(accessRole("INSTALLED_MY_WIDGET",$connection))
										{
									?>
											<li class="divider"></li>
											<li><a href="widgets.php">My Installed Widgets</a></li>
									<?php
										}
										if(accessRole("INSTALL_WIDGETS",$connection))
										{
									?>
											<li class="divider"></li>
											<li><a href="marketplace_widget.php">Install New</a></li>
									<?php
										}
										if(accessRole("VIEW_MY_WIDGET",$connection))
										{
									?>
											<li class="divider"></li>
											<li><a href="manage_widgets.php">Manage Widgets of local FORGEBox installation</a></li>
									<?php
										}
										if(accessRole("NEW_EDIT_DELETE_WIDGET_CATEGORY",$connection))
										{
									?>
											<li class="divider"></li>
											<li><a href="localstore_list_widget_category.php">Categories</a></li>
									<?php
										}
									?>
									<li class="divider"></li>
								</ul>
							</li>
							<?php
							
							}
							if(accessRole("INSTALLED_MY_SERVICES",$connection) || accessRole("INSTALL_SERVICES",$connection) || accessRole("VIEW_MY_SERVICES",$connection))
							{
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">FORGEBox Services <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php
									if(accessRole("INSTALLED_MY_SERVICES",$connection))
									{
									?>
										<li class="divider"></li>
										<li><a href="services.php">My Installed Services</a></li>
									
									<?php
									}
									if(accessRole("INSTALL_SERVICES",$connection))
									{
									?>
										<li class="divider"></li>
										<li><a href="marketplace_services.php">Installed services</a></li>
									<?php
									}
									if(accessRole("VIEW_MY_SERVICES",$connection))
									{
									?>
										<li class="divider"></li>
										<li><a href="manage_services.php">Manage Services</a></li>
									<?php
									}
									?>
								</ul>
							</li>
							<?php
							}
							if(accessRole("USER_MANAGEMENT",$connection) || accessRole("ACCESS_CONTROL",$connection) || accessRole("NEW_EDIT_DELETE_REPOSITORY",$connection) || accessRole("SITE_CONFIGURATION",$connection)|| accessRole("LRS_CONFIGURATION",$connection))
							{
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">System <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
								<?php
									if(accessRole("USER_MANAGEMENT",$connection))
									{
								?>
										<li class="divider"></li>
										<li><a href="users.php">Users Management</a></li>
								<?php
									}
									if(accessRole("ACCESS_CONTROL",$connection))
									{
								?>
										<li class="divider"></li>
										<li><a href="action.php">Access Control</a></li>
								<?php
									}
									if(accessRole("NEW_EDIT_DELETE_REPOSITORY",$connection))
									{
								?>
										<li class="divider"></li>
										<li><a href="configure_repository.php">Configure Repository</a></li>
								<?php
									}
									if(accessRole("SITE_CONFIGURATION",$connection))
									{
								?>
										<li class="divider"></li>
										<li><a href="site_configuration.php">Site Configuration</a></li>
								<?php
									}
									if(accessRole("LRS_CONFIGURATION",$connection))
									{
								?>
										<li class="divider"></li>
										<li><a href="lrs_configuration.php">LRS Configuration</a></li>
								<?php
									}
								?>
								</ul>
							</li>
							<?php
							}
							?>
						</ul>
						<?php
						if($urole_id!=7)
						{
						?>
						<ul class="nav navbar-nav navbar-right nav-forgebox">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="height: 50px;">
								<?php
									$query_select_av = "SELECT avatar_name FROM tbl_users WHERE active_user=1 AND id_user=".$_SESSION["USERID"];
									$result_select_av = $connection->query($query_select_av);
							
									while($row = $result_select_av->fetch_array())
									{
										$avatar1 = $row[0];
									}						
								?>											
								
									<div style="float:left; margin-top:-10px;">
										<img id="avatarProf" src="<?php if(!empty($avatar1)){ if (  strpos($avatar1, 'http') === 0  ){ echo $avatar1; }else 	echo 'images/avatars/'.$_SESSION['USERID'].'/thubs/'.$avatar1; }else { echo 'images/defavatar.png'; } ?>" style="height:42px;" />
									</div>
									<div style="float:left; margin-top:-10px;padding-left:5px;">
										<?php echo $_SESSION['FNAME']." ".$_SESSION['LNAME'];?> <br /> <?php echo "(".$_SESSION['UROLE'].")";?>  
									</div>
									<div style="float:left;">&nbsp;
										<span class="caret"></span>
									</div>
								
								</a>
								<ul class="dropdown-menu" role="menu">
								<?php
									if(accessRole("MY_ACCOUNT",$connection))
									{
								?>
									<li class="divider"></li>
									<li><a href="account.php">My Account</a></li>	
								<?php
									}
									if(accessRole("REVIEWS",$connection))
									{
								?>	
										<li class="divider"></li>
										<li><a href="reviews.php">My Reviews</a></li>
								<?php
									}
									if(accessRole("MY_DASHBOARD",$connection))
									{
								?>	
										<li class="divider"></li>
										<li><a href="dashboard.php">My Dashboard</a></li>
								<?php
									}
									if(accessRole("NOTIFICATIONS",$connection))
									{
								?>	
										<li class="divider"></li>
										<li><a href="notification.php">Notifications</a></li>
								<?php
									}
								?>	
									<li class="divider"></li>
									<li><a href="functions/logout.php">Logout</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
						<?php
						}
						?>
					</div><!--/.nav-collapse -->
				</div><!--/.container-fluid -->
			</div>
	</section> 
	<!--  End Header -->	
   <div class="container" >  <!-- This div should close on footer.php -->   
	
