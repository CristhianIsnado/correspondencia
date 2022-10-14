<?php
session_start();
if ($_SESSION["autentificado"] != "SI") 
	{
	session_start();
	session_unset();
	session_destroy();
	header ("location: index.php"); 
	exit();
}	
?>
