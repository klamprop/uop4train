<?php
	include "conf.php";
	if(isset($_POST["categoryid"]))
	{
		if($_POST["categoryid"]>0)
		{
			$query_select = "SELECT active_category_widget FROM tbl_category_widget WHERE id_category_widget=".$_POST["categoryid"];
			
			$result_select = $connection->query($query_select);
			
			while($row = $result_select->fetch_array()){
				$active_category=$row[0];
			}
			
			if(isset($active_category))
			{
				if($active_category==0)
				{
					$query_activate = "UPDATE tbl_category_widget SET active_category_widget=1 WHERE id_category_widget=".$_POST["categoryid"];
					
					$result_activate = $connection->query($query_activate);
					die(msg(1,"Activate"));
				}
				else if ($active_category==1)
				{
					$query_deactivate = "UPDATE tbl_category_widget SET active_category_widget=0 WHERE id_category_widget=".$_POST["categoryid"];
					
					$result_deactivate = $connection->query($query_deactivate);
					die(msg(1,"Deactivate"));
				}
			}
			else
			{
				die(msg(0,"No Valid Category"));
			}
		}
		else
		{
			die(msg(0,"No Valid Category"));
		}
		
	}
	else
	{
		die(msg(0,"No Valid Category"));
	}
	
	function msg($status,$txt1)
	{
	
		return '{"status":"'.$status.'","txt":"'.$txt1.'"}';
	}
 ?>