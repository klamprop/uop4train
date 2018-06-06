
<!DOCTYPE html>
<?php

include "functions/conf.php";
include "functions/session.php";
include "functions/functions.php";


?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="product" content="FORGEBox">
    <meta name="description" content="FORGEBox">
    <meta name="author" content="NAM ECE UoP">
	<!-- fonts -->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>


	
</head>
<body>
	
	
   <div class="container" >  <!-- This div should close on footer.php -->   
	
	
	 <?php 

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
			<?php 				
				$my_folder=explode("/",$_SERVER[REQUEST_URI]);
				
				
				for($i=0;$i<$count_rec;$i++) {
					
				?>
				<table  width="500">
					<tr>
						<td width="150"><img src="images/course_smallico.PNG"/></td>
						<td width="550"><div><h3><a href="<?php echo "http://".$_SERVER[HTTP_HOST]."/".$my_folder[1]; ?>/preview_course.php?course_id=<?php echo $id[$i]; ?>"><?php echo $title[$i]; ?></a></h3></div>
						<?php echo $sdescription[$i]; ?>	<br /><br />
						<?php echo "<b>Publisher :</b> &nbsp;&nbsp;".$publisher[$i]."&nbsp;&nbsp;&nbsp;&nbsp;"; ?>
						<?php echo "<b>Author : </b>&nbsp;&nbsp;".$author[$i]."&nbsp;&nbsp;&nbsp;&nbsp;"; ?><br />
						<?php echo "<b>Created Date :</b> &nbsp;&nbsp;".date('d-m-Y', strtotime($create_date[$i]))."&nbsp;&nbsp;&nbsp;"; ?>
						<a class="btn btn-default" href="<?php echo "http://".$_SERVER[HTTP_HOST]."/".$my_folder[1]; ?>/preview_course.php?course_id=<?php echo $id[$i]; ?>">See More</a>
					</td>
					</tr>
				</table>					
				<hr />
				<?php
				}
			?>
		
	</div>
</div>

		
		
</body>
</html>
