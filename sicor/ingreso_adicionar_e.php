<?php
include("../filtro.php");
include("inicio.php");
include("../conecta.php");
include("cifrar.php");
include("script/functions.php");
$conn = Conectarse();
?>

<?php
    /**************************************************************************
			      PARA VALIDAR BOTÓN ATRÁS
    ***************************************************************************/
$rsrev=mysqli_query($conn, "select * from ingreso where ingreso_hoja_ruta='$_POST[hojaderuta]'");
if(mysqli_num_rows($rsrev) > 1)
{
?>
		  <script language="JavaScript">
			window.self.location="ingreso_recepcion.php";
		  </script>
<?php 
exit();
}
mysqli_free_result($rsrev);
?>

<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=450,height=300");
}
function Retornar()
{
    document.enviar.action="ingreso_recepcion.php";
    document.enviar.submit();
}
</script>
<?php
$respaaaa=mysqli_query($conn, "select * from cargos where cargos_id='$_SESSION[cargo_asignado]'");
if($rowaa=mysqli_fetch_array($respaaaa))
{
	$codigodepartamento = $rowaa["cargos_cod_depto"];
}
?>
<?php
	$respuesta=mysqli_query($conn, "SELECT * FROM departamento
                                WHERE departamento_cod_departamento='$codigodepartamento'");
	if ($rowasi=mysqli_fetch_array($respuesta))
	{
		$varuss=$rowasi["departamento_cod_edificio"];
		$sigladep=$rowasi["departamento_sigla_dep"];
	      	$respuestatres=mysqli_query($conn, "SELECT * FROM edificio
                                            WHERE edificio_cod_edificio='$varuss'");
        	if ($rowasitres=mysqli_fetch_array($respuestatres))
		{  
	               $codigoedificio=$rowasitres["edificio_cod_edificio"];		
   	               $siglaedificio=$rowasitres["edificio_sigla_ed"];
		}
	}
        
if(!empty($_POST['correspondencia_tipo']))
{
    $_SESSION["correspondencia_tipo_elegido"] = $_POST['correspondencia_tipo'];
    $_SESSION["correpondencia_regularizacion"] = $_POST['fecha_regularizacion'];
}

if ($_SESSION["correspondencia_tipo_elegido"] == "Regularizacion")
{
	
      if($_SESSION["correpondencia_regularizacion"] < date("Y-m-d") && !empty($_SESSION["correpondencia_regularizacion"]))
      {
       $ssql = "SELECT * FROM ingreso
                WHERE ingreso_fecha_ingreso = '$_SESSION[correpondencia_regularizacion]'
                AND ingreso_hoja_ruta_tipo = 'e'
                ORDER BY ingreso_nro_registro DESC";
        $rss_consulta = mysqli_query($conn, $ssql);
        if(mysqli_num_rows($rss_consulta) > 0)
        {
         if($row = mysqli_fetch_array($rss_consulta))
            {
                $fecha_ingreso = $_SESSION["correpondencia_regularizacion"];
                $hora_ingreso = $row["ingreso_hora_ingreso"];
                $hoja_ruta_recuperado1  = explode("-",$row["ingreso_hoja_ruta"]);
                $hoja_ruta_recuperado2 = explode("/",$hoja_ruta_recuperado1[2]);

                if(substr_count($hoja_ruta_recuperado2[0],".") > 0)
                 {
                    $hoja_ruta_recuperado3 = explode(".",$hoja_ruta_recuperado2[0]);
                    $numero_correlativo = $hoja_ruta_recuperado3[1] + 1;
                    $hoja_ruta_nueva = $hoja_ruta_recuperado3[0].".".$numero_correlativo;
                 }
                 else
                 {
                     $hoja_ruta_nueva = $hoja_ruta_recuperado2[0].".1";
                 }
                 
                 $hoja_ruta_nueva = $hoja_ruta_nueva."/".$hoja_ruta_recuperado2[1];
                 $hoja_ruta_v = $hoja_ruta_recuperado1[0]."-".$hoja_ruta_recuperado1[1]."-".$hoja_ruta_nueva;

            }
          }
           else
           {
                     echo "<br /><br /><br />";
                     echo "<center>NO SE HA ENCONTRADO CORRESPONDENCIA EN LA FECHA INDICADA";
                     echo "<br /><br /><a href=\"elegir.php\" class=\"boton\" />&nbsp;&nbsp; [Volver...]&nbsp;&nbsp; </a></center>";
                     echo "<br /><br /><br />";
                     exit;
           }
         }
         else
          {
                     echo "<br /><br /><br />";
                     echo "<center>FECHA NO VALIDA";
                     echo "<br /><br /><a href=\"elegir.php\" class=\"boton\" />&nbsp;&nbsp; [Volver...]&nbsp;&nbsp; </a></center>";
                     echo "<br /><br /><br />";
                     exit;
           }

}
else
{
      $ssql="SELECT * FROM edificio
                   WHERE edificio_cod_edificio='$codigoedificio'
                   ORDER BY edificio_hoja_ruta_ext DESC";
        $rss_consulta = mysqli_query($conn, $ssql);
            if($row=mysqli_fetch_array($rss_consulta))
            {
                     $hoja_num = $row["edificio_hoja_ruta_ext"];
                     $hoja_ruta_v = $hoja_num + 1;
                     $hoja_ruta_v = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
            }

          $fecha_ingreso = date("Y-m-d");
	  $hora_ingreso = date("H:i:s");
}

    $respuesta=mysqli_query($conn, "SELECT  * FROM instituciones WHERE instituciones_cod_institucion='$_SESSION[institucion]'");
    if ($rowasi=mysqli_fetch_array($respuesta))
    {
             $nro_reg=$rowasi["instituciones_nro_registro"];
    }

$nro_reg = $nro_reg + 1;


/*PROCEDIMIENTO DE ENVIO DE CORRESPODENCIA*/
if (isset($_POST['grabar'])) 
{
/**********************************************************************************
                                VALIDACIONES NUEVAS 
***********************************************************************************/

        $valor1=val_alfanum($_POST['entidad_remite']);
	if($valor1 == 0)
	{
             $error=1;
             $alert_ent=1;
	}
	
        $valor2=val_alfanum($_POST['remitente']);
	if($valor2 == 0)
	{ 
            $error=1;
            $alert_rem=1;
	}

         $valor3=val_alfanum($_POST['cargo_remitente']);
	if($valor3 == 0)
	{ 
             $error=1;
             $alert_crem=1;
	}

        $valor4=alfanumerico($_POST['numero_cite']);
	if($valor4 == 0)
	{ 
            $error=1;
            $alert_cite=1;
	}

	if (empty($_POST['fecha_cite']))
	{
		 $error=1;
		 $alert_fechacite=1; 
	}
	else
	{
		$guardar_fecha=$_POST['fecha_cite'];
		if($guardar_fecha > date("Y-m-d"))
		{ 
		 $error=1;
		 $alert_fechacite=1; 	
		}
	}

        $valor5=val_alfanum($_POST['referencia']);
	if($valor5 == 0)
	{ 
            $error=1;
            $alert_ref=1;
	}
	
	if(Val_numeros($_POST['cantidad_hojas']) == 1)
	{
	 $error= 1;
	 $alert_hojas=1;
	}
	
	if(Val_numeros($_POST['nro_anexos']) == 1)
	{
	 $error= 1;
	 $alert_anexos=1;
	}

         $valor6=val_alfanum($_POST['descripcion_clase_corresp']);
	if($valor6 == 0)
	{
	 $error=1;
         $alert_clase=1;
	}

if ($error == 0) 
{
$respaaaa=mysqli_query($conn, "select * from cargos where cargos_id='$_SESSION[cargo_asignado]'");
if($rowaa=mysqli_fetch_array($respaaaa))
{
	$codigodepartamento = $rowaa["cargos_cod_depto"];
}
$respuesta=mysqli_query($conn, "select * from departamento where departamento_cod_departamento='$codigodepartamento'");
	if ($rowasi=mysqli_fetch_array($respuesta))
	{
		$varuss=$rowasi["departamento_cod_edificio"];
		$sigladep=$rowasi["departamento_sigla_dep"];
	      	$respuestatres=mysqli_query($conn, "select * from edificio where edificio_cod_edificio='$varuss'");
        	if ($rowasitres=mysqli_fetch_array($respuestatres))
			{  
	               $codigoedificio=$rowasitres["edificio_cod_edificio"];		
   	               $siglaedificio=$rowasitres["edificio_sigla_ed"];
			}
	}

if ($_SESSION["correspondencia_tipo_elegido"] == "Regularizacion")
{
        $ssql = "SELECT * FROM ingreso
                     WHERE ingreso_fecha_ingreso = '$_SESSION[correpondencia_regularizacion]'
                     AND ingreso_hoja_ruta_tipo = 'e'
                     ORDER BY ingreso_nro_registro DESC";
        $rss_consulta = mysqli_query($conn, $ssql);
         if($row = mysqli_fetch_array($rss_consulta))
            {
                 $fecha_ingreso = $_SESSION["correpondencia_regularizacion"];
                 $hora_ingreso = $row["ingreso_hora_ingreso"];
                 $hoja_ruta_recuperado1  = explode("-",$row["ingreso_hoja_ruta"]);
                 $hoja_ruta_recuperado2 = explode("/",$hoja_ruta_recuperado1[2]);
                 
                 if(substr_count($hoja_ruta_recuperado2[0],".") > 0)
                 {
                    $hoja_ruta_recuperado3 = explode(".",$hoja_ruta_recuperado2[0]);
                    $numero_correlativo = $hoja_ruta_recuperado3[1] + 1;
                    $hoja_ruta_nueva = $hoja_ruta_recuperado3[0].".".$numero_correlativo;
                 }
                 else
                 {
                     $hoja_ruta_nueva = $hoja_ruta_recuperado2[0].".1";
                 }

                 $hoja_ruta_nueva = $hoja_ruta_nueva."/".$hoja_ruta_recuperado2[1];
                 $hoja_ruta = $hoja_ruta_recuperado1[0]."-".$hoja_ruta_recuperado1[1]."-".$hoja_ruta_nueva;
            }
            mysqli_free_result($rss_consulta);
			$codigo_gestion=date("Y"); //cambiar por gestion de ingreso o gestion de archivo original
}
else
{
      $ssql="SELECT * FROM edificio
                   WHERE edificio_cod_edificio='$codigoedificio'
                   ORDER BY edificio_hoja_ruta_ext DESC";
        $rss_consulta = mysqli_query($conn, $ssql);
            if($row=mysqli_fetch_array($rss_consulta))
            {
                     $hoja_num = $row["edificio_hoja_ruta_ext"];
                     $hoja_ruta_v = $hoja_num + 1;
                     $hoja_ruta = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
            }
            mysqli_free_result($rss_consulta);
            $fecha_ingreso=date("Y-m-d");
            $hora_ingreso=date("H:i:s");
            $codigo_gestion=date("Y");
}

        $respuesta=mysqli_query($conn, "SELECT * FROM departamento
                                WHERE departamento_cod_departamento='$codigodepartamento'");
	if ($rowasi=mysqli_fetch_array($respuesta))
	{
              $nro_registro = $rowasi["departamento_nroregistro_e"];
	}

$nro_registro = $nro_registro + 1;

$respuestados=mysqli_query($conn, "select * from instituciones
                           where instituciones_cod_institucion='$_SESSION[institucion]'");
if ($rowasidos=mysqli_fetch_array($respuestados))
{
	   $nro_registro_int=$rowasidos["instituciones_nro_registro"];		
}
$nro_registro_int = $nro_registro_int + 1;


$fecha_actual_generado = date("Y-m-d H:i:s");
$ssql2 = "INSERT INTO ingreso SET 
          ingreso_fecha_recepcion = '$fecha_actual_generado',
          ingreso_tipo_anexos = '$_POST[tipo_anexos]',
          ingreso_nro_registro = '$nro_registro_int',
          ingreso_codigo_gestion = '$codigo_gestion',
          ingreso_hoja_ruta = '$hoja_ruta',
          ingreso_descripcion_clase_corresp = '$_POST[descripcion_clase_corresp]',
          ingreso_nro_anexos = '$_POST[nro_anexos]',
          ingreso_fecha_ingreso = '$fecha_ingreso',
          ingreso_hora_ingreso = '$hora_ingreso',
          ingreso_cantidad_hojas = '$_POST[cantidad_hojas]',
          ingreso_numero_cite = '$_POST[numero_cite]',
          ingreso_fecha_cite = '$_POST[fecha_cite]',
          ingreso_referencia = '$_POST[referencia]',
          ingreso_entidad_remite = '$_POST[entidad_remite]',
          ingreso_remitente = '$_POST[remitente]',
          ingreso_cargo_remitente = '$_POST[cargo_remitente]',
          ingreso_estado = 'P',
          ingreso_hoja_ruta_tipo = 'e',
          ingreso_Cod_Institucion = '$_SESSION[institucion]',
          ingreso_cod_usr = '$_SESSION[cargo_asignado]',
          ingreso_nro_registro_e = '$nro_registro',
          ingreso_destinatario_principal  = '$destinatario_principal_ext',
          ingreso_codigo  = '$_SESSION[codigo]',
		  ingreso_codigor = '0'";
mysqli_query($conn, $ssql2);
//arreglar destinatario principal
     if ($_SESSION["correspondencia_tipo_elegido"] != "Regularizacion")
     {
	mysqli_query($conn, "UPDATE edificio SET
				  edificio_hoja_ruta_ext='$hoja_ruta_v'
				  WHERE edificio_cod_institucion='$_SESSION[institucion]'
				  AND edificio_cod_edificio='$codigoedificio'");
     }
        mysqli_query($conn, "UPDATE instituciones SET
                             instituciones_nro_registro='$nro_registro_int'
                             WHERE instituciones_cod_institucion='$_SESSION[institucion]'");
        unset($_POST);
?>
	 <script language="JavaScript">
			window.self.location="ingreso_recepcion.php";
	 </script>
 <?php  
 } 
}
   echo "<br />";
   echo "<p class=fuente_titulo>";
   echo "<center><B>INGRESO DE CORRESPONDENCIA";
   	   if ($tipo=='cg')
		{
		   echo " EXTERNA";
		}
		else
		{
	           echo " EXTERNA";
		}
   echo "</B></center></span>";
   echo "<br />";

if ($error != 0)
{
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>

<center>
<form  method="POST" name="enviar"> 
<table width="60%" cellspacing="2" cellpadding="2" border="0">
	  <tr class="truno">
	  <td align="center" class="border_tr2">
	  <b>Hoja de Ruta: </b>&nbsp; 
	  <?php echo "<b>".$hoja_ruta_v."</b>";?>
	  <input type="hidden" name="hojaderuta" value="<?php echo $hoja_ruta_v;?>" />			
	  </td>
	  <td align="left">
	  <b>Nro de Registro Entrada:</b>&nbsp;
	  <?php echo "<b>".$nro_reg."</b>";?>
	  </td>
	  </tr>

	  <tr class="truno">
	  <td class="border_tr2" align="right">
	  <span class="fuente_normal">Fecha y Hora de Ingreso al Sistema
	  </td>
	  <td>
	  <?php
	  echo $fecha_ingreso." ".$hora_ingreso;
	  ?>
	  </td>
	  </tr>
		
	  <tr class="truno">
	  <td class="border_tr2" align="right">
	  <span class="fuente_normal">Entidad Emisora
	  </td>
	  <td>
	  <input type="text" name="entidad_remite" class="caja_texto" size="40" value="<?php echo $_POST['entidad_remite'];?>">
	  <input type="hidden" name="entidad_remite2" class="caja_texto">
	  <a href="javascript:Abre_ventana('busca_entidad.php')">
	  <img src="images/puntos.gif">
	  </a>
	  <?php Alert($alert_ent);?>
	  </td>
	  </tr>
		
	  <tr class="truno">
	  <td class="border_tr2" align="right">
	  <span class="fuente_normal">Remitente</span>
	  </td>
	  <td>
	  <input type="text" name="remitente" class="caja_texto" value="<?php echo $_POST['remitente'];?>">
	  <?php Alert($alert_rem);?>
	  </td>
	  </tr>

	  <tr class="truno">
	  <td class="border_tr2" align="right">
	  <span class="fuente_normal">Cargo del Remitente
	  </td>
	  <td>
	  <input type="texto" name="cargo_remitente" class="caja_texto" value="<?php echo $_POST['cargo_remitente'];?>">
	  <?php Alert($alert_crem);?>
	  </td>
	  </tr>

	  <tr class="truno">
	  <td class="border_tr2" align="right"><span class="fuente_normal">No. de CITE</td>
	  <td>
	  <?php
	  echo "<input type=\"text\" name=\"numero_cite\" class=\"caja_texto\" value=".$_POST['numero_cite'].">";
	  Alert($alert_cite);
	  ?>
	  </td>
	  </tr>
	
	  <tr class="truno">
	  <td class="border_tr2" align="right">
	  <span class="fuente_normal">Fecha del CITE</td>
	  <td>
	  <?php
	  echo "<input type=\"text\" name=\"fecha_cite\" readonly=\"readonly\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_cite'].">";
	  echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
	  Alert($alert_fechacite);
	  ?>
	  </td>
	  </tr>
		
	  <tr class="truno"><td width="30%" class="border_tr2" align="right"><span class="fuente_normal">Clasificacion</span></td>
	  <td>
			<select name="descripcion_clase_corresp" class="caja_texto">
                                        <option value="">Seleccione una Clasificacion</option>
				<?php
					$ssql = "SELECT * FROM clasecorrespondencia order by clasecorrespondencia_descripcion_clase_corresp";
					$rss = mysqli_query($conn, $ssql);
					while($row=mysqli_fetch_array($rss))
					{  
					     if ($_POST['descripcion_clase_corresp']==$row["clasecorrespondencia_descripcion_clase_corresp"])
						 {
	               		  ?>	
  				         <option value="<?php echo $row["clasecorrespondencia_descripcion_clase_corresp"]?>" selected="selected">
                         <?php
	                      echo $row["clasecorrespondencia_descripcion_clase_corresp"];
						  ?>
					</option>
					<?php
					          }
						  else
						  {			
						  ?>
						  <option value="<?php echo $row["clasecorrespondencia_descripcion_clase_corresp"]?>">
						  <?php
						  echo $row["clasecorrespondencia_descripcion_clase_corresp"];
						  ?>
						  </option>
						  <?php
						  }
					}	   
				        ?>
			   </select>
        <?php Alert($alert_clase);?>	
	</td>
	</tr>
	<tr class="truno">
        <td class="border_tr2" align="right">
        <span class="fuente_normal">Referencia</td>
	<td>
	<textarea name="referencia" cols="60" rows="2" class="caja_texto"><?php echo $_POST['referencia'];?></textarea>
        <?php Alert($alert_ref);?>
	</td>
	</tr>
	
	<tr class="truno">
        <td class="border_tr2" align="right">
        <span class="fuente_normal">N&uacute;mero de Hojas</td>
	<td>
	<?php
	echo "<input type=\"text\" name=\"cantidad_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['cantidad_hojas'].">";
	Alert($alert_hojas);
	?>
	</td>
	</tr>
	
	<tr class="truno"><td class="border_tr2" align="right"><span class="fuente_normal">Cantidad Anexos</td>
	<td>
        <?php
 	echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['nro_anexos'].">";
	Alert($alert_anexos);
        ?>
	</td>
	</tr>
	
	<tr class="truno"><td class="border_tr2" align="right"><span class="fuente_normal">Tipo Anexo</td>
	<td>
	<?php
	echo "<input type=\"text\" name=\"tipo_anexos\" maxlength=100 size=50 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
  	?>
	</td>
	</tr>
	
	<tr>
	<td align="center" colspan="2">
        	<input type="submit" name="grabar" value="Grabar" class="boton"/>
		<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/>
	</td>
	</tr>
	</table>
	</form>
</center>

<?php
include("final.php");
?>