<?php
	include "conf.php";
	
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