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
	if(isset($_POST["categoryid"]))
	{
		if($_POST["categoryid"]>0)
		{
			$query_select = "SELECT active FROM tbl_category_courses WHERE id=".$_POST["categoryid"];
			$result_select = $connection->query($query_select);
			
			while($row = $result_select->fetch_array()){
				$active_category=$row[0];
			}
			if(isset($active_category))
			{
				if($active_category==0)
				{
					$query_activate = "UPDATE tbl_category_courses SET active=1 WHERE id=".$_POST["categoryid"];
					$result_activate = $connection->query($query_activate);
					die(msg(1,"Activate"));
				}
				else if ($active_category==1)
				{
					$query_deactivate = "UPDATE tbl_category_courses SET active=0 WHERE id=".$_POST["categoryid"];
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
		die(msg(0,"No Valid Category oopsie"));
	}
	
	function msg($status,$txt1)
	{
	
		return '{"status":"'.$status.'","txt":"'.$txt1.'"}';
	}
 ?>
