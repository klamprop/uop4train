<?php
//	include "session.php"; SOS Kosta why do we need this?
	include "conf.php";
	include "access_role.php";

		$data_table_category='';

		$query_select_category = "SELECT id, name, active FROM tbl_category_courses ";

		$result_select_category = $connection->query($query_select_category);
		$i_category=0;
		$data_table_category='<div id="test-list"><div class="row"><div"><input type="text" class="form-control search" style="border-radius:1px;" placeholder="Search by Category Name" /></div></div><table class="table" ><tbody class="list">';
	//	$data_table_category.="<tr><td class=\"name\" style=\"border:none;\"><a href=\"all_course.php\">All categories</a></td></tr>";
		while($row = $result_select_category->fetch_row()){
			 $id = $row[0];
			 $name = $row[1];
			if($row[2]==0){
			$active_cat = "fa fa-square-o";
			} else if($row[2]==1){
			$active_cat = "fa fa-check-square-o";
			}
//		FOR SMESEC ADJUSTMENT - 	$data_table_category.="<tr><td class=\"name\" style=\"border:none; font-weight:bold;\"><a style=\"color:#000000;\" href=\"all_course.php?course_category_id=".$row[0]." \">".$row[1]."</a></td></tr>";
			$data_table_category.="<tr><td class=\"name\" style=\"border:none; font-weight:bold;\"><a style=\"color:#000000;\" href=\"#\" \">".$row[1]."</a></td></tr>";


		/*	if(accessRole("NEW_EDIT_DELETE_CATEGORY_COURSE",$connection))
			{
			$data_table_category.="<i class=\"fa fa-pencil\"></i></a></td><td style=\"\" class=\"right\"><a href=\"#\" onclick=\"activate_category(".$row[0]."); return false;\"><i id=\"category".$row[0]."\" class=\"".$active_cat."\"></i></a></td></tr>";
			}
			$i_category++;*/
		}
		$data_table_category.="</tbody></table><ul class=\"pagination\"></ul></div><SCRIPT>var monkeyList = new List('test-list', {valueNames: ['name'], page: 10,plugins: [ ListPagination({}) ] });</SCRIPT>";

		echo $data_table_category;


			/*}

	}*/

?>
