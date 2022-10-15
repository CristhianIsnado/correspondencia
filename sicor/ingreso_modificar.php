<?php
include("../filtro.php");
include("inicio.php");
include("../conecta.php");
include("script/functions.php");
include("script/cifrar.php");
$aux = 0;
$cod_institucion = $_SESSION["institucion"];
$variable=descifrar($_GET['nro_registro']);
if(!is_numeric($variable))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACI&Oacute;N DE DATOS !!!!</b></center>";
    exit;
}

$conn = Conectarse();

if(!empty($variable))
{
	$_SESSION['cualquiera']=$variable;
	
	$consulta_tipo = "SELECT * FROM ingreso WHERE '$_SESSION[cualquiera]'=ingreso_nro_registro AND ingreso_cod_institucion='$_SESSION[institucion]'";
	$conex = mysqli_query($conn, $consulta_tipo);
	while($rowm=mysqli_fetch_array($conex))
	{
	  $_SESSION['hoja_tipo_aux']=$rowm["ingreso_hoja_ruta_tipo"];
    } 
	
}
$clave=$variable;
?>
<?php
if (isset($_POST['guardar'])) 
{   

	
   if ($_SESSION['hoja_tipo_aux']=='e')
   {
      $valor1=val_alfanum($_POST['entidad']);
	if($valor1 == 0)
        {
         $aux=1;
         $alert_dep_e=1;
        }
	
        $valor1=val_alfanum($_POST['remitente']);
	if($valor1 == 0)
        {
             $aux=1;
             $alert_rem_e=1;
	     }

        $valor1=val_alfanum($_POST['cargo_remitente']);
	if($valor1 == 0)
        {
	  $aux=1;
	  $alert_cargo_e=1;
	    }		
  
        $valor1=val_alfanum($_POST['cite']);
	if($valor1 == 0)
        {
	 $aux=1;
	 $alert_cite=1; 	
	     }

	if (empty($_POST['fecha_cite']))
	{
		 $aux=1;
		 $alert_fechacite=1; 
	}
	else
	{
		$guardar_fecha=$_POST['fecha_cite'];
		if($guardar_fecha > date("Y-m-d"))
		{ 
		 $aux=1;
		 $alert_fechacite=1; 	
		}
	}		
		
        $valor1=val_alfanum($_POST['referencia']);
	if($valor1 == 0)
        {
	 $aux=1;
	 $alert_ref=1; 	
	   }
	 }	
        if(Val_numeros($_POST['num_hojas']) == 1)
        {
         $aux= 1;
         $alert_hojas=1;
        }
		
        if(Val_numeros($_POST['anexo']) == 1)
        {
         $aux= 1;
         $alert_anexos=1;
        }

    if ($aux == 0) 
	  {
     if($_SESSION['hoja_tipo_aux'] == 'e')
		{
     	$fecha_recepcion=date("Y-m-d")." ".date("H:i:s");
 		//$ssqlm = "UPDATE ingreso SET ingreso_cod_departamento='$_POST[cod_departamento]',
		 $ssqlm = "UPDATE ingreso SET ingreso_fecha_recepcion='$fecha_recepcion',
		ingreso_fecha_cite='$_POST[fecha_cite]',
		ingreso_descripcion_clase_corresp='$_POST[clasificacion]',
		ingreso_entidad_remite='$_POST[entidad]',
		ingreso_remitente='$_POST[remitente]',
		ingreso_cargo_remitente='$_POST[cargo_remitente]',
		ingreso_referencia='$_POST[referencia]',
		ingreso_cantidad_hojas='$_POST[num_hojas]',
		ingreso_nro_anexos='$_POST[anexo]',
		ingreso_tipo_anexos='$_POST[tipo_anexos]',
		ingreso_numero_cite='$_POST[cite]' WHERE ingreso_nro_registro='$variable'";
	    mysqli_query($conn, $ssqlm);
		unset($_SESSION['cualquiera']);
		unset($_SESSION['hoja_tipo_aux']);
		unset($_SESSION['cargo_rem']);
		}
		else
		{
     	$fecha_recepcion=date("Y-m-d")." ".date("H:i:s");
 		$ssqlm = "UPDATE ingreso SET ingreso_cantidad_hojas='$_POST[num_hojas]',
		ingreso_nro_anexos='$_POST[anexo]',
		ingreso_tipo_anexos='$_POST[tipo_anexos]' WHERE ingreso_nro_registro='$variable'";
	    mysqli_query($conn, $ssqlm);
		unset($_SESSION['cualquiera']);
		unset($_SESSION['hoja_tipo_aux']);
		unset($_SESSION['cargo_rem']);		
		}
?>
	<script language="JavaScript">
             window.self.location="ingreso_recepcion.php";
        </script>
   <?php	
   }
}


if(isset($_POST['cancelar']))
{
?>
        <script language="JavaScript">
        window.self.location="ingreso_recepcion.php";
        </script>
<?php
}
?>
<br />
    
    
<?php 
if ($aux <> 0)
{
echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! ERROR DATOS NO VALIDOS !!!</b></div></p>";
}
?>
        <p class="fuente_titulo">
        <center>
                <b>MODIFICACI&Oacute;N DE REGISTRO DE CORREPONDENCIA</b>
        </center>
        </p>
<?php 
	$ssqlm = "SELECT * FROM ingreso WHERE '$variable'=ingreso_nro_registro AND ingreso_cod_institucion='$_SESSION[institucion]'";
	$rssm = mysqli_query($conn, $ssqlm);
	while($rowm=mysqli_fetch_array($rssm))
	{
	  $clasificacion = $rowm["ingreso_descripcion_clase_corresp"];
	  $_POST['entidad'] = $rowm["ingreso_entidad_remite"];
	  $remitente = $rowm["ingreso_remitente"];
	  $_SESSION['cargo_rem'] = $rowm["ingreso_cargo_remitente"];
	  $_POST['referencia'] = $rowm["ingreso_referencia"];
	  $_POST['cite'] = $rowm["ingreso_numero_cite"];
	  
	  $num_hojas = $rowm["ingreso_cantidad_hojas"];
	  $anexo = $rowm["ingreso_nro_anexos"];
	  
	  $numhojas = $rowm["ingreso_cantidad_hojas"];
	  $anexos = $rowm["ingreso_nro_anexos"];
	  
	  $_POST['tipo_anexos'] = $rowm["ingreso_tipo_anexos"];
	  
	  $_POST['tipo'] = $rowm["ingreso_hoja_ruta_tipo"];
	  $cod_departamento = $rowm["ingreso_cod_departamento"];
      $_POST['fecha_recepcion'] = $rowm["ingreso_fecha_recepcion"];
	  $_POST['fecha_cite'] = $rowm["ingreso_fecha_cite"];
	  $hoja_ruta = $rowm["ingreso_hoja_ruta"];
	 }
	mysqli_free_result($rssm);

 

/********************************************************************************************
                        SACAR INFORMACION DE LA HOJA RUTA A MODIFICAR
********************************************************************************************/
	

?>

<center>
<table width="70%" cellspacing="2" cellpadding="2"  border="0">
	<form  method="POST" name="enviar"> 
		<tr class="truno">
			<td align="right">
				<span class="fuente_normal"><b>HOJA DE RUTA</b></td>
			<td>
				<?php echo $hoja_ruta;
				?>
		</td>
		</tr>
		<tr class="truno">
			<td align="right">
				<span class="fuente_normal"><b>FECHA Y HORA DE INGRESO AL SISTEMA</b></td>
			<td>
				<?php echo date("Y-m-d")." ".date("H:i:s");
				?>
		</td>
			</tr>
		
       <?php
        if($_SESSION['hoja_tipo_aux'] == 'e')
		{
		?>
        <tr class="truno">
		<td align="right">
			<span class="fuente_normal"><b>ENTIDAD EMISORA</b></td>
		 <td><input type="text" name="entidad" class="caja_texto" size="50" value="<?php echo $_POST['entidad'];?>">
         <?php Alert($alert_dep_e);?>
         </td>
        </tr>
        <?php
		}
		else
		{
	    ?> 
        <tr class="truno">
		<td align="right">
			<span class="fuente_normal"><b>ENTIDAD EMISORA</b></td>
		<td>
        <?php
	$respuesta=mysqli_query($conn, "SELECT * FROM departamento WHERE departamento_cod_departamento='$cod_departamento'");
	if ($rowasi=mysqli_fetch_array($respuesta))
	{
			echo $rowasi["departamento_descripcion_dep"];
	}
	
		 
		 ?>
         </td>
		</tr>
        <?php
        }//Fin de hoja_tipo Entidad Remite
	 
	    if($_SESSION['hoja_tipo_aux'] == 'e')
		{
		?>
         <tr class="truno">
		<td align="right">
			<span class="fuente_normal"><b>REMITENTE</b></td>
		 <td><input type="text" class="caja_texto" name="remitente" size="50" value="<?php echo $remitente;?>" />
           <?php Alert($alert_rem_e);?> 
         </td>
        </tr>
        <?php
        }
		else
		{
		?>
		<tr class="truno">
		<td align="right">
			<span class="fuente_normal"><b>REMITENTE</b>
       	</td>
		<td>
       <?php 
	$ssqlcinco2="SELECT * FROM cargos where cargos_id='$remitente'";
		$rsscinco2 = mysqli_query($conn, $ssqlcinco2);
		if ($rowcinco2=mysqli_fetch_array($rsscinco2))
		{

				$ssqlcinco22="SELECT * FROM usuario where usuario_ocupacion='$remitente'";
		        $rsscinco22 = mysqli_query($conn, $ssqlcinco22);
		        if ($rowcinco22=mysqli_fetch_array($rsscinco22))
				{
		
		echo strtoupper($rowcinco22["usuario_nombre"])."</br>";
		echo "<b>".$rowcinco2["cargos_cargo"]."</b>";
				}
		
		}	
	
	   ?>    
           </td>
	</tr>
   <?php
    }//fin de hoja_tipo remitente
	
   if($_SESSION['hoja_tipo_aux'] == 'e')
   {
    ?>
   <tr class="truno">
	<td align="right">
	<span class="fuente_normal"><b>CARGO REMITENTE</b></td>
	<td>
  
    <input type="text" name="cargo_remitente" class="caja_texto" size="50" value="<?php echo $_SESSION['cargo_rem'];?>"/>
      <?php Alert($alert_cargo_e);?> 
    </td>
   </tr>   
	<?php
    }
    ?>
	    <tr class="truno"><td align="right"><span class="fuente_normal"><b>No. DE CITE</b></td>
		<td>
        
		<?php
	 if($_SESSION['hoja_tipo_aux'] == 'e')
	   {		
		 echo "<input type=\"text\" name=\"cite\" class=\"caja_texto\" value=".$_POST['cite'].">";
		Alert($alert_cite);
		}
		else
		{
		echo $_POST['cite'];
        }
		?>		
        </td>
		</tr>

		<tr class="truno"><td align="right"><span class="fuente_normal"><b>FECHA DEL CITE</b></td>
		<td>
		<?php
	   if($_SESSION['hoja_tipo_aux'] == 'e')
	   {
echo "<input type=\"text\" name=\"fecha_cite\" readonly=\"readonly\" class=\"caja_texto\" value=".$_POST['fecha_cite']." id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\">";
echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
Alert($alert_fechacite);
        }
		else
		{
		echo $_POST['fecha_cite'];
		}
   		?>   	    
        </td>
		</tr>
	  
       <tr class="truno"><td width="30%" align="right"><span class="fuente_normal"><b>CLASIFICACI&Oacute;N</b></td>
		<td>
       <?php
	   if($_SESSION['hoja_tipo_aux'] == 'e')
	   {
	   ?>
       		<select name="clasificacion" class="caja_texto">
				     <?php
					$ssql = "SELECT * FROM clasecorrespondencia order by clasecorrespondencia_descripcion_clase_corresp";
					$rss = mysqli_query($conn, $ssql);
					while($row=mysqli_fetch_array($rss))
					 {  if ($clasificacion==$row["clasecorrespondencia_descripcion_clase_corresp"])
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
         <?php
         }
		 else
		 {
		 echo $clasificacion;
		 }
		 ?>
    </td>
	</tr>
	
    <tr class="truno">
    <td align="right">
    <span class="fuente_normal"><b>REFERENCIA</b></td>
	<td>
       <?php
	   if($_SESSION['hoja_tipo_aux'] == 'e')
	   {
	   ?>    
	   <textarea name="referencia"  class="caja_texto" cols="60" rows="2"><?php echo $_POST['referencia'];?></textarea>
      <?php Alert($alert_ref);
	  }
	  else
	  {
	  echo $_POST['referencia'];
	  }
	  ?>
    </td>
	</tr>
	
    <tr class="truno"><td align="right"><span class="fuente_normal"><b>No. DE HOJAS</b></td>
	<td>
	<?php
	if($_POST['num_hojas'] == '')
	{
		 echo "<input type=\"text\" name=\"num_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$numhojas.">";
	 Alert($alert_hojas);
	
	}
	else
	{
		 echo "<input type=\"text\" name=\"num_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['num_hojas'].">";
	 Alert($alert_hojas);
	}
	

	?>
    </td>
	</tr>
	<tr class="truno"><td align="right"><span class="fuente_normal"><b>CANTIDAD ANEXOS</b></td>
	<td>
		<?php
	if($_POST['anexo'] == '')
	{
			echo "<input type=\"text\" name=\"anexo\" maxlength=4 size=4 class=\"caja_texto\" value=".$anexos.">";
			Alert($alert_anexos);
    }
	else
	{
			echo "<input type=\"text\" name=\"anexo\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['anexo'].">";
			Alert($alert_anexos);
	}
		
		?>	
    </td>
	</tr>
	
    <tr class="truno"><td align="right"><span class="fuente_normal"><b>TIPO ANEXOS</b></td>
	<td>
       <?php
			echo "<input type=\"text\" name=\"tipo_anexos\" maxlength=100 size=50 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
  	    ?>
  

    </td>
	</tr>
	
    <tr>
	<td align="center" colspan="2">
         	<input type="submit" name="guardar" value="Grabar" class="boton"/>
			<input type="submit" name="cancelar" value="Cancelar" class="boton" />
    </td>
    </tr>
	</form>
	</table>
    </center>
<br>
<?php
include("final.php");
?>