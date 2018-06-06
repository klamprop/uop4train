<?php

	
	include "conf.php";
	
	if(isset($_POST['email']))
	{
		if(!empty($_POST['email'])){
			
			
			$uid =0;
			
			$query_select_uid = "SELECT id_user FROM tbl_users WHERE email_user='".$_POST['email']."'";
			$result_select_uid = $connection->query($query_select_uid);
			
			/*$obj = mysqli_fetch_object($result_select_uid);
			$uid = $result_select_uid->num_rows;
		*/
			
			while($row = $result_select_uid->fetch_array())
			{
				$uid = $row[0];
			}
			
			if($uid > 0){
				
				$ative_number = generateRandomString(10);
				//die(msg(1,$ative_number));
				$updPass = md5($ative_number);
				$query_update_uid = "UPDATE tbl_users SET password_user='".$updPass."' WHERE id_user=".$uid;
				$result_update_uid = $connection->query($query_update_uid);
				
				//die(msg(1,$query_update_uid));
				
				
				$myemail = "<info@forgebox.eu>";
				
				
				$to = $_POST['email'];
				$email_subject = $InstallationSite." Forgot Password ";
				$email_body = 'Hi,<br /> Folow the link to change your password! <br /> <a href="http://www.forgebox.eu/fb/forgot_my_pass.php?actnum='.$updPass.'&mail='.$_POST['email'].'">Click here to change your password!</a> ';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";				
				$headers .= 'To: '. $to . "\r\n";
				$headers .= 'From: Forgebox.eu '. $myemail . " \r\n";
				mail($to,$email_subject,$email_body,$headers);
				
				die(msg(1,"You have an email in your mail account. Please follow the instuctions!"));
				
				
			}else{
				die(msg(1,"The email doesn't exist! Please try again!"));
			}
			
		}

	}
	
	
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
	
	function generateRandomString($length = 10) {
		$characters = '123456789ABCDEFGHIJKLMNOPQRSTWXYZabcdefghijklmnopqrstwxyz';
		$charactersLength = strlen($characters);
		$randomString = 'A';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	
?>