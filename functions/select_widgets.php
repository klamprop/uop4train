<?php
	include "session.php";
	include "conf.php";
	include "access_role.php";
	
	$table_data = "<table class=\"table\"><thead><tr><th style=\"width:35%;\"><b>Widget Name</b></th><th style=\"width:10%;\"><b>Edit</b></th><th style=\"width:15%;\"><b>Publish to Stores</b></th><th style=\"width:10%;\"><b>Delete</b></th><th style=\"width:20%;\"><b>Category</b></th><th style=\"width:10%;\"><b>Active</b></th></tr></thead><tbody>";
	
	$query_select_categories = "SELECT id_category_widget, name_category_widget FROM tbl_category_widget WHERE active_category_widget=1";
	$result_select_categories = $connection->query($query_select_categories);
	$count_cat =0;

	while($row = $result_select_categories->fetch_array()){
		$id_category_widget[$count_cat] = $row[0];
		$name_category_widget[$count_cat] = $row[1];
		$count_cat++;
	}
	$query_select_item = "SELECT id_widget_meta_data, title_widget_meta_data, active_widget_meta_data FROM tbl_widget_meta_data ";
	
	$result_select_item = $connection->query($query_select_item);
	$num_rows = $result_select_item->num_rows;
	$count_items=0;
	while($row1 = $result_select_item->fetch_array()){
		$query_select_cat = "SELECT tbl_category_widget.name_category_widget FROM tbl_widget_match_with_category INNER JOIN tbl_category_widget ON tbl_widget_match_with_category.id_category_widget = tbl_category_widget.id_category_widget INNER JOIN tbl_widget_meta_data ON tbl_widget_match_with_category.id_widget_meta_data = tbl_widget_meta_data.id_widget_meta_data WHERE tbl_widget_meta_data.id_widget_meta_data =".$row1[0];//active_category_widget=1 AND
		$result_select_cat = $connection->query($query_select_cat);
	
		$category_items="";
								
		while($row2 = $result_select_cat->fetch_array()){
			$category_items .=$row2[0]."<br />";									
		}
		if($row1[2]==1)
		{
			$table_data .= '<tr><td class="widget_name" style="width:35%;">'.$row1[1].'</td>';
			if(accessRole("NEW_EDIT_DELETE_WIDGET",$connection))
			{
			$table_data .= '<td class="edit" style="width:10%;"><a href="localstore_create_item_widget.php?widgetid='.$row1[0].'"><i class="fa fa-pencil"></i></a></td>';
			}
			else
			{
				$table_data .= '<td style="width:10%;"></td>';
			}
			if(accessRole("PUBLISH_TO_STORE_WIDGET",$connection))
			{
			$table_data .= '<td class="publish_to_store" style="width:10%;"><a href="#"><i class="fa fa-share-alt"></i></a></td>';
			}
			else
			{
				$table_data .= '<td class="publish_to_store" style="width:10%;"></td>';
			}
			if(accessRole("NEW_EDIT_DELETE_WIDGET",$connection))
			{
			$table_data .= '<td class="delete_widget" style="width:10%;"><a href="#"><i class="fa fa-codepen"></i></a></td>';
			}
			else
			{
				$table_data .= '<td style="width:10%;"></td>';
			}
			
			$table_data .= '<td class="category" style="width:20%;">'.$category_items.'</td>';
			if(accessRole("NEW_EDIT_DELETE_WIDGET",$connection))
			{
			$table_data .= '<td style="width:10%;"><a onclick="activation_action('.$row1[0].'); return false;" class="active_widget" href="#" data-artid="'.$row1[0].'"><i  id="function'.$row1[0].'" class="fa fa-check-square-o"></i></a></td>';
			}
			else
			{
				$table_data .= '<td style="width:10%;"></td>';
			}
			$table_data .= '</tr>';
		}
		else if($row1[2]==0)
		{
			$table_data .= '<tr><td class="widget_name" style="width:35%;">'.$row1[1].'</td><td class="edit" style="width:10%;"><a href="localstore_create_item_widget.php?widgetid='.$row1[0].'"><i class="icon-pencil"></i></a></td><td class="publish_to_store" style="width:10%;"><a href="#"><i class="fa fa-share-alt"></i></a></td><td class="delete_widget" style="width:10%;"><a href="#"><i class="fa fa-codepen"></i></a></td><td class="category" style="width:20%;">'.$category_items.'</td><td style="width:10%;"><a onclick="activation_action('.$row1[0].'); return false;" class="active_widget" href="#" data-artid="'.$row1[0].'"><i  id="function'.$row1[0].'" class="fa fa-square-o"></i></a></td></tr>';
		}
		$count_items++;
	}
	
	$table_data .="</tbody><tfoot></tfoot></table>";
	
	echo $table_data;
	
?>