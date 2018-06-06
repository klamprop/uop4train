<?php include "header.php"; 

	accessRole("ADD_DELETE_ORDER_COURSE_PART",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	
	if(isset($_GET['id']))
	{
		
		//$query_select= "SELECT tbl_match_present_interact_course.id,tbl_presentation.title,tbl_presentation.id FROM tbl_match_present_interact_course INNER JOIN tbl_presentation ON tbl_presentation.id = tbl_match_present_interact_course.presentation_id  WHERE tbl_match_present_interact_course.course_id=".$_GET['course_id']." ORDER BY tbl_match_present_interact_course.order_list ASC,tbl_presentation.title ASC";
		
		$query_select= "SELECT id, presentation_id, interactive_id FROM tbl_match_present_interact_course WHERE course_id=".$_GET['id']." ORDER BY order_list ASC" or die("Error in query.." . mysqli_error($connection));
		$result_select = $connection->query($query_select);
		$count_parts =0;
		while($row = $result_select->fetch_array()){
			$partid[$count_parts] = $row[0];
			$presentation_id[$count_parts] = $row[1];	
			$interactive_id[$count_parts] = $row[2];
			
			$count_parts++;
		}
		
		$query_select= "SELECT title FROM tbl_courses WHERE id=".$_GET['id'] ;	
		$result_select = $connection->query($query_select)or die("Error in query.." . mysqli_error($connection));
		$row = $result_select->fetch_array();
		$courseTitle = $row['title'];
	}
	else
	{
		//redirection
	}

?>
 
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-sm-12">	
		<h1>
			<a href="index.php" id="return_back" style="text-decoration:none;">
				<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
			</a>
			Edit Course Module Parts
		</h1>
	</div>
	
	<div class="col-sm-12">	
		<h2>Course Module:<?php echo $courseTitle; ?></h2>
	</div>
	
	<style>
		.button-dropdown .dropdown-toggle:after{
			margin-left: 0.50em;
			bottom: 3px;
			content: '\203A';
		}
	</style>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="tile_widget1" style="height: 200px;width: 180px;" class="col-sm-2">
			<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="location.href='add_course_part.php?course_id=<?php echo $_GET['id']; ?>&action=addpresentation'">
				<div id="img_tile_widget1" style ="background: url('images/coursecategoryico.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">

				Add Course Presentation Part
				</div>
			</a>
			</div>
			<div id="tile_widget1" style="height: 200px;width: 180px;" class="col-sm-2">
			<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="location.href='add_course_part.php?course_id=<?php echo $_GET['id']; ?>&action=addinteractive'">
				<div id="img_tile_widget1" style ="background: url('images/coursecategoryico.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">

				Add Course Interactive Part
				</div>
			</a>
			</div>
		</div>
	</div>
	
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<style>
		#sortable1 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; width:100% }
		#sortable1 li {padding-bottom:15px; font-size: 1.2em; height:40px; }
		.connectedSortable li:nth-child(odd) { border: 0px solid #EEEEEE;}
		.connectedSortable li:nth-child(even) { border: 0px solid #B0E0E6;}
	</style>
	<script>
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
		var course_sort ='';
		
		$(function() {
			$( "#sortable1" ).sortable({
				connectWith: ".connectedSortable",
				stop: function( event, ui ) {
					course_sort ='';
					$('#sortable1 li').each( function(e) {
						course_sort +=$(this).attr('id')+'|';
					});
				}
			}).disableSelection();
		});	
	</script>
	
	
	<div class="col-sm-12">
		<h3>Drag and Drop to reorder parts of course module</h3>
		<table class="table">
			<thead>
				<tr>
					<th class="text-left" width="80%">Name (Course Part Title)</th>
					<th class="text-left" width="20%">Action</th>				
				</tr>
			</thead>
		</table>
	
	<ul id="sortable1" class="connectedSortable">
	<?php
		for($i=0;$i<$count_parts;$i++)
		{
			echo "<li id=\"".$partid[$i]."\" class=\"ui-state-default\">";
			echo "<table class=\"table\">";		
			echo "<tbody>";
			echo "<tr>";
			if($presentation_id[$i]>0 && $interactive_id[$i]==0)
			{
				$query_select_presentation= "SELECT title FROM tbl_courses WHERE id=".$presentation_id[$i];
				$result_select_presentation = $connection->query($query_select_presentation);
				
				while($row1 = $result_select_presentation->fetch_array()){										
					echo "<td class=\"text-left\" width=\"80%\"><a href=\"courses.php?id=".$presentation_id[$i]."&citem=2\">".$row1[0]."</a></td>";
					echo "<td class=\"text-left\" width=\"20%\"><a href=\"#\" onclick=\"delete_course(".$partid[$i]."); return false;\"><i class=\"fa fa-times\"></i></a></td>";
					
				}
			}
			else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
			{
				$query_select_interactive= "SELECT title FROM tbl_courses WHERE id=".$interactive_id[$i];
				$result_select_interactive = $connection->query($query_select_interactive);
				while($row2 = $result_select_interactive->fetch_array()){
					
					echo "<td class=\"text-left\" width=\"80%\"><a href=\"courses.php?id=".$interactive_id[$i]."&citem=3\">".$row2[0]."</a></td>";
					echo "<td class=\"text-left\" width=\"20%\"><a href=\"#\" onclick=\"delete_course(".$partid[$i]."); return false;\"><i class=\"fa fa-times\"></i></a></td>";
				}
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo "</li>";
		}
	?>
	</ul>
	 <button onclick="save_course();">Save</button> 
	
	</div>	
	 
	<script>
		
		var data_post="";
		
		function save_course()
		{
			
			if(course_sort!='')
			{
			data_post = 'sort_list='+course_sort;
			data_post += '&action=upd&course_id=<?php echo $_GET['id']; ?>';
			$.ajax({
				type: "POST",
				url: "functions/edit_course_part.php",
				data: data_post,
				dataType: "json",
				success: function(msg){
					window.location.reload();		
				}							
			});
			}
			
		}
		var part_id=0;
		function delete_course(part_id)
		{
			data_post = 'action=del&part_id='+part_id;
				
			$.ajax({
				type: "POST",
				url: "functions/edit_course_part.php",
				data: data_post,
				dataType: "json",
				success: function(msg){
					window.location.reload();					
				}							
			});
			
		}
		
	</script>
</div><!--  ------------------------  END CONTENT      ------------------------      -->


<?php include "footer.php"; ?>
