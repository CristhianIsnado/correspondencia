<?php
include("../filtro.php");
include("inicio.php");
include("../conecta.php");
include("script/functions.php");
include("script/cifrar.php");
$cod_institucion = $_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$variable=descifrar($_GET['nro_registro']);
if(!is_numeric($variable))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}

$conn = Conectarse();

$respaaaa=mysqli_query($conn, "SELECT * FROM cargos WHERE cargos_id='$_SESSION[cargo_asignado]'");
if($rowaa=mysqli_fetch_array($respaaaa))
{
	$departamentillo=$rowaa["cargos_cod_depto"];
}

if (isset($_POST['enviar']))
{

/**********************************************************************************
                                VALIDACIONES NUEVAS 
***********************************************************************************/
    
	if($_POST['edificio_destino'] == "")
	{ 
            $aux=1;
            $alert_edificio=1;
	}
	
	if($_POST['unidad_destino'] == "")
	{ 
	 $aux=2;
     $alert_unidad=1; 	
	}
	
	if($_POST['usuario_destino'] == "")
	{ 
            $aux=3;
            $alert_usuario=1;
	}
	
	if(empty($_POST['codigo_instruccion']))
	{
		$aux=4;
			 $alert_usuario=1;
	}
	
	   
  if ($aux == 0)
	{
		$conn = Conectarse();
    
	  if($_POST['unidad_destino']==$departamentillo)
	     {
		   $estado_registro_e='S';
		 }
		 else
		 {
           $estado_registro_e='N';  
		 }

$rss1=mysqli_query($conn, "SELECT * FROM ingreso WHERE '$variable'=ingreso_nro_registro and ingreso_cod_institucion='$_SESSION[institucion]'");
if($row1=mysqli_fetch_array($rss1))
{
$hoja_ruta=$row1["ingreso_hoja_ruta"];
$tipodecorres=$row1["ingreso_hoja_ruta_tipo"];
if ($row1["ingreso_hoja_ruta_tipo"]=='e')
{
$usr_remitente=$row1["ingreso_remitente"];
}
else
{
	$respuesta_codigo1=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$row1[ingreso_remitente]'"); 
	if ($fila_cod1=mysqli_fetch_array($respuesta_codigo1))
	  {
		$codigo3=$fila_cod1["usuario_cod_usr"];
		$usr_remitente=$row1["ingreso_remitente"];
	  }
}
}
//para liberar
$respuesta_codigo=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$_POST[usuario_destino]'"); 
if ($fila_cod=mysqli_fetch_array($respuesta_codigo))
  {
	$codigo1=$fila_cod["usuario_cod_usr"];
  }
//fin para liberar
		 $respuesta_dos_ingreso=mysqli_query($conn, "select * from ingreso where ingreso_cod_institucion='$_SESSION[institucion]' AND ingreso_nro_registro='$variable'"); 
		 if ($fila_q=mysqli_fetch_array($respuesta_dos_ingreso))
			  {
				$observacion_ingreso=$fila_q["ingreso_referencia"];
			  }

         $fecha_despacho=date("Y-m-d")." ".date("H:i:s");

if($row1["ingreso_hoja_ruta_tipo"]=='e')
{
	 $ssql = "INSERT INTO  seguimiento(seguimiento_codigo_instruccion,seguimiento_cod_departamento,seguimiento_destinatario,seguimiento_observaciones,seguimiento_hoja_ruta,seguimiento_nro_registro,seguimiento_fecha_deriva,seguimiento_tipo,seguimiento_remitente,seguimiento_dpto_remite,seguimiento_estado,seguimiento_cod_institucion,seguimiento_estado_registro_e,seguimiento_prioridad,seguimiento_codigod,seguimiento_codigor,seguimiento_archivado) VALUES ('$_POST[codigo_instruccion]','$_POST[unidad_destino]','$_POST[usuario_destino]','$observacion_ingreso','$hoja_ruta','$variable','$fecha_despacho','A','$_SESSION[codigo]','0','P','$_SESSION[institucion]','$estado_registro_e','Media','$codigo1','$_SESSION[codigo]','0')";
}
else
{
$ssql = "INSERT INTO  seguimiento(seguimiento_codigo_instruccion,seguimiento_cod_departamento,seguimiento_destinatario,seguimiento_observaciones,seguimiento_hoja_ruta,seguimiento_nro_registro,seguimiento_fecha_deriva,seguimiento_tipo,seguimiento_remitente,seguimiento_dpto_remite,seguimiento_estado,seguimiento_cod_institucion,seguimiento_estado_registro_e,seguimiento_prioridad,seguimiento_codigod,seguimiento_codigor,seguimiento_archivado) VALUES ('$_POST[codigo_instruccion]','$_POST[unidad_destino]','$_POST[usuario_destino]','$observacion_ingreso','$hoja_ruta','$variable','$fecha_despacho','A','$_SESSION[codigo]','0','P','$_SESSION[institucion]','$estado_registro_e','Media','$codigo1','$codigo3','0')";

}

	if (mysqli_query($conn, $ssql)) 
	{
		 mysqli_query($conn, "UPDATE ingreso SET ingreso_estado='T' WHERE ingreso_nro_registro='$variable' and ingreso_cod_institucion='$_SESSION[institucion]'");    
	     
		 $imprimeh=encryto($variable);
		
		 $respuestaq=mysqli_query($conn, "SELECT * FROM ingreso
                                          WHERE ingreso_cod_institucion='$_SESSION[institucion]'
                                          AND ingreso_nro_registro='$variable'");
		 if ($rowq=mysqli_fetch_array($respuestaq))
			  {
				$fecha_recepcion=$rowq["ingreso_fecha_recepcion"];
				$hojas=$rowq["ingreso_cantidad_hojas"];
				$tipo_correspondencia_in=$rowq["ingreso_hoja_ruta_tipo"];
				$anexos=$rowq["ingreso_tipo_anexos"];
				$clasificacion_de=$rowq["ingreso_descripcion_clase_corresp"];
				$cargo_de=$rowq["ingreso_cargo_remitente"];
				$cite=$rowq["ingreso_numero_cite"];
		        $fecha_cite=$rowq["ingreso_fecha_cite"];
			    $remitente=$rowq["ingreso_remitente"];
				
				
				
  		        $codigo2=$rowq["ingreso_codigo"];//caso liberar
				if(!empty($rowq["ingreso_entidad_remite"]))    
				  {
					$procedencia=$rowq["ingreso_entidad_remite"];
		   	      }
				   else
				  {
		            $codijj=$rowq["ingreso_cod_departamento"];
					$descripayu=mysqli_query($conn, "select * from departamento where departamento_cod_departamento='$codijj'"); 
					if($rowaas=mysqli_fetch_array($descripayu))
						 {
							$procedencia=$rowaas["departamento_cod_departamento"];
						 }

				  }

					$referencia=$rowq["ingreso_referencia"];
					$recepcion=$_POST['usuario_destino'];
//para liberar
$respuesta_codigo=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$_POST[usuario_destino]'"); 
if ($fila_cod=mysqli_fetch_array($respuesta_codigo))
  {
	$codigo1=$fila_cod["usuario_cod_usr"];
  }
//fin para liberar

//para liberar

if ($tipodecorres=='i')
{
$respuesta_codigo2=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$remitente'"); 
if ($fila_cod2=mysqli_fetch_array($respuesta_codigo2))
  {
	$codigo4=$fila_cod2["usuario_cod_usr"];
  }
}
else
{
$codigo4='0';
}  
//fin para liberar
					
					$descripayu=mysqli_query($conn, "select * from departamento where departamento_cod_departamento='$_POST[unidad_destino]'"); 
					if($rowaas=mysqli_fetch_array($descripayu))
						 {
							$destino=$rowaas["departamento_cod_departamento"];
						 }
					$nro_registro_e=$rowq["ingreso_nro_registro_e"];
			   }
	  
		 $variable_a=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$cargo_unico'");
		 if ($fila_a=mysqli_fetch_array($variable_a))
			{
				$nro_libro=$fila_a["usuario_nro_correspondencia"];
				$nro_libro=$nro_libro+1;
			}

		 mysqli_query($conn, "update usuario set usuario_nro_correspondencia='$nro_libro' where usuario_ocupacion='$cargo_unico'");
	
		 mysqli_query($conn, "INSERT INTO libroregistro(libroregistro_cod_departamento,libroregistro_hoja_ruta,libroregistro_tipo,libroregistro_fecha_recepcion,libroregistro_hojas,libroregistro_anexos,libroregistro_cite,libroregistro_fecha_cite,libroregistro_remitente,libroregistro_procedencia,libroregistro_referencia,libroregistro_recepcion,libroregistro_destino,libroregistro_fecha_salida,libroregistro_nro_libro,libroregistro_cod_usr,libroregistro_cargo_remitente,libroregistro_clasificacion,libroregistro_codigor,libroregistro_codigoc,libroregistro_codigori)VALUES('$departamentillo','$hoja_ruta','$tipo_correspondencia_in','$fecha_recepcion','$hojas','$anexos','$cite','$fecha_cite','$remitente','$procedencia','$referencia','$recepcion','$destino','$fecha_despacho','$nro_libro','$cargo_unico','$cargo_de','$clasificacion_de','$codigo1','$codigo2','$codigo4')") or die("Fallo");  	
	 }	

	?>
            <script language="JavaScript">
		window.open('imprime_hoja34.php?imprimeh=<?php echo $imprimeh;?> & unidad_destino=<?php echo $_POST['unidad_destino'];?> & usuario_destino=<?php echo $_POST['usuario_destino']; ?>','Imprimir');		
                window.self.location="ingreso_recepcion.php";
            </script>
	<?php
}
} //en if isset enviar
if (isset($_POST['cancelar']))
{
			?>
			 <script language="JavaScript">
			    window.self.location="ingreso_recepcion.php";
		     </script>
			<?php
}
?>

<br>
<?php if ($aux == 0){
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>DESPACHO DE CORRESPONDENCIA</b></div></p>";
} else 
{ echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! ERROR INTRODUCIR DATOS VALIDOS !!!</b></div></p>";
}
?>
<center>
<table width="60%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="despachar">
<tr class="truno"><td align="right">
<?php
$ssql3="SELECT * FROM ingreso
        WHERE '$variable'=ingreso_nro_registro
        AND ingreso_cod_institucion='$cod_institucion'";
$rss3=mysqli_query($conn, $ssql3);
$row3=mysqli_fetch_array($rss3);
?>
<span class="fuente_normal"><b>HOJA DE RUTA</b></span></td>
<td><?php echo "<b>".$row3["ingreso_hoja_ruta"]."</b>";?></td></tr>
<?php
$rssmul=mysqli_query($conn, "SELECT * FROM registroarchivo
        WHERE registroarchivo_hoja_interna='$row3[ingreso_numero_cite]'");
if($rowmul=mysqli_fetch_array($rssmul))
{
$multiples=$rowmul["registroarchivo_multiples"];
}
mysqli_free_result($rssmul);

if($row3["ingreso_hoja_ruta_tipo"]=='i' and $multiples=='P')
{
?>
<?php
    $ssqlcinco="SELECT * FROM registroarchivo a, derivaciones b
                WHERE a.registroarchivo_hoja_interna='$row3[ingreso_numero_cite]'
                AND  a.registroarchivo_codigo=b.derivaciones_hoja_interna
                AND b.derivaciones_estado='P'";
    $rsscinco = mysqli_query($conn, $ssqlcinco);
    if ($rowcinco=mysqli_fetch_array($rsscinco))
    {
    ?>
        <tr class="truno">
            <td align="right"><span class="fuente_normal"><b>EDIFICIO</b></span></td>
            <td>
                <?php
                    $sql_auxiliar = mysqli_query($conn, "SELECT b.edificio_descripcion_ed, b.edificio_cod_edificio FROM cargos a, edificio b
                                                 WHERE a.cargos_id='$rowcinco[derivaciones_cod_usr]'
                                                 AND b.edificio_cod_edificio=a.cargos_edificio");
                    if($fila_cargo=  mysqli_fetch_array($sql_auxiliar))
                    {
                      ?>
                        <select name="edificio_destino" class="caja_texto">
                            <option value="<?php echo $fila_cargo["edificio_cod_edificio"];?>">
                                <?php echo $fila_cargo["edificio_descripcion_ed"];?>
                            </option>
                        </select>
                      <?php
                    }
                    mysqli_free_result($sql_auxiliar);
                ?>
            </td>
        </tr>
        <tr class="truno">
            <td align="right"><span class="fuente_normal"><b>DEPARTAMENTO</b></span></td>
            <td>
                <?php
                    $sql_auxiliar = mysqli_query($conn, "SELECT b.departamento_cod_departamento, b.departamento_descripcion_dep
                                                 FROM cargos a, departamento b
                                                 WHERE a.cargos_id='$rowcinco[derivaciones_cod_usr]'
                                                 AND b.departamento_cod_departamento=a.cargos_cod_depto");
                    if($fila_cargo=  mysqli_fetch_array($sql_auxiliar))
                    {
                        ?>
                        <select name="unidad_destino" class="caja_texto">
                            <option value="<?php echo $fila_cargo["departamento_cod_departamento"];?>">
                                <?php echo $fila_cargo["departamento_descripcion_dep"];?>
                            </option>
                        </select>
                      <?php
                    }
                    mysqli_free_result($sql_auxiliar);
                ?>
            </td>
        </tr>
        <tr class="truno">
            <td align="right"><span class="fuente_normal"><b>USUARIO</b></span></td>
            <td>
                <?php
                    $sql_auxiliar = mysqli_query($conn, "SELECT b.usuario_nombre, b.usuario_ocupacion FROM usuario b
                                                 WHERE b.usuario_ocupacion='$rowcinco[derivaciones_cod_usr]'");
                    if($fila_cargo=  mysqli_fetch_array($sql_auxiliar))
                    {
                        ?>
                        <select name="usuario_destino" class="caja_texto">
                            <option value="<?php echo $fila_cargo["usuario_ocupacion"];?>">
                                <?php echo $fila_cargo["usuario_nombre"];?>
                            </option>
                        </select>
                      <?php
                    }
                    mysqli_free_result($sql_auxiliar);
                ?>
            </td>
        </tr>
    <?php
    }
    mysqli_free_result($rsscinco);
?>
<?php
}
else
{
?>

<tr class="truno"><td align="right"><span class="fuente_normal"><b>EDIFICIO / DESTINO </b></td>
		<td>
			<select name="edificio_destino" class="caja_texto" onChange="this.form.submit()">
			<option value="">Selecione un Edificio</option>
			<?php
				$ssqlcinco="SELECT * FROM edificio WHERE '$cod_institucion'=edificio_cod_institucion order by edificio_descripcion_ed ";
				$rsscinco = mysqli_query($conn, $ssqlcinco);
				while ($rowcinco=mysqli_fetch_array($rsscinco))
					 {
						if($_POST['edificio_destino']==$rowcinco["edificio_cod_edificio"])
							{
			?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>" selected>
								<?php
									echo $rowcinco["edificio_descripcion_ed"];
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>">
							<?php
								echo $rowcinco["edificio_descripcion_ed"];
							?>
								</option>
					<?php
						    }
					 } 

					?>
			</select>
            <?php Alert($alert_edificio);?>
		</td></tr>
		<tr class="truno">
        <td align="right"><span class="fuente_normal"><b>UNIDAD / DESTINO </b></td>
		<td>
        <select name="unidad_destino" class="caja_texto" onChange="this.form.submit()">
				<option value="">Selecione un Departamento</option>
				<?php
					$ssql="SELECT * FROM departamento WHERE '$cod_institucion'=departamento_cod_institucion and departamento_cod_edificio='$_POST[edificio_destino]' order by departamento_descripcion_dep ";
					$rss = mysqli_query($conn, $ssql);
				   if (mysqli_num_rows($rss) > 0) 
					 {
						while($row=mysqli_fetch_array($rss))
							{
								if (isset($_POST['unidad_destino'])) 
									{
								      if ($_POST['unidad_destino']==$row["departamento_cod_departamento"])
						  				{
			    ?>
											<option value="<?php echo $row["departamento_cod_departamento"];?>" selected >
									         <?php echo $row["departamento_descripcion_dep"];
									         echo "</option>";
					       				} 
									   else 
									    {
									   ?>
									   		<option value="<?php echo $row["departamento_cod_departamento"];?>" >
									           <?php echo $row["departamento_descripcion_dep"];
								           echo "</option>"; 	   
						   				}  
				   					}
								   else
									{
									  ?>
									  		<option value="<?php echo $row["departamento_cod_departamento"];?>">
									  <?php 
												  echo $row["departamento_descripcion_dep"];
										   	echo "</option>";
				   					} //end if isset
						  } // while  
				}
				else 
				mysqli_free_result($rss);
			echo "</select>";
	   Alert($alert_unidad);		
		?>
		</td></tr>

		<tr class="truno">
        <td align="right"><span class="fuente_normal"><b>DESTINATARIO</b></td>
		<td>
			<select name="usuario_destino" class="caja_texto">
			<?php
				if (isset($_POST['usuario_destino'])) 
						{
						$ssql2="SELECT * FROM usuario a, departamento b WHERE '$_POST[unidad_destino]'=a.usuario_cod_departamento AND '$cod_institucion'=a.usuario_cod_institucion AND a.usuario_cod_departamento=b.departamento_cod_departamento AND b.departamento_cod_edificio='$_POST[edificio_destino]' AND a.usuario_active='1'";
						  $rss2 = mysqli_query($conn, $ssql2);
						  if (mysqli_num_rows($rss2) > 0) 
							{
							  while($row2=mysqli_fetch_array($rss2))
								{
									$cargo_recibidor = $row2["usuario_ocupacion"];
									$row_cargo = mysqli_query($conn, "select * from cargos where cargos_id = $cargo_recibidor");
									$row_cargo1 = mysqli_fetch_array($row_cargo);
  		    ?>
									  <option value="<?php echo $row2["usuario_ocupacion"];?>">
									   <?php 
									   		echo $row_cargo1["cargos_cargo"]; echo " - ";  echo $row2["usuario_nombre"];
										
							   	      echo "</option>";	
								} // while  
							}
						   else
							{
		     					echo "<option value=\"\"> No hay registros para este Item </option>"; 
							}
							mysqli_free_result($rss2);  
						 }
						else 
						 {
							echo "<option value=\"\"><- Seleccione un Usuario</option>";
						 }
						echo "</select>";
					 Alert($alert_usuario);
		?>
		</td></tr>

		
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

<?php
}
?>
<tr class="truno"><td align="right"><span class="fuente_normal"><b>FECHA DESPACHO</b></span></td>
<td>
<?php echo date("Y-m-d")." ".date("H:i:s");?></td></tr>



<tr><td align="center" colspan="2">
<input type="submit" name="enviar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton"></td></tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>
