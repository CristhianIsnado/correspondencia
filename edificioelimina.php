<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
$conn=Conectarse();
$elementos = count($cod_dep);
echo $elementos;
for($i=0; $i< $elementos; $i++){
mysqli_query($conn, "DELETE FROM edificio WHERE edificio_cod_edificio='$cod_dep[$i]'") or die("El Registro no Existe");
}
mysqli_close($conn);
include("final.php");
?>
	<script>
	window.self.location="edificio.php";
	</script>		
