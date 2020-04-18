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
	if($_POST['cid']>0)
	{
		//insert
		
		$query_select = "SELECT url_widget,description_widget FROM tbl_install_widget WHERE id=".$_POST['cid']." AND user_id=".$_POST["userid"];
		$result_select = $connection->query($query_select);
		
		while($row = $result_select->fetch_array())
		{
			die(msg(1,$row[0]."|".$row[1]));
		}
	}
	else
	{
		die(msg(0,"Wrong data!"));
	}
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
	
?>
