<?php
	function accessRole($action,$connection)
	{
		
		if(count(explode("/",$_SESSION["UROLE_ID"]))>1)
		{
			$rid=explode("/",$_SESSION["UROLE_ID"]);
			$return_action=false;
			for($i=0;$i<count(explode("/",$_SESSION["UROLE_ID"]));$i++)
			{
				$query_select = "SELECT id FROM match_action_role WHERE id_role=".$rid[$i]." AND action='".$action."'";
				$result = mysqli_query($connection, $query_select);
				
				if( mysqli_num_rows($result)==1)
				{
					$return_action= true;	
				}
			}
		}
		else
		{
			$query_select = "SELECT id FROM match_action_role WHERE id_role=".$_SESSION["UROLE_ID"]." AND action='".$action."'";
			$result = mysqli_query($connection, $query_select);

			if(mysqli_num_rows($result)==0)
			{
				$return_action= false;
			}
			else if(mysqli_num_rows($result)==1)
			{
				$return_action= true;	
			}
		}
			
		return $return_action;
	}
	
?>