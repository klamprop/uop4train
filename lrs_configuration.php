<?php
	include "header.php"; 	
	accessRole("LRS_CONFIGURATION",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	$lrs_object_name = "LRS Configuration";
?>
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			LRS Configuration 
		</h1>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:25px;">
		<div class="col-md-6">
			<form action="#" id="add_edit_lrs" name="add_edit_lrs">
				<div class="col-md-12" style="padding-bottom:10px;">
					<div class="col-md-4">
						<label>LRS Name : </label>
					</div>
					<input type="text" name="lrs_name" id="lrs_name" />
				</div>
				<div class="col-md-12" style="padding-bottom:10px;">
					<div class="col-md-4">
						<label>LRS Endpoint : </label>
					</div>
					<input type="text" name="lrs_endpoint" id="lrs_endpoint" />
				</div>
				<div class="col-md-12" style="padding-bottom:10px;">
					<div class="col-md-4">
						<label>LRS Username : </label>
					</div>
					<input type="text" name="lrs_username" id="lrs_username" />
				</div>
				<div class="col-md-12" style="padding-bottom:10px;">
					<div class="col-md-4">
						<label>LRS Password : </label>
					</div>
					<input type="text" name="lrs_password" id="lrs_password" />
				</div>
				<div class="col-md-12" style="padding:20px;">
					<div class="col-md-4">
						&nbsp;
					</div>
					<a class="btn btn-default" id="btn_add_edit_lrs" href="#" >Add new LRS</a>
				</div>
				<input name="addedit" type="hidden" id="addedit" value="add" />
				<input name="lrs_id" type="hidden" id="lrs_id" value="" />
			</form>
		</div>
		<div class="col-md-6">
			<table class="table table-hover">
				<thead>
					<tr>						
						<th width="25%">LRS Name</th>
						<th width="70%">Endpoint</th>
						<th width="5%">Action</th>
					</tr>
				</thead>				
				<tbody id="lrs_results">
					
				</tbody>
			</table>
		</div>
	</div>
</div>



<script>
	$( document ).ready(function() {
		$.ajax({
			url:"functions/lrs_details.php?action=sel",
			success: function(msg){
				$("#lrs_results").html(msg);
				$("#lrs_name").focus();
			}
		});
		
		$("#btn_add_edit_lrs").click(function(){
			
			if($("#addedit").val() == "add")
			{
				$.ajax({
					type: "POST",
					url:"functions/lrs_details.php?action=ins",
					data: $('#add_edit_lrs').serialize(),
					//dataType: "json",
					success: function(msg){
						$("#lrs_results").html(msg);
						$("#lrs_name").val('');
						$("#lrs_endpoint").val('');
						$("#lrs_username").val('');
						$("#lrs_password").val('');
						$("#addedit").val('add');
						$("#lrs_name").focus();
					}
				});
			}
			else if($("#addedit").val() == "edit"){
				$.ajax({
					type: "POST",
					url:"functions/lrs_details.php?action=upd&id="+$("#lrs_id").val(),
					data: $('#add_edit_lrs').serialize(),
					//dataType: "json",
					success: function(msg){
						$("#lrs_results").html(msg);
						$("#lrs_name").val('');
						$("#lrs_endpoint").val('');
						$("#lrs_username").val('');
						$("#lrs_password").val('');
						$("#addedit").val('add');
						$("#lrs_name").focus();
					}
				});
			}
		});
	});
	
	var lrs_id=0;
	function edit_lrs(lrs_id){
		//alert(lrs_id);
		$.ajax({
		url:"functions/lrs_details.php?action=sel&id="+lrs_id,
			success: function(msg){
				var arr = msg.split('|');
				var lrs_id= arr[0].split(':');
				$("#lrs_id").val(lrs_id[1]);
				var lrs_name = arr[2].split(':');
				$("#lrs_name").val(lrs_name[1]);
				var lrs_endpoint = arr[3].split(':');
				$("#lrs_endpoint").val(lrs_endpoint[1]);
				var lrs_username = arr[4].split(':');
				$("#lrs_username").val(lrs_username[1]);
				var lrs_password = arr[5].split(':');
				$("#lrs_password").val(lrs_password[1]);
				$("#addedit").val('edit');
				$("#lrs_name").focus();
				//alert(msg);
				//$("#lrs_results").html(msg);
			}
		});
	}
	
	function delete_lrs(lrs_id){
		
		$.ajax({			
			url:"functions/lrs_details.php?action=del&id="+lrs_id,
			success: function(msg){
				//alert(msg);
				$("#lrs_results").html(msg);
				$("#lrs_name").focus();
			}
		});
	}
</script>

 <?php include "footer.php"; ?>