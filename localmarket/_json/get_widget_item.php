 <?php
		include "../../functions/conf.php";	
		
		if(!isset($_POST["widget_id"]))
		{
			die(msg(1,"error"));
		}
		
		$query_widget_item = "SELECT url_widget_meta_data, title_widget_meta_data, author_widget_meta_data, description_widget_meta_data, simage_widget_meta_data, active_widget_meta_data, version_widget_meta_data FROM  tbl_widget_meta_data WHERE id_widget_meta_data =".$_POST["widget_id"];
		//$result_widget_item = mysql_query($query_widget_item);
		$result_widget_item = $connection->query($query_widget_item);
		//while($row = mysql_fetch_array($result_widget_item))
		$json_result_widget='';
		while($row = $result_widget_item->fetch_array())
		{	
			$url_widget_meta_data = $row[0];
			$title_widget_meta_data = $row[1];
			$author_widget_meta_data = $row[2];
			$description_widget_meta_data = $row[3];
			$simage_widget_meta_data = $row[4];
			$active_widget_meta_data = $row[5];
			$version_widget_meta_data = $row[6];
			
			$descript = str_replace("\n",htmlentities("&lt;br&gt;"),htmlentities($row[3]));
			
			/*$json_result_widget .= '{\"widget\":[';
			$json_result_widget .= '{\"url\":\"'.$row[0].'\",\"title\":\"'.$row[1].'\",\"author\":\"'.$row[2].'\",\"description\":\"'.htmlspecialchars_decode($row[3]).'\",\"simage\":\"'.$row[4].'\",\"active\":\"'.$row[5].'\",\"version\":\"'.$row[6].'\"}';
			$json_result_widget .= ']}';*/
			$json_result_widget .= '{"widget":[';
			$json_result_widget .= '{"url":"'.$row[0].'","title":"'.$row[1].'","author":"'.$row[2].'","description":"'.$descript.'","simage":"'.$row[4].'","active":"'.$row[5].'","version":"'.$row[6].'"}';
			$json_result_widget .= ']}';
		}	
		
		$query_widget_screenshot = "SELECT screenshot_name FROM tbl_widget_screenshot WHERE widget_id=".$_POST["widget_id"];

		$result_widget_screenshot = $connection->query($query_widget_screenshot);
		$count=0;
		$json_result_widget_screenshot = '[';
		//$json_result_widget_screenshot = '{\"screenshots\":[';		
				
		while($row = $result_widget_screenshot->fetch_array())
		{	
			if($count>0)
			{
				$json_result_widget_screenshot .= ',';
			}
			$screenshot_name[$count] = $row[0];
			//$json_result_widget_screenshot .= '{\"screenshot'.$count.'\":\"'.$row[0].'\"}';
			$json_result_widget_screenshot .= '{"screenshot'.$count.'":"'.$row[0].'"}';
			
			$count++;
		}
		$json_result_widget_screenshot .= ']';
		//$json_result_widget_screenshot .= ']}';
		if($count==0)
		{
			$json_result_widget_screenshot="";
		}
		if(!empty($title_widget_meta_data))
		{
			die(msg(0,$json_result_widget,$json_result_widget_screenshot));
		}
		else
		{
			die(msg(1,"error",""));
		}
				
		function msg($status,$txt,$txt1)
		{
			return '{"status":'.$status.',"txt":'.json_encode($txt).',"txt1":'.json_encode($txt1).'}';
		}
	
?>
