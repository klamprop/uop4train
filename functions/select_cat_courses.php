<?php
	include "session.php";
	include "conf.php";
	include "access_role.php";
	
		$data_table_category='';
	
		$query_select_category = "SELECT id, name, active FROM tbl_category_courses ";
				
		$result_select_category = $connection->query($query_select_category);
		$i_category=0;
		$data_table_category='<div id="test-list"><div class="row"><div class="col-sm-4 "><input type="text" class="form-control search" placeholder="Search by Category Name" /></div></div><table class="table"><thead><tr><td class="sort" data-sort="name" style="width:75%;">Name</td><td class="sort">Action</td><td class="sort">Active</td></tr></thead><tbody class="list">';
		while($row = $result_select_category->fetch_row()){
			 $id = $row[0];
			 $name = $row[1];
			if($row[2]==0){ 
			$active_cat = "fa fa-square-o";
			} else if($row[2]==1){
			$active_cat = "fa fa-check-square-o";
			}
			$data_table_category.="<tr><td class=\"name\">".$row[1]."</td><td style=\"\" class=\"right\"><a href=\"add_course_category.php?id=".$id."\">";
			if(accessRole("NEW_EDIT_DELETE_CATEGORY_COURSE",$connection))
			{
			$data_table_category.="<i class=\"fa fa-pencil\"></i></a></td><td style=\"\" class=\"right\"><a href=\"#\" onclick=\"activate_category(".$row[0]."); return false;\"><i id=\"category".$row[0]."\" class=\"".$active_cat."\"></i></a></td></tr>";
			}
			$i_category++;
		}
		$data_table_category.="</tbody></table><ul class=\"pagination\"></ul></div><SCRIPT>var monkeyList = new List('test-list', {valueNames: ['name'], page: 10,plugins: [ ListPagination({}) ] });</SCRIPT>";
		
		echo $data_table_category;	
		
		
			/*}
		
	}*/

?>