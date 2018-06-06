<?php

	include "conf.php";
	
	if(isset($_GET["lrs_id"]) && isset($_GET["cid"]) && !isset($_GET["action"])){
		
		$query_select_lrs= "SELECT lrs_id FROM match_course_lrs WHERE course_id=".$_GET["cid"]." AND lrs_id=".$_GET["lrs_id"];
		$result_select_lrs = $connection->query($query_select_lrs);
		
		if($result_select_lrs->num_rows > 0)
		{
			//update
			$query_update = "UPDATE match_course_lrs SET lrs_id=".$_GET["lrs_id"]." WHERE course_id=".$_GET["cid"];
			$result_update = $connection->query($query_update);
			//if($result_update){
				die(msg(0,"Updated"));
			//}
			
		}
		else
		{
			//insert
			$query_insert = "INSERT INTO match_course_lrs(course_id, lrs_id) VALUES (".$_GET["cid"].",".$_GET["lrs_id"].")";

			$result_insert = $connection->query($query_insert);
		//	if($result_insert){
				die(msg(0,"Saved"));
		//	}
			
		}		
	}
	
	if(isset($_GET["action"])){
		if($_GET["action"]=='del'){
			$query_delete = "DELETE FROM match_course_lrs WHERE course_id=".$_GET["cid"];
			$result_delete = $connection->query($query_delete);
			//if($result_update){
				die(msg(0,"Deleted"));
			//}
		}
	}
	
	function msg($status,$txt)
	{
		
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
?>