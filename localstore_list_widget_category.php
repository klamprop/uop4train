   <?php include "header.php"; 
   
	accessRole("VIEW_CATEGORY_WIDGET",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');

			$query_select= "SELECT id_category_widget, name_category_widget, active_category_widget FROM tbl_category_widget";
			$result_select = $connection->query($query_select);
			
			while($row = $result_select->fetch_array()){
				$id=$row[0];
				$name=$row[1];
				$active=$row[2];
			}
			
   
   
   ?>
  <style>
		.pagination li {
			display:inline-block;
			padding:5px;
		}
		
		.list tr:hover{
			background-color:#f7fafa;
		}
	</style>
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-sm-12">	
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Manage Widget categories
		</h1>
	</div>
	<?php
	if(accessRole("NEW_EDIT_DELETE_WIDGET_CATEGORY",$connection))
	{
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="tile_widget1" style="height: 200px;width: 180px;" >
			<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="window.location='localstore_add_widget_category.php';">
				<div id="img_tile_widget1" style ="background: url('images/coursecategoryico.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">

				New Category
				</div>
			</a>
			</div>
	</div>
	<?php
	}
	if(accessRole("VIEW_CATEGORY_WIDGET",$connection))
	{
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="table_cat">
				</div>
	</div>
	<?php
	}
	?>
	<script>
	
		var catid=0;
		var citem="<?php echo  $_GET['citem']; ?>";// if(isset($_GET['citem'])){	if(!empty($_GET['citem'])){}}
		var link = 'functions/select_cat_widget.php';//?citem='+citem;
		$(document).ready(function(){
		<?php
			if(accessRole("VIEW_CATEGORY_WIDGET",$connection))
			{
		?>
				$('#table_cat').load(link).fadeIn("slow");
		<?php
			}
		?>
			$('#insert_course').submit(function(e) {						
				insert_category();	
				e.preventDefault();		
			});
		});
		
		function activate_category(catid)
		{				
			
			$.ajax({
				type: "POST",
				url: "functions/activate_widget_category.php",
				data: "categoryid="+catid,
				dataType:"json",  
				success: function(msg) {
					if(msg.status == 1){					
						if(msg.txt=="Deactivate")
						{
							/*
							$.Notify({
								style: {background: 'red', color: 'white'},
								shadow: true,
								position: 'bottom-right',
								content: "Deactivate Category"
							});*/
							$("#category"+catid).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
							$('#table_cat').load('functions/select_cat_widget.php').fadeIn("slow");
						}
						else if(msg.txt=="Activate")
						{
							/*
							$.Notify({
								style: {background: 'green', color: 'white'},
								shadow: true,
								position: 'bottom-right',
								content: "Activate Category"
							});*/
							$("#category"+catid).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
							$('#table_cat').load('functions/select_cat_widget.php').fadeIn("slow");
						}
					}
					else if(msg.status == 0){
						/*$.Notify({
							style: {background: 'red', color: 'white'},
							shadow: true,
							position: 'bottom-right',
							content: msg.txt
						});*/						
					}
				}
			});
		}
		
		
	</script>
	
	
</div><!--  ------------------------  END CONTENT      ------------------------      -->
 <?php include "footer.php"; ?> 