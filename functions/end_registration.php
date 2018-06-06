 <?php
	include "conf.php";
	
	
	if(!isset($_POST['reg_email']))
	{
		die(msg(0,"You must fill your registration email!"));
	}
	
	if($_POST['reg_email'] == '')
	{
		die(msg(0,"You must fill your registration email!"));
	}
	else
	{
		$query_select = "SELECT id_user FROM tbl_users WHERE email_user ='".$_POST['reg_email']."' AND active_user>1";
		$result_select = $connection->query($query_select);
		$obj = mysqli_fetch_object($result_select);
		$row_cnt = $result_select->num_rows;
		if($row_cnt>0)
		{
			$query_update = "UPDATE tbl_users SET active_user=1 WHERE email_user='".$_POST['reg_email']."'";
			$result_update = $connection->query($query_update);
			
			
			$query_user_role="INSERT INTO tbl_user_role(id_user, id_role) VALUES (".$obj->id_user.",6)";
			$results_user_role = $connection->query($query_user_role);
			
			die(msg(0,"Your registration has finished!<br>You can now login<br>Thank you! "));
			
		}
		else
		{
			die(msg(0,"You use wrong email to finish your registration!"));
		}
	}
	
	
	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}
?>
