<?php
	include "session.php";

	//check googleplus disconnect
	if ($_SESSION['GPTOKEN']){
		header('Location: ../gpconnect.php?disconnect=1');
	}else{
		header('Location: ../index.php'); 
		$_SESSION['AUTHENTICATION'] = "";
		session_destroy();
	}


?>
