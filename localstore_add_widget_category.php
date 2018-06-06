<?php include "header.php"; 
accessRole("NEW_EDIT_DELETE_WIDGET_CATEGORY",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');

if(isset($_GET["id"]))
	{
		$query_select = "SELECT name_category_widget, active_category_widget FROM tbl_category_widget WHERE id_category_widget=".$_GET["id"];
		$result_select = $connection->query($query_select);
				
		while($row = $result_select->fetch_array()){
			$name=$row[0];
			$active=$row[1];
		}
	}

?>
 
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		<?php if(isset($_GET['id'])) { echo "Edit Widget Category"; } else { echo "Add Widget Category"; } ?>
	</h1>
	</div>


	<form id="insert_course" method="post" >
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					<div class="span3"><label>Name:</label></div>
					<div class="input-control text size3 span2" data-role="input-control">
						<input type="text" placeholder="type category name" id="category_name" name="category_name" value="<?php if(isset($name)){echo $name;} ?>"></input>
					</div>
					<div class="input-control checkbox span3" style="margin-left: 0px;">
						<label>
							<input type="checkbox" name="active" id="chkactive" <?php if(isset($active)){ if($active==1){ echo "checked";}} ?> />
							<span class="check"></span>
							Active
						</label>
					</div><br>
					<div class="span3" style="margin-left: 0px;">
						<input type="hidden" id="category_id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo "";}  ?>"/>
						<input type="hidden" id="update" value="<?php if(isset($_GET['id'])) { echo "1";} else { echo "0"; } ?>"/>
						<input type="submit" id="submit" onclick="insert_cat_cour(); return false;" value="<?php if(isset($_GET['id'])) { ?>Edit Category<?php } else { ?>Create Category<?php } ?>"></input>
					</div><br>
		</div>
	</form>

<script>

	$('#return_back').click(function(){
		parent.history.back();
		return false;
	});
	
	function insert_cat_cour()
	{
		var data_post='';
		var active_cat=0;
		if(document.getElementById('chkactive').checked)
		{
			active_cat=1;
		}
		else
		{
			active_cat=0;
		}
		
		if(document.getElementById('category_name').value == '')
		{
			$.Notify({
				style: {background: 'red', color: 'white'},
				shadow: true,
				position: 'bottom-right',
				content: 'Check your fields!<br>All fields are required!'
			});	
			return false;
		}
	
		data_post += '&category_name='+document.getElementById('category_name').value;
		data_post += '&update='+document.getElementById('update').value;
		data_post += '&active='+active_cat;
		data_post += '&category_id='+document.getElementById('category_id').value;		
		
		
		
		$.ajax({
			type: "POST",
			url: "functions/create_widget_category.php",
			data: data_post,
			dataType: "json",
			success: function(msg){
				if(parseInt(msg.status)==0)
				{
					window.location.href="localstore_add_widget_category.php"
				}	
				else if(parseInt(msg.status)>0)
				{
					
					window.location.href="localstore_list_widget_category.php";
				}
				hideshow('loading',0);					
			}							
		});
	}
	
	
		
</script>
</div><!--  ------------------------  END CONTENT      ------------------------      -->
<?php include "footer.php"; ?>