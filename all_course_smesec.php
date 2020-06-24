 <?php
	include "header.php";


	if(count($_GET)<0 || count($_GET)>1){
  		http_response_code(404);
  		include('404.html'); // provide your own HTML for the error page
  		die();
	}else if(count($_GET)==1){
  		if(!isset($_GET["course_category_id"])){
    			http_response_code(404);
    			include('404.html'); // provide your own HTML for the error page
    			die();
  }
}

	accessRole("VIEW_ALL_COURSES",$connection) or die('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=403error.html">');



  $query_select= "SELECT id, name, active FROM tbl_course_types";// WHERE id =".$_GET['citem'];
  $result_select = $connection->query($query_select);

  while($rowcat = $result_select->fetch_array()){
    $id=$rowcat[0];
    $name=$rowcat[1];
    $active=$rowcat[2];
  }


?>


<section id="headerMainOpencourses" >
	<div class="container" >
		<div class="row"  >
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="padding-top:20px;padding-bottom:50px">
      <h2 style="color:#000000; font-family:'Jost*'; font-weight:300; margin-bottom:15px;" >CATEGORIES</h2>
        <div id="table_cat" style="font-family:'Miriam Libre';">
        </div>

      <h2 style="color:#000000; font-family:'Jost*'; font-weight:300; margin-bottom:15px;" >EXTERNAL LINKS</h2>
        <div style="font-family:'Miriam Libre'; margin-left:10px; ">
          <a target="_blank" rel="noopener noreferrer" href="https://www.concordia-h2020.eu/map-courses-cyber-professionals/"><img style="width:120px;" src="images/concordia.png"></a>
        </div>

        <div style="font-family:'Miriam Libre'; margin-left:10px; margin-top:15px; ">
          <a target="_blank" rel="noopener noreferrer" href="https://gcatoolkit.org/smallbusiness/#toolboxes"><img style="width:120px;  border-radius: 10%;" src="images/gca.png"></a>
        </div>

      </div>
			<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="padding-top:20px;padding-bottom:50px">
			    <div style="text-align:center;"> <h2 style="color:#000000; font-family:'Jost*'; font-weight:300; margin-left:5px;" >LIST OF SMESEC COURSES</h2></div>
           <?php
	          if(isset($_GET['project_id']))
            {
              printSMESECCourses($connection,$_GET['project_id']);
            }elseif(isset($_GET['course_category_id'])){
              printCoursesPerCategory($connection,$_GET['course_category_id']);
            }else
printSMESECCourses($connection,2);
           ?>
			</div>
		</div>
	</div>
</section>


 <?php include "footer.php"; ?>


 <script>

   var catid=0;
   var citem="<?php echo  $_GET['citem']; ?>";// if(isset($_GET['citem'])){	if(!empty($_GET['citem'])){}}
   var link = 'functions/select_cat_courses_list_smesec.php';//?citem='+citem;
   var link2 = 'functions/select_proj_courses_list.php';
   $(document).ready(function(){
   <?php
     if(accessRole("VIEW_ALL_COURSES",$connection))
     {
   ?>
       $('#table_cat').load(link).fadeIn("slow");
       $('#table_prj').load(link2).fadeIn("slow");
   <?php
     }
   ?>
     $('#insert_course').submit(function(e) {
       insert_category();
       e.preventDefault();
     });
   });
   </script>



 <?php


 //Shows only latest public Course Modules
 function printTeaserPublicCourses($connection){
 $query_select_courses= "SELECT * FROM tbl_courses WHERE publish_to_anonymous=1  AND course_item_id=1 AND active=1 order by modify_date DESC LIMIT 40";
 printCoursesTeaser($connection, $query_select_courses);

}

function printTeaserSignUpCourses($connection){
 $query_select_courses= "SELECT * FROM tbl_courses WHERE publish_to_anonymous=0  AND course_item_id=1 AND active=1 order by modify_date DESC LIMIT 4";
 printCoursesTeaser($connection, $query_select_courses);

 }


 function printSMESECCourses($connection, $projectID){
  $query_select_courses = "SELECT tbl_courses.id, tbl_courses.title, tbl_courses.sdescription, tbl_courses.content, tbl_courses.course_item_id, tbl_courses.author, ";
  $query_select_courses .= " tbl_courses.create_date, tbl_courses.modify_date, tbl_courses.publisher, tbl_courses.`language`, tbl_courses.about, tbl_courses.alignmentType, ";
  $query_select_courses .= " tbl_courses.educationalFramework, tbl_courses.targetName, tbl_courses.targetDescription, tbl_courses.targetURL, tbl_courses.educationalUse, ";
  $query_select_courses .= " tbl_courses.duration, tbl_courses.typicalAgeRange, tbl_courses.interactivityType, tbl_courses.learningResourseType, tbl_courses.licence, tbl_courses.isBasedOnURL, ";
  $query_select_courses .= " tbl_courses.educationalRole, tbl_courses.audienceType, tbl_courses.active, tbl_courses.publish_to_anonymous, tbl_courses.category_id, tbl_courses.create_uid, ";
  $query_select_courses .= " tbl_courses.interactive_category, tbl_courses.interactive_item, tbl_courses.interactive_url, tbl_courses.iframe_height, tbl_project.`name` FROM ";
  $query_select_courses .= " tbl_project INNER JOIN tbl_project_course ON tbl_project_course.project_id = tbl_project.id INNER JOIN tbl_courses ON tbl_project_course.course_id = tbl_courses.id WHERE ";
  $query_select_courses .= " tbl_project_course.project_id = ".$projectID." AND tbl_courses.course_item_id = 1 ORDER BY tbl_courses.create_date DESC";
  $result_select_courses = $connection->query($query_select_courses);


  printCoursesTeaser($connection, $query_select_courses);

  }

  function printCoursesPerCategory($connection, $course_category_id){
    $query_select_courses = "SELECT tbl_courses.id, tbl_courses.title, tbl_courses.sdescription, tbl_courses.content, tbl_courses.course_item_id, tbl_courses.author, ";
    $query_select_courses .= " tbl_courses.create_date, tbl_courses.modify_date, tbl_courses.publisher, tbl_courses.`language`, tbl_courses.about, tbl_courses.alignmentType, ";
    $query_select_courses .= " tbl_courses.educationalFramework, tbl_courses.targetName, tbl_courses.targetDescription, tbl_courses.targetURL, tbl_courses.educationalUse, ";
    $query_select_courses .= " tbl_courses.duration, tbl_courses.typicalAgeRange, tbl_courses.interactivityType, tbl_courses.learningResourseType, tbl_courses.licence, tbl_courses.isBasedOnURL, ";
    $query_select_courses .= " tbl_courses.educationalRole, tbl_courses.audienceType, tbl_courses.active, tbl_courses.publish_to_anonymous, tbl_courses.category_id, tbl_courses.create_uid, ";
    $query_select_courses .= " tbl_courses.interactive_category, tbl_courses.interactive_item, tbl_courses.interactive_url, tbl_courses.iframe_height, tbl_category_courses.`name` FROM ";
    $query_select_courses .= " tbl_category_courses INNER JOIN tbl_match_course_category ON tbl_match_course_category.course_category_id = tbl_category_courses.id INNER JOIN tbl_courses ON tbl_match_course_category.course_id = tbl_courses.id INNER JOIN tbl_project_course ON tbl_project_course.course_id = tbl_courses.id  WHERE ";
    $query_select_courses .= " tbl_match_course_category.course_category_id = ".$course_category_id." AND tbl_project_course.project_id = 2  AND tbl_courses.course_item_id = 1 AND tbl_courses.active = 1 AND tbl_courses.publish_to_anonymous = 1 ORDER BY tbl_courses.create_date DESC";
    $result_select_courses = $connection->query($query_select_courses);
  
  
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



   echo '<div class="col-sm-4 col-md-4" style="padding:0px 5px 0px 5px; margin-top:5px;">';
   echo '<div  style="border: #cfcfcf; background-color: white;border-width: 1px; border-style: solid; padding: 5px; /*text-align: center;border-radius: 5px;box-shadow: 1px 1px 3px #a0a0a0;*/">';
   echo '<div  style="vertical-align: top; position:absolute;"><img style="margin:15px 0 0 3px; width:45px;" src="images/trainingicon.PNG"></div>';
   echo '<div  style="height:160px; margin-left:45px;">';
   echo '<div id="courseHeaderTitle" style="height:160px; margin-bottom:10px;">';
   echo '<table style="width:100%;height:140px;"><tr>';
   echo '<td style="vertical-align:top;"><a style="text-decoration: none;" href="preview_course.php?course_id='  .$row['id'].  '"><h3 style="color:#000000;font-family:\'Miriam Libre\'; font-weight:bold; margin:20px 10px 5px 10px; font-size:20px;">'.$row['title'].'</h3></a>';
   echo '<p style="color:#777777; margin-left:10px; font-family:\'Miriam Libre\'; font-size:15px;" >by '.$row['publisher'].'</p>';
   echo '</td>';
   echo '</tr>';
   echo '</table>';

   echo '<table style="width:100%; margin-left:-40px;">';

   /* **** Start Rating *** */

   if($avg_rate!='N/A'){
     if($avg_rate>0 && $avg_rate<1){echo '<tr><td colspan="2"><p style="text-align:left;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate===1){echo '<tr><td colspan="2"><p style="text-align:left;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate>1 && $avg_rate <2 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate===2 ){echo '<tr><td colspan="2"><p style="text-align:left;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate>2 && $avg_rate <3 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate===3 ){echo '<tr><td colspan="2"><p style="text-align:left;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate>3 && $avg_rate <4 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate===4 ){echo '<tr><td colspan="2"><p style="text-align:left;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate>4 && $avg_rate <5 ){echo '<tr><td colspan="2"><p style="text-align:right;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}
     else if($avg_rate===5 ){echo '<tr><td colspan="2"><p style="text-align:left;"><a href="" data-toggle="modal" data-target="#myModal_'.$row['id'].'" style="color: #BDBD12 !important;"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>&nbsp;<i class="fa fa-info" aria-hidden="true"></i></a> </p></td></tr></table>';}

   }else{
     echo '<tr><td colspan="2"><p style="text-align:left;"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></p></td></tr></table>';
   }

   /* **** End Rating *** */


   echo '</div>';//headerTitle
   echo '<p style="color:#fd5602; margin-top:-25px; padding-right:10px; font-size:85%; text-align:right;">'.$row['sdescription'].'</p>';
   echo '</div>';

   echo '<div class="btn-smesec" style="text-align:center; margin:24px 5px 15px 5px;"><a style="text-decoration:none; font-size:120%;" href="preview_course.php?course_id='  .$row['id'].  '">View course</a></div>';

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

 
   


