<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
$conn=Conectarse();
$variable=descryto($_GET['sel_inst']);
$respi=mysqli_query($conn, "select * from instituciones where instituciones_cod_institucion='$variable';");
$error=0;

if(isset($_POST['enviar']))
{

  $text=$_POST['nombresito'];
  $valor=alfanumerico($text);
  if ($valor==0)
	{
      $error=1;
	  $alert_nombre=1;
    }	
	
	if(empty($_POST['dominio']))
	{
	  $error=1;
	  $alert_dominio=1;
  	}				
			

  $text2=$_POST['siglaed'];
  $valor2=sinespacios($text2);
  if ($valor2==0)
	{
      $error=1;
	  $alert_sigla=1;
    }		
	
  if($error==0)
	{
  mysqli_query($conn, "update instituciones set instituciones_descripcion_inst='$_POST[nombresito]',instituciones_sigla_inst='$_POST[siglaed]',instituciones_dominio='$_POST[dominio]' where instituciones_cod_institucion='$variable'") or die ("No se Guardo el archivo");
?>
	<script language='JavaScript'> 
		window.self.location="institucion.php"
	</script> 

<?php
    }
	}
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="institucion.php"
			</script>
<?php
}
?>
<br>

<!DOCTYPE html>
<html>
<body>
	
<center>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MODIFICAR DATOS DE LA INSTITUCION
</P>
<?php
if ($rowi=mysqli_fetch_array($respi))
{
?>
<table bgcolor="#eeeeee">
<form method="post">
<tr>
<td><SPAN class="fuente_subtitulo">NOMBRE DE LA INSTITUCI&Oacute;N: </td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" size="50" value="<?php echo $rowi["instituciones_descripcion_inst"];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>
<tr>
<td><SPAN class="fuente_subtitulo">SIGLA DE LA INSTITUCI&Oacute;N:</td>
<td><input class="fuente_caja_texto" type="text" name="siglaed" size="50" value="<?php echo $rowi["instituciones_sigla_inst"];?>">
<?php Alert($alert_sigla); ?>
</td>
</tr>
<tr>
<td><SPAN class="fuente_subtitulo">DOMINIO:</td>
<td><input class="fuente_caja_texto" type="text" name="dominio" size="50" value="<?php echo $rowi["instituciones_dominio"];?>">
<?php Alert($alert_dominio); ?>
</td>
</tr>
<tr>
<td>&nbsp;
</td>
</tr>

<tr>
<td></td>
<td>
<input class="BOTON" type="submit" name="enviar" value="Enviar" >
<input class="BOTON" type="submit" name="cancelar" value="Cancelar" >
</td>
</tr>
</form>
</table>
<br>
</center>

</body>	
</html>

<?php
}
include("final.php");
?>
