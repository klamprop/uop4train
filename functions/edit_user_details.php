<?php
	include "conf.php";
	include "session.php";
		
		
		
		
		if(isset($_POST['lastname']) | isset($_POST['firstname']) | empty($_POST['email']))
		{	
		
			// define variables and set to empty values
			$fname = $lname = $email = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			  $fname = test_input($_POST["firstname"]);
			  $lname = test_input($_POST["lastname"]);
			  $email = test_input($_POST["email"]);
			 
			}

			
				    
					
			if(!empty($_POST['lastname']) | !empty($_POST['firstname']) | !empty($_POST['email']) )
			{		
					
										
				$query_update_user = "UPDATE tbl_users SET name_user='$fname' ,surname_user='$lname' ,email_user='$email' WHERE active_user=1 AND id_user=".$_SESSION['USERID'];
														
				//echo $query_update_user;										
				$result_update_user = $connection->query($query_update_user);
				
				die(msg(1,"User  updated!"));
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