<?php include "header.php";
/*accessRole("NEW_EDIT_DELETE_WIDGET_CATEGORY",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');*/

?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>
		<?php  echo "Create New Project"; ?>
	</h1>
	</div>


	<form id="insert_course" method="post" >
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="span3"><label>Name:</label></div>
					<div class="input-control text size3 span2" data-role="input-control">
						<input type="text" placeholder="type project name" id="project_name" name="project_name" value="<?php if(isset($name)){echo $name;} ?>"></input>
					</div>
					<br>
					<div class="span3" style="margin-left: 0px;">
						<input type="submit" id="submitPrj" onclick="insert_cat_cour(); return false;" value="Create Project"></input>
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
        /*
		var data_post='';
		var active_cat=0;
		if(document.getElementById('chkactive').checked)
		{*/
			active_cat=1;
		/*}
		else
		{
			active_cat=0;
		}*/

		if(document.getElementById('project_name').value == '')
		{
			$.Notify({
				style: {background: 'red', color: 'white'},
				shadow: true,
				position: 'bottom-right',
				content: 'Check your fields!<br>All fields are required!'
			});
			return false;
		}


		data_post += '&project_name='+document.getElementById('project_name').value;
		//data_post += '&update='+document.getElementById('update').value;
		data_post += '&active='+active_cat;
		//data_post += '&category_id='+document.getElementById('category_id').value;



		$.ajax({
			type: "POST",
			url: "functions/create_project_category.php",
			data: data_post,
			dataType: "json",
			success: function(msg){
				if(parseInt(msg.status)==0)
				{
					window.location.href="#";

				}
				else if(parseInt(msg.status)>0)
				{

					//window.location.href="localstore_list_widget_category.php";
                    window.location.href="list_project.php";
				}
				hideshow('loading',0);
			}
		});
	}



</script>
</div><!--  ------------------------  END CONTENT      ------------------------      -->
<?php include "footer.php"; ?>
