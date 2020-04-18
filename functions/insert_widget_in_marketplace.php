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
	$query_install_widget = "INSERT INTO tbl_install_widget(widget_id, user_id, url_widget, title_widget, author_widget, description_widget, marketplace_id, version) VALUES (".$_POST["widgetid"].",".$_POST["userid"].",'".$_POST["url_widget"]."','".$_POST["title_widget"]."','".$_POST["author_widget"]."','".$_POST["description_widget"]."',".$_POST["marketplace_id"].",'".$_POST["version"]."')";
	$result_install_widget = $connection->query($query_install_widget);
	
	if($result_install_widget)
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
