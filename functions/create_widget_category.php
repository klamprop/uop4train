<?php
	include "conf.php";
		
		
		$flag=NULL;
		if(isset($_POST['category_name']) && isset($_POST['active']) && $_POST['update'] == '0')
		{
		
			$query_select= "SELECT id_category_widget ,name_category_widget ,active_category_widget FROM tbl_category_widget";
			$result_select = $connection->query($query_select);
			
			while($row = $result_select->fetch_array()){
				$id=$row[0];
				$name=$row[1];
				$active=$row[2];
				
				if($name == $_POST['category_name'])
				{$flag = 1;}
			}

		
			if(!empty($_POST['category_name'])&& ($flag!=1))
			{
				
				$query_edit_category = "INSERT INTO tbl_category_widget(name_category_widget, active_category_widget) VALUES ('".$_POST['category_name']."',".$_POST['active'].")";
				//echo $query_edit_category;
				$result_edit_category = $connection->query($query_edit_category);
							
				$id_item = $connection->insert_id;
			  
				//echo $id_item;
				if($id_item>0)
				{
					die(msg(1,"Category saved!"));
				}
			}
			else
			{
				die(msg(0,"All the fields are required!"));
				
				
			}
			
			
			
			
		}
		else if(isset($_POST['category_id']) &&  $_POST['update'] == '1')
		{
			if(!empty($_POST['category_id']) && !empty($_POST['category_name']))
			{
				$query_edit_category = "UPDATE tbl_category_widget SET name_category_widget='".$_POST['category_name']."',active_category_widget=".$_POST['active']." WHERE id_category_widget=".$_POST['category_id'];				
				$result_edit_category = $connection->query($query_edit_category);
				die(msg(1,"Category saved!"));
			}
			else
			{
				die(msg(0,"All the fields are required!"));
			}
	
	
		}
		else
		{
			
			
			die(msg(0,"All the fields are required!"));
		}

		
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
	
	function test_input($data) {
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
	}

?>