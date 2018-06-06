  <?php
	include "conf.php";

	/*
	$_POST['course_id'] = 24;
	$_POST['present_id'] = 23;
	$_POST['action']='ins';
	
	course_id=24&present_id=23&action=ins
	
	
	//update
	
	$_POST['sort_list']="8|7|";
	$_POST['action']="upd";
	$_POST['course_id']=17;
	*/
	
	
	if(isset($_POST['present_id']) && isset($_POST['action']) && isset($_POST['course_id']) && $_POST['action']=="ins")
	{

			$query_insert = "INSERT INTO tbl_match_present_interact_course(course_id, presentation_id, interactive_id, order_list) VALUES (".$_POST['course_id'].",".$_POST['present_id'].",0,0)";			
			//echo $query_insert;
			
			$result_insert = $connection->query($query_insert);
						
			die(msg(1,"Succeed!"));

	}
	else if(isset($_POST['sort_list']) && isset($_POST['action']) && isset($_POST['course_id']) && $_POST['action']=="upd")
	{
			$total_parts = explode("|", $_POST['sort_list']);

			for($i=0;$i<(count($total_parts)-1);$i++)
			{
				$query_update = "UPDATE tbl_match_present_interact_course SET order_list=".($i+1)." WHERE id=".$total_parts[$i];
				$result_update = $connection->query($query_update);
			}			
			die(msg(1,"Succeed!"));
	
	}
	else if(isset($_POST['part_id']) && isset($_POST['action']))
	{
		if($_POST['action']=="del")
		{
			$query_delete = "DELETE FROM tbl_match_present_interact_course WHERE id=".$_POST['part_id'];
			$result_delete = $connection->query($query_delete);
			
			die(msg(1,"Succeed!"));
		}
	}
	else
	{
		die(msg(0,"Error!"));
	}
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
?>