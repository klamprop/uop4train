<?php

	include "conf.php";
	
	$query_your_widget="SELECT tbl_install_widget.title_widget, tbl_install_widget.author_widget, tbl_install_widget.description_widget, tbl_install_widget.widget_id, tbl_install_widget.marketplace_id, tbl_repository.name FROM tbl_install_widget INNER JOIN tbl_repository ON tbl_install_widget.marketplace_id = tbl_repository.id WHERE user_id=".$_POST['userid'];//." AND marketplace_id= ".$_POST['marketid'];
	
	$result_your_widget = $connection->query($query_your_widget);
	
	$json_array='';
	
	//echo $query_your_widget;
	$count_widget=0;
	$json_array .='{"widgets":[';
	while($row = $result_your_widget->fetch_array())
	{
		
		if($count_widget>0)
		{
			$json_array .=',';
		}
		$json_array .= '{"id":"'.$row[3].'","marketplace_id":"'.$row[4].'","author":"'.$row[1].'","name":"'.$row[0].'","note":"'.$row[2].'","repository_name":"'.$row[5].'"}';
		$count_widget++;
	}
	$json_array.=']}';
	//echo json_encode($json_array);

	die(msg("0", json_encode($json_array)));
	//die(msg("0", $json_array));
	function msg($status,$txt1)
	{
		//return '{"status":'.$status.',"txt":'.$txt1.'}';
		//$txt = '['.$txt1.']';
		return '{"status":'.$status.',"txt":'.$txt1.'}';
	}

?>