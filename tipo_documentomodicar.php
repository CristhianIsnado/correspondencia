<?php
include("filtro.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("conecta.php");
?>

<?php
$variable = descifrar($_GET['sel_inst']);
$conn=Conectarse();
$respi=mysqli_query($conn, "select * from instruccion where instruccion_codigo_instruccion='$variable'");

if(!is_numeric($variable))
{
    echo "!!! INTENTO DE MANIPULACION DEL SISTEMA !!!";
    exit;
}

$respiaux=mysqli_query($conn, "select * from instruccion where instruccion_codigo_instruccion='$variable'");
if ($rowaux=mysqli_fetch_array($respiaux))
{
$uno=$rowaux["instruccion_instruccion"];
}

$aux = 0;

if (isset($_POST['enviar'])) 
{
$cons1=mysqli_query($conn, "select * from instruccion where instruccion_instruccion='$_POST[instruccion]'");
if ($_POST['instruccion'] == "" ) {	
         $aux = 1;
		   $tipo_instruccion = 1;
} 
 else {
          if($uno != $_POST['instruccion']) { 
	              if(mysqli_num_rows($cons1) == 1){
		               $aux = 1;
		               $tipo_instruccion = 1;
	               }
	         } 
}


    $valor1=val_alfanum($_POST['instruccion']);
    if($valor1 == 0)
    { 
    $aux = 1;
    $tipo_instruccion=1;
    }

  if ($aux == 0) {
     mysqli_query($conn, "update instruccion set instruccion_instruccion='$_POST[instruccion]' where instruccion_codigo_instruccion='$variable'");
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

<!DOCTYPE html>
<html>
<body>
    
<br>
<center>
<p class="fuente_titulo_principal"><span class="fuente_normal">MODIFICAR INSTRUCCI&Oacute;N</span></P>
<?php
if ($rowi=mysqli_fetch_array($respi))
{
?>
<table width="30%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="documento">

<tr class="truno">
<td><SPAN class="fuente_subtitulo">Descripci&oacute;n:</td>
<td><input class="fuente_caja_texto" type="text" name="instruccion" maxlength="50" size="50" value="<?php echo $rowi["instruccion_instruccion"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["instruccion_codigo_instruccion"];?>">
   <?php if ($tipo_instruccion == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }
   ?>
</td>
</tr>

<tr class="truno">
<td align="center" colspan="2">
	<input type="submit" name="enviar" value="Aceptar" class="boton" />
	<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
</form>
</table>
</center>

</body>    
</html>

<?php
}
include("final.php");
?>