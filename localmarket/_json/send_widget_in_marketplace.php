<?php
		include "../../functions/conf.php";		 

		$query_widget="SELECT id_widget_meta_data, url_widget_meta_data, title_widget_meta_data, sdescription_widget_meta_data, simage_widget_meta_data FROM tbl_widget_meta_data WHERE active_widget_meta_data =1";
			
		$result_widget = $connection->query($query_widget);
		
		$num_rows_widget = $result_widget->num_rows;
		
		$count_widget=0;
		
		$json_result_widget = '{"widget":[';
	
		while($row2 = $result_widget->fetch_array())
		{			
			$widget_category="";
			$query_widget_category = "SELECT id_category_widget FROM tbl_widget_match_with_category WHERE id_widget_meta_data =".$row2[0];
				
			$result_widget_category = $connection->query($query_widget_category);
			
			while($row3 = $result_widget_category->fetch_array())
			{	
				$widget_category .= " category".$row3[0];
			}
			$sdescript = str_replace("\n",htmlentities("&lt;br&gt;"),htmlentities($row2[3]));
			$json_result_widget .= '{"id":"'.$row2[0].'","url":"'.$row2[1].'","title":"'.$row2[2].'","sdescription":"'.$sdescript.'","simage":"'.$row2[4].'","categories":"'.$widget_category.'"}';
		
			if($num_rows_widget-1>$count_widget){
				$json_result_widget .=",";
				}
			$count_widget++;
		}
		
		$json_result_widget .= ']}';
		
		die(msg(0,$json_result_widget));
		
		function msg($status,$txt)
		{
			return '{"status":'.$status.',"txt":'.json_encode($txt).'}';
			//return '{"status":'.$status.',"txt":"'.$txt.'"}';
		}
	
?>
