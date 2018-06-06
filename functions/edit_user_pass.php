<?php
	include "conf.php";
	include "session.php";
		
		
		
		
		if(isset($_POST['oldpass']) | isset($_POST['newpass']) | empty($_POST['newpass2']))
		{	
		
			// define variables and set to empty values
			$name = $email = $gender = $comment = $website = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			  $oldpass = test_input($_POST["oldpass"]);
			  $newpass = test_input($_POST["newpass"]);
			  $newpass2 = test_input($_POST["newpass2"]);
			 
			}

			
				    
					
			if(!empty($_POST['oldpass']) && !empty($_POST['newpass']) && !empty($_POST['newpass2']) )
			{	
				//retrieve old password in order to check
				$query_select_pass = "SELECT password_user FROM tbl_users WHERE active_user=1 AND id_user=".$_SESSION["USERID"];
				$result_select_pass = $connection->query($query_select_pass);
	
				while($row = $result_select_pass->fetch_array())
				{
					$pass = $row[0];
				}
				
				
				$enOldPass =	md5($oldpass);
				if($pass == $enOldPass){
					if($newpass2 == $newpass){
						$updPass = md5($newpass);
						
						$query_update_user = "UPDATE tbl_users SET password_user='$updPass'  WHERE active_user=1 AND id_user=".$_SESSION['USERID'];
																
						//echo $query_update_user;										
						$result_update_user = $connection->query($query_update_user);
						
						
						die(msg(1,"User Password updated!"));
						
					}else{
						die(msg(0,"New Password and Confirmation Password missmatch"));
					
					}
				}else{
				
					die(msg(0,"Wrong Password,Please type again you password!"));
				
				}
					
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