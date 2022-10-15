<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.php");
$conn=Conectarse();
?>
<?php
$error=0;
if (isset($_POST['enviar']))
{
    $valor1=val_alfanum($_POST['nombresito']);
    if($valor1 == 0)
    { 
    $error = 1;
    $alert_nombre=1;
    }

    $valor2=val_alfanum($_POST['siglaed']);
    if($valor2 == 0)
    { 
    $error = 1;
    $alert_sigla=1;
    }

    $valor3=val_alfanum($_POST['ciudad']);
    if($valor3 == 0)
    { 
    $error = 1;
    $alert_ciudad=1;
    }  


	if ($error == 0)
	{
       $var=$_SESSION["institucion"];
        mysqli_query($conn, "insert into edificio(edificio_descripcion_ed,edificio_cod_institucion,edificio_sigla_ed,edificio_ciudad)values('$_POST[nombresito]','$var','$_POST[siglaed]','$_POST[ciudad]') ");
		?>
			<script language='JavaScript'> 
				window.self.location="edificio.php"
			</script> 
		<?php
	}
}

if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="edificio.php"
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
ADICION DE EDIFICIOS
</P>
<?php
if ($error != '0')
{
echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
}
?>
<table>
<form method="post">
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Sigla del Edificio:</td>
<td><input class="fuente_caja_texto" type="text" name="siglaed" value="<?php echo $_POST['siglaed'];?>">
<?php Alert($alert_sigla); ?>
</td>
</tr>
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Nombre del Edificio:</td>
<td>
<input class="fuente_caja_texto" type="text" name="nombresito" value="<?php echo $_POST['nombresito'];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Ciudad del Edificio:</td>
<td>
   <select class="fuente_caja_texto" name="ciudad">
        <option value="">Seleccione Ciudad</option>
   <option value='La Paz' <?php if($_POST['ciudad']=='La Paz') { echo 'selected';}?> >La Paz</option>
   <option value='Cochabamba' <?php if($_POST['ciudad']=='Cochabamba') { echo 'selected';}?> >Cochabamba</option>
   <option value='Oruro' <?php if($_POST['ciudad']=='Oruro') { echo 'selected';}?> >Oruro</option>
   <option value='Beni' <?php if($_POST['ciudad']=='La Paz') { echo 'selected';}?> >Beni</option>
   <option value='Pando' <?php if($_POST['ciudad']=='Beni') { echo 'selected';}?> >Pando</option>
   <option value='Chuquisaca' <?php if($_POST['ciudad']=='Chuquisaca') { echo 'selected';}?> >Chuquisaca</option>
   <option value='Potosi' <?php if($_POST['ciudad']=='Potosi') { echo 'selected';}?> >Potosi</option>
   <option value='Tarija' <?php if($_POST['ciudad']=='Tarija') { echo 'selected';}?> >Tarija</option>              
   <option value='Santa Cruz' <?php if($_POST['ciudad']=='Santa Cruz') { echo 'selected';}?> >Santa Cruz</option>
    </select>
     <?php Alert($alert_ciudad);?>  


</td>
</tr>
<tr>
</tr>
<tr>
<td colspan="2" align="center">
	<br>
	<input class="boton" type="submit" name="enviar" value="Enviar">
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
