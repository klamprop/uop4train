<?php 
include "conf.php";
include "session.php";
		
		
  if(!isset($_SESSION)){
     http_response_code(403);
     include('../403error.html'); // provide your own HTML for the error page
     die();
   }
   
   if(!is_numeric($_SESSION['USERID'])){
     http_response_code(403);
     include('../403error.html'); // provide your own HTML for the error page
     die();
   }

if ($_POST['user_id'] != null){
    $query_match_course_user2 ="SELECT user_id, course_id, last_visited, total, courses_completed FROM tbl_match_course_user WHERE course_id=".$_POST['course_id']." AND user_id=".$_POST['user_id']."";
    $result_match_course_user2 = $connection->query($query_match_course_user2);
    
    

    while($row3 = $result_match_course_user2->fetch_array()){
        $user_id_match=$row3[0];
        $course_id_match=$row3[1];
        $last_visited_match=$row3[2];
        $total_match=$row3[3];
        $courses_completed_match=$row3[4];
        $array_of_completed = explode(",",$courses_completed_match);

    }
    //We test if the user has ever signed in this course
    if($user_id_match == null){
        



        //if the user signed in
    } else {
        if(in_array($_POST['section_id'],$array_of_completed)){
            //if it is in the array then we just add it in the last cisited
           $query_insert_course_user_connection = "UPDATE tbl_match_course_user SET last_visited=".$_POST['section_id']." WHERE course_id=".$_POST['course_id']." AND user_id=".$_POST['user_id']."  ";
           $result_insert_course_user_connection = $connection->query($query_insert_course_user_connection);
           //echo "{'first_course':".$sum_of_completed."}";
        }
        else{
            //We add it in the courses completed
            array_push($array_of_completed,$_POST['section_id']);
            sort($array_of_completed);
            $sum_of_completed = count($array_of_completed);
            $string_of_completed = implode(",",$array_of_completed);
            $percentage = ($sum_of_completed / $total_match) * 100 ; 
            $query_insert_course_user_connection2 = "UPDATE tbl_match_course_user SET last_visited=".$_POST['section_id']." , percentage =".$percentage." , courses_completed =\"".$string_of_completed."\" WHERE tbl_match_course_user.course_id=".$_POST['course_id']." AND tbl_match_course_user.user_id=".$_POST['user_id']."  ";
            $result_insert_course_user_connection2 = $connection->query($query_insert_course_user_connection2);
            
        }
       
        
    }
    
    
}





?>

