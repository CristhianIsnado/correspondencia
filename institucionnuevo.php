<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
$conn=Conectarse();
?>
<?php
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
	

		if($error==0 )
		{
		      mysqli_query($conn, "INSERT INTO instituciones (instituciones_descripcion_inst,instituciones_sigla_inst,instituciones_tipo_hoja,instituciones_dominio)
	VALUES ('$_POST[nombresito]','$_POST[siglaed]','4','$_POST[dominio]')") or die ("No se Guardo el archivo");
						
				?>
					<script>
					window.self.location="institucion.php";
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

<!DOCTYPE html>
<html>
<body>
	
<center>
<br>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
ADICION DE INSTITUCIONES
</P>
<?php
if ($error != '0')
{
echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
}
?>
<table>

<form method="POST">

<tr class="truno">
<td><SPAN class="fuente_subtitulo">Nombre de la Instituci&oacute;n :</td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" size="50" value="<?php echo $_POST['nombresito'];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_subtitulo">Sigla de  la Instituci&oacute;n:</td>
<td><input class="fuente_caja_texto" type="text" name="siglaed" size="50" value="<?php echo $_POST['siglaed'];?>">
<?php Alert($alert_sigla); ?>
</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_subtitulo">Dominio:</td>
<td><input class="fuente_caja_texto" type="text" name="dominio" size="50" value="<?php echo $_POST['dominio'];?>">
<?php Alert($alert_dominio); ?>
</td>
</tr>


<tr>
<td colspan="2" align="center">
	<br>
	<input class="boton" type="submit" name="enviar" value="Aceptar">
	<input class="boton" type="submit" name="cancelar" value="Cancelar">
</td>
</tr>
</form>
</table>
<br>
</center>

</body>	
</html>

<?php
include("final.php");
?>
