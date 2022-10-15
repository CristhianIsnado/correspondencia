<?php
include("../filtro.php");
include("inicio.php");
include("../conecta.php");
include("script/functions.php");
include("script/cifrar.php");
$cod_institucion = $_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$conn = Conectarse();
$ssqlao = "SELECT * FROM cargos WHERE '$cargo_unico'=cargos_id";
$rsao = mysqli_query($conn, $ssqlao);
if ($rowao = mysqli_fetch_array($rsao)) 
{
$departamentillo=$rowao["cargos_cod_depto"];
}
mysqli_free_result($rsao);

$sel_derivar=descifrar($_GET['datos']);

		/**************************************************************************
						            PARA VALIDAR BOTÓN ATRÁS
		***************************************************************************/
$rsrev = mysqli_query($conn, "SELECT * FROM seguimiento WHERE seguimiento_codigo_seguimiento='$sel_derivar' and seguimiento_tipo='D'");
if (mysqli_num_rows($rsrev) > 0) 
{
	?>
		  <script language="JavaScript">
			window.self.location="recepcion_lista.php";
		  </script>
<?php 
exit();
}

mysqli_free_result($rsrev);

if(!is_numeric($sel_derivar))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACI&Oacute;N DE DATOS !!!!</b></center>";
    exit;
}
		/**************************************************************************
							DESDE AQUI ENTRA PARA GRABAR
		***************************************************************************/
$error=0;
$fecha_plazo='';

if (isset($_POST['grabar']))
{

/**********************************************************************************
                                VALIDACIONES NUEVAS 
***********************************************************************************/

	 if(empty($_POST['destinatario']))
	{ 
	 $error=TRUE;
     $alert_coddepto=1; 	
	}
	
	if(empty($_POST['observaciones']))
	{ 
	 $error=TRUE;
     $alert_obs=1; 	
	}
	
	      if(empty($_POST['codigo_instruccion']))
   {
            $error=TRUE;
            $codigo_instruccion=1;
   }
	
	if($_POST['fecha_plazo'] != "")
	{
		$guardar_fecha=$_POST['fecha_plazo'];
		if(date("Y-m-d") > $guardar_fecha)
		{ 
		 $error=TRUE;
		 $alert_fechaplazo=1; 	
		}
	}

    if (!$error)
    {
	  $conn = Conectarse();
	  $resu123=mysqli_query($conn, "select * from cargos where cargos_id='$tarde[$i]'");//VER VECTOR
		if ($row123=mysqli_fetch_array($resu123))
		{
		  $unidad_destino=$row123["cargos_cod_depto"];
		  $usuario_destino=$row123["cargos_id"];
		}

    $fecha_deriva = date("Y-m-d H:i:s");
		/**************************************************************************
							SACAMOS LA DESCRIPCION DEL DEPARTAMENTO PARA 
							        EL USUARIO PRINCIPAL
		***************************************************************************/

	$descripayu=mysqli_query($conn, "select * from departamento where departamento_cod_departamento='$departamentillo'"); 
			if($rowaas=mysqli_fetch_array($descripayu))
			 {
				$procedencia=$rowaas["departamento_descripcion_dep"];
			 }


		/**************************************************************************
							SACAMOS LA DESCRIPCION DEL DEPARTAMENTO PARA 
							              EL USUARIO CC
		***************************************************************************/

     $descripayudos=mysqli_query($conn, "select * from departamento where departamento_cod_departamento='$unidad_destino'"); 
			if($rowaasdos=mysqli_fetch_array($descripayudos))
			 {
				$destino=$rowaasdos["departamento_descripcion_dep"];
			 }


		/**************************************************************************
					BUSQUEDA EN  MIDERIVACION DE MI CODIGO Y 
			SU CODIGO SACANDO  SU CODIGO Y SU DEPARTAMENTO (FUNCIONARIO DESTINO)
		***************************************************************************/	
		   
 	$ssql55 = "SELECT * FROM miderivacion where miderivacion_mi_codigo='$cargo_unico' and miderivacion_su_codigo='$_POST[destinatario]'";
	$rss55 = mysqli_query($conn, $ssql55);
	if($row55=mysqli_fetch_array($rss55))
	{
		    $destinatariouno=$row55["miderivacion_su_codigo"];
				$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE cargos_id=$destinatariouno");
				if($fila_clave=mysqli_fetch_array($conexion))
				{
			$departamentouno=$fila_clave["cargos_cod_depto"];
				}
	}

       /**************************************************************************
					SACAR TODO DE INGRESO DONDE $nro_registro 
					ES EL NRO DE REGISTRO DE LA TABLA INGRESO
		***************************************************************************/
		//nuevo
$rssaux=mysqli_query($conn, "SELECT * FROM seguimiento WHERE '$sel_derivar'= seguimiento_codigo_seguimiento");
if($rowaux=mysqli_fetch_array($rssaux))
{
$nro_registro=$rowaux["seguimiento_nro_registro"];
$hoja_ruta=$rowaux["seguimiento_hoja_ruta"];
$codigo_seguimiento=$rowaux["seguimiento_codigo_seguimiento"];
$remitente=$rowaux["seguimiento_destinatario"];
$dpto_remite=$rowaux["seguimiento_cod_departamento"];
//$codigo2=$rowaux["seguimiento_codigod"];//caso liberar
}		
		 
	$variable_ingreso=mysqli_query($conn, "select * from ingreso where ingreso_cod_institucion='$cod_institucion' AND '$nro_registro'=ingreso_nro_registro");
	if ($fila_ingreso=mysqli_fetch_array($variable_ingreso))
		{
        	$tipo_correspondencia_in=$fila_ingreso["ingreso_hoja_ruta_tipo"];	
			$fecha_recepcion_a=$fila_ingreso["ingreso_fecha_recepcion"];
			$cantidad_hojas_a=$fila_ingreso["ingreso_cantidad_hojas"];
			$nro_anexos_a=$fila_ingreso["ingreso_tipo_anexos"];
			$numero_cite_a=$fila_ingreso["ingreso_numero_cite"];
			$fecha_cite_a=$fila_ingreso["ingreso_fecha_cite"];
			$remitente_a=$fila_ingreso["ingreso_remitente"];
			$codigointerno=$fila_ingreso['ingreso_codigor'];
				if ($tipo_correspondencia_in=='e')
				{
				$entidad_remite_a=$fila_ingreso["ingreso_entidad_remite"];
				}
				else
				{
				$entidad_remite_a=$fila_ingreso["ingreso_cod_departamento"];
				}
			$referencia_a=$fila_ingreso["ingreso_referencia"];
			$clasificacion_de=$fila_ingreso["ingreso_descripcion_clase_corresp"];
			$cargo_de=$fila_ingreso["ingreso_cargo_remitente"];
		}

	$elementos2 = count($_POST['tarde']);
	$fecha_plazo = $_POST['fecha_plazo'];//ok

    $variable_consul=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$cargo_unico'");
	 if ($fila_ab=mysqli_fetch_array($variable_consul))
		{
			$nro_libro_ab=$fila_ab["usuario_nro_correspondencia"];
			$nro_libro_ab=$nro_libro_ab+1;
		}

//para liberar
$respuesta_codigo=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$_POST[destinatario]'"); 
if ($fila_cod=mysqli_fetch_array($respuesta_codigo))
  {
	$codigo1=$fila_cod["usuario_cod_usr"];
  }
$respuesta_codigoaa=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$remitente'"); 
if ($fila_codaa=mysqli_fetch_array($respuesta_codigoaa))
  {
	$codigo2=$fila_codaa["usuario_cod_usr"];
  }  
//fin para liberar

//para liberar

if ($tipo_correspondencia_in=='i')
{
$respuesta_codigo2=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$remitente'"); 
if ($fila_cod2=mysqli_fetch_array($respuesta_codigo2))
  {
	$codigo4=$codigointerno;
  }
}
else
{
$codigo4='0';
}  
//fin para liberar
		
	mysqli_query($conn, "update usuario set usuario_nro_correspondencia='$nro_libro_ab' where usuario_ocupacion='$cargo_unico'");
	
	mysqli_query($conn, "INSERT INTO libroregistro(libroregistro_cod_departamento,libroregistro_hoja_ruta,libroregistro_tipo,libroregistro_fecha_recepcion,libroregistro_hojas,libroregistro_anexos,libroregistro_cite,libroregistro_fecha_cite,libroregistro_remitente,libroregistro_procedencia,libroregistro_referencia,libroregistro_recepcion,libroregistro_destino,libroregistro_fecha_salida,libroregistro_nro_libro,libroregistro_cod_usr,libroregistro_cargo_remitente,libroregistro_clasificacion,libroregistro_codigor,libroregistro_codigoc,libroregistro_codigori)VALUES('$departamentillo','$hoja_ruta','$tipo_correspondencia_in','$fecha_recepcion_a','$cantidad_hojas_a','$nro_anexos_a','$numero_cite_a','$fecha_cite_a','$remitente_a','$entidad_remite_a','$referencia_a','$destinatariouno','$departamentouno','$fecha_deriva','$nro_libro_ab','$cargo_unico','$cargo_de','$clasificacion_de','$codigo1','$codigo2','$codigo4')") or die("Fallo");
	$ssql = "INSERT INTO  seguimiento(seguimiento_cod_departamento,seguimiento_destinatario,seguimiento_tipo,seguimiento_hoja_ruta,seguimiento_nro_registro,seguimiento_fecha_deriva,seguimiento_codigo_instruccion,seguimiento_dpto_remite,seguimiento_remitente,seguimiento_fecha_plazo,seguimiento_estado,seguimiento_observaciones,seguimiento_cod_institucion,seguimiento_prioridad,seguimiento_cod_departamento_Emisor,seguimiento_codigod,seguimiento_codigor,seguimiento_archivado) VALUES ('$_POST[cod_departamento]','$destinatariouno','A','$hoja_ruta','$nro_registro','$fecha_deriva','$_POST[codigo_instruccion]','$dpto_remite','$remitente','$fecha_plazo','P','$_POST[observaciones]','$cod_institucion','$_POST[prioridad_total]','$departamentillo','$codigo1','$codigo2','0')";

	 if (mysqli_query($conn, $ssql)) 
	 {
		 mysqli_query($conn, "update seguimiento set seguimiento_tipo='D' where seguimiento_codigo_seguimiento='$codigo_seguimiento'");
	 }

	 $var_sql=mysqli_query($conn, "select * from seguimiento where '$cod_institucion'=seguimiento_cod_institucion order by seguimiento_codigo_seguimiento DESC");
	 if ($fila_a=mysqli_fetch_array($var_sql))
		{
			$codigo_seguimiento_1=$fila_a["seguimiento_codigo_seguimiento"];
		}

for($i=0; $i < $elementos2; $i++)
{   $var=$_POST['tarde']; 
	$resu123=mysqli_query($conn, "select * from miderivacion where miderivacion_su_codigo='$var[$i]'");

	if ($row123=mysqli_fetch_array($resu123))
	{
	  $usuario_destino=$row123["miderivacion_su_codigo"];
	  
		//para liberar
		$respuesta_codigo=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$usuario_destino'"); 
		if ($fila_cod=mysqli_fetch_array($respuesta_codigo))
		  {
			$codigo3=$fila_cod["usuario_cod_usr"];
		  }
		//fin para liberar	  
			
			$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$usuario_destino'=cargos_id");
			if($fila_clave=mysqli_fetch_array($conexion))
			{
			$unidad_destino=$fila_clave["cargos_cod_depto"];
			$usuario_departamentillo_a=$fila_clave["cargos_cod_depto"];
			}	  
	}

	$variable_ab=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$cargo_unico'");
	 if ($fila_ab=mysqli_fetch_array($variable_ab))
		{
			$nro_libro_ab=$fila_ab["usuario_nro_correspondencia"];
			$nro_libro_ab=$nro_libro_ab+1;
		}

	mysqli_query($conn, "update usuario set usuario_nro_correspondencia='$nro_libro_ab' where usuario_ocupacion='$cargo_unico'");

	$var_ssql="INSERT INTO  correspondenciacopia(correspondenciacopia_cod_departamento,correspondenciacopia_destinatario,correspondenciacopia_tipo,correspondenciacopia_hoja_ruta,correspondenciacopia_nro_registro,correspondenciacopia_fecha_deriva,correspondenciacopia_codigo_instruccion,correspondenciacopia_dpto_remite,correspondenciacopia_remitente,correspondenciacopia_fecha_plazo,correspondenciacopia_estado,correspondenciacopia_observaciones,correspondenciacopia_cod_institucion,correspondenciacopia_prioridad,correspondenciacopia_cod_departamento_Emisor,correspondenciacopia_codigo_seguimiento,correspondenciacopia_codigod,correspondenciacopia_codigor,correspondenciacopia_archivado) VALUES ('$unidad_destino','$usuario_destino','A','$hoja_ruta','$nro_registro','$fecha_deriva','$_POST[codigo_instruccion]','$dpto_remite','$remitente','$fecha_plazo','p','$_POST[observaciones]','$cod_institucion','$_POST[prioridad_total]','$departamentillo','$codigo_seguimiento_1','$codigo3','$codigo2','0')";
	mysqli_query($conn, $var_ssql);
	
	mysqli_query($conn, "INSERT INTO libroregistro(libroregistro_cod_departamento,libroregistro_hoja_ruta,libroregistro_tipo,libroregistro_fecha_recepcion,libroregistro_hojas,libroregistro_anexos,libroregistro_cite,libroregistro_fecha_cite,libroregistro_remitente,libroregistro_procedencia,libroregistro_referencia,libroregistro_recepcion,libroregistro_destino,libroregistro_fecha_salida,libroregistro_nro_libro,libroregistro_cod_usr,libroregistro_cargo_remitente,libroregistro_clasificacion,libroregistro_codigor,libroregistro_codigoc,libroregistro_codigori)VALUES('$departamentillo','$hoja_ruta','$tipo_correspondencia_in','$fecha_recepcion_a','$cantidad_hojas_a','$nro_anexos_a','$numero_cite_a','$fecha_cite_a','$remitente_a','$entidad_remite_a','$referencia_a','$usuario_destino','$usuario_departamentillo_a','$fecha_deriva','$nro_libro_ab','$cargo_unico','$cargo_de','$clasificacion_de','$codigo3','$codigo2','$codigo4')") or die("Fallo");

} // fin for
?>
  <script language="JavaScript">
    window.self.location="recepcion_lista.php";
  </script>
<?php	
  }//fin if error
} //fin if isset grabar

	if (isset($_POST['cancelar']))
	{
	?>
		  <script language="JavaScript">
			window.self.location="recepcion_lista.php";
		  </script>
	<?php
	}
?>
<script>

function Combo()
{
  document.derivar.action="derivar.php";
  document.derivar.submit();
}

function Retornar()
{
  document.enviar.action="recepcion_lista.php";
  document.enviar.submit();
}

</script>
<br>
<?php
if ($error == 0)
{
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>DERIVACI&Oacute;N DE CORRESPONDENCIA</b></div></p>";
} 
else 
{ 
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>
<center>

<table width="60%" cellspacing="2" cellpadding="2"  border="0">
<form  method="POST" name="enviar">
<tr class="truno">
<td align="right"><span class="fuente_normal"><b>HOJA DE RUTA</b></td>

<td>

<?php
$ssql3="SELECT * FROM seguimiento WHERE '$sel_derivar'= seguimiento_codigo_seguimiento";
$rss3=mysqli_query($conn, $ssql3);
$row3=mysqli_fetch_array($rss3);
echo $row3["seguimiento_hoja_ruta"];
?>
</td>
</tr>

<tr class="truno">
<td align="right"><span class="fuente_normal"><b>FECHA Y HORA DE DERIVACI&Oacute;N</b></td> 
<td>
<?php echo date("Y-m-d H:i:s");?>
</td>
</tr>

<tr class="truno">
<td align="right">
<span class="fuente_normal"><b>FUNCIONARIO/DESTINO</b></td>
<td>
<select name="destinatario" onchange="this.form.submit()">
  <option value=""> Seleccione un Funcionario</option>
  <?php
$ssql55_1 = "SELECT * FROM usuario where usuario_ocupacion='$cargo_unico' and usuario_active='1'";
$rss55_1 = mysqli_query($conn, $ssql55_1);  
if (mysqli_num_rows($rss55_1) > 0)
{  
  
$ssql55 = "SELECT * FROM miderivacion where miderivacion_mi_codigo='$cargo_unico' and miderivacion_estado='1'";
$rss55 = mysqli_query($conn, $ssql55);
while($row55=mysqli_fetch_array($rss55))
{
	if ($_POST['destinatario']==$row55["miderivacion_su_codigo"])
	  { 
		    echo "<option value=".$row55["miderivacion_su_codigo"]." selected>";
			$valor_clave=$row55["miderivacion_su_codigo"];
			$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
			if($fila_clave=mysqli_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion");
				if($fila_cargo=mysqli_fetch_array($conexion2))
				{
					$cargo_recibidor = $fila_cargo["usuario_ocupacion"];
					$row_cargo = mysqli_query($conn, "select * from cargos where cargos_id = $cargo_recibidor");
					$row_cargo1 = mysqli_fetch_array($row_cargo);
					echo $row_cargo1["cargos_cargo"]; echo " - ";  echo $fila_cargo["usuario_nombre"];
				}
			}
			
		echo "</option>";
      }
    else
      {
	        echo "<option value=".$row55["miderivacion_su_codigo"].">";
			$valor_clave=$row55["miderivacion_su_codigo"];
			$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
			if($fila_clave=mysqli_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion");
				if($fila_cargo=mysqli_fetch_array($conexion2))
				{
					$cargo_recibidor = $fila_cargo["usuario_ocupacion"];
					$row_cargo = mysqli_query($conn, "select * from cargos where cargos_id = $cargo_recibidor");
					$row_cargo1 = mysqli_fetch_array($row_cargo);
					echo $row_cargo1["cargos_cargo"]; echo " - ";  echo $fila_cargo["usuario_nombre"];
				}

			}		  
		echo "</option>";
	   }
}
}//if
mysqli_free_result($rss55);
?>
</select>
 <?php Alert($alert_coddepto);?>
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
<tr class="truno">
<td align="right">
<span class="fuente_normal"><b>CARGO DESTINATARIO</b></td>
<td>
<?php
	$valor_clave=$fila_clave["cargos_id"];
	$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
	echo $fila_clave["cargos_cargo"];
	$salvado_destino=$fila_clave["cargos_cod_depto"];
	}	
?></td>
</tr>
<tr class="truno">
<td align="right">
<span class="fuente_normal"><b>DEPARTAMENTO/DESTINO</b></td>
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
?></td>
</tr>
<?php
}
?>

<tr class="truno">
<td align="right">
<span class="fuente_normal"><b>PRIORIDAD</b></td>
<td>
<select name="prioridad_total">
<?php
if (!empty($_POST['prioridad_total']))
{
	if ($_POST['prioridad_total']=='Alta')
	{ echo "<option value='Alta' selected>Alta</option>";
   	  echo "<option value='Media' >Media</option>";
      echo "<option value='Baja' >Baja</option>";
	}
	else
	{
	   if ($_POST['prioridad_total']=='Media')
		{echo "<option value='Alta' >Alta</option>";
		 echo "<option value='Media'selected >Media</option>";
         echo "<option value='Baja' >Baja</option>"; 
		}
		else
		{echo "<option value='Alta' >Alta</option>";
 		 echo "<option value='Media' >Media</option>";
         echo "<option value='Baja' selected>Baja</option>";
		}
	}
	
	}
else
{
echo "<option value='Alta' >Alta</option>";
echo "<option value='Media' >Media</option>";
echo "<option value='Baja' >Baja</option>";
}
?>
</select>
</td>
</tr>
<?php
if(!empty($_POST['destinatario']))
{
?>
<tr class="truno">
<td align="right" valign="top">
<span class="fuente_normal"><b>CC:</b></td>
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
$rss2=mysqli_query($conn, "SELECT * FROM miderivacion where miderivacion_mi_codigo='$cargo_unico' and '$_POST[destinatario]'<> miderivacion_su_codigo and miderivacion_estado='1'");
if (mysqli_num_rows($rss2) > 0) 
{
while($row2 = mysqli_fetch_array($rss2)) 
{
?>
    <TR class="trdos">
    <td width="200">
    <?php if (!empty($_POST['tarde']))
	{
	?>
     <input type="checkbox" value="<?php echo $row2["miderivacion_su_codigo"];?>" name="tarde[]" <?php if(in_array($row2["miderivacion_su_codigo"],$_POST['tarde'])) {echo "checked";} ?> />
    <?php
	}
	else
	{	
	?>
    <input type="checkbox" value="<?php echo $row2["miderivacion_su_codigo"];?>" name="tarde[]" />
    <?php
	}
    $valor_clave=$row2["miderivacion_su_codigo"];
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
	?>    </td>
	<td width="200">
	<?php
	$guardado=$row2["miderivacion_su_codigo"];
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
	    ?></td>
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


<tr class="truno"><td align="right"><span class="fuente_normal"><b>FECHA PLAZO</b></td>
<td>
<?php
echo "<input type=\"text\" name=\"fecha_plazo\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_plazo'].">";
echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
 Alert($alert_fechaplazo);
?></td>
</tr>



<tr class="truno"><td align="right"><span class="fuente_normal"><b>INSTRUCCI&Oacute;N</b></td>
<td>
<select name="codigo_instruccion" class="caja_texto">
<option value="">Seleccione una Instruccion</option>
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
mysqli_free_result($rss4);
?>
</select>
 <?php Alert($codigo_instruccion);?>
</td>
</tr>

<tr class="truno"><td align="right"><span class="fuente_normal"><b>PROVEIDO</b></td>
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

<tr>
<td align="center" colspan="2">
<input type="submit" name="grabar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton"></td>
</tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>