<?php
//	include "session.php"; SOS KOsta why do we need this?
	include "conf.php";
	include "access_role.php";

		$data_table_project='';

		$query_select_project = "SELECT id, name, active FROM tbl_project";

		$result_select_project = $connection->query($query_select_project);
		$i_project=0;
		$data_table_project='<div id="test-list"><div class="row"><div"><input type="text" class="form-control search" style="border-radius:1px;" placeholder="Search by Project Name" /></div></div><table class="table" ><tbody class="list">';
		$data_table_project.="<tr><td class=\"name\" style=\"border:none;\"><a href=\"all_course.php\">All projects</a></td></tr>";
		while($row = $result_select_project->fetch_row()){
			 $id = $row[0];
			 $name = $row[1];
			if($row[2]==0){
			$active_prj = "fa fa-square-o";
			} else if($row[2]==1){
			$active_prj = "fa fa-check-square-o";
			}
			$data_table_project.="<tr><td class=\"name\" style=\"border:none;\"><a href=\"all_course.php?project_id=".$row[0]." \">".$row[1]."</a></td></tr>";
		/*	if(accessRole("NEW_EDIT_DELETE_CATEGORY_COURSE",$connection))
			{
			$data_table_category.="<i class=\"fa fa-pencil\"></i></a></td><td style=\"\" class=\"right\"><a href=\"#\" onclick=\"activate_category(".$row[0]."); return false;\"><i id=\"category".$row[0]."\" class=\"".$active_cat."\"></i></a></td></tr>";
			}
			$i_category++;*/
		}
		$data_table_project.="</tbody></table><ul class=\"pagination\"></ul></div><SCRIPT>var monkeyList = new List('test-list', {valueNames: ['name'], page: 10,plugins: [ ListPagination({}) ] });</SCRIPT>";

		echo $data_table_project;


			/*}

	}*/

?>
