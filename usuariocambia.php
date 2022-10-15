<?php
include("filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("conecta.php");
$codigo_bg=$_SESSION["codigo"];
$conn=Conectarse();
echo $codigo_bg;
echo $_POST['titulo'];
echo $_REQUEST['titulo'];
echo $_SESSION['titulo'];
mysqli_query($conn, "UPDATE usuario SET  usuario_titulo='$_POST[titulo]' WHERE  usuario_cod_usr='$codigo_bg'");

?>
<script>
//window.self.location="menu.php";
</script>

