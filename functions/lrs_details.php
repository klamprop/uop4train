<?php
	
	
	include "conf.php";
	include "session.php";
	
	if(isset($_GET["action"]))
	{
		if($_GET["action"] == "ins")
		{
			$query_insert="INSERT INTO lrs_details (uid, lrs_name, endpoint_url, username, password) VALUES (".$_SESSION["USERID"].",'".$_POST["lrs_name"]."','".$_POST["lrs_endpoint"]."','".$_POST["lrs_username"]."','".$_POST["lrs_password"]."')";
			$connection->query($query_insert);
			table_view($connection);
		}
		
		if($_GET["action"] == "upd" && isset($_GET["id"]))
		{
			$query_update="UPDATE lrs_details SET uid=".$_SESSION["USERID"].",lrs_name='".$_POST["lrs_name"]."',endpoint_url='".$_POST["lrs_endpoint"]."',username='".$_POST["lrs_username"]."',password='".$_POST["lrs_password"]."' WHERE id=".$_GET["id"];
			$connection->query($query_update);
			
			table_view($connection);
		}
		
		if($_GET["action"] == "del" && isset($_GET["id"]))
		{
			$query_delete = "DELETE FROM lrs_details WHERE id=".$_GET["id"];			
			$connection->query($query_delete);
			
			table_view($connection);
		}
		
		if($_GET["action"] == "sel" && !isset($_GET["id"]))
		{
			table_view($connection);
		}
		
		if(isset($_GET["id"]))
		{
			if($_GET["action"] == "sel" && !empty($_GET["id"])){
				$query_select = "SELECT id,uid,lrs_name,endpoint_url, username, password FROM lrs_details WHERE uid=".$_SESSION["USERID"]." AND id=".$_GET["id"];
				$result_select = $connection->query($query_select);
				$txt_return="";
				while($row = $result_select->fetch_array())
				{
					$txt_return .= "id:".$row[0]."|uid:".$row[1]."|lrs_name:".$row[2]."|endpoint_url:".$row[3]."|username:".$row[4]."|password:".$row[5];
				}
				die(msg(1,$txt_return));
			}
			//table_view($connection);
		}
	}
	
	function table_view($connection){
		
		$query_select = "SELECT id,uid,lrs_name,endpoint_url, username, password FROM lrs_details WHERE uid=".$_SESSION["USERID"];
		$result_select = $connection->query($query_select);
		$txt_return="";
		while($row = $result_select->fetch_array())
		{
			$txt_return .= "<tr><td>".$row[2]."</td><td>".$row[3]."</td><td><a href=\"#\" onclick=\"delete_lrs(".$row[0].");return false;\"><i class=\"fa fa-times\"></i></a>&nbsp;|&nbsp;<a href=\"#\" onclick=\"edit_lrs(".$row[0].");return false;\"><i class=\"fa fa-pencil-square-o\"></i></a></td> </tr>";
		}
		die(msg(1,$txt_return));
	}
	
	function msg($status,$txt)
	{
		//return '{"status":'.$status.',"txt":"'.$txt.'"}';
		return $txt;
	}
	
?>