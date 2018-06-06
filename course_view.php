<?php include "header.php"; 

accessRole("VIEW_WIDGETS",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
?>

<!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;" >
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			View Widget from Repository
		</h1>
		
	<?php
		
		if(isset($_GET["id"]))
		{
			$json = file_get_contents('http://www.forgestore.eu:8080/fsapi/services/api/repo/courses/'.$_GET["id"]);
			$obj = json_decode($json);
		}
		else
		{
			
			die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
		}
	?>
	
	<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 appIconMainScreen">
				<h1></h1>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tileimg"><img src="<?php if(!isset($obj->iconsrc)){ print "images/_courses/default.png";} else { print $obj->iconsrc; } ?>" width="100%" />
				</div>
				<h4 class="ng-binding">Version: <?php print $obj->version; ?></h4>
				
			</div>
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				<h1 id="headerTitle" class="ng-binding"><?php print $obj->name; ?></h1>
				<p>
					<?php
					//print_r($obj->categories);
					$my_categories = $obj->categories;
					for($i=0;$i<count($my_categories);$i++)
					{
					?>
						<span ng-repeat="cat in widget.categories" class="ng-scope"><span class="label label-info ng-binding"><?php print $my_categories[$i]->name; ?></span>&nbsp;&nbsp;</span>
					<?php
					
					}
					?>
				</p>
				
				<h3 class="ng-binding"><?php print $obj->shortDescription; ?></h3>
				<?php $my_owner = $obj->owner; ?>
				<p>Author: <strong class="ng-binding"><?php print $my_owner->name; ?></strong></p>
				<p>Organization: <strong class="ng-binding"><?php print $my_owner->organization; ?></strong></p>
				<p>URL: <strong class="ng-binding"><?php print $obj->url; ?></strong></p>
				<p>Date created: <strong class="ng-binding"><?php print $obj->dateCreated; ?></strong></p>
				<p>Last update: <strong class="ng-binding"><?php print $obj->dateUpdated; ?></strong></p>
				<p>UUID: <strong class="ng-binding"><?php print $obj->uuid; ?></strong></p>
				<p class="ng-binding"><?php print $obj->longDescription; ?></p>
				<?php if(!isset($obj->screenshots)){ ?><img src="<?php print $obj->screenshots; ?>" width="100%"><?php  } ?>
				
			</div>
		</div>
		<div class="row" style="float:right;">
			
			<button class="btn btn-success" style="font-size:24px;" onclick="install_course('<?php print $obj->packageLocation;?>'); "><table><tr><td><i id="download_course" class="fa fa-download fa-lg"></i>&nbsp;&nbsp;&nbsp;</td><td>Install from <br/>FORGEStore</td></tr></table></button>
		</div>
		
		
	</div>
	

<script>

	var install_url="";
	function install_course(install_url)
	{
		$('#download_course').removeClass('fa-download');
		$('#download_course').addClass('fa-refresh fa-spin');
		$.ajax({
		   url: 'install_course_function.php?get_link='+install_url,
		   dataType: 'json',
		   success: function(data){				
				$('#download_course').removeClass('fa-refresh fa-spin');
				$('#download_course').addClass('fa-check-square-o');
		   }
		});
	}
	
</script>

<?php include "footer.php"; ?>