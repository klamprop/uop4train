<?php
	if(count($_GET)<1 || count($_GET)>2){
		http_response_code(404);
		include('404.html'); // provide your own HTML for the error page
		die();
	}else if(count($_GET)==1){
		
		if(!isset($_GET["course_id"])){
			http_response_code(404);
			include('404.html'); // provide your own HTML for the error page
			die();
		}
	}else if(count($_GET)==2){
		if(!isset($_GET["course_id"]) && !isset($_GET["preview"])){
			http_response_code(404);
			include('404.html'); // provide your own HTML for the error page
			die();
		}else if ($_GET["preview"]!="full" && $_GET["preview"]!="section"){
			http_response_code(404);
			include('404.html'); // provide your own HTML for the error page
			die();
		}
	}
	if(!is_numeric($_GET["course_id"])){
		http_response_code(404);
			include('404.html'); // provide your own HTML for the error page
			die();
	}
	include "header.php";
	require_once 'functions/lti/blti.php';


	if(isset($_GET['course_id']))
	{

		$query_select= "SELECT title, author, create_date, publisher, language, about, alignmentType, educationalFramework, targetName, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, learningResourseType, licence, isBasedOnURL, educationalRole, audienceType, content, interactive_url, publish_to_anonymous, iframe_height FROM tbl_courses WHERE tbl_courses.id = ".$_GET['course_id'];//." AND course_item_id=1";

		$result_select = $connection->query($query_select);

		while($row1 = $result_select->fetch_array()){
			$title_course=$row1[0];
			$author=$row1[1];
			$create_date=$row1[2];
			$publisher=$row1[3];
			$language=$row1[4];
			$about=$row1[5];
			$alignmentType=$row1[6];
			$educationalFramework=$row1[7];
			$targetName=$row1[8];
			$targetDescription=$row1[9];
			$targetURL=$row1[10];
			$educationalUse=$row1[11];
			$$duration=$row1[12];
			$typicalAgeRange=$row1[13];
			$interactivityType=$row1[14];
			$learningResourseType=$row1[15];
			$licence=$row1[16];
			$isBasedOnURL=$row1[17];
			$educationalRole=$row1[18];
			$audienceType=$row1[19];
			$content=$row1[20];
			$interactive_url=$row1[21];
			$publish_to_anonymous = $row1[22];
			$iframe_height = $row1[23];
		}
		$lrs_object_name = $title_course;
		if($publish_to_anonymous == 0 && $urole_id==7 )
		{
			?>
			<script>
				window.location.href = "index.php";
			</script>
			<?php
		}
		$query_select_list = "SELECT id, presentation_id, interactive_id FROM tbl_match_present_interact_course WHERE course_id=".$_GET['course_id']." ORDER BY order_list ASC";
		$result_select_list = $connection->query($query_select_list);
		$count_list=0;
		while($row1 = $result_select_list->fetch_array()){
			$id[$count_list]=$row1[0];
			$presentation_id[$count_list]= $row1[1];
			$interactive_id[$count_list]= $row1[2];

			$count_list++;
			
		}

		////Additions for matching course and user. Query that asks with having course id and user id . With an if we have a user
		if ($_SESSION['USERID'] != null){
			$query_match_course_user ="SELECT user_id, course_id, last_visited, total, courses_completed FROM tbl_match_course_user WHERE course_id=".$_GET['course_id']." AND user_id=".$_SESSION['USERID']."";
			$result_match_course_user = $connection->query($query_match_course_user);
			
			

			while($row3 = $result_match_course_user->fetch_array()){
				$user_id_match=$row3[0];
				$course_id_match=$row3[1];
				$last_visited_match=$row3[2];
				$total_match=$row3[3];
				$courses_completed_match=$row3[4];
				
			}//We test if the user has ever signed in this course
			
			if($user_id_match == null){
				
				//If we had never signed in we have to add user,course,total_parts and last_visited =1 so we can create his record
				$percentage = (1/$count_list)*100;
				$query_insert_course_user_connection = "INSERT INTO tbl_match_course_user(user_id, course_id, last_visited, total, courses_completed, percentage ) VALUES (".$_SESSION['USERID'].",".$_GET['course_id'].",1,".$count_list.",'1',".$percentage.")";
				$result_insert_course_user_connection = $connection->query($query_insert_course_user_connection);
				
			} 
			
			
		}
	}

	?>


	



<div id="CourseContentRow" class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
	<div itemscope="" itemtype="http://schema.org/CreativeWork" >


		<?php
		echo "<div style=\"text-align:center; border-bottom:3px solid #ff4400; font-size:50px; font-weight:bold; color:#000000; margin-top:20px;\">";
		echo 	"<div style=\"max-width:100%;\">".$title_course."</div>";
		echo "</div>";

		 ?>

		<!-- ***** Start Rating ***** -->
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right" style="margin-top:5px;">
		<?php

			$avg_rate=0;
			$query_select_courses_rate= "SELECT COUNT(id) , SUM(score_val) FROM course_rating WHERE course_id=".$_GET['course_id'];
			$result_select_course_rate = $connection->query($query_select_courses_rate)  or die("Error in query.." . mysqli_error($connection));

			while($row_score = $result_select_course_rate->fetch_array()){
				if($row_score[0]>0){
					$avg_rate = $row_score[1]/$row_score[0];
				}
				else{
					$avg_rate='N/A';
				}
			}

			/* **** Start Rating *** */
			if($avg_rate!='N/A'){
			  if($avg_rate>0 && $avg_rate<1){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate===1){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate>1 && $avg_rate <2 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate===2 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate>2 && $avg_rate <3 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate===3 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate>3 && $avg_rate <4 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate===4 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate>4 && $avg_rate <5 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
			  else if($avg_rate===5 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$_GET['course_id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}

			}else{
				echo '<tr><td colspan="2"><p style="text-align:right;"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></p></td></tr></table>';
			}
			/* **** End Rating *** */


			if($avg_rate!='N/A'){
				$score1=0;
				$score2=0;
				$score3=0;
				$score4=0;
				$score5=0;


				$query_select_courses_rate5= "SELECT COUNT( id )FROM course_rating WHERE score_val=5 && course_id=".$_GET['course_id'];
				$result_select_course_rate5 = $connection->query($query_select_courses_rate5)  or die("Error in query.." . mysqli_error($connection));

				while($row_score5 = $result_select_course_rate5->fetch_array()){
					$score5=$row_score5[0];
				}

				$query_select_courses_rate4= "SELECT COUNT( id )FROM course_rating WHERE score_val=4 && course_id=".$_GET['course_id'];
				$result_select_course_rate4 = $connection->query($query_select_courses_rate4)  or die("Error in query.." . mysqli_error($connection));

				while($row_score4 = $result_select_course_rate4->fetch_array()){
					$score4=$row_score4[0];
				}

				$query_select_courses_rate3= "SELECT COUNT( id )FROM course_rating WHERE score_val=3 && course_id=".$_GET['course_id'];
				$result_select_course_rate3 = $connection->query($query_select_courses_rate3)  or die("Error in query.." . mysqli_error($connection));

				while($row_score3 = $result_select_course_rate3->fetch_array()){
					$score3=$row_score3[0];
				}

				$query_select_courses_rate2= "SELECT COUNT( id )FROM course_rating WHERE score_val=2 && course_id=".$_GET['course_id'];
				$result_select_course_rate2 = $connection->query($query_select_courses_rate2)  or die("Error in query.." . mysqli_error($connection));

				while($row_score2 = $result_select_course_rate2->fetch_array()){
					$score2=$row_score2[0];
				}

				$query_select_courses_rate1= "SELECT COUNT( id )FROM course_rating WHERE score_val=1 && course_id=".$_GET['course_id'];
				$result_select_course_rate1 = $connection->query($query_select_courses_rate1)  or die("Error in query.." . mysqli_error($connection));

				while($row_score1 = $result_select_course_rate1->fetch_array()){
					$score1=$row_score1[0];
				}

				echo '
					<div class="modal fade" id="myModal_'.$_GET['course_id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Rate for course : '.$row['title'].'</h4>
						  </div>
						  <div class="modal-body">
							<table>
							  <tr>
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score1.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
								<td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></td>
							  </tr>
							  <tr>
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score2.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
								<td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></td>
							  </tr>
							  <tr>
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score3.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
								<td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></td>
							  </tr>
							  <tr>
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score4.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
								<td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true">&nbsp;&nbsp;<i class="fa fa-star-o" aria-hidden="true"></i></i></td>
							  </tr>
							  <tr>
								<td>&nbsp;&nbsp;-&nbsp;&nbsp;'.$score5.'&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
								<td style="color:#B5B526;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-star" aria-hidden="true"></i></td>
							  </tr>
							</table>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>
					  </div>
					</div>';

			}


		?>


	<!-- ***** End Rating ***** -->


		</div>

		<?php
		if($count_list>0)
		{
		?>
		<div class=container style="margin:5px 0px 30px 0px;">
			<div id="CourseViewMenu"  class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

						<a class="btn btn-default btn-sm" href="preview_course.php?course_id=<?php echo $_GET['course_id']; ?>&preview=full">Full Height</a>&nbsp;|&nbsp;
						<a class="btn btn-default btn-sm" href="preview_course.php?course_id=<?php echo $_GET['course_id']; ?>&preview=section">Parts</a>&nbsp;

			</div>
		</div>
		<?php
		}
		?>

		<?php

		if(isset($_GET['preview']) )

		{

 			if(($_GET['preview']=="section") || ($_GET['preview']=="full"))
			{

 			if(($_GET['preview']=="section")) // worst code ever written!!!
			{

				if(isset($_GET["noheaders"]) && $_GET["noheaders"]==1)
				{
					?>
					<div class="row" style="font-size:20px; padding-right:15px;"><a href="preview_course.php?course_id=<?php echo $_GET['course_id']; if(isset($_GET['preview'])){ if($_GET['preview']=="twocol"){echo "&preview=twocol";}if($_GET['preview']=="section"){echo "&preview=section";}} ?>" onclick=""><i class="glyphicon glyphicon-resize-small"></i></a></div>
					<?php
				}
				echo '<div class="row">';



				echo '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="padding-left:5px; padding-right:10px;">';
				echo "<div class=\"tab-control\" data-role=\"tab-control\">";
				echo "<ul id=\"myTab\" class=\"nav coursesections flex nav-pills nav-stacked\" >";
				//$count_pres=0;
				//echo "<li class=\"active\"><a href=\"#_page_".$count_pres."\">Part - ".$count_pres."</a></li>";
				$count_pres=1;
				for($i=0; $i<$count_list;$i++)
				{
					if($presentation_id[$i]>0 && $interactive_id[$i]==0)
					{
						//presentation
						$query_select_present= "SELECT title FROM tbl_courses WHERE id=".$presentation_id[$i];
						$result_select_present = $connection->query($query_select_present);

						while($row = $result_select_present->fetch_array()){
							if($count_pres==1)
							{
								echo '<li class="active"><a href="#_page_'.$count_pres.'" data-sectionid="'.$count_pres.'" data-user_id="'.$_SESSION["USERID"].'" data-course_id="'.$_GET['course_id'].'" class="update_course_status" data-toggle="tab" >'.$row[title].'</a></li>';
							

							}
							else
							{
								echo '<div style ="position:absolute; margin-left:45%; background-color:black; margin-top:-20px; height:40px;"> a </div>';
								echo '<li><a href="#_page_'.$count_pres.'" data-sectionid="'.$count_pres.'"  data-user_id="'.$_SESSION["USERID"].'" data-course_id="'.$_GET['course_id'].'" class="update_course_status" data-toggle="tab">'.$row[title].'</a></li>';
							}

						}

					}
					else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
					{
						//interactive
						$query_select_present= "SELECT title FROM tbl_courses WHERE id=".$interactive_id[$i];
						$result_select_present = $connection->query($query_select_present);

						while($row2 = $result_select_present->fetch_array()){

							if($count_pres==1)
							{
								echo "<li class=\"active\"><a href=\"#_page_".$count_pres."\" data-toggle=\"tab\" >Part - ".$count_pres."9999</a></li>";
							}
							else
							{
								echo "<li><a href=\"#_page_".$count_pres."\" data-toggle=\"tab\">Part - ".$count_pres."</a></li>";
							}

						}
					}

					$count_pres++;
				}
				echo "</ul>";
				echo "</div>";
				echo "</div>";

				echo '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 coursecontent" >';
				echo "<div id=\"myTabContent\" class=\"tab-content\" style=\"margin-left:20px;\">";

				//$count_pres=0;
				//printCoursePart($connection, $_GET['course_id'] , "section", $count_pres);  //printModule Content in first tab
				$count_pres=1;

				for($i=0; $i<$count_list;$i++)
				{
					if($presentation_id[$i]>0 && $interactive_id[$i]==0)
					{
						
						printCoursePart($connection, $presentation_id[$i], "section", $count_pres,$url_iframe);
						

					}
					else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
					{
						
						printCoursePart($connection, $interactive_id[$i], "section", $count_pres,$url_iframe);
					}

					$count_pres++;
				}

				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}

 			else if(($_GET['preview']=="full")) // worst code ever written!!!
			 {
				if(isset($_GET["noheaders"]) && $_GET["noheaders"]==1)
					{
						?>
						<div class="row" style="float:right; font-size:20px; padding-right:35px;"><a href="preview_course.php?course_id=<?php echo $_GET['course_id']; if(isset($_GET['preview'])){ if($_GET['preview']=="twocol"){echo "&preview=twocol";}if($_GET['preview']=="section"){echo "&preview=section";}} ?>" onclick=""><i class="glyphicon glyphicon-resize-small"></i></a></div>
						<?php
					}
			//	printCoursePart($connection, $_GET['course_id'],"","",$url_iframe);
			echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 coursecontent\">";
				for($i=0; $i<$count_list;$i++)
				{
					echo "<span itemprop=\"citation\">";
					if($presentation_id[$i]>0 && $interactive_id[$i]==0)
					{
						printCoursePart($connection, $presentation_id[$i],"","",$url_iframe);
					}
					else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
					{
						printCoursePart($connection, $interactive_id[$i],"","",$url_iframe);
					}
					echo "</span>";

				}
			echo "</div>";
			}

		}
	}
		else
		{
			if ($count_list>0) // the stupidity of my code is unprecedented
			{
								if(isset($_GET["noheaders"]) && $_GET["noheaders"]==1)
								{
									?>
									<div class="row" style="float:right; font-size:20px; padding-right:15px;"><a href="preview_course.php?course_id=<?php echo $_GET['course_id']; if(isset($_GET['preview'])){ if($_GET['preview']=="twocol"){echo "&preview=twocol";}if($_GET['preview']=="section"){echo "&preview=section";}} ?>" onclick=""><i class="glyphicon glyphicon-resize-small"></i></a></div>
									<?php
								}
								echo '<div class="row">';



								echo '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="padding-left:5px; padding-right:10px;">';
								echo "<div class=\"tab-control\" data-role=\"tab-control\">";
								echo "<ul id=\"myTab\" class=\"nav coursesections flex nav-pills nav-stacked\" >";
								//$count_pres=0;
								//echo "<li class=\"active\"><a href=\"#_page_".$count_pres."\">Part - ".$count_pres."</a></li>";
								$count_pres=1;
								for($i=0; $i<$count_list;$i++)
								{
									if($presentation_id[$i]>0 && $interactive_id[$i]==0)
									{
										//presentation
										$query_select_present= "SELECT title FROM tbl_courses WHERE id=".$presentation_id[$i];
										$result_select_present = $connection->query($query_select_present);

										while($row = $result_select_present->fetch_array()){
											if($count_pres==1)
											{
												echo '<li class="active"><a href="#_page_'.$count_pres.'" data-sectionid="'.$count_pres.'" data-user_id="'.$_SESSION["USERID"].'" data-course_id="'.$_GET['course_id'].'" class="update_course_status"  data-toggle="tab" >'.$row[title].'</a></li>';

											}
											else
											{
						        		echo '<div style ="position:absolute; margin-left:45%; background-color:black; margin-top:-20px; height:40px;"> a </div>';
												echo '<li><a href="#_page_'.$count_pres.'" data-sectionid="'.$count_pres.'" data-user_id="'.$_SESSION["USERID"].'" data-course_id="'.$_GET['course_id'].'" class="update_course_status"  data-toggle="tab">'.$row[title].'</a></li>';
											}

										}

									}
									else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
									{
										//interactive
										$query_select_present= "SELECT title FROM tbl_courses WHERE id=".$interactive_id[$i];
										$result_select_present = $connection->query($query_select_present);

										while($row2 = $result_select_present->fetch_array()){

											if($count_pres==1)
											{
												echo "<li class=\"active\"><a href=\"#_page_".$count_pres."\" data-toggle=\"tab\" >Part - ".$count_pres."9999</a></li>";
											}
											else
											{
												echo "<li><a href=\"#_page_".$count_pres."\" data-toggle=\"tab\">Part - ".$count_pres."</a></li>";
											}

										}
									}

									$count_pres++;
								}
								echo "</ul>";
								echo "</div>";
								echo "</div>";

								echo '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 coursecontent" >';
								echo "<div id=\"myTabContent\" class=\"tab-content\" style=\"margin-left:20px;\">";

								//$count_pres=0;
								//printCoursePart($connection, $_GET['course_id'] , "section", $count_pres);  //printModule Content in first tab
								$count_pres=1;
								
								for($i=0; $i<$count_list;$i++)
								{
									if($presentation_id[$i]>0 && $interactive_id[$i]==0)
									{
										
										printCoursePart($connection, $presentation_id[$i], "section", $count_pres,$url_iframe);


									}
									else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
									{
										
										printCoursePart($connection, $interactive_id[$i], "section", $count_pres,$url_iframe);
									}

									$count_pres++;
								}

								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
			}
			else {
			if(isset($_GET["noheaders"]) && $_GET["noheaders"]==1)
				{
					?>
					<div class="row" style="float:right; font-size:20px; padding-right:35px;"><a href="preview_course.php?course_id=<?php echo $_GET['course_id']; if(isset($_GET['preview'])){ if($_GET['preview']=="twocol"){echo "&preview=twocol";}if($_GET['preview']=="section"){echo "&preview=section";}} ?>" onclick=""><i class="glyphicon glyphicon-resize-small"></i></a></div>
					<?php
				}

			echo '<div class="echo col-xs-12 col-sm-12 col-md-12 col-lg-12 coursecontent">';
			printCoursePart($connection, $_GET['course_id'],"","",$url_iframe);
  		echo '</div>';

			for($i=0; $i<$count_list;$i++)
			{
				echo "<span itemprop=\"citation\">";
				if($presentation_id[$i]>0 && $interactive_id[$i]==0)
				{
					printCoursePart($connection, $presentation_id[$i],"","",$url_iframe);
				}
				else if($presentation_id[$i]==0 && $interactive_id[$i]>0)
				{
					printCoursePart($connection, $interactive_id[$i],"","",$url_iframe);
				}
				echo "</span>";
			}
		}
		}
		






		?>
	</div> <!-- div   itemtype= http://schema.org/CreativeWork    -->
</div><!--  ------------------------  END CONTENT      ------------------------      -->


<div class="row">
	<div class="container">
		<!-- AddToAny BEGIN -->
		<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
			<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
			<a class="a2a_button_facebook"></a>
			<a class="a2a_button_twitter"></a>
			<a class="a2a_button_google_plus"></a>
		</div>
		<script async src="https://static.addtoany.com/menu/page.js"></script>
		<!-- AddToAny END -->
	</div>
</div>

<div class="row" style="padding-top:20px; padding-bottom:20px;">
	<div class="container">
		<main class="o-content">
			<div class="">
				<div class="o-section">
					<div id="shop" style="border-top:1px solid #e7e7e7; margin-top: 15px;"></div>
				</div>
				<div class="o-section">
					<div id="github-icons"></div>
				</div>
			</div>
		</main>


		<script src="js/dist/rating.min.js"></script>
		<script>

		var user_id = "<?php echo $_SESSION['USERID']; ?>";
		var course_id = "<?php echo $_GET['course_id']; ?>";
		var data_post1;
		/**
		* Demo in action!
		*/
		(function() {

			'use strict';


			// SHOP ELEMENT
			var shop = document.querySelector('#shop');

			// DUMMY DATA
			var data = [
				{
					title: "Rate this course",
					description: "",
					rating: 0
				}
			];

			// INITIALIZE
			(function init() {
				for (var i = 0; i < data.length; i++) {
					addRatingWidget(buildShopItem(data[i]), data[i]);
				}
			})();

			// BUILD SHOP ITEM
			function buildShopItem(data) {
				var shopItem = document.createElement('div');

				var html = '<div class="c-shop-item__details">' +
					'<h3 class="c-shop-item__title">' + data.title + '</h3>' +
					'<p class="c-shop-item__description">' + data.description + '</p>' +
					'<ul class="c-rating"></ul>' +
					'</div>';

				shopItem.classList.add('c-shop-item');
				shopItem.innerHTML = html;
				shop.appendChild(shopItem);

				return shopItem;
			}


			// ADD RATING WIDGET
			function addRatingWidget(shopItem, data) {

				var ratingElement = shopItem.querySelector('.c-rating');
				var currentRating = data.rating;
				var maxRating = 5;
				var callback = function(rating) {
					if(user_id==0 || course_id==null){
						//alert("You have must register to rate the course!");
						error_msg();
						return false;
					}
					else{
						var data_post ='';

						data_post += 'user_id='+user_id;
						data_post += '&course_id='+course_id;
						data_post += '&score='+rating;

						//data_post1 = data_post;
						insert_rate(data_post);

					}
				};

				var r = rating(ratingElement, currentRating, maxRating, callback);
			}

		})();


		function error_msg(){
			$( ".alert-danger" ).remove();$( ".alert-success" ).remove();
			$("<div class=\"alert alert-danger\" role=\"alert\">You must register to rate the course!</div>").insertAfter(".c-rating");
		}



		function insert_rate(data_post1){
			$.ajax({
				type: "POST",
				url: "functions/insert_rating.php",
				data: data_post1,
				dataType: "json",
				success: function(msg){
					if(msg.status == 1){
						$( ".alert-danger" ).remove();$( ".alert-success" ).remove();
						$("<div class=\"alert alert-success\" role=\"alert\">"+msg.txt+"</div>").insertAfter(".c-rating");
					}
					else{
						$( ".alert-danger" ).remove();$( ".alert-success" ).remove();
						$("<div class=\"alert alert-danger\" role=\"alert\">"+msg.txt+"</div>").insertAfter(".c-rating");
					}
				}
			});
		}

	</script>
	</div>

</div>



<div class="row">
	<div class="container">
		<div id="disqus_thread"></div>
			<script type="text/javascript">
				/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
				var disqus_shortname = 'securityaware-dotme'; // required: replace example with your forum shortname

				/* * * DON'T EDIT BELOW THIS LINE * * */
				(function() {
					var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		</div>
	</div>
</div>

<?php include "footer.php"; ?>


<script>
$('#return_back').click(function(){
	parent.history.back();
	return false;
});

$('#myTab a[href="#_page_1"]').tab('show');

$('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
})

function reloadFullscreen(){

	window.location = document.URL + '&noheaders=1';
}
/*var reloadFullscreen = function (object){
	window.location = document.URL + '&noheaders=1';
}*/

function showFullScreen() {
	$('#CourseViewMenu').hide();
	$('#FORGETitleWindow').hide();
	$('#FORGEBoxHeaderMenu').hide();
	$('#FORGEBoxHeaderMenuLogo').hide();
	$('#footer').hide();
	$('#disqus_thread').hide();
	$('#CourseContentRow').css({ left: 10, right:10, position:'absolute'});
}
/*
var showFullScreen = function (object){
	$('#CourseViewMenu').hide();
	$('#FORGETitleWindow').hide();
	$('#FORGEBoxHeaderMenu').hide();
	$('#FORGEBoxHeaderMenuLogo').hide();
	$('#footer').hide();
	$('#disqus_thread').hide();
	$('#CourseContentRow').css({ left: 10, right:10, position:'absolute'});
}*/
function twoSectionsDiv() {
		if ($('#footer').is(':visible') ){
			//$('#twocols').height($(window).height() - $('#footer').height() - $('#twocols').offset().top-100);
			$('#twocols').height($(window).height() +200);
		}else{

			//$('#twocols').height($(window).height()  - $('#twocols').offset().top );
			$('#twocols').height($(window).height())+200;
		}
	}
/*
var twoSectionsDiv = function (object) {
		if ($('#footer').is(':visible') ){
			$('#twocols').height($(window).height() - $('#footer').height() - $('#twocols').offset().top-100 );
		}else{

			$('#twocols').height($(window).height()  - $('#twocols').offset().top );
		}
	}*/
$(window).ready(function () {


	<?php if(isset($_GET['noheaders']) && $_GET['noheaders']==1){ //trick to Hide header and all to show the course clear for embedded usage in other pages
	?>showFullScreen();
	<?php }
	else { ?>
		return_screen();
		<?php
	}
	//if....?>

	if ($('#twocols').length ){
		twoSectionsDiv($('#twocols'));
	}
});

$(window).bind("resize", function () {
	if ($('#twocols').length){
		twoSectionsDiv($('#twocols'));
	}
});

	 $('#lrmi_popup').popover({ html : true });

	$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

function return_screen(){
	$('#CourseViewMenu').show();
	$('#FORGETitleWindow').show();
	$('#FORGEBoxHeaderMenu').show();
	$('#FORGEBoxHeaderMenuLogo').show();
	$('#footer').show();
	$('#disqus_thread').show();
	//$('#CourseContentRow').css({ left: 10, right:10, position:'absolute'});
	twoSectionsDiv();
}
</script>

<style>
.popover-content {
	font-size:11px;
}

</style>


<?php
function printTitleAndHintInfo($hintTitle, $coursetitle, $author, $publisher, $create_date, $lang, $about, $educAlignement, $eduFramework, $targetName, $targetDescription){
	$hintinfo = 'Author(s) : '.$author.
					' <br/> Publisher : '.$publisher.
					' <br/> Date created : '.date("d/m/Y",strtotime( $create_date )).
					' <br/> Language : '.$lang.
					' <br/> About : '.$about.
					' <br/> Educational Alignment : '.$educAlignement.
					' <br/> Educational Framework : '. $eduFramework.
					' <br/> Target Name : '.$targetName.
					' <br/> Target Description : '.$targetDescription;



	echo "<h1 style=\"text-align:center;\">".$coursetitle."</h1>";
	/*echo '<a href="#" data-hint-mode="2" data-hint="'.$hintTitle.' | '.$hintinfo.'" data-hint-position="bottom"><small style="padding-left: 5px;"><i class="fa fa-info-circle"></i></small></a>';*/
	//echo '<a href="#" id="lrmi_popup" class="btn" data-toggle="popover" rel="popover" data-content="'.$hintinfo.'" data-original-title="'.$hintTitle.'"><i class="fa fa-info-circle fa-2x"></i></a>';


}




function printCoursePart( $connection, $course_id, $issectionparts, $partid , $url_iframe){

	$query_select_present= "SELECT title, content, author, create_date, publisher, language, about, alignmentType, educationalFramework, ".
	"targetName, targetDescription, targetURL, educationalUse, duration, typicalAgeRange, interactivityType, learningResourseType, licence, ".
	"isBasedOnURL, educationalRole, audienceType, interactive_url, iframe_height FROM tbl_courses WHERE id=".$course_id;

	$result_select_present = $connection->query($query_select_present);
	if($issectionparts=="section")
	{
		$bool_issectionparts=true;
	}
	else
	{
		$bool_issectionparts=false;
	}
	while($row = $result_select_present->fetch_array())
	{
			
		if ($bool_issectionparts){
			if($partid==1){
				echo "<div class=\"tab-pane fade in active\" id=\"_page_".$partid."\">";
			}
			else
			{
				echo "<div class=\"tab-pane fade\" id=\"_page_".$partid."\">";
			}
			printTitleAndHintInfo('Course Presentation Part info',$row[0], $row[2], $row[4], $row[3], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
		}else{
			echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			printTitleAndHintInfo('Course Presentation Part info',$row[0], $row[2], $row[4], $row[3], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
			echo "</div><!-- end col-sm-12 div-->";
		}

		printLRMIInfoBlock($row);

		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo html_entity_decode($row[1]);
		echo "</div><!-- end col-sm-12 div-->";
		if(strpos($row[21], "?")==false){
			$url_iframe="?".$url_iframe;
		}else{
			$url_iframe="&".$url_iframe;
		}
		if ($row[21]){
			echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			if(!empty($row[22])){
			echo "<iframe width=\"100%\" height=\"".$row[22]."\" style=\"border-right: 1px dotted navy; border-style: dotted; border-color: navy; border-width: 1px;\"  src=\"".$row[21].$url_iframe."\"></iframe>";
			}
			else{
			echo "<iframe width=\"100%\" height=\"450px\" style=\"border-right: 1px dotted navy; border-style: dotted; border-color: navy; border-width: 1px;\"  src=\"".$row[21].$url_iframe."\"></iframe>";
			}
			echo "</div><!-- end col-sm-12 div-->";
		}

		if ($bool_issectionparts){
			echo "</div>";
		}
		
	}
}


function printLRMIInfoBlock( $row ){

	?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div style="display:none;">
				<span itemprop="name"><?php echo $row[0]; ?> </span>
				<?php
					if(substr_count($row[2], ',')>0)
					{
						$author_arr = explode(',',$row[2]);
						for($q=0;$q<count($author_arr);$q++)
						{
							echo "<span itemprop=\"author\">".$author_arr[$q]."</span>";
						}
					}
					else
					{
					?>
						<span itemprop="author"><?php echo $row[2]; ?> </span>
					<?php
					}
				?>

				<span itemprop="publisher"><?php echo $row[4]; ?> </span>
				<span itemprop="datecreated"><?php echo date("d/m/Y",strtotime($row[3])); ?> </span>
				<span itemprop="inLanguage"><?php echo $row[5]; ?></span><br>
				<?php
					if(substr_count($row[6], ',')>0)
					{
						$author_arr = explode(',',$row[6]);
						for($q=0;$q<count($author_arr);$q++)
						{
							echo "<span itemprop=\"about\">".$author_arr[$q]."</span>";
						}
					}
					else
					{
					?>
						<span itemprop="about"><?php echo $row[6]; ?> </span>
					<?php
					}
				?>
				<span itemprop="educationalAlignment" itemscope itemtype="http://schema.org/AlignmentObject">
					<span itemprop="alignmentType" ><?php echo $row[7]; ?></span>
					<span itemprop="educationalFramework" ><?php echo $row[8]; ?></span>
					<span itemprop="targetName"  ><?php echo $row[9]; ?></span>
					<span itemprop="targetDescription"  ><?php echo $row[10]; ?></span>
					<span itemprop="targetUrl" >
						<a href="<?php echo $row[11]; ?>" >
							<?php echo $row[11]; ?>
						</a>
					</span>
				</span>
				<span itemprop="educationalUse"><?php echo $row[12]; ?></span>
				<span itemprop="timeRequired" content="PT1H30M"><?php echo $row[13]; ?></span>
				<span itemprop="typicalAgeRange" ><?php echo $row[14]; ?></span>
				<span itemprop="interactivityType" ><?php echo $row[15]; ?></span>
				<span itemprop="learningResourceType" ><?php echo $row[16]; ?></span>
				<span itemprop="license" itemscope itemtype="http://schema.org/URL">
					<a href="http://creativecommons.org/licenses/by/3.0/" itemprop="url">
						http://creativecommons.org/licenses/by/3.0/
					</a>
				</span>
				<span itemprop="isBasedOnUrl" ><?php echo $row[18]; ?></span>
				<span itemprop="audience" itemscope itemtyp="http://schema.org/EducationalAudience">
					<span itemprop="educationalRole"><?php echo $row[19]; ?></span>
					<span itemprop="audienceType"><?php echo $row[20]; ?></span>
				</span>
			</div>
		</div>

	<?php
}


function makeUserALoggedInUser($connection, $email){
	$result_check_mail_query = "SELECT * FROM tbl_users WHERE email_user = '".$email."'";
	$result = $connection->query($result_check_mail_query) or die("Error in query.." . mysqli_error($connection));
	$row = mysqli_fetch_array($result);
	$_SESSION['AUTHENTICATION'] = true;
	$_SESSION['SESSION'] = true;
	$_SESSION['USERID'] = $row['id_user'];
	$_SESSION['EMAIL'] = $row['email_user'];
	$_SESSION['FNAME'] = $row['name_user'];
	$_SESSION['LNAME'] = $row['surname_user'];
	$_SESSION['UROLE'] = "";
	$_SESSION['UROLE_ID'] = "";
	$Select_user_role_query="SELECT tbl_role.name_role,tbl_role.id_role FROM tbl_role INNER JOIN tbl_user_role ON tbl_role.id_role=tbl_user_role.id_role WHERE tbl_user_role.id_user=". $row['id_user'];
	//$result_user_role = mysql_query($Select_user_role_query);
	$result_user_role = $connection->query($Select_user_role_query)  or die("Error in query.. result_user_role" . mysqli_error($connection));
	$count_roles=0;
	//while($row1 = mysql_fetch_array($result_user_role)){
	while($row1 = $result_user_role->fetch_array()){
		if($count_roles>0)
		{
			$_SESSION['UROLE'] .= "/".$row1[0];
			$_SESSION['UROLE_ID'] .= "/".$row1[1];
		}
		else
		{
			$_SESSION['UROLE'] .= $row1[0];
			$_SESSION['UROLE_ID'] .= $row1[1];

		}
		$count_roles++;
	}

	?>
		<style>
			#FORGEBoxHeaderMenuLogo{display:none !important;}
			#FORGEBoxHeaderMenu{display:none !important;}
			#disqus_thread{display:none !important;}
			#footer{display:none !important;}
		</style>

		<?php

}


?>



