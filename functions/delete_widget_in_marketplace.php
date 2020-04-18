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
	$query_delete_widget="DELETE FROM tbl_install_widget WHERE user_id=".$_POST['userid']." AND widget_id=".$_POST['widgetid']." AND marketplace_id=".$_POST['marketid'];
	$delete_widget=$connection->query($query_delete_widget);
	if($delete_widget)
	{
		die(msg(1,"Installed"));
	}
	else
	{
		die(msg(0,"error"));
	}
		
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}

?>
