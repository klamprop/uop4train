<?php 
	include "header.php"; 

	if ($_POST['url'])
		include $_POST['url'];
	else
		include $_GET['url'];


	include "footer.php"; 
?>
