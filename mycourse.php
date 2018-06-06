 <?php 
	include "header.php"; 
	
	accessRole("VIEW_MY_COURSES",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');
	$lrs_object_name = "My Course Module";
?>

<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h1>
		<a href="index.php" id="return_back" style="text-decoration:none;">
			<span class="fa fa-arrow-circle-o-left fa-lg black"></span>
		</a>
		My Course Modules
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
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php
			
			if(accessRole("NEW_EDIT_DELETE_COURSE",$connection))
			{
			?>
				<div id="tile_widget1" style="height: 200px;width: 180px;" class="col-sm-2">
					<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="window.location='courses.php?citem=1';">
						<div id="img_tile_widget1" style ="background: url('images/newCourseModule.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">

						New Course Module
						</div>
					
					
					</a>
				</div>
			<?php
			}
			
			if(accessRole("NEW_EDIT_DELETE_PRESENTATION_COURSE",$connection))
			{
		
			?>
				<div id="tile_widget1" style="height: 200px;width: 180px;" class="col-sm-2">
					<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="window.location='courses.php?citem=2';">
						<div id="img_tile_widget1" style ="background: url('images/newPresentationCoursePart.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">
						New Course Presentation Part
						</div>
					
					
					</a>
				</div>
				<?php
				}
				
				if(accessRole("NEW_EDIT_DELETE_INTERACTIVE_COURSE",$connection))
				{
			
				?>
					<div id="tile_widget1" style="height: 200px;width: 180px;" class="col-sm-2">
						<a id="link_widget1" href="#" class="widget widget_id_2" data-atr_id="2" data-atrarrposition="1" onclick="window.location='courses.php?citem=3';">
							<div id="img_tile_widget1" style ="background: url('images/newInteractiveCoursePart.PNG') no-repeat top center;width: inherit; height: 200px;text-align: center;padding-top: 155px;">
							New Course Interactive Part
							</div>
						</a>
					</div>
				<?php
				}
				?>
		</div>
	</div>
	
	<div class="col-sm-12">	
		<div class="grid fluid">
		<?php
			if(accessRole("VIEW_MY_COURSES",$connection))
			{
		?>				
				<div id="test-list">
					<div>    
						<div class="row">
							<div class="col-sm-4 "><input type="text" class="form-control search" placeholder="Search by Title,Category" /></div>					
						</div>
					</div>
					<br />
					<?php
						$table_data = "<table width=\"100%\" style=\"border: 1px solid #efefef;\"><tr style=\"font-size:16px; background-color:#f5f5f5; height:30px;\"><td class=\"sort\" width=\"30%\" data-sort=\"name\">Title</td><td class=\"sort\" data-sort=\"category\">Category</td><td class=\"sort\">Files</td><td class=\"sort\">Preview</td><td class=\"sort\">Parts</td><td class=\"sort\">Action</td></tr><tbody class=\"list\">";
						if(isset($_SESSION['UROLE_ID']))
						{
							if($_SESSION['UROLE_ID']==1)
							{
								$where_case ="";
							}
							else if($_SESSION['UROLE_ID']>1 && $_SESSION['UROLE_ID']<7)
							{
								$where_case = "create_uid=".$_SESSION['USERID']." AND";
							}
							
						}
						
						$query_select_mycourse= "SELECT id, title, sdescription FROM tbl_courses WHERE ".$where_case."  course_item_id=1 ORDER BY title";						
						$result_select_mycourse = $connection->query($query_select_mycourse);
		
						while($row = $result_select_mycourse->fetch_array()){
							$query_select_categories= "SELECT tbl_category_courses.name FROM tbl_category_courses INNER JOIN tbl_match_course_category ON tbl_category_courses.id = tbl_match_course_category.course_category_id WHERE tbl_match_course_category.course_id=".$row[0];
			
							$result_select_categories = $connection->query($query_select_categories);
							$course_categories='';
							while($row_cat = $result_select_categories->fetch_array()){
								$course_categories .= $row_cat[0]."<br>";
							}
							
							$table_data .="<tr style=\" height:30px;\"><td><a href=\"preview_course.php?course_id=".$row[0]."\" class=\"name\">".$row[1]."</a></td><td class=\"category\">".$course_categories."</td>";
							
							$query_select_files= "SELECT has_scorm, has_epub FROM store_scorm_epub WHERE course_id=".$row[0];
			
							$result_select_files = $connection->query($query_select_files);
							$course_files='NA / NA';
							while($row_file = $result_select_files->fetch_array()){
								if($row_file[0]>0 && $row_file[1]>0)
								{
									$course_files = "<a href=\"attachments/scorm_files/".$row[0]."/".$row[0].".zip \">scorm</a> / <a href=\"attachments/epub_files/".$row[0]."/".$row[0].".epub \">epub</a>";
								}
								else if($row_file[0]>0 && $row_file[1]==0)
								{
									$course_files = "<a href=\"attachments/scorm_files/".$row[0]."/".$row[0].".zip \">scorm</a>&nbsp;/&nbsp;NA";
								}
								else if($row_file[0]==0 && $row_file[1]>0)
								{
									$course_files = "NA &nbsp; / &nbsp;<a href=\"attachments/epub_files/".$row[0]."/".$row[0].".epub \">epub</a>";
								}
								else{
									$course_files='NA&nbsp;/&nbsp; NA';
								}
								//$course_files .= $row_file[0]."<br>";
							}
							
							if(accessRole("EPUB_EXPORT_COURSE",$connection))
							{
								$table_data .="<td>".$course_files."</td>";
							}
							else
							{
								$table_data .="<td></td>";
							}
							if(accessRole("PREVIEW_COURSE",$connection))
							{
								
								$table_data .="<td><a href=\"preview_course.php?course_id=".$row[0]."\"><i class=\"glyphicon glyphicon-eye-open\"></i></a></td>";
							}
							else
							{
								$table_data .="<td></td>";
							}
							if(accessRole("NEW_EDIT_DELETE_PRESENTATION_COURSE",$connection))
							{
								$table_data .="<td><a href=\"edit_course.php?id=".$row[0]."\"><i class=\"glyphicon glyphicon-th-list\"></i></a></td>";
								
								$table_data .="<td><a href=\"courses.php?id=".$row[0]."&citem=1\"><i class=\"glyphicon glyphicon-pencil\"></i></a>&nbsp;<a href=\"#\"><i class=\"glyphicon glyphicon-remove\"></i></a></td>";
							}
							else
							{
								$table_data .="<td></td>";
							}
							$table_data .="</tr>";
						}
						
						$table_data .="</tbody></table>";
		
						echo $table_data;
					?>

					<ul class="pagination"></ul>

				</div>
			<?php
			}
		?>
		</div>
	</div>

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
