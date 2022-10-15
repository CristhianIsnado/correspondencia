<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.php");
include("script/cifrar.php");
$sel_derivar=descifrar($_GET['datos']);//Codigo de hoja_interna $datos desde recepcion_lista

$cod_institucion = $_SESSION["institucion"];
$codiguillo=$_SESSION["cargo_asignado"];//Codigo de usuario

$conn = Conectarse();

$ssqlao = "SELECT * FROM cargos WHERE '$codiguillo'=cargos_id";
$rsao = mysqli_query($conn, $ssqlao);
if ($rowao = mysqli_fetch_array($rsao)) 
{
    $departamentillo=$rowao["cargos_cod_depto"];//Codigo al que pertenece
}
mysqli_free_result($rsao);
	
if (isset($_POST['grabar']))
{

   if(empty($_POST['destinatario']))
   {
            $error=TRUE;
            $alert_coddepto=1;
   }
   
      if(empty($_POST['codigo_instruccion']))
   {
            $error=TRUE;
            $codigo_instruccion=1;
   }
	
    $valor1 = alfanumerico($_POST['observaciones']);
    if ($valor1==0)
    {
       $error = TRUE;
       $alert_obs = 1;
    }

if (!$error)
{  

//comparo la id de hoja interna y el idcargo actual "P"	
$elementos2 = count($_POST['tarde']);

    $sql_aux=mysqli_query($conn, "SELECT * FROM derivaciones
                          WHERE derivaciones_hoja_interna='$sel_derivar'
			  AND derivaciones_cod_usr='$codiguillo'");
	if($fila_saber=mysqli_fetch_array($sql_aux))
	{
		$valor_tipo=$fila_saber["derivaciones_tipo_derivacion"];
		$id_aderivar=$fila_saber["derivaciones_cod_seg"];
	}

$fecha_actual = date("Y-m-d H:i:s");
mysqli_query($conn, "UPDATE derivaciones SET
             derivaciones_estado='TR',
             derivaciones_fecha_derivacion='$fecha_actual'
             WHERE derivaciones_hoja_interna='$sel_derivar'
             AND derivaciones_cod_usr='$_SESSION[cargo_asignado]'");

  $ssql = "INSERT INTO  derivaciones SET
          derivaciones_hoja_interna='$_POST[hoja_ruta]',
          derivaciones_cod_usr='$_POST[destinatario]',
          derivaciones_estado='P',
          derivaciones_fecha_derivacion='$fecha_actual',
          derivaciones_tipo_derivacion='$valor_tipo',
          derivaciones_id_derivacion='$id_aderivar',
          derivaciones_instruccion='$_POST[codigo_instruccion]',
          derivaciones_proveido='$_POST[observaciones]'";
 mysqli_query($conn, $ssql);


$copia=$_POST['tarde'];
for($i=0; $i < $elementos2; $i++)
{  
    $var_ssql="INSERT INTO  derivaciones(derivaciones_hoja_interna,derivaciones_cod_usr,derivaciones_estado,derivaciones_fecha_derivacion,derivaciones_tipo_derivacion,derivaciones_id_derivacion,derivaciones_instruccion,derivaciones_proveido)
			   VALUES ('$_POST[hoja_ruta]','$copia[$i]','P','$fecha_actual','CC','$id_aderivar','$_POST[codigo_instruccion]','$_POST[observaciones]')";
	mysqli_query($conn, $var_ssql);
}
?>
      <script language="JavaScript">
        window.self.location="notas_derivadas.php";
      </script>
<?php	
  }
} 

if (isset($_POST['cancelar']))
{
?>
      <script language="JavaScript">
		window.self.location="notas_recibidas.php";
      </script>
<?php
}
?>

<br>

<?php
if ($error == 0)
{
    echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>DERIVACI&Oacute;N DE DOCUMENTOS</b></div></p>";
} 
else 
{ 
    echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>
<center>
<?php
$huaychi=mysqli_query($conn, "select * from instituciones where instituciones_cod_institucion = '$cod_institucion'");
if ($huaychi2=mysqli_fetch_array($huaychi))
{
  $hoja_tipoaa=$huaychi2["instituciones_tipo_hoja"];
}
?>
<table width="85%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="enviar">
<tr class="border_tr3">
<td><span class="fuente_normal">Codigo Documento</td>
<td>
<?php
$ssql3="SELECT * FROM registroarchivo WHERE '$sel_derivar'= registroarchivo_codigo";
$rss3=mysqli_query($conn, $ssql3);
$row3=mysqli_fetch_array($rss3);
echo $row3["registroarchivo_hoja_interna"];
?>
<input type="hidden" name="imprimeh" value="<?php echo $row3["registroarchivo_nro_registro"];?>"/>
</td>
</tr>

<tr class="border_tr3"><td><span class="fuente_normal">Fecha y Hora de Derivacion</td> 
<td><?php echo date("Y-m-d")." ".date("H:i:s");?>
<input type="hidden" name="fecha_deriva" value="<?php echo date("Y-m-d")." ".date("H:i:s");?>">
<input type="hidden" name="hoja_ruta" value="<?php echo $row3["registroarchivo_codigo"];?>">
</td>
</tr>


<tr class="border_tr3">
<td>
<span class="fuente_normal">Funcionario/Destino</td>
<td>
<input type="hidden" name="cod_institucion" value="<?php echo $cod_institucion;?>">
<select name="destinatario" onChange="this.form.submit()">
  <option value=""> Seleccione un Funcionario</option>
<?php
$ssql55 = "SELECT * FROM asignar where asignar_mi_codigo='$codiguillo'";
$rss55 = mysqli_query($conn, $ssql55);
while($row55=mysqli_fetch_array($rss55))
{
	if ($_POST['destinatario']==$row55["asignar_su_codigo"])
	  { 
		echo "<option value=".$row55["asignar_su_codigo"]." selected>";
			$valor_clave=$row55["asignar_su_codigo"];
			$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
			if($fila_clave=mysqli_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion");
				if($fila_cargo=mysqli_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				}
			}
			
		echo "</option>";
      }
    else
      {
	    echo "<option value=".$row55["asignar_su_codigo"].">";
			$valor_clave=$row55["asignar_su_codigo"];
			$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
			if($fila_clave=mysqli_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion");
				if($fila_cargo=mysqli_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				}
			}		  
		echo "</option>";
	   }
}
?>
</select>
	<?php
    Alert($alert_coddepto);
    ?>
</td>
</tr>

<?php
	if(!empty($_POST['destinatario']))
	{
	$valor_clave=$_POST['destinatario'];
	}
	else
	{
	$valor_clave=0;
	}
	$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
?>
<tr class="border_tr3">
<td>
<span class="fuente_normal">Cargo Destinatario</td>
<td>
<?php
	$valor_clave=$fila_clave["cargos_id"];
	$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
	echo $fila_clave["cargos_cargo"];
	$salvado_destino=$fila_clave["cargos_cod_depto"];
	}
		
?>
</td>
</tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">Departamento/Destino</td>
<td>
<?php
$valor_clave=$salvado_destino;
$conexion = mysqli_query($conn, "SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
	echo $fila_clave["departamento_descripcion_dep"];
	?>
	<input type=hidden name="cod_departamento" value="<?php echo $fila_clave["departamento_cod_departamento"];?>">
	<?php
	}
?>
</td>
</tr>

<?php
}
?>

<?php
if(!empty($_POST['destinatario']))
{
?>
<tr class="border_tr3">
<td valign="top">
<span class="fuente_normal">Cc:</td>
<td>
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<tr bgcolor="#CCCCCC">
<td width="200" align="center"><b>FUNCIONARIO</b></td>
<td width="200" align="center"><b>CARGO</b></td>
<td width="200" align="center"><b>DEPARTAMENTO</b></td>
</tr>
</table>

<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
$rss2=mysqli_query($conn, "SELECT * FROM asignar where asignar_mi_codigo='$codiguillo' and '$_POST[destinatario]'<> asignar_su_codigo");
if (mysqli_num_rows($rss2) > 0) 
{
while($row2 = mysqli_fetch_array($rss2)) 
{
?>
    <TR>
    <td bgcolor="#EFEBE3" width="200">
    <?php if (!empty($_POST['tarde']))
	{
	?>
     <input type="checkbox" value="<?php echo $row2["asignar_su_codigo"];?>" name="tarde[]" <?php if(in_array($row2["asignar_su_codigo"],$_POST['tarde'])) {echo "checked";} ?> />
    <?php
	}
	else
	{	
	?>
    <input type="checkbox" value="<?php echo $row2["asignar_su_codigo"];?>" name="tarde[]" />
    <?php
	}
    $valor_clave=$row2["asignar_su_codigo"];
	$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
		$valor_cargo=$fila_clave["cargos_id"];
		$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion");
		if($fila_cargo=mysqli_fetch_array($conexion2))
		{
		echo "<span class=fuente_normal>".$fila_cargo["usuario_nombre"]."</span>";
		}
	}	
	?>    
    </td>
	<td width="200">
	<?php
	$guardado=$row2["asignar_su_codigo"];
	$con_ocu=mysqli_query($conn, "SELECT * from cargos where $guardado = cargos_id");
	if($ocupacion=mysqli_fetch_array($con_ocu))
	{  
		 echo "<span class=fuente_normal>".$ocupacion["cargos_cargo"]."</span>";
		 $guardar_depto=$ocupacion["cargos_cod_depto"];
    }
	?>    </td>
	<td width="200">
		<?php
	$valor_clave=$guardar_depto;
	$conexion = mysqli_query($conn, "SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
	echo "<span class=fuente_normal>".$fila_clave["departamento_descripcion_dep"]."</span>";
	}
	    ?>
    </td>
<?php
}//end while
}//end if
?>
</table>
<br>
</td>
</tr>
<?php
}
?>


<tr class="border_tr3"><td><span class="fuente_normal">Instruccion</td>
<td>
<select name="codigo_instruccion">
<option value="">Seleccionar Instruccion</option>
<?php
$ssql4 = "SELECT * FROM instruccion order by instruccion_instruccion";
$rss4 = mysqli_query($conn, $ssql4);
while($row4=mysqli_fetch_array($rss4))
{
  if($_POST['codigo_instruccion']==$row4["instruccion_codigo_instruccion"])
  {
  echo "<option value=".$row4['instruccion_codigo_instruccion']." selected>";
  echo $row4["instruccion_instruccion"];
  echo "</option>";
  }
  else
  {
  echo "<option value=".$row4['instruccion_codigo_instruccion'].">";
  echo $row4["instruccion_instruccion"];
  echo "</option>";
  }
}
?>
</select>
 <?php Alert($codigo_instruccion);?>
</td>
</tr>

<tr class="border_tr3"><td><span class="fuente_normal">Proveido</td>
<td>
<textarea name="observaciones" class="caja_texto" cols="60" rows="2">
<?php
 if (isset($error))
 {
   echo $_POST['observaciones'];    
 }
?>
</textarea>
 <?php Alert($alert_obs);?>
</td>
</tr>

<td align="center" colspan="2">
<input type="submit" name="grabar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton"></td></tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>