<?php
	include "conf.php";
		
		
		$flag=NULL;
		if(isset($_POST['category_name']) && isset($_POST['active']) && isset($_POST['citem']) && $_POST['update'] == '0')
		{
		
			$query_select= "SELECT id ,name ,active FROM tbl_category_courses WHERE course_item_id =".$_POST['citem'];
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
				
				$query_edit_category = "INSERT INTO tbl_category_courses(name, active, course_item_id) VALUES ('".$_POST['category_name']."',".$_POST['active'].",'".$_POST['citem']."')";
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
				$query_edit_category = "UPDATE tbl_category_courses SET name='".$_POST['category_name']."',active=".$_POST['active']." WHERE id=".$_POST['category_id'];				
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