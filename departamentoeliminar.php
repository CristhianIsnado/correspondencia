<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
$conn=Conectarse();
$elementos = count($cod_dep);

for($i=0; $i< $elementos; $i++){
mysqli_query($conn, "DELETE FROM departamento WHERE departamento_cod_departamento='$cod_dep[$i]'") or die("El Registro no Existe");
}

mysqli_close($conn);
include("final.php");
?>
	<script>
	window.self.location="departamento.php";
	</script>		
