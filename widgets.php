<?php include "header.php"; 

accessRole("INSTALLED_MY_WIDGET",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
$lrs_object_name = "My Installed Widget";

$query_select_repository = "SELECT name, id FROM tbl_repository WHERE active=1";
$result_select_repository = $connection->query($query_select_repository);
$count_repository = 0;
while($row = $result_select_repository->fetch_array())
{			
	$repo_name[$count_repository]=$row[0];
	$repo_id[$count_repository]=$row[1];
	
	$count_repository++;
}

	$query_select_repo_details = "SELECT url_json, url_images FROM tbl_repository WHERE id= 1 AND active=1";
	$result_select_repo_details = $connection->query($query_select_repo_details);

	while($row1 = $result_select_repo_details->fetch_array())
	{			
		$repo_url_json=$row1[0];
		$repo_url_images=$row1[1];
	}

?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h1>
			<a href="#" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			My Installed Widgets
		</h1>
		
		<br><br>
		
		<table class="table">
			<thead>
				<tr>
					<th class="text-left">Action</th>
					<th class="text-left">Widget name</th>
					<th class="text-left">Description</th>
					<th class="text-left">Author</th>
					<th class="text-left">Repository</th>
				</tr>
			</thead>

			<tbody id="table1">
		
		
				</tbody>
            <tfoot></tfoot>
		</table>
	</div>
</div>

<script>
			
			$('#return_back').click(function(){
				parent.history.back();
				return false;
			});

			//var marketid= 'marketid=1';
				$.ajax({
					type: "POST",
					url: "functions/list_install_widget.php",
					data: 'userid=<?php echo $_SESSION["USERID"]; ?>',
					dataType: "json",
					success: function(msg){

						if(parseInt(msg.status)==1)
						{
							window.location=msg.txt;
						}
						else if(parseInt(msg.status)==0)
						{
							var i_row=0;
							var id_widget = new Array();
							var author_widget = new Array();
							var name_widget = new Array();
							var note_widget = new Array();
							var marketplace_id = new Array();
							var repository_name = new Array();
							
							mydata = JSON.parse(msg.txt, function (key, value){
								switch(key)
								{
									case "id":
										id_widget[i_row] = value;								
										break;
									case "author":
										author_widget[i_row] = value;
										break;
									case "name":
										name_widget[i_row] = value;
										break;
									case "marketplace_id":
										marketplace_id[i_row] = value;
										break;
									case "note":
										note_widget[i_row] = value;
										break;	
									case "repository_name":
										repository_name[i_row] = value;
										i_row++;
										break;	
									default:
										break;
								}
							
							});
							var tr_table='';
							for(var i=0;i<i_row;i++)
							{
								tr_table += "<tr>";
								<?php
								if(accessRole("DELETE_INSTALLED_WIDGET",$connection))
								{
								?>
								tr_table +="<td><a href=\"\" onclick=\"unistall_widget("+id_widget[i]+",<?php echo $_SESSION["USERID"]; ?>,"+marketplace_id[i]+"); return false; \"><i class=\"fa fa-times \"></i></a></td>";
								<?php
								}
								else
								{ ?>
								tr_table +="<td></td>";
								<?php
								}
								?>
								tr_table +="<td class=\"right\">"+name_widget[i]+"</td><td class=\"right\">"+note_widget[i]+"</td><td class=\"right\">"+author_widget[i]+"</td><td class=\"right\">"+repository_name[i]+"</td></tr>";
							}
							document.getElementById("table1").innerHTML=tr_table;
							
						}
					}
				});
				
			var widget_id=0,user_id=0,marketplace_id=0;
			
			function unistall_widget(widget_id,user_id,marketplace_id)
			{
				$.ajax({
					type: "POST",
					url: "functions/delete_widget_in_marketplace.php",
					data: 'userid='+user_id+'&widgetid='+widget_id+'&marketid='+marketplace_id,//userid+'&'+marketid,
					dataType: "json",
					success: function(msg){
						/*
						$.Notify({
										style: {background: 'red', color: 'white'},
										shadow: true,
										position: 'bottom-right',
										content: "Widget unistalled!"
									});
						*/
						
						$.ajax({
					type: "POST",
					url: "functions/list_install_widget.php",
					data: 'userid=<?php echo $_SESSION["USERID"]; ?>',
					dataType: "json",
					success: function(msg){

						if(parseInt(msg.status)==1)
						{
							window.location=msg.txt;
						}
						else if(parseInt(msg.status)==0)
						{
							var i_row=0;
							var id_widget = new Array();
							var author_widget = new Array();
							var name_widget = new Array();
							var note_widget = new Array();
							var marketplace_id = new Array();
							var repository_name = new Array();
							
							mydata = JSON.parse(msg.txt, function (key, value){
								switch(key)
								{
									case "id":
										id_widget[i_row] = value;								
										break;
									case "author":
										author_widget[i_row] = value;
										break;
									case "name":
										name_widget[i_row] = value;
										break;
									case "marketplace_id":
										marketplace_id[i_row] = value;
										break;
									case "note":
										note_widget[i_row] = value;
										break;	
									case "repository_name":
										repository_name[i_row] = value;
										i_row++;
										break;									
									default:
										break;
								}
							
							});
							var tr_table='';
							for(var i=0;i<i_row;i++)
							{
								tr_table += "<tr>";
								<?php
								if(accessRole("DELETE_INSTALLED_WIDGET",$connection))
								{
								?>
								tr_table +="<td><a href=\"\" onclick=\"unistall_widget("+id_widget[i]+",<?php echo $_SESSION["USERID"]; ?>,"+marketplace_id[i]+"); return false; \"><i class=\"fa fa-times \"></i></a></td>";
								<?php
								}
								else
								{ ?>
								tr_table +="<td></td>";
								<?php
								}
								?>
								tr_table +="<td class=\"right\">"+name_widget[i]+"</td><td class=\"right\">"+note_widget[i]+"</td><td class=\"right\">"+author_widget[i]+"</td><td class=\"right\">"+repository_name[i]+"</td></tr>";
							}
							document.getElementById("table1").innerHTML=tr_table;
							
						}
					}
				});
				
					}
				});
				
			}
				
		</script>
		
  
<?php include "footer.php"; ?>
