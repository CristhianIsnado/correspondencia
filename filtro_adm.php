<?php
session_start();
if ($_SESSION["autentificado"] != "SI" || $_SESSION["nivel"] =='1')
{
	session_start();
	session_unset();
	session_destroy();
	header ("location: index.php"); 
	exit();
}	
?>
