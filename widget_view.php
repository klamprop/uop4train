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
			$json = file_get_contents('http://www.forgestore.eu:8080/fsapi/services/api/repo/widgets/'.$_GET["id"]);
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tileimg"><img src="<?php print $obj->iconsrc; ?>" width="100%" />
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
						<!-- <span ng-repeat="cat in widget.categories" class="ng-scope"><span class="label label-info ng-binding">Monitoring</span>&nbsp;&nbsp;</span>
						<span ng-repeat="cat in widget.categories" class="ng-scope"><span class="label label-info ng-binding">User interaction</span>&nbsp;&nbsp;</span> -->
					<?php
					
					}
					?>
				</p>
				
				<h3 class="ng-binding"><?php print $obj->shortDescription; ?></h3>
				<?php $my_owner = $obj->owner; ?>
				<p>Author: <strong class="ng-binding"><?php print $my_owner->neme; ?></strong></p>
				<p>Organization: <strong class="ng-binding"><?php print $my_owner->organization; ?></strong></p>
				<p>URL: <strong class="ng-binding"><?php print $obj->url; ?></strong></p>
				<p>Date created: <strong class="ng-binding"><?php print $obj->dateCreated; ?></strong></p>
				<p>Last update: <strong class="ng-binding"><?php print $obj->dateUpdated; ?></strong></p>
				<p>UUID: <strong class="ng-binding"><?php print $obj->uuid; ?></strong></p>
				<p class="ng-binding"><?php print $obj->longDescription; ?></p>
				<img src="<?php print $obj->screenshots; ?>" width="100%">
				
			</div>
		</div>
		
		<div style="float:right;">
			<a href="#" class="btn btn-primary" onclick="insert_widget();">Install</a>
		</div>
		
	</div>
	
	<script>
		function insert_widget()
		{	
		
			//var str = document.getElementById('select_repository').value;
			//var marketid = str.replace('marketplace_widget.php?rep_id=','');
			var data1 = 'userid=<?php print $_SESSION["USERID"]; ?>&widgetid=<?php print $_GET["id"]; ?>&title_widget=<?php print $obj->name; ?>&author_widget=<?php print $my_owner->neme; ?>&description_widget=<?php print $obj->shortDescription; ?>&marketplace_id=1&version=<?php print $obj->version; ?>&url_widget=<?php print $obj->url; ?>';
							
			$.ajax({
				type: "POST",
				url: "functions/insert_widget_in_marketplace.php",
				data: data1,
				dataType: "json",
				success: function(msg){
					if(parseInt(msg.status)==1)
					{
						//window.location='marketplace_widget.php?rep_id='+marketid;
						alert('Installed');
					}
					else if(parseInt(msg.status)==0)
					{				
						alert('Error');
					}
				}
			});
		}
						
	</script>
<?php include "footer.php"; ?>