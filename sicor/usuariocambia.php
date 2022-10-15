<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("../conecta.php");
$codigo_bg=$_SESSION["codigo"];
$conn=Conectarse();

mysqli_query($conn, "UPDATE usuario SET  usuario_titulo = '$titulo' WHERE  usuario_cod_usr= '$codigo_bg'");
?>
<script>
window.self.location="menu.php";
</script>
<?php
exit;
?>

