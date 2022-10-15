<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
$variable=descryto($_GET['sel_usuario']);
$conn=Conectarse();
?>

<?php
$ssql="SELECT * FROM usuario where usuario_cod_usr='$variable'";
$rss=mysqli_query($conn, $ssql);
	if (!empty($rss)) 
	{
	while($row=mysqli_fetch_array($rss))
	{
	$usuario=$row["usuario_cod_usr"];
	$depto=$row["usuario_cod_departamento"];
	$ocupacion=$row["usuario_ocupacion"];
	$fecha=date("Y-m-d")." ".date("H:i:s");
mysqli_query($conn, "insert into liberar (liberar_cod_usr,liberar_fecha,liberar_depto,liberar_ocupacion)
VALUES ('$usuario','$fecha','$depto','$ocupacion')") or die ("No se Guardo el archivo");
	}
mysqli_query($conn, "UPDATE usuario SET usuario_ocupacion='0',usuario_active='0' WHERE usuario_cod_usr='$variable'") or die("No se Guardo el Registro");
mysqli_query($conn, "UPDATE miderivacion SET miderivacion_estado='0' WHERE miderivacion_su_codigo='$ocupacion'") or die("No se Guardo el Registro");	
mysqli_query($conn, "UPDATE asignar SET asignar_estado='0' WHERE asignar_su_codigo='$ocupacion'") or die("No se Guardo el Registro");	
	
	?>
    <script language='JavaScript'> 
	window.self.location="adminusuarios.php"
	</script>
	<?php
    }
	?>
