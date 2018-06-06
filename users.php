<?php
include 'header.php'; 

accessRole("USER_MANAGEMENT",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
$lrs_object_name = "Users Management";
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>
		<a href="index.php" id="return_back"  style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Users Management
	</h1><br>
	<?php
	if(accessRole("USER_MANAGEMENT",$connection))
	{
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
	<?php 
	
			$query_select_role_query = "SELECT id_role , name_role FROM tbl_role WHERE active_role =1";			
			
			//$result_select_role = mysql_query($query_select_role) or die(mysql_error());
			
			
			$result_select_role = $connection->query($query_select_role_query);
			
			$i_select_role=0;
			
			//while($row = mysql_fetch_array($result_select_role)){
			while($row = $result_select_role->fetch_array()){
				$id_role[$i_select_role] = $row[0];
				$name_role[$i_select_role] = $row[1];				
				
				$i_select_role++;
			}
			
			$query_select_users_query = "SELECT DISTINCT tbl_users.id_user, tbl_users.email_user, tbl_users.active_user, tbl_users.surname_user, tbl_users.name_user, tbl_users.avatar_name,tbl_users.auth_type FROM tbl_user_role RIGHT JOIN tbl_users ON tbl_user_role.id_user = tbl_users.id_user WHERE tbl_users.active_user=1 ORDER BY tbl_users.name_user";
			
			//$result_select_users = mysql_query($query_select_users) or die(mysql_error());
			$result_select_users = $connection->query($query_select_users_query);
			
			$i_select_user=0;
			
			while($row = $result_select_users->fetch_row()){
				$id_user[$i_select_user] = $row[0];
				$email_user[$i_select_user] = $row[1];
				$active_user[$i_select_user] = $row[2];
				$surname_user[$i_select_user] = $row[3];
				$name_user[$i_select_user] = $row[4];
				$avatar_name[$i_select_user] = $row[5];
				$auth_type[$i_select_user] = $row[6];
				
				$i_select_user++;
			}
			
			$query_select_role_user_query = "SELECT tbl_user_role.id_user, tbl_user_role.id_role FROM tbl_user_role ORDER BY tbl_user_role.id_user";
			
			//$result_select_role_user = mysql_query($query_select_role_user) or die(mysql_error());
			$query_select_role_user = $connection->query($query_select_role_user_query);
			
			$i_select_user_role=0;
			
			while($row = $query_select_role_user->fetch_row()){
				$id_user_[$i_select_user_role] = $row[0];
				$id_role_[$i_select_user_role] = $row[1];
				
				$i_select_user_role++;
			}
			
		?>
	
	<div id="test-list">
				<div class="row">    
					<div class="input-control text col-md-4">
						<input type="text" class="search form-control" placeholder="Search user by email" />
					</div>
				</div>
				<br />
				<table width="100%" class="table table-hover" style="border: 1px solid #efefef;">
					<tr style="font-size:14px; background-color:#f5f5f5;">
						<td class="sort">&nbsp;</td>
						<td class="sort" data-sort="name"><center>User</center></td>
						<?php
							for ($i=0;$i<$i_select_role;$i++)
							{
								echo "<td class=\"sort\" style=\"word-wrap: break-word;border: 1px solid #FFFFFF;\"><center>".$name_role[$i]."</center></td>";
							}
						?>
						<td class="sort" style="border: 1px solid #FFFFFF;"><center>Active</center></td>
					</tr>			
				<?php
					echo "<tbody class=\"list\">";
					for ($i=0;$i<$i_select_user;$i++)
					{	 
						if(!empty($avatar_name[$i])){ 
									
									if (  strpos($avatar_name[$i], 'http') === 0  ){
							$image_url=$avatar_name[$i];
						}
						else
						{
								$image_url="images/avatars/".$id_user[$i]."/thubs/".$avatar_name[$i];
							}
							}
							else
							{
								$image_url="images/defavatar.png";
							}
						
						
						echo "<tr><td><img src=\"".$image_url."\" style=\"height:50px; \" /></td><td class=\"name\"  width=\"35%\">".$name_user[$i]." ".$surname_user[$i]."<br /><a href=\"#\">(".$email_user[$i].")</a></td>";
						for($k=0;$k<$i_select_role;$k++)
						{	
							$user_have_not_role=0;
							$query_select_role_user_query = "SELECT tbl_user_role.id_user, tbl_user_role.id_role FROM tbl_user_role WHERE  tbl_user_role.id_user = ".$id_user[$i]." AND tbl_user_role.id_role = ".$id_role[$k];
			
							$result_select_role_user = $connection->query($query_select_role_user_query);
			
							$cnum_rows = $result_select_role_user->num_rows;
						
							if($cnum_rows==0)
							{
								echo "<td width=\"8%\" ><a class=\"role\" href=\"#\" style=\"\" data-artid=\"".$id_role[$k]."\" data-artuserid=\"".$id_user[$i]."\"><center><i id=\"role".$id_role[$k].$id_user[$i]."\" class=\"fa fa-square-o\"></i></center></a></td>";
							}
							else if($cnum_rows>0)
							{
								echo "<td width=\"8%\"><a class=\"role\" href=\"#\" style=\"\" data-artid=\"".$id_role[$k]."\" data-artuserid=\"".$id_user[$i]."\"><center><i  id=\"role".$id_role[$k].$id_user[$i]."\" class=\"fa fa-check-square-o\"></i></center></a></td>";
							}	
						}
						if($i<$i_select_user-1)
						{
							if($active_user[$i]==1)
							{
								echo "<td width=\"5%\"><a class=\"activate\" style=\"\" href=\"#\" onclick=\"return false;\" data-artid=\"".$id_user[$i]."\"><center><i id=\"active".$id_user[$i]."\" class=\"fa fa-check-square-o\"></i></center></a></td></tr>";							
							}
							else
							{
								echo "<td width=\"5%\"><a class=\"activate\" style=\"\" href=\"#\" onclick=\"return false;\" data-artid=\"".$id_user[$i]."\"><center><i id=\"active".$id_user[$i]."\" class=\"fa fa-square-o\"></i></center></a></td></tr>";
							}
						}
						else
						{
							if($active_user[$i]==1)
							{
								echo "<td width=\"5%\"><a class=\"activate\" style=\"\" href=\"#\" onclick=\"return false;\" data-artid=\"".$id_user[$i]."\"><center><i id=\"active".$id_user[$i]."\" class=\"fa fa-check-square-o\"></i></center></a></td></tr>";
							
							}
							else
							{
								echo "<td width=\"5%\"><a class=\"activate\" style=\"\" href=\"#\" onclick=\"return false;\" data-artid=\"".$id_user[$i]."\"><center><i id=\"active".$id_user[$i]."\" class=\"fa fa-square-o\"></i></center></a></td></tr>";
							}
						}
					}
									
					?>
					</tbody></table>
				<ul class="pagination"></ul>
			</div>
	
	
	
	<br><hr><br>
	<table id="table_unregister" class="striped"></table>
	
	</div>

	<script>
		
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
		var monkeyList = new List('test-list', {
		  valueNames: ['name'],
		  page: 30,
		  plugins: [ ListPagination({}) ] 
		});
		
		var table1,table_data_unregister;			
		
		table_data_unregister = [		
			<?php
				$print_table_unregister = '';
			
				$query_select_unregister_user = "SELECT email_user,id_user FROM tbl_users WHERE active_user >1";
				$result_select_unregister_user = $connection->query($query_select_unregister_user);
				$num_rows_unregister = $result_select_unregister_user->num_rows;
				$count_user =0;
				while($row = $result_select_unregister_user->fetch_row())
				{
					$print_table_unregister .= '{user:"'.$row[0].'",Activate:"<a class=\"active_unregister\" style=\"font-size:22px;\" href=\"#\" data-art_id=\"'.$row[1].'\" ><i class=\"fa fa-check-square-o \" ></i></a>", Delete:"<a class=\"delete_unregister\" href=\"#\" data-artid=\"'.$row[1].'\" ><i class=\" icon-cancel fg-red\" ></i></a>"}';
					$count_user++;
					if($num_rows_unregister > $count_user)
					{
						$print_table_unregister .= ',';
					}
				}
				
				echo $print_table_unregister;
			?>			
		];	
		
		$(function(){
			table1 = $("#table_unregister").tablecontrol({				
				cls: 'table hovered border myClass',
				colModel: [
					{field: 'user', caption: 'Unregister User', width: '', sortable: false, cls: 'text-left', hcls: "text-left"},
					{field: 'Activate', caption: 'Activate', width: 50, sortable: false, cls: 'text-center', hcls: ""},
					{field: 'Delete', caption: 'Delete', width: 50, sortable: false, cls: 'text-center', hcls: ""}				
				],
				 
				data: table_data_unregister
			});
		});
		
	
		$("table").delegate('.role', 'click', function() {
			var elem = $(this);
			 $.ajax({
                    type: "GET",
                    url: "functions.php",
                    data: "id="+elem.attr('data-artid')+"&userid="+elem.attr('data-artuserid'),
                    dataType:"json",  
                    success: function(data) {						
                        if(data.success){                              
							if(data.message=="Deleted from User Group")
							{
								$("#role"+elem.attr('data-artid')+elem.attr('data-artuserid')).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
							}
							else if(data.message=="Updated User Group")
							{
								$("#role"+elem.attr('data-artid')+elem.attr('data-artuserid')).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
							}	
                        }
                    }
                });	
			return false;			
		});
		
		/*$( ".role" ).click(function() {			
			var elem = $(this);
			 $.ajax({
                    type: "GET",
                    url: "functions.php",
                    data: "id="+elem.attr('data-artid')+"&userid="+elem.attr('data-artuserid'),
                    dataType:"json",  
                    success: function(data) {						
                        if(data.success){                              
							if(data.message=="Deleted from User Group")
							{
								$("#role"+elem.attr('data-artid')+elem.attr('data-artuserid')).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
							}
							else if(data.message=="Updated User Group")
							{
								$("#role"+elem.attr('data-artid')+elem.attr('data-artuserid')).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
							}	
                        }
                    }
                });
                return false;
		});*/

		$("table").delegate('.activate', 'click', function() {
			var elem = $(this);	
                $.ajax({
                    type: "GET",
                    url: "active.php",
                    data: "id="+elem.attr('data-artid'),
                    dataType:"json",  
                    success: function(data) {
                        if(data.success){
							if(data.message=="Activate")
							{
                                /*$.Notify({
									style: {background: 'green', color: 'white'},
									shadow: true,
                                    position: 'bottom-right',
                                    content: data.message
                                });*/
								$("#active"+elem.attr('data-artid')).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
							}
							else if(data.message=="Deactivate")
							{
								/*$.Notify({
									style: {background: 'red', color: 'white'},
									shadow: true,
                                    position: 'bottom-right',
                                    content: data.message
                                });*/
								$("#active"+elem.attr('data-artid')).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
							}
                        }
                    }
                });
                return false;
		});
	
		/*$('.activate').click(function(){
                var elem = $(this);	
                $.ajax({
                    type: "GET",
                    url: "active.php",
                    data: "id="+elem.attr('data-artid'),
                    dataType:"json",  
                    success: function(data) {
                        if(data.success){
							if(data.message=="Activate")
							{*/
                                /*$.Notify({
									style: {background: 'green', color: 'white'},
									shadow: true,
                                    position: 'bottom-right',
                                    content: data.message
                                });*/
								/*$("#active"+elem.attr('data-artid')).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
							}
							else if(data.message=="Deactivate")
							{
								/*$.Notify({
									style: {background: 'red', color: 'white'},
									shadow: true,
                                    position: 'bottom-right',
                                    content: data.message
                                });*/
								/*$("#active"+elem.attr('data-artid')).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
							}
                        }
                    }
                });
                return false;
            });
			*/
			
			$("table").delegate('.delete_unregister', 'click', function() {
				var elem = $(this);		
				
                $.ajax({
                    type: "GET",
                    url: "functions.php",
                    data: "unregister="+elem.attr('data-artid'),
                    dataType:"json",  
                    success: function(data) {						
                        if(data.success){                              
							if(data.message=="Unregister user Deleted!")
							{								
								/*$.Notify({
									style: {background: 'red', color: 'white'},
									shadow: true,
									position: 'bottom-right',
									content: "Unregister user Deleted!"
								});*/
								window.location = "users.php";
								
							}
                        }
                    }
                });
                return false;
			});
			/*
			$('.delete_unregister').click(function(){
				var elem = $(this);		
				
                $.ajax({
                    type: "GET",
                    url: "functions.php",
                    data: "unregister="+elem.attr('data-artid'),
                    dataType:"json",  
                    success: function(data) {						
                        if(data.success){                              
							if(data.message=="Unregister user Deleted!")
							{								
								/*$.Notify({
									style: {background: 'red', color: 'white'},
									shadow: true,
									position: 'bottom-right',
									content: "Unregister user Deleted!"
								});*/
								/*window.location = "users.php";
								
							}
                        }
                    }
                });
                return false;
			
			});
			*/
			
			$("table").delegate('.active_unregister', 'click', function() {
				var elem = $(this);		
				
                $.ajax({
                    type: "GET",
                    url: "functions.php",
                    data: "activation="+elem.attr('data-art_id'),
                    dataType:"json",  
                    success: function(data) {						
                        if(data.success){                              
							if(data.message=="User activated!")
							{
								window.location = "users.php";
							}
                        }
                    }
                });
                return false;
			});
			
			/*$('.active_unregister').click(function(){
				var elem = $(this);		
				
                $.ajax({
                    type: "GET",
                    url: "functions.php",
                    data: "activation="+elem.attr('data-art_id'),
                    dataType:"json",  
                    success: function(data) {						
                        if(data.success){                              
							if(data.message=="User activated!")
							{*/
								/*$.Notify({
									style: {background: 'green', color: 'white'},
									shadow: true,
									position: 'bottom-right',
									content: "User activated!"
								});*/
						/*		window.location = "users.php";
								
							}
                        }
                    }
                });
                return false;
			
			});*/
		<?php
		}
		?>
        </script>
</div>
<?php			
include 'footer.php'; 
?>