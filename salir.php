<?php
include("conecta.php");
$conn = Conectarse();
session_start();
$login_id = $_SESSION["login_id"];
$fecha_salida = date("Y-m-d");
$hora_salida = date("H:i:s");
mysqli_query($conn, "UPDATE login set login_fecha_salida='$fecha_salida', login_hora_salida='$hora_salida' WHERE login_id='$login_id'");
session_unset();
session_destroy();
header ("location: index.php"); 
?>
