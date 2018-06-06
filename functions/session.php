<?php
	ini_set('session.cookie_path', ''); //fixes installation on other paths
	
	session_set_cookie_params(86400,"/");
	
	session_start();
	
  
  
	//include "conf.php";
	
	//if (!isset($_SESSION['SESSION'])) include ( "session_init.php");
	if(!isset($_SESSION['lrs_login_record']))
	{
		$_SESSION['lrs_login_record']=0;
	}
	
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
		
		$Select_user_query="SELECT id_user,name_user,surname_user,email_user FROM tbl_users WHERE email_user='".addslashes($_POST['username'])."' AND  password_user=MD5('".addslashes($_POST['password'])."') AND active_user=1";		
		//$result = mysql_query($Select_user_query);
		$result = $connection->query($Select_user_query);
		
		//$row = mysql_fetch_row($result);
		while($row = $result->fetch_row())
		{
			if(!empty($row[0]))
			{
							
				$_SESSION['AUTHENTICATION'] = true;
				$_SESSION['USERID'] = $row[0];
				$_SESSION['EMAIL'] = $row[3];
				$_SESSION['FNAME'] = $row[1];
				$_SESSION['LNAME'] = $row[2];
				
				$_SESSION['UROLE']="";
				$_SESSION['UROLE_ID']="";
				$Select_user_role_query="SELECT tbl_role.name_role,tbl_role.id_role FROM tbl_role INNER JOIN tbl_user_role ON tbl_role.id_role=tbl_user_role.id_role WHERE tbl_user_role.id_user=".$_SESSION['USERID'];	
				//$result_user_role = mysql_query($Select_user_role_query);
				$result_user_role = $connection->query($Select_user_role_query);
				$count_roles=0;
				//while($row1 = mysql_fetch_array($result_user_role)){
				while($row1 = $result_user_role->fetch_array()){
					if($count_roles>0)
					{
						$_SESSION['UROLE'] .= "/".$row1[0];	
						$_SESSION['UROLE_ID'] .= "/".$row1[1];
					}
					else
					{
						$_SESSION['UROLE'] .= $row1[0];	
						$_SESSION['UROLE_ID'] .= $row1[1];
						
					}
					$count_roles++;
				}
				
				$update_tbluser_lastlogin = "UPDATE lrs_details SET last_login_date=NOW() WHERE id_user=".$_SESSION['USERID'];
				$result_update_tbluser_lastlogin = $connection->query($update_tbluser_lastlogin);
			}
			else
			{
				$_SESSION['AUTHENTICATION'] = "";
			}
		}
	}	
	
	
	
	if($_SESSION['USERID']==0)
	{
		$_SESSION['UROLE_ID'] = 7;
	}
	
	
?>
