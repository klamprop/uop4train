<?php
	include "conf.php";
		
		
		$flag=NULL;
		if(isset($_POST['user_id']) && isset($_POST['course_id']) && isset($_POST['score']))
		{
         
      $query_select= "SELECT id FROM course_rating WHERE course_id =".$_POST['course_id']." AND user_id=".$_POST['user_id'] ;
			$result_select = $connection->query($query_select);
			
			while($row = $result_select->fetch_array()){
				$id=$row[0];			
			}
			
        if(isset($id)){
          die(msg(0,"You have already rate this course!"));
        }
        else{
        
        //$query_edit_category = "INSERT INTO tbl_category_courses(name, active, course_item_id) VALUES ('".$_POST['category_name']."',".$_POST['active'].",'".$_POST['citem']."')";
        $query_insert_score = "INSERT INTO course_rating(course_id, user_id, score_val) VALUES (".$_POST['course_id'].",".$_POST['user_id'].",".$_POST['score'].")";
        			
  				//$result_edit_category = $connection->query($query_edit_category);
        $result_insert_score = $connection->query($query_insert_score);
  							
  				$id_rate = $connection->insert_id;
  			  
  				//echo $id_item;
  				if($id_rate>0)
  				{
            die(msg(1,"Thank you for your rate!"));
          }else{
          die(msg(0,"Your rate doesn't saved! Please try again!"));
          }
        
        }
			}else{
        die(msg(0,"Your rate doesn't saved! Please try again!"));
      }
      
      

		
			

		
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
	
?>