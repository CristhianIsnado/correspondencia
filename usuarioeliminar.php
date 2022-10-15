<?php
include("filtro.php");
?>
<?php
include("inicio.php");
include("conecta.php");
$conn=Conectarse();
if (isset($codusuario))
{
  $elementos = 1;
  $cod_usuario[]= $codusuario;	
}
else
{
   $elementos = count($cod_usuario);
}


for($i=0; $i < $elementos; $i++)
{
	$result=mysqli_query($conn, "SELECT * FROM usuario where usuario_cod_usr='$cod_usuario[$i]'");
	if ($row=mysqli_fetch_array($result))
	{
	$eliminar=$row["usuario_username"];
	$elimincc=$row["usuario_cod_usr"];
	echo system("rm -rf /var/spool/mail/$eliminar",$result); 
	echo system("rm -rf /var/www/html/virtual/disco/usuarios/$eliminar",$result); 
	echo system("rm -rf /var/www/html/squirrelmail/data/$eliminar@*.*",$result); 
	}
	mysqli_query($conn, "DELETE FROM usuario WHERE usuario_cod_usr='$elimincc'") or die("El Registro no Existe");
}
mysqli_close($conn);
?>
<script>
	window.self.location="adminusuarios.php";
</script>		
