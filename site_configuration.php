<?php include "header.php"; 

	if(isset($_POST["database_host"]) && isset($_POST["database_username"]) && isset($_POST["database_password"]) && isset($_POST["db_name"]) && isset($_POST["InstallationSite"]) && isset($_POST["SiteNoteTeaser"]) && isset($_POST["emailAdministrator"]) && isset($_POST["OrganizationName"]) && isset($_POST["GeneralInformation"]) )
	{
		$file = 'functions/conf.php';
		$current = file_get_contents($file);
		// Append a new person to the file
	
		$current = "<?php \n include \"conn_with_db.php\";\n\n\$database_host=\"".$_POST["database_host"]."\";\n\n";
		$current .= "\$database_username=\"".$_POST["database_username"]."\";\n\n";
		$current .= "\$database_password=\"".$_POST["database_password"]."\";\n\n";
		$current .= "\$db_name = \"".$_POST["db_name"]."\";\n\n";
		$current .= "\$InstallationSite = \"".$_POST["InstallationSite"]."\";\n\n";	
		$current .= "\$SiteNoteTeaser = \"".$_POST["SiteNoteTeaser"]."\";\n\n";	
		$current .= "\$connection = conn_with_db(\$database_host, \$database_username, \$database_password, \$db_name);\n\n";	
		$current .= "const CLIENT_ID = '<GPLUSCLIENTID>';\n\n";	
		$current .= "const CLIENT_SECRET = '<GPLUSClientSecret>';\n\n";	
		$current .= "const APPLICATION_NAME = \"FORGEBox web app\";\n\n";
		$current .= "\$emailAdministrator = \"".$_POST["emailAdministrator"]."\";\n\n";	
		$current .= "\$OrganizationName = \"".$_POST["OrganizationName"]."\";\n\n";	
		$current .= "\$GeneralInformation = \"".$_POST["GeneralInformation"]."\";\n\n";	
		
						
		
		// Write the contents back to the file
		file_put_contents($file, $current);
		
		
		?>
		<meta http-equiv="refresh" content="0">
		<?php
		
	}
	$lrs_object_name = "Site Configuration";
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Site Configuration
		</h1>
		<br>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
		<?php
			$filename="functions/conf.php";
			if(is_writable($filename))
			{
		?>
				<form action="site_configuration.php" method="post" >
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Input Database Hostname</p>
							<input type="text" class="form-control" name="database_host" data-toggle="tooltip" data-placement="top" title="The field is read only." readonly value="<?php echo $database_host; ?>" placeholder="Input Database Hostname"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Input Database Username</p>
							<input type="text" class="form-control" name="database_username" data-toggle="tooltip" data-placement="top" title="The field is read only." readonly value="<?php echo $database_username; ?>" placeholder="Input Database Username"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Input Database Password</p>
							<input type="password" class="form-control" name="database_password" data-toggle="tooltip" data-placement="top" title="The field is read only." readonly value="<?php echo $database_password; ?>" placeholder="Input Database Password"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Input Database Name</p>
							<input type="text" class="form-control" name="db_name" data-toggle="tooltip" data-placement="top" title="The field is read only." readonly value="<?php echo $db_name; ?>" placeholder="Input Database Name"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Installation Site</p>
							<input type="text" class="form-control" name="InstallationSite" value="<?php echo $InstallationSite; ?>" placeholder="Installation Site"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Site Note Teaser</p>
							<input type="text" class="form-control" name="SiteNoteTeaser" value="<?php echo $SiteNoteTeaser; ?>" placeholder="Site Note Teaser"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>e-mail Administrator</p>
							<input type="text" class="form-control" name="emailAdministrator" value="<?php echo $emailAdministrator; ?>" placeholder="e-mail Administrator"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>Organization Name</p>
							<input type="text" class="form-control" name="OrganizationName" value="<?php echo $OrganizationName; ?>" placeholder="Organization Name"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-control col-md-4 text">
							<p>General Information</p>
							<input type="text" class="form-control" name="GeneralInformation" value="<?php echo $GeneralInformation; ?>" placeholder="General Information"/>
						</div>
					</div>
					<br />
					<br />
					<button type="submit" >Save</button>
					<button type="reset" >Reset</button>
				</form>
				
				
			<?php
			}
			else
			{
				echo "<div style=\"color:red;\">You have not permission to change the configuration file.<br>Please contact with the administrator to change the permission!</div>";
			}
		?>
	</div>
</div>

<script>

	$('#return_back').click(function(){
		parent.history.back();
		return false;
	});
	
</script>

<?php include "footer.php"; ?>