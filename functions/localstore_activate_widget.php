<?php
	include "conf.php";		
		//$_POST["widgetid"]=8;
	if(isset($_POST["widgetid"]))
	{
		if($_POST["widgetid"]>0)
		{
		
			$query_select = "SELECT active_widget_meta_data FROM tbl_widget_meta_data WHERE id_widget_meta_data=".$_POST["widgetid"];
			$result_select = $connection->query($query_select);
			
			while($row = $result_select->fetch_array()){
				$active_widget=$row[0];
			}
			if($active_widget==0)
			{
				$query_activate = "UPDATE tbl_widget_meta_data SET active_widget_meta_data=1 WHERE id_widget_meta_data=".$_POST["widgetid"];
				$result_activate = $connection->query($query_activate);
				die(msg(1,"Activate"));
			}
			else if ($active_widget==1)
			{
				$query_deactivate = "UPDATE tbl_widget_meta_data SET active_widget_meta_data=0 WHERE id_widget_meta_data=".$_POST["widgetid"];
				$result_deactivate = $connection->query($query_deactivate);
				die(msg(1,"Deactivate"));
			}
		}
		else
		{
			die(msg(0,"No Valid Widget"));
		}
	}
	else
	{
		die(msg(0,"No Valid Widget"));
	}
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
		
?>