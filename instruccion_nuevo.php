<?php
include("filtro_adm.php");
include("inicio.php");
include("sicor/script/functions.php");
include("conecta.php");
$cod_institucion = $_SESSION["institucion"];
$conn = Conectarse();
?>

<?php
$aux = 0;
if (isset($_POST['enviar'])) {
   
    $valor1=val_alfanum($_POST['descripcion']);
    if($valor1 == 0)
    { 
    $aux = 1;
    $descri=1;
    }   

  if ($aux == 0) {
	$ssql = "INSERT INTO  instruccion(instruccion_instruccion) 
	VALUES ('$_POST[descripcion]')";
	mysqli_query($conn, $ssql);
	
?>
    <script language="JavaScript">
    window.self.location="instrucciones.php";
    </script>
<?php	
   }
} //en if isset enviar

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="instrucciones.php";
    </script>
<?php
}
?>

<br>
<?php if ($aux == 0){
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>AGREGAR INSTRUCCION</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>VERIFICAR DATOS</b></div></p>";
}?>

<center>
<table width="40%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="documento">

<tr class="truno"><td><span class="fuente_normal">Descripcion</td>
<td><input type="text" name="descripcion" value="" maxlength="50" size="30" />
<?php if ($descri == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }?>
</td></tr>

<tr>
<td align="center" colspan="2">
	<input type="submit" name="enviar" value="Aceptar" class="boton" />
	<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
</form>
</table>
</center>
<br>

<?php
include("final.php");
?>