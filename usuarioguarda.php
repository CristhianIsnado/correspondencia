<?php
include("filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("conecta.php");
$conn=Conectarse();
$result=mysqli_query($conn, "SELECT count(*) as numero FROM usuario where usuario_username='$Username'");
$Lista=mysqli_fetch_row($result);
if($Lista[0])
{
?>
<br>
<br>
<center>
<span class="fuente_subtitulo">
<b>Lo siento el <strong>Nombre de Usuario</strong> <?php echo strtoupper($Username);?> ya existe
<br>
Elija Otro Gracias..
</b>
<br>
</span>
<br>
<a href="usuarionuevo.php"><img src="images/atras.gif" alt="ATRAS" border=0/>
</a>

<br>
</center>
<?php
exit();
}

if (($_SESSION["adminvirtual"])=="adminlocal")
{
   $Cod_Institucion = $_SESSION["institucion"];
}

$User2=$Username."/";
$Email=$Username."@".$Dominio;
mysqli_query($conn, "insert into usuario (usuario_cod_departamento,usuario_nombre,usuario_titulo,usuario_email,usuario_username,usuario_dominio,usuario_cod_nivel,usuario_password,usuario_cod_institucion,usuario_cargo,usuario_maildir,usuario_ocupacion,,usuario_carnet,usuario_carnet_ciudad)
VALUES ('$Cod_Departamento','$Nombre', '$Titulo','$Email','$Username', '$Dominio', '$Cod_Nivel', '$Username', '$Cod_Institucion','$car_codigo','$User2','$ocupacion','$ci','$ci_ciudad')") or die ("No se Guardo el archivo");

include("final.php");
?>
<script>
window.self.location="adminusuarios.php";
</script>
