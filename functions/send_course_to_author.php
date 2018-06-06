<?php
	include "conf.php";
	$id_user=0;
	$contain_in_course_module=0;
	
	$query_select_user= "SELECT id_user FROM tbl_users WHERE email_user='".$_GET["user"]."'";
	$result_select_user = $connection->query($query_select_user);
	
	while($row = $result_select_user->fetch_array()){
		$id_user=$row[0];
	}
	
	if($id_user==0)
	{
		die(msg(0,"Invalid email!"));
	}
	else
	{
		$query_select_course= "SELECT course_item_id FROM tbl_courses WHERE id=".$_GET["c_id"];
		$result_select_course = $connection->query($query_select_course);
		while($row = $result_select_course->fetch_array()){
			$course_item_id=$row[0];
		}
		if($course_item_id==1){ //Course Module
			//select all course parts id
			$query_select_course_parts= "SELECT presentation_id, interactive_id FROM tbl_match_present_interact_course WHERE course_id=".$_GET["c_id"];			
			$result_select_course_parts = $connection->query($query_select_course_parts);
			$i_part=1;
			$course_part_id[0]=$_GET["c_id"];
			
			while($row = $result_select_course_parts->fetch_array()){
				
				
				
				if($row[0]>0)
				{
					
					$course_part_id[$i_part]=$row[0];
				}
				else if($row[1]>0)
				{
					
					$course_part_id[$i_part]=$row[1];
				}
				
				$i_part++;
				
			}
			//update author
			for($i=0;$i<$i_part;$i++)
			{
				$query_update="UPDATE tbl_courses SET create_uid=".$id_user." WHERE id=".$course_part_id[$i];
				$result_update = $connection->query($query_update);
			}
			die(msg(0,"The Course change author!"));
		}
		else if($course_item_id==2 || $course_item_id==3){
			
			$query_select_course_parts= "SELECT id FROM tbl_match_present_interact_course WHERE presentation_id=".$_GET["c_id"]." OR interactive_id=".$_GET["c_id"];
			
			$result_select_course_parts = $connection->query($query_select_course_parts);						
			$row_i=0;
			while($row_part = $result_select_course_parts->fetch_array()){
				if($row_part[0]>0){
					$contain_in_course_module=1;
				}
			}
			if($contain_in_course_module==1){
				die(msg(0,"This Part used as part of course module!"));
			}
			else{

				$query_update="UPDATE tbl_courses SET create_uid=".$id_user." WHERE id=".$_GET["c_id"];
				$result_update = $connection->query($query_update);
				die(msg(0,"The Part change author!"));
			}
			//change author
			//update author
		}
	}
	die(msg(0,$_GET["user"]));
	
	function msg($status,$txt)
	{
		
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
?>