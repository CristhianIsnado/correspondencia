<?php
include("filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("conecta.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
$variable=descifrar($_GET['sel_inst']);
if(!is_numeric($variable))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACI&Oacute;N DE DATOS !!!!</b></center>";
    exit();
}
$conn=Conectarse();
$respi=mysqli_query($conn, "select * from departamento where departamento_cod_departamento='$variable'");
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
    
    $valor2=val_alfanum($_POST['sigla']);
    if($valor2 == 0)
    { 
    $error = 1;
    $alert_sigla=1;
    } 	
	
  if ($error==0)
  {
 	$var=$_SESSION["institucion"];
	mysqli_query($conn, "UPDATE departamento SET departamento_sigla_dep='$_POST[sigla]',
	departamento_descripcion_dep='$_POST[nombresito]',
	departamento_cod_institucion='$var',
	departamento_dependencia_dep='$_POST[depende]',
	departamento_cod_edificio='$_POST[edificio]' WHERE departamento_cod_departamento='$variable'") or die("No se Guardo el Registro");
	?>
			<script language='JavaScript'> 
				window.self.location="departamento.php"
			</script>
   <?php
  }
}
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="departamento.php"
			</script>
<?php
}
?>

<!DOCTYPE html>
<html>
<body>
  
<center>
<?php
if ($error>0)
{
  echo "<br><span class=fuente_normal_rojo>!! Error al Introducir Datos !!</span>";
}
?>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MODIFICAR DATOS DE LOS DEPARTAMENTOS					
</P>
<?php
if ($rowi=mysqli_fetch_array($respi))
{
?>
<table>
<form method="post">
<tr class="truno">
<td><SPAN class="fuente_subtitulo">Nombre del Departamento:</td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" value="<?php echo $rowi["departamento_descripcion_dep"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["departamento_cod_departamento"];?>">
<?php Alert($alert_nombre); ?>

</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_subtitulo">Sigla del Departamento:</td>
<td><input class="fuente_caja_texto" type="text" name="sigla" value="<?php echo $rowi["departamento_sigla_dep"];?>">
<?php Alert($alert_sigla); ?>

</td>
</tr>



<tr class="truno">
<td><SPAN class="fuente_subtitulo">Dependencia:</td>
<td>
<select class="fuente_caja_texto" name="depende">
<?php
$cod_institucion=$_SESSION["institucion"];
$ssql="SELECT * FROM departamento where departamento_cod_institucion='$cod_institucion'";
$rss = mysqli_query($conn, $ssql);
if (!empty($rss)) {
  while($row=mysqli_fetch_array($rss))
	  {
      if ($rowi["departamento_dependencia_dep"]==$row["departamento_cod_departamento"]) 
	  {
         ?><option value="<?php echo $row["departamento_cod_departamento"];?>" selected>
         <?php echo $row["departamento_descripcion_dep"];
         echo "</option>";
       } 
	   else
	   {
	   ?>
	   <option value="<?php echo $row["departamento_cod_departamento"];?>" >
       <?php
		 echo $row["departamento_descripcion_dep"];
         echo "</option>"; 	   
	   }
  } // while  
}
mysqli_free_result($rss);
?>
</select>
</td>
</tr>
<tr class="truno"><td><SPAN class="fuente_subtitulo">Edificio de Pertenencia</td>
<td>
<select name="edificio" class="caja_texto">
<?php
$conn = Conectarse();
$cod_institucion=$_SESSION["institucion"];
$ssql="SELECT * FROM edificio where edificio_cod_institucion='$cod_institucion'";
$rss = mysqli_query($conn, $ssql);
if (!empty($rss)) {
  while($row=mysqli_fetch_array($rss))
	  {
      if ($rowi["departamento_cod_edificio"]==$row["edificio_cod_edificio"]) 
	  {
         ?><option value="<?php echo $row["edificio_cod_edificio"];?>" selected>
         <?php echo $row["edificio_descripcion_ed"];
         echo "</option>";
       } 
	   else
	   {
	   ?>
	   <option value="<?php echo $row["edificio_cod_edificio"];?>" >
       <?php
		 echo $row["edificio_descripcion_ed"];
         echo "</option>"; 	   
	   }
  } // while  
}
mysqli_free_result($rss);
?>
</select>
</td></tr>


<tr>
<td>&nbsp;

</td>
</tr>

<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="Enviar" >
<input class="boton" type="submit" name="cancelar" value="Cancelar" >
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
