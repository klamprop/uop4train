<?php
	include "session.php";

	//check googleplus disconnect
	if ($_SESSION['GPTOKEN']){
		header('Location: ../gpconnect.php?disconnect=1');
		
		
	}	else{
		header('Location: https://keycloak.smesec.eu/auth/realms/SMESEC/protocol/openid-connect/logout?redirect_uri=https://securityaware.me'); 
		$_SESSION['AUTHENTICATION'] = "";
		session_destroy();
		
	}


?>
