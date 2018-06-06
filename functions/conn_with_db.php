<?php

function conn_with_db($database_host, $database_username, $database_password,$db_name)
{
	return mysqli_connect($database_host, $database_username, $database_password,$db_name);
}

?>