<?php
include("filtro.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("conecta.php");
$conn=Conectarse();
$variable=descifrar($_GET['sel_inst']);

$respi=mysqli_query($conn, "select * from clasecorrespondencia where clasecorrespondencia_codigo_clase_corresp='$variable'");

$respiaux=mysqli_query($conn, "select * from clasecorrespondencia where clasecorrespondencia_codigo_clase_corresp='$variable'");
if ($rowaux=mysqli_fetch_array($respiaux))
{
$uno=$rowaux["clasecorrespondencia_codigo_clase_corresp"];
$dos=$rowaux["clasecorrespondencia_descripcion_clase_corresp"];
}

$aux = 0;

if (isset($_POST['enviar'])) 
{
$cons1=mysqli_query($conn, "select * from clasecorrespondencia where clasecorrespondencia_codigo_clase_corresp='$_POST[tipo_codigo]'");
if ($_POST['tipo_codigo'] == "" ) {	
         $aux = 1;
		   $tipo_doc = 1;
} 
 else {
          if($uno != $_POST['tipo_codigo']) { 
	              if(mysqli_num_rows($cons1) == 1){
		               $aux = 1;
		               $tipo_doc = 1;
	               }
	         } 
}
		
	
$cons2=mysqli_query($conn, "select * from clasecorrespondencia where clasecorrespondencia_descripcion_clase_corresp='$_POST[descripcion]'");
if ($_POST['descripcion'] == "" ) {	
         $aux = 1;
		   $descri = 1;
} 
 else {
          if($dos != $_POST['descripcion']) { 
	              if(mysqli_num_rows($cons2) == 1){
		               $aux = 1;
		               $descri = 1;
	               }
	         } 
}

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
     mysqli_query($conn, "update clasecorrespondencia set clasecorrespondencia_codigo_clase_corresp='$_POST[tipo_codigo]',clasecorrespondencia_descripcion_clase_corresp='$_POST[descripcion]' where clasecorrespondencia_codigo_clase_corresp='$variable'");
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
<center>
<p class="fuente_titulo_principal"><span class="fuente_normal">MODIFICAR TIPO DE DOCUMENTO</span></P>
<?php
if ($rowi=mysqli_fetch_array($respi))
{
?>
<table width="20%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="documento">

<tr class="truno">
<td><SPAN class="fuente_subtitulo">C&oacute;digo:</td>
<td><input class="fuente_caja_texto" type="text" name="tipo_codigo" maxlength="2" size="2" value="<?php echo $rowi["clasecorrespondencia_codigo_clase_corresp"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["clasecorrespondencia_codigo_clase_corresp"];?>">
   <?php if ($tipo_doc == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }
   ?>
</td>
</tr>
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Descripci&oacute;n:</td>
<td><input class="fuente_caja_texto" type="text" name="descripcion" value="<?php echo $rowi["clasecorrespondencia_descripcion_clase_corresp"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["clasecorrespondencia_codigo_clase_corresp"];?>">
   <?php if ($descri == 1) {
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

<?php
}
include("final.php");
?>