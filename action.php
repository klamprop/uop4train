<?php
include 'header.php'; 

	 accessRole("ACCESS_CONTROL",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	 $lrs_object_name = "Access Control";
?>
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-sm-12">		
		<h1>
			<a href="dashboard.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Access Control
		</h1>
		<table id="table1" class="hovered" width="100%">
			
			<?php
				
				$query_select_role_query = "SELECT id_role , name_role FROM tbl_role WHERE active_role =1";			
				$result_select_role = $connection->query($query_select_role_query);
					
				$i_select_role=0;
					
				while($row1 = $result_select_role->fetch_array()){
					$id_role[$i_select_role] = $row1[0];
					$name_role[$i_select_role] = $row1[1];				
						
					$i_select_role++;
				}
					
				$query_select_function = "SELECT key_name, display_name,category_id FROM actions ORDER BY category_id ASC";
				$result_select_function = $connection->query($query_select_function);
					
				$i_select_function=0;
				while($row2 = $result_select_function->fetch_row()){
					$id_function[$i_select_function] = $row2[0];
					$name_function[$i_select_function] = $row2[1];
					$category_id[$i_select_function] = $row2[2];
					$i_select_function++;
				}
				for ($i=0;$i<$i_select_function;$i++)
				{
					
					
					
				}
			?>	
		<?php 
				$table_header = "<tr><td><b>Action</b></td>";
				
				for($i=0;$i<$i_select_role;$i++)
				{
					$table_header .= "<td><b>".$name_role[$i]."</b></td>";					
				}

				$table_header .= "<tr>";
				$check_cat_id=0;
				for ($i=0;$i<$i_select_function;$i++)
				{

					if($category_id[$i]>$check_cat_id)
					{
						echo "<tr><td  colspan=\"".($i_select_role+1)."\"><hr /></td></tr>";
						$check_cat_id=$category_id[$i];
						switch($category_id[$i])
						{
							case 1:
								echo "<tr><td colspan=\"".($i_select_role+1)."\"><h3>Course</h3></td></tr><tr><td  colspan=\"".$i_select_role."\"><hr /></td></tr>";
								echo $table_header;
								break;
							case 2:
								echo "<tr><td colspan=\"".($i_select_role+1)."\"><h3>Widget</h3></td></tr><tr><td  colspan=\"".$i_select_role."\"><hr /></td></tr>";echo $table_header;
								break;
							case 3:
								echo "<tr><td colspan=\"".($i_select_role+1)."\"><h3>Services</h3></td></tr><tr><td  colspan=\"".$i_select_role."\"><hr /></td></tr>";echo $table_header;
								break;
							case 4:
								echo "<tr><td colspan=\"".($i_select_role+1)."\"><h3>System</h3></td></tr><tr><td  colspan=\"".$i_select_role."\"><hr /></td></tr>";echo $table_header;
								break;
							case 5:
								echo "<tr><td colspan=\"".($i_select_role+1)."\"><h3>User Menu</h3></td></tr><tr><td  colspan=\"".$i_select_role."\"><hr /></td></tr>";echo $table_header;
								break;
							default:
								break;
						}
					}
					
					echo "<tr><td>".$name_function[$i]."</td>";					
					
					for($k=0;$k<$i_select_role;$k++)
					{
						$query_role_function = "SELECT match_action_role.id_role, match_action_role.action FROM match_action_role WHERE  match_action_role.id_role = ".$id_role[$k]." AND match_action_role.action='".$id_function[$i]."'";
						$result_role_function = $connection->query($query_role_function);
						while($row5 = $result_select_function->fetch_row()){
							$id_role1 = $row5[0];
							$id_function1 = $row5[1];
						}
						$cnum_rows = $result_role_function->num_rows;

						if($cnum_rows>0)
						{
							echo "<td><center><a class=\"function_role\" href=\"#\" style=\"\" data-artid=\"".$id_role[$k]."\" data-artfunctionid=\"".$id_function[$i]."\"><i  id=\"function".$id_role[$k].$id_function[$i]."\" class=\"fa fa-check-square-o\"></i></a></center></td>";
						}
						else if ($cnum_rows==0)
						{
							echo "<td><center><a class=\"function_role\" href=\"#\" style=\"\" data-artid=\"".$id_role[$k]."\" data-artfunctionid=\"".$id_function[$i]."\"><i id=\"function".$id_role[$k].$id_function[$i]."\" class=\"fa fa-square-o\"></i></a></center></td>";
						}	
						
						
					}
					echo "</tr>";
					
				}
				
				
				?>
		</table>

		
	</div>
	<script>
	
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});

            $('.function_role').click(function(){
                var elem = $(this);		
				
                $.ajax({
                    type: "GET",
                    url: "functions/permission.php",
                    data: "roleid="+elem.attr('data-artid')+"&functionid="+elem.attr('data-artfunctionid'),
                    dataType:"json",  
                    success: function(data) {	
                        if(data.success){                              
								if(data.message=="Deleted from User Group")
								{
									/*$.Notify({
										style: {background: 'red', color: 'white'},
										shadow: true,
										position: 'bottom-right',
										content: "Deactivate user role"
									});
									*/
									$("#function"+elem.attr('data-artid')+elem.attr('data-artfunctionid')).removeClass("fa fa-check-square-o").addClass("fa fa-square-o");
								}
								else if(data.message=="Updated User Group")
								{
									/*$.Notify({
										style: {background: 'green', color: 'white'},
										shadow: true,
										position: 'bottom-right',
										content: "Activate user role"
									});
									*/
									$("#function"+elem.attr('data-artid')+elem.attr('data-artfunctionid')).removeClass("fa fa-square-o").addClass("fa fa-check-square-o");
								}
								
                        }
                    }
                });
                return false;
            });
			
	</script>
</div>

<?php			
include 'footer.php'; 
?>