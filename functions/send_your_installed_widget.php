<?php
	include "conf.php";
	
	$query_install_widget = "SELECT widget_id FROM tbl_install_widget WHERE user_id =".$_POST["userid"]." AND marketplace_id =".$_POST["marketid"];
	$result_install_widget = $connection->query($query_install_widget);

	$json_result_widget='';
	$count_widget=0;
	$json_result_widget .= '{\"mywidget\":[';
	while($row = $result_install_widget->fetch_array())
	{	
		if($count_widget>0)
		{
			$json_result_widget .= ',';
		}
		$widget_id[$count_widget] = $row[0];
		$json_result_widget .= '{\"widgetid\":\"'.$row[0].'\"}';
		
		$count_widget++;
	}	
	$json_result_widget .= ']}';
	
	if(!empty($json_result_widget))
	{
		die(msg(1,$json_result_widget));
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