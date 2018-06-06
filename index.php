<?php include 'header.php'; ?>



</div> <!-- trick to close the container for the next section  -->


<?php

if(!isset($_SESSION["UROLE_ID"]) OR ($_SESSION["UROLE_ID"]==7)) {
	include "login_header.php";
	echo "<script> $('#FORGEBoxHeaderMenu').hide(); </script><!-- HIDE THE MENU in INDEX When NOT LOGGED IN -->";
}

?>

<section id="headermain" >
	<div class="container">
		<div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1>&nbsp;</h1>
			<h1>Learn by experimenting on real hardware!</h1>
			<p>Interactive Courses with Real Infrastructures! Access, create and share interactive courses with widgets accessing real infrastructures and resources available from <a href="http://www.ict-fire.eu/">FIRE</a> testbeds across Europe! 
			</p>
			<h1>&nbsp;</h1>
			</div>
		</div><!--  ------------------------  END CONTENT      ------------------------      -->
	</div>
	</div>
</section>


<section id="searchbar">
        <div class="container">
                <div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
                        <input style="width:75%; text-align:center; height:40px; margin-right:20%; margin-left:20%; font-size:30px;" placeholder="Search for lessons" type="text>
                </div><!--  ------------------------  END CONTENT      ------------------------      -->
        </div>
</section>


<section id="headerMainOpencourses" style="background-color: #E4E3D5; " >
	<div class="container" >
		<div class="row"  > 
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:50px;padding-bottom:50px">
			
			<h1 style="color:#636365" >Featured Open courses</h1>
			</div>	
		</div>	
		<div class="row"> 
			<?php printTeaserPublicCourses($connection); ?>
		</div>
		<div class="row" >  <!--  ------------------------  START CONTENT      ------------------------      -->			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;padding-top:50px;padding-bottom:50px">
			<h3><a style="color:#636365; text-decoration:none;" href="all_course.php">More Open Courses...</a></h3>
			</div>
		</div><!--  ------------------------  END CONTENT      ------------------------      -->
	
	</div>
</section>
<section id="headerMainSignUpcourses" style="background-color: #EFEFDF; " >
	<div class="container" >
		<div class="row"  > 
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:50px;padding-bottom:50px">
			
			<h1 style="color:#636365" >Featured courses for FORGEBox users</h1>
			</div>	
		</div>	
		<div class="row"> 
			<?php printTeaserSignUpCourses($connection); ?>
		</div>
		<div class="row" >  <!--  ------------------------  START CONTENT      ------------------------      -->			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;padding-top:50px;padding-bottom:50px">
			<?php if(!isset($_SESSION["UROLE_ID"])) {
					echo '<h3><a style="color:#636365" href="register.php">Open a FORGEBox account to see more courses</a></h3>';
				}else{
					echo '<h3><a style="color:#636365; text-decoration:none;" href="all_course.php">See all courses...</a></h3>';
				}
			?>
			</div>
		</div><!--  ------------------------  END CONTENT      ------------------------      -->
	
	</div>
</section>
			
<section id="headermain_whatisFIRE" >
        <div class="container">
                <div class="row"> <!--  ------------------------  START CONTENT      ------------------------      -->
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <h1>&nbsp;</h1>
                        <h1>What is FIRE?</h1>
			<h3>Future Internet Research and Experimentation = FIRE</h3>
			<p>There is an increasing demand from both academic and industrial communities to bridge 
			the gap between visionary research and large-scale experimentation, 
			through experimentally-driven advanced research consisting of iterative cycles of research, 
			design and experimentation of new networking and service architectures and paradigms addressing all 
			levels, including horizontal research on issues such as system complexity and security.
			See more at <a href="http://www.ict-fire.eu">http://www.ict-fire.eu</a>
		
</p>


                        <h1>&nbsp;</h1>
                        </div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<br>
			<iframe width="560" height="315" src="//www.youtube.com/embed/YlTSyn5iHCU" frameborder="0" allowfullscreen></iframe>
			</div>
                </div><!--  ------------------------  END CONTENT      ------------------------      -->
        </div>
</section>


<div class="container"> <!-- trick reopen container again so that can continue normally. Container div closes on footer anyway    -->


 <?php include "footer.php"; ?>
 
 <?php 
 
 
 //Shows only latest public Course Modules
 function printTeaserPublicCourses($connection){
	$query_select_courses= "SELECT * FROM tbl_courses WHERE publish_to_anonymous=1  AND course_item_id=1 AND active=1 order by modify_date DESC LIMIT 4";
	printCoursesTeaser($connection, $query_select_courses);
	
}

function printTeaserSignUpCourses($connection){
	$query_select_courses= "SELECT * FROM tbl_courses WHERE publish_to_anonymous=0  AND course_item_id=1 AND active=1 order by modify_date DESC LIMIT 4";
	printCoursesTeaser($connection, $query_select_courses);
	
 }
	
function printCoursesTeaser($connection, $query_select_courses){
	$result_select_course = $connection->query($query_select_courses)  or die("Error in query.." . mysqli_error($connection));
	while($row = $result_select_course->fetch_array()){
		
		
		/* **** Start Rating *** */
		$avg_rate=0;
		$query_select_courses_rate= "SELECT COUNT(id) , SUM(score_val) FROM course_rating WHERE course_id=".$row['id'];
		$result_select_course_rate = $connection->query($query_select_courses_rate)  or die("Error in query.." . mysqli_error($connection));
		
		while($row_score = $result_select_course_rate->fetch_array()){
			if($row_score[0]>0){
				$avg_rate = $row_score[1]/$row_score[0];
			}
			else{
				$avg_rate='N/A';
			}
		}
			
		/* **** End Rating *** */
   
   
		echo '<div class="col-sm-6 col-md-3" >';
		echo '<div  style="border: #cecece; background-color: white;border-width: 1px;border-style: solid;padding: 5px;/*text-align: center;*/;border-radius: 5px;box-shadow: 2px 2px 9px #888888;">';
		echo '<div  style="height:400px;">';
		echo '<div id="courseHeaderTitle" style="height:150px;margin-bottom:10px;border-bottom: 1px dotted rgb(222, 197, 197);">';
		echo '<table><tr>';
		echo '<td width="50px" style="vertical-align: top;"><img style="margin-top: 5px;" src="images/course_smallico.PNG"></td>';
		echo '<td style="vertical-align: top;"><a href="preview_course.php?course_id='  .$row['id'].  '"><h3 style="color:#525789; margin-top:7px; margin-left:2px; font-size:19px;">'.$row['title'].'</h3></a>';
		echo '<tr><td colspan="2"><p style="color:#0B0F39;margin-top:10px;" >by '.$row['publisher'].'</p></td></tr>';
		echo '</td>';
		echo '</tr>';
		
		
		/* **** Start Rating *** */
		if($avg_rate!='N/A'){
		  if($avg_rate>0 && $avg_rate<1){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate===1){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate>1 && $avg_rate <2 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate===2 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate>2 && $avg_rate <3 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate===3 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate>3 && $avg_rate <4 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate===4 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate>4 && $avg_rate <5 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		  else if($avg_rate===5 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
		
		}else{
			echo '<tr><td colspan="2"><p style="text-align:right;"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></p></td></tr></table>';
		}
		/* **** End Rating *** */
		
		
		echo '</div>';//headerTitle
		echo '<p style="color:#636365">'.$row['sdescription'].'</p>';
		echo '</div>';
		
		echo '<a style="bottom: 0; margin: 5px; border-style: solid; border-width: 1px;padding: 10px; background-color: #525789; text-decoration: none; text-align: center; color:white; right: 15px; position: absolute; left: 15px;" href="preview_course.php?course_id='  .$row['id'].  '">View course</a>';
		echo '</div>';
		echo '</div>';
		
		
		
		/* **** Start Rating *** */
		
		if($avg_rate!='N/A'){
			$score1=0;
			$score2=0;
			$score3=0;
			$score4=0;
			$score5=0;
    
    
			$query_select_courses_rate5= "SELECT COUNT( id )FROM course_rating WHERE score_val=5 && course_id=".$row['id'];
			$result_select_course_rate5 = $connection->query($query_select_courses_rate5)  or die("Error in query.." . mysqli_error($connection));
    
			while($row_score5 = $result_select_course_rate5->fetch_array()){
				$score5=$row_score5[0];
			}
   
			$query_select_courses_rate4= "SELECT COUNT( id )FROM course_rating WHERE score_val=4 && course_id=".$row['id'];
			$result_select_course_rate4 = $connection->query($query_select_courses_rate4)  or die("Error in query.." . mysqli_error($connection));
    
			while($row_score4 = $result_select_course_rate4->fetch_array()){
				$score4=$row_score4[0];
			}
     
			$query_select_courses_rate3= "SELECT COUNT( id )FROM course_rating WHERE score_val=3 && course_id=".$row['id'];
			$result_select_course_rate3 = $connection->query($query_select_courses_rate3)  or die("Error in query.." . mysqli_error($connection));
    
			while($row_score3 = $result_select_course_rate3->fetch_array()){
				$score3=$row_score3[0];
			}
     
			$query_select_courses_rate2= "SELECT COUNT( id )FROM course_rating WHERE score_val=2 && course_id=".$row['id'];
			$result_select_course_rate2 = $connection->query($query_select_courses_rate2)  or die("Error in query.." . mysqli_error($connection));
    
			while($row_score2 = $result_select_course_rate2->fetch_array()){
				$score2=$row_score2[0];
			}
     
			$query_select_courses_rate1= "SELECT COUNT( id )FROM course_rating WHERE score_val=1 && course_id=".$row['id'];
			$result_select_course_rate1 = $connection->query($query_select_courses_rate1)  or die("Error in query.." . mysqli_error($connection));
    
			while($row_score1 = $result_select_course_rate1->fetch_array()){
				$score1=$row_score1[0];
			}
   
     
			echo '
				<div class="modal fade" id="myModal_'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
		/* **** End Rating *** */
		
		
		
	}
 }
 

 
 ?>

 <?php
	
	if(isset($_SESSION['USERID']) && $_SESSION['USERID']>0 && $_SESSION['USERID']!=7)
	{
		?>
		 <script type="text/javascript">
			/*var tincan = new TinCan (
            {
                url: window.location.href,
                activity: {
                    id: "/index.php",
                    definition: {
                        name: {
                            "en-US": "FORGEBox - index.php"
                        },
                        description: {
                            "en-US": "FORGEBox - index.php"
                        }, 
                        type: "http://activitystrea.ms/schema/1.0/page"
                    }
                }
            }
        );
*/
        tincan.sendStatement(
            {
				actor: {
					name: "<?php echo $_SESSION['FNAME'].' '.$_SESSION['LNAME']; ?>",
					mbox: "mailto:<?php echo $_SESSION['EMAIL']; ?>"
				  },
				  verb: {
					id: "http://adlnet.gov/expapi/verbs/experienced",
					display: {"en-US": "experienced"}
				},
				object: {
					id: "http://localhost/git_Project/ForgeBox/index.php",
					definition: {
						type: "http://adlnet.gov/expapi/activities/assessment",
						name: { "en-US": "Login FORGEBox" },
						extensions: {
							"http://localhost/git_Project/ForgeBox/index.php": "index"
						}
					}
				},
                context: {
					extensions: {
					  "http://localhost/git_Project/ForgeBox/index.php": "index.php"
					}
				},
				authority: {
					objectType: "Agent",
					name: "<?php echo $adminName; ?>",
					mbox: "mailto:<?php echo $adminEmail; ?>"
					
				}
            },
            function () {}
        );
    </script>
		<?php
	}
	/*
	if(!empty($_SESSION['lrs_name']) && !empty($_SESSION['lrs_endpoint_url']) && !empty($_SESSION['lrs_username']) && !empty($_SESSION['lrs_password']) && isset($_SESSION['lrs_login_record']))
	{
		$url_redirection = $_SERVER['HTTP_REFERER']."?endpoint=".$_SESSION['lrs_endpoint_url']."&auth=Basic ".base64_encode($_SESSION['lrs_username'] . ':' . $_SESSION['lrs_password']);
				
		print "<script>	alert('sdfsd'); window.location= '".$url_redirection."'; </script>";		
		
	}
	*/
	
	
	?>
