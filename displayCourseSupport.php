<?php 



include "functions/session.php";

	if(!isset($_SESSION)){
		http_response_code(403);
		include('403error.html'); // provide your own HTML for the error page
		die();
	}
	
	if(!is_numeric($_SESSION['USERID'])){
		http_response_code(403);
		include('403error.html'); // provide your own HTML for the error page
		die();
	}





	include "header.php"; 

	if ($_POST['url'])
		include $_POST['url'];
	else
		include $_GET['url'];


	include "footer.php"; 
?>
