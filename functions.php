<?php

include "functions/session.php";
include "functions/functions.php";
include "functions/conf.php";


		if (isset($_GET['id']) ) {
			$id = $_GET['id'];
			$user_id = $_GET['userid'];
			
			$query_select = "SELECT id_user FROM tbl_user_role WHERE id_user=".$user_id." AND id_role=".$id;
			
			//$result_select = mysql_query($query_select) or die(mysql_error());
			$result_select = $connection->query($query_select);
			
			//$num_rows = mysql_num_rows($result_select);
			$rnum_rows = $result_select->num_rows;
			/*$i_select=0;
			while($row = mysql_fetch_array($result_select)){
				$i_select++;
			}
			*/
			
			if ($rnum_rows>0)
			{
				//DELETE
				$query_delete = "DELETE FROM tbl_user_role WHERE id_user=".$user_id." AND id_role=".$id;
				$result_delete = $connection->query($query_delete);
				//if(mysql_query($query_delete))
				if($result_delete)
					echo json_encode(array('success'=>TRUE,'message'=>"Deleted from User Group"));
			}
			else if($rnum_rows==0)
			{
				//INSERT
				$query_insert = "INSERT INTO tbl_user_role (id_user, id_role) VALUES (".$user_id.",".$id.")";
				$result_insert = $connection->query($query_insert);
				if($result_insert)
					echo json_encode(array('success'=>TRUE,'message'=>"Updated User Group"));
			}
		} 

		if(isset($_GET['unregister']))
		{
			$query_delete_unregister = "DELETE FROM tbl_users WHERE id_user=".$_GET['unregister'];
			$result_delete_unregister = $connection->query($query_delete_unregister);
			if($result_delete_unregister)
					echo json_encode(array('success'=>TRUE,'message'=>"Unregister user Deleted!"));
			
		}		
		
		if(isset($_GET['activation']))
		{
			$query_active_user = "UPDATE tbl_users SET active_user=1 WHERE id_user=".$_GET['activation'];
			$result_active_user = $connection->query($query_active_user);
			
			$query_learner_role = "INSERT INTO tbl_user_role(id_user, id_role) VALUES (".$_GET['activation'].",6)";
			$result_learner_role = $connection->query($query_learner_role);
			
			if($result_learner_role)
					echo json_encode(array('success'=>TRUE,'message'=>"User activated!"));
			
		}

?>