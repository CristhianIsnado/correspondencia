<?php
include("filtro_adm.php");
?>
<?php
include("conecta.php");
$conn = Conectarse();
$elementos = count($sel_corresp);

// esto es nuevo
for($i=0; $i < $elementos; $i++){
  mysqli_query($conn, "DELETE FROM instruccion WHERE instruccion_codigo_instruccion='$sel_corresp[$i]'"); 
} //end for
//mysql_close($conn);
?>
<script>
window.self.location="instrucciones.php";			
</script>		

