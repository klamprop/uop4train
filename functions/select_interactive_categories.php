<?php
	include "conf.php";
	$data_table_category='';
	
		$query_select_category = "SELECT id, category, active FROM tbl_category_interactive_course_part ";
				
		$result_select_category = $connection->query($query_select_category);
		$i_category=0;
		$data_table_category='<table class="table"><thead><tr><th class="text-left" style="width:75%;">Name</th><th class="text-left">Action</th><th class="text-left">Active</th></tr></thead><tbody>';
		while($row = $result_select_category->fetch_row()){
			if($row[2]==0){ 
			$active_cat = "icon-checkbox-unchecked";
			} else if($row[2]==1){
			$active_cat = "icon-checkbox";
			}
			$data_table_category.="<tr><td class=\"right\">".$row[1]."</td>";
			if(accessRole("NEW_EDIT_DELETE_WIDGET_CATEGORY",$connection))
			{
				$data_table_category.="<td class=\"right\"><a href=\"create_interactive_part_category.php?category_id=".$row[0]."\"><i class=\"icon-pencil\"></i></a></td><td class=\"right\"><a href=\"#\" onclick=\"activate_category(".$row[0]."); return false;\"><i id=\"category".$row[0]."\" class=\"".$active_cat."\"></i></a></td>";
			}
			$data_table_category.="</tr>";
		
			$i_category++;
		}
		$data_table_category.='</tbody><tfoot></tfoot></table>';
		
		echo $data_table_category;	

?>