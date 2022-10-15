<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
$conn=Conectarse();

$consulta_a=mysqli_query($conn, "SELECT * from usuario where usuario_cod_usr='$usuario'");
if($fila_b=mysqli_fetch_array($consulta_a))
{
	if($fila_b["usuario_nombre"] =='$Nombre')
	{
		mysqli_query($conn, "UPDATE usuario SET usuario_cod_departamento='$Cod_Departamento', usuario_titulo = '$Titulo' , usuario_cargo='$car_codigo' , usuario_carnet='$ci',usuario_carnet_ciudad='$ci_ciudad' WHERE  usuario_cod_usr= '$usuario'")
		 or die("No se Guardo el Registro");

		$result_uno=mysqli_query($conn, "SELECT * FROM usuario,departamento where usuario.usuario_cod_usr='$usuario' and usuario.usuario_cod_departamento=departamento.departamento_cod_departamento");
		if ($row=mysqli_fetch_array($result_uno))
		{
			$departamento_nombre=$row["departamento_descripcion_dep"];
		} 
			
	}
	else
	{
		mysqli_query($conn, "UPDATE usuario SET usuario_cod_departamento='$Cod_Departamento', usuario_nombre = '$Nombre' , usuario_titulo = '$Titulo' , usuario_cargo='$car_codigo',usuario_carnet='$ci',usuario_carnet_ciudad='$ci_ciudad' WHERE  usuario_cod_usr= '$usuario'")
		 or die("No se Guardo el Registro");
		 
		$result_uno=mysqli_query($conn, "SELECT * FROM usuario,departamento where usuario.usuario_cod_usr='$usuario' and usuario.usuario_cod_departamento=departamento.departamento_cod_departamento");
		if ($row=mysqli_fetch_array($result_uno))
		{
			$departamento_nombre=$row["departamento_descripcion_dep"];
			$codigo_departamento_a=$row["departamento_cod_departamento"];
		} 
						
		?>
			<script>
				window.self.location="adminusuarios.php";
			</script>
		<?php
		 include("final.php");
	}
}
		?>