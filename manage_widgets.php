<?php 
	include "header.php"; 
	
	accessRole("VIEW_MY_WIDGET",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;">
			 <span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Manage Widgets of local FORGEBox installation
	</h1>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php
			if(accessRole("NEW_EDIT_DELETE_WIDGET",$connection))
			{
			?>
				<div id="tile_widget1" style="height: 200px;width: 180px;" class="col-sm-2">
				<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="window.location='localstore_create_item_widget.php';">
					<div id="img_tile_widget1" style ="background: url('images/new_widgets.png') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">
					New Widgets
					</div>
				
				
				</a>
				</div>
			<?php
			}
			?>
				
		</div>
	</div>
	<?php
	
	if(accessRole("VIEW_MY_WIDGET",$connection))
	{
	?>
	<div class="col-sm-12">	
		<div class="grid fluid">
			<div id="table_widget"  class="col-sm-12"></div>
		</div>
	</div>
	
	<?php
	}

	?>
	<br/><br/>	
			
	<script>
	
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});	

					var wid=0;
					function activation_action(wid)
					{
					
						$.ajax({
								type: "POST",
								url: "functions/localstore_activate_widget.php",
								data: "widgetid="+wid,
								dataType:"json",  
								success: function(msg) {	
									if(msg.status == 1){
										if(msg.txt=="Deactivate")
										{
											/*$.Notify({
												style: {background: 'red', color: 'white'},
												shadow: true,
												position: 'bottom-right',
												content: "Deactivate widget"
											});
										*/
											$("#function"+wid).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
										}
										else if(msg.txt=="Activate")
										{
											/*$.Notify({
												style: {background: 'green', color: 'white'},
												shadow: true,
												position: 'bottom-right',
												content: "Activate widget"
											});
										*/
											$("#function"+wid).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
										}
									
									}
									else if(msg.status == 0){
										alert(msg.txt);
									}
								}
							});
					}
		<?php
	
		if(accessRole("VIEW_MY_WIDGET",$connection))
		{
		?>			
		$('#table_widget').load('functions/select_widgets.php?USERID=<?php echo $_SESSION['USERID']; ?>').fadeIn("slow");	
		<?php
		}
		?>
	</script>
	
</div>

<?php 
	include "footer.php"; 
?>
