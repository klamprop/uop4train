 <?php 
		 include "header.php"; 

		$query_course = "SELECT tbl_courses.id, tbl_courses.title, tbl_courses.author, tbl_courses.create_date, tbl_courses.sdescription, tbl_courses.publisher FROM tbl_courses WHERE tbl_courses.active=1 AND tbl_courses.course_item_id=1 ORDER BY tbl_courses.create_date DESC LIMIT 10";		
		$result_course = $connection->query($query_course);
		
		$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
		$url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
  
		$plit_url = explode('/',$_SERVER["REQUEST_URI"]);
		$url_host = $url;
		for($i=0;$i<count($plit_url)-1;$i++)
		{
			$url_host .= $plit_url[$i]."/";
		}
		//echo $url_host;
		
		$count_rec = 0;
		
		while($row = $result_course->fetch_row()) 
		{
			$id[$count_rec]=$row[0];
			$title[$count_rec]=$row[1];
			$author[$count_rec]=$row[2];
			$create_date[$count_rec]=$row[3];
			$sdescription[$count_rec]=$row[4];
			$publisher[$count_rec]=$row[5];
			$count_rec++;
		}
 ?>
	
	<div class="container">
		<h1>All Forgebox Courses</h1>
		<a href="all_forge_courses_to_pdf.php" style="float:right;"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;&nbsp;Export to PDF</a>
			
			<?php 				
				for($i=0;$i<$count_rec;$i++) {
					
				?>
				<div class="row">					
					<div class="col-md-2">
						<img src="images/course_smallico.PNG" width="100" />
					</div>
					<div class="col-md-10">
						<div style="padding-left:0px;"><h3><a href="preview_course.php?course_id=<?php echo $id[$i]; ?>"><?php echo $title[$i]; ?></a></h3></div>
						<?php echo "<p>".$sdescription[$i]."</p>"; ?>	
						<?php echo "<div style=\"float:left; padding-right:10px; width:auto;\"><i class=\"fa fa-university \" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Publisher\"></i>&nbsp;&nbsp;".$publisher[$i]."</div>"; ?>
						<?php echo "<div style=\"float:left; padding-right:10px; width:auto;\"><i class=\"fa fa-user\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Author\"></i>&nbsp;&nbsp;".$author[$i]."</div>"; ?>
						<?php echo "<div style=\"float:left; padding-right:10px; width:auto;\"><i class=\"fa fa-calendar\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Created Date\"></i>&nbsp;&nbsp;".date('d-m-Y', strtotime($create_date[$i]))."</div>"; ?>
						<div style="float:right; padding-right:10px; width:auto;"><a class="btn btn-default" href="preview_course.php?course_id=<?php echo $id[$i]; ?>">See More</a></div>
					</div>
				</div>
				<hr />
				<?php
				}
			?>
		
	</div>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>

<?php include "footer.php"; ?>
