<?php
include("filtro.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("conecta.php");
$conn=Conectarse();
?>

<?php
$variable=descifrar($_GET['sel_inst']);
if(!is_numeric($variable))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACI&Oacute;N DE DATOS !!!!</b></center>";
    exit();
}

$respi100=mysqli_query($conn,  "select * from cargos");
if($rowvar=mysqli_fetch_array($respi100))
{
$principal=$rowvar["cargos_id"];
}


$respi=mysqli_query($conn, "select * from cargos where cargos_id='$variable'");
?>
<?php
$error=0;
if (isset($_POST['enviar']))
{
  if ($variable==$principal)
  {
  echo "<center>";
  echo "<br>";
  echo "<img src='images/maximo.jpg' border='0' alt='Volver Pantalla Anterior' align='center'/>";
  echo "<b class='fuente_normal_rojo'> ��� USTED ELIGIO MODIFICAR EL CARGO MAXIMO, ESTE NO TIENE RELACI&Oacute;N DE DEPENDENDENCIA DENTRO DEL SISTEMA !!! </b>";
  echo "<br>";echo "<br>";
  echo "<a href='cargos.php'><img src='images/atras.gif' border='0' alt='Volver Pantalla Anterior' /></a>";
  echo "</center>";
  exit;
  }



     $result=mysqli_query($conn, "SELECT * FROM cargos where cargos_cargo='$_POST[nombresito]' AND cargos_cod_institucion='$_SESSION[institucion]' AND         cargos_cod_depto='$_POST[depende]' AND cargos_edificio='$_POST[edificio]'");
	 $lista=mysqli_num_rows($result);
	 if($lista >0)
	{
	  $error=1;
	  $alert_duplicado=1;
 	}
  
  $text1=$_POST['nombresito'];
  $valor1=alfanumerico($text1);
  if ($valor1==0)
	{
      $error=1;
	  $alert_nombre=1;
    }

  if ($error==0)
  { 

	mysqli_query($conn, "UPDATE cargos SET cargos_cargo='$_POST[nombresito]',cargos_cod_depto='$_POST[depende]',cargos_edificio='$_POST[edificio]',cargos_cod_institucion='$_SESSION[institucion]',cargos_dependencia=$_POST[dependencia] WHERE cargos_id='$variable'") or die("No se Actualizo el Registro");

  $ssql00="SELECT * FROM miderivacion where miderivacion_mi_codigo='$_POST[dependencia]' and miderivacion_su_codigo='$variable'";
  $rss100 = mysqli_query($conn, $ssql00);
  if (mysqli_num_rows($rss100) <> 1)
  {
  mysqli_query($conn, "insert into miderivacion (miderivacion_mi_codigo,miderivacion_su_codigo,miderivacion_estado,miderivacion_original)values('$_POST[dependencia]','$variable','0','1')") or die("El Registro no Existe");
  mysqli_query($conn, "DELETE FROM miderivacion WHERE miderivacion_mi_codigo <> '$_POST[dependencia]' and miderivacion_su_codigo='$variable'"); 
  }
 
  $ssq200="SELECT * FROM asignar where asignar_mi_codigo='$_POST[dependencia]' and asignar_su_codigo='$variable'";
  $rss200 = mysqli_query($conn, $ssq200);
  if (mysqli_num_rows($rss200) <> 1)
  {
  mysqli_query($conn, "UPDATE asignar SET asignar_su_codigo='$_POST[dependencia]' WHERE asignar_mi_codigo='$variable'") or die("No se Actualizo el Registro");
  mysqli_query($conn, "UPDATE asignar SET asignar_mi_codigo='$_POST[dependencia]' WHERE asignar_su_codigo='$variable'") or die("No se Actualizo el Registro");
  }

	?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
   <?php
  }
}
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
<?php
}
?>

<!DOCTYPE html>
<html>
<body>
  
<center>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MODIFICAR DATOS DE LOS CARGOS		
</P>
<?php
if ($error>0)
{
  echo "<span class=fuente_normal_rojo>!! ERROR AL INTRODUCIR DATOS !!</span>";
}
echo "<br />";
	if (isset($alert_duplicado))
	{
	echo "<i class='fuente_normal_rojo'>ESTE CARGO YA EXISTE EN LA BASE DE DATOS</i>";echo "<br />";
	echo "<b class='fuente_normal_rojo'>".$_POST['nombresito']."</b>";
	}
?>
<?php
if ($rowi=mysqli_fetch_array($respi))
{
?>
<table>
<form method="post">
<tr class="truno"><td><SPAN class="fuente_subtitulo">EDIFICIO DE PERTENENCIA</td>
<td>
<select name="edificio" class="caja_texto">
<?php
$conn = Conectarse();
$ssql="SELECT * FROM edificio where edificio_cod_institucion='$_SESSION[institucion]'";
$rss = mysqli_query($conn, $ssql);
if (!empty($rss)) {
  while($row=mysqli_fetch_array($rss))
	  {
      if ($rowi["cargos_edificio"]==$row["edificio_cod_edificio"]) 
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
?>
</select>
</td></tr>

<tr class="truno">
<td><SPAN class="fuente_subtitulo">DEPARTAMENTO:</td>
<td>
<select class="fuente_caja_texto" name="depende">
<?php
$ssql="SELECT * FROM departamento where departamento_cod_institucion='$_SESSION[institucion]'";
$rss = mysqli_query($conn, $ssql);
if (!empty($rss)) {
  while($row=mysqli_fetch_array($rss))
	  {
      if ($rowi["cargos_cod_depto"]==$row["departamento_cod_departamento"]) 
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
?>
</select>
</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_subtitulo">DESCRIPCION CARGO:</td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" size="50" value="<?php echo $rowi["cargos_cargo"];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>


<tr class="truno">
<td><SPAN class="fuente_subtitulo">DEPENDENCIA:</td>
<td>
<select class="fuente_caja_texto" name="dependencia">
<option value="">Seleccionar Dependencia</option>
<?php
$ssql="SELECT * FROM cargos WHERE '$_SESSION[institucion]'=cargos_cod_institucion and cargos_id <> '$variable'";

$rss = mysqli_query($conn, $ssql);
if (!empty($rss)) {
  while($row=mysqli_fetch_array($rss))
	  {
      if ($rowi["cargos_dependencia"]==$row["cargos_id"]) 
	  {
         ?><option value="<?php echo $row["cargos_id"];?>" selected>
         <?php echo $row["cargos_cargo"];
         echo "</option>";
       } 
	   else
	   {
	   ?>
	   <option value="<?php echo $row["cargos_id"];?>" >
       <?php
		 echo $row["cargos_cargo"];
         echo "</option>"; 	   
	   }
  } // while  
}
?>
</select>
</td>
</tr>

<tr>
<td>&nbsp;

</td>
</tr>

<tr>
<td colspan="2" align="center">
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
}
include("final.php");
?>
