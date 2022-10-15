<?php
include("filtro_adm.php");
include("inicio.php");
include("conecta.php");
include("sicor/script/functions.php");
$gestion = strftime("%Y");
$aux = 0;
$cod_institucion = $_SESSION["institucion"];

if (isset($_POST['enviar'])) {

    $valor1=val_alfanum($_POST['tipo_codigo']);
    if($valor1 == 0)
    { 
    $aux = 1;
    $tipo_doc=1;
    }
    
    $valor2=val_alfanum($_POST['descripcion']);
    if($valor2 == 0)
    { 
    $aux = 1;
    $descri=1;
    }    

  if ($aux == 0) {
    $conn = Conectarse();
	$ssql = "INSERT INTO  clasecorrespondencia(clasecorrespondencia_codigo_clase_corresp, clasecorrespondencia_descripcion_clase_corresp) 
	VALUES ('$_POST[tipo_codigo]', '$_POST[descripcion]')";
	mysqli_query($conn, $ssql);
	
?>
    <script language="JavaScript">
    window.self.location="tipo_documento.php";
    </script>
<?php	
   }
} //en if isset enviar

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="tipo_documento.php";
    </script>
<?php
}
?>
<br>
<?php if ($aux == 0){
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>NUEVO DOCUMENTO</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>VERIFICAR DATOS</b></div></p>";
}?>
   
<center>
<table width="40%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="documento">

<tr class="truno"><td><span class="fuente_normal">C&oacute;digo</td>
<td><input type="text" name="tipo_codigo" value="" maxlength="10" size="10" />
   <?php if ($tipo_doc == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }
   ?>
</td></tr>

<tr class="truno"><td><span class="fuente_normal">Descripci&oacute;n</td>
<td><input type="text" name="descripcion" value="" maxlength="50" size="20" />
   <?php if ($descri == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }
   ?>
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