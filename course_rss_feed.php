 <?php 
		include "functions/conf.php"; 

		$query_course = "SELECT tbl_courses.id, tbl_courses.title, tbl_courses.author, tbl_courses.create_date, tbl_courses.sdescription FROM tbl_courses WHERE tbl_courses.active=1 AND tbl_courses.course_item_id=1 ORDER BY tbl_courses.create_date DESC LIMIT 10";		
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
			$count_rec++;
		}
 ?>
	<?php header('Content-type: text/xml'); ?>
	
	<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo $plit_url[count($plit_url) - 2]; ?></title>
		<?php 
		for($i=0;$i<$count_rec;$i++)
		{
			$count_epub=0;
			$count_scorm=0;
			$query_course_epub = "SELECT has_epub, has_scorm FROM store_scorm_epub WHERE course_id=".$id[$i]." AND has_epub=1";		
			$result_course_epub= $connection->query($query_course_epub);
			while($row1 = $result_course_epub->fetch_row()) 
			{
				if($row1[0]==1)
				{
					$count_epub++;
				}
				if($row1[1]==1)
				{
					$count_scorm++;
				}
			}
			

			
		?>
		<item>
		<title><?php echo $title[$i]; ?></title> 	                        
		<author><?php echo $author[$i]; ?></author> 
		<create_date><?php echo $create_date[$i]; ?></create_date>
		<description><?php echo $sdescription[$i]; ?></description>
		<link><?php echo $url_host."preview_course.php?course_id=".$id[$i]; ?></link>
		<epub_link><?php if($count_epub>0){ echo $url_host."attachments/epub_files/".$id[$i]."/".$id[$i].".epub"; } else {echo "NA";}?></epub_link>
		<scorm_link><?php if($count_scorm>0){ echo $url_host."attachments/scorm_files/".$id[$i]."/".$id[$i].".zip"; } else {echo "NA";}?></scorm_link>
		</item>
		<?php
		}
		?>

</channel>
</rss>
