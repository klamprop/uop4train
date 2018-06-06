<?php 
	include "header.php"; 
	accessRole("VIEW_PRESENTATION",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	$lrs_object_name = "Course Presentation Part";
?>
 
<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-sm-12">	
	<h1>
		<a href="index.php" id="return_back"  style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		Manage Course Presentation Parts
	</h1>
	</div>
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
	if(accessRole("NEW_EDIT_DELETE_PRESENTATION_COURSE",$connection))
	{
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="tile_widget1" style="height: 200px;width: 180px;" >
			<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="window.location='courses.php?citem=2';">
				<div id="img_tile_widget1" style ="background: url('images/newPresentationCoursePart.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">
				New Course Presentation Part
				</div>
			
			
			</a>
			</div>
	</div>
	<?php
	}
	if(accessRole("VIEW_PRESENTATION",$connection))
	{
	?>	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="test-list">
			<div>    
				<div class="row">
					<div class="col-sm-4 "><input type="text" class="form-control search" id="inputEmail2" placeholder="Search by Title,Category" /></div>					
				</div>
			</div>
			<br />
			<?php
				$table_data = "<table width=\"100%\" style=\"border: 1px solid #efefef;\"><tr style=\"font-size:14px; background-color:#f5f5f5; height:30px;\"><td class=\"sort\" width=\"30%\" data-sort=\"name\">Title</td><td class=\"sort\" data-sort=\"category\">Category</td><td class=\"sort\">Action</td></tr><tbody class=\"list\">";
	
				$query_select_mycourse= "SELECT id, title, sdescription FROM tbl_courses WHERE create_uid=".$_SESSION['USERID']." AND course_item_id=2 GROUP BY title,id ";
 				$result_select_mycourse = $connection->query($query_select_mycourse);
	
				while($row = $result_select_mycourse->fetch_array()){
					$query_select_categories= "SELECT tbl_category_courses.name FROM tbl_category_courses INNER JOIN tbl_match_course_category ON tbl_category_courses.id = tbl_match_course_category.course_category_id WHERE tbl_match_course_category.course_id=".$row[0];
					
					$result_select_categories = $connection->query($query_select_categories);
					$course_categories='';
					while($row_cat = $result_select_categories->fetch_array()){			
						$course_categories .= $row_cat[0]."<br>";			
					}
		
					$table_data .="<tr style=\" height:30px;\"><td><a href=\"preview_course.php?course_id=".$row[0]."\" class=\"name\">".$row[1]."</a></td><td class=\"category\">".$course_categories."</td>";
			
					if(accessRole("NEW_EDIT_DELETE_PRESENTATION_COURSE",$connection))
					{
						$table_data .="<td class=\"right\"><a href=\"courses.php?id=".$row[0]."&citem=2\"><i class=\"glyphicon glyphicon-pencil\"></i></a>&nbsp;<a href=\"#\"><i class=\"glyphicon glyphicon-remove\"></i></a></td></tr>";
					}
		
				}
				$table_data .="</tbody></table>";
	
				echo $table_data;
			?>
			<ul class="pagination"></ul>
		</div>
	</div>
	<?php
	}
	?>
	<script>
		$('#return_back').click(function(){
			parent.history.back();
			return false;
		});
		
	var monkeyList = new List('test-list', {
		  valueNames: ['name','category'],
		  page: 10,
		  plugins: [ ListPagination({}) ] 
		});
	</script>

</div><!--  ------------------------  END CONTENT      ------------------------      -->
 <?php include "footer.php"; ?>
