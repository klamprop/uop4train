 <?php

	include "conf.php";
/*
		if (isset($_GET['roleid']) ) {
			$roleid = $_GET['roleid'];
			$functionid = $_GET['functionid'];
			
			$query_select = "SELECT tbl_role_functionality.id_role FROM  tbl_role_functionality WHERE tbl_role_functionality.id_role=".$roleid." AND tbl_role_functionality.id_functionality=".$functionid;
			$result_select = $connection->query($query_select);
			
			$rnum_rows = $result_select->num_rows;

			if ($rnum_rows>0)
			{
				//DELETE
				$query_delete = "DELETE FROM tbl_role_functionality WHERE tbl_role_functionality.id_role=".$roleid." AND tbl_role_functionality.id_functionality=".$functionid;

				$result_delete = $connection->query($query_delete);
				//if(mysql_query($query_delete))
				if($result_delete)
					echo json_encode(array('success'=>TRUE,'message'=>"Deleted from User Group"));
			}
			else if($rnum_rows==0)
			{
				//INSERT
				$query_insert = "INSERT INTO tbl_role_functionality (id_role, id_functionality) VALUES (".$roleid.",".$functionid.")";

				$result_insert = $connection->query($query_insert);
				if($result_insert)
					echo json_encode(array('success'=>TRUE,'message'=>"Updated User Group"));
			}
		}        
   */

		/*$_GET['roleid']='7';
		$_GET['functionid']='VIEW_COURSE';
		*/
		if (isset($_GET['roleid']) ) {
			$roleid = $_GET['roleid'];
			$functionid = $_GET['functionid'];
			
			$query_select = "SELECT id_role FROM  match_action_role WHERE id_role=".$roleid." AND action='".$functionid."'";

			$result_select = $connection->query($query_select);
			
			$rnum_rows = $result_select->num_rows;
			
			if ($rnum_rows>0)
			{
				//DELETE
				$query_delete = "DELETE FROM match_action_role WHERE id_role=".$roleid." AND action='".$functionid."'";
				
				$result_delete = $connection->query($query_delete);
				//if(mysql_query($query_delete))
				if($result_delete)
					echo json_encode(array('success'=>TRUE,'message'=>"Deleted from User Group"));
			}
			else if($rnum_rows==0)
			{
				//INSERT
				$query_insert = "INSERT INTO match_action_role (id_role, action) VALUES (".$roleid.",'".$functionid."')";

				$result_insert = $connection->query($query_insert);
				if($result_insert)
					echo json_encode(array('success'=>TRUE,'message'=>"Updated User Group"));
			}
		}

?>