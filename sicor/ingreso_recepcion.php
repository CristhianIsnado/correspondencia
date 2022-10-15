<?php
include("../filtro.php");
include("inicio.php");
include("script/functions.php");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$conn = Conectarse();
?>

<?php
$ssql="SELECT * FROM ingreso
       WHERE '$cod_institucion'=ingreso_cod_institucion
       AND 'P'=ingreso_estado
       AND ingreso_cod_usr='$cargo_unico'
       ORDER BY ingreso_nro_registro DESC";
$rss=mysqli_query($conn, $ssql);
?>

<?php
$var1=$_POST['cod_ingreso'];
$sel_inst=$var1[0];
if(isset($_POST['modificar']) and isset($sel_inst))
{
		?>
			<script language='JavaScript'> 
				window.self.location="ingreso_modificar.php?nro_registro=<?php echo cifrar($var1[0]);?>"
			</script>
		<?php
}

if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="elegir.php"
			</script>
		<?php
}

if(isset($_POST['imprimir']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="ingreso_imprimir.php"
			</script>
		<?php
}

$var1=$_POST['cod_ingreso'];
$sel_inst=$var1[0];
if(isset($_POST['adjuntar']) and isset($sel_inst))
{
		?>
			<script language='JavaScript'> 
				window.self.location="adjuntar_nota.php?nro_registro=<?php echo cifrar($var1[0]);?>"
			</script>
		<?php
}
if(isset($_POST['cancelar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="principal.php"
			</script>
		<?php
}


$var=$_POST['cod_ingreso'];
$sel_inst1=$var[0];
if(isset($_POST['despachar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="despachar.php?nro_registro=<?php echo cifrar($var[0]);?>"
			</script>
		<?php
}
?>
<script language="JavaScript">
function CopiaValor(objeto) 
{
	document.ingreso.sel_ingreso.value = objeto.value;
}
</script>
<br>
<p class="fuente_titulo">
<center><b>CORRESPONDENCIA RECEPCIONADA</b></center></center>

<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="3%" align="center"><b>*</b></td>
<td width="15%" align="center"><span>Hoja Ruta</span></td>
<td width="4%" align="center"><span >Entrada</span></td>
<td width="10%" align="center"><span >Fecha y Hora Rec.</span></td>
<td width="15%" align="center"><span >Entidad</span></td>
<td width="15%" align="center"><span >Remitente</span></td>
<td width="10%" align="center"><span >Tipo Doc</span></td>
<td width="10%" align="center"><span >Cite Doc.</span></td>
<td width="3%" align="center"><span >Hojas</span></td>
<td width="3%" align="center"><span >Anexo</span></td>
</tr>
</table>
<div style="overflow:auto; width:100%; height:210px; align-self:left;">
<center>
<form name="ingreso" method="POST">
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<?php
$resaltador=0;
if (!empty($rss))
{
 while($row=mysqli_fetch_array($rss))
{
	 if ($resaltador==0)
	  {
       echo "<tr class=truno><td align=center width=3%>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos><td align=center width=3%>";
   	   $resaltador=0;
	  }
?>
<input type="checkbox" name="cod_ingreso[]" value="<?php echo $row["ingreso_nro_registro"];?>" onclick="javascript:CopiaValor(this);"/>
</td>
<td align="left" width="15%">
<?php
$tipo_cor = $row["ingreso_hoja_ruta_tipo"];
if ($tipo_cor == "e")
{
	  if($row["ingreso_adjunto_correspondencia"] != '')
		{
		?>
			<a href="<?php echo $row["ingreso_adjunto_correspondencia"];?>" target="_blank" /><img src="images/adjunto.gif" align="absmiddle" border="0" alt="archivo" /></a>
        <?php
		}
}
else
{ 
?>      <a href="archivo_adjunto.php?valor=<?php echo cifrar($row["ingreso_numero_cite"]);?>"><img src="images/documentos.png" border="0" alt="archivo" /></a>
<?php
}
echo $row["ingreso_hoja_ruta"];
?>
</td>
<td align="center" width="4%">
<?php 
$tipo_cor = $row["ingreso_hoja_ruta_tipo"];
if ($tipo_cor == "i") 
{
  echo "Interno";
}
else
 {
  echo "Externo"; 
 }
?>
</td>
<td align="center" width="10%">
<?php echo $row["ingreso_fecha_ingreso"]." ". $row["ingreso_hora_ingreso"];?>
</td>
<td align="left" width="15%">
<?php
if ($tipo_cor == "i") 
{
  $depto = $row["ingreso_cod_departamento"];
  $rssde = mysqli_query($conn, "SELECT * FROM departamento WHERE '$depto'=departamento_cod_departamento");
  $rowde = mysqli_fetch_array($rssde);
  echo $rowde["departamento_descripcion_dep"];
  mysqli_free_result($rssde);
}
else
{ 
  echo $row["ingreso_entidad_remite"]; 
}
 ?>
 </td>
<td align="left" width="15%">
<?php
if ($tipo_cor == "i") 
{
	    $codigo2=$row["ingreso_codigor"];//caso liberar
		$conexion = mysqli_query($conn, "SELECT * FROM usuario WHERE '$codigo2'=usuario_cod_usr");
		if (mysqli_num_rows($conexion) > 0)
		{
			if($fila_clave=mysqli_fetch_array($conexion))
			{
			echo $fila_clave["usuario_nombre"];
			}
		}
}
else
{
	    $codigo2=$row["ingreso_codigo"];//caso liberar
		$conexion = mysqli_query($conn, "SELECT * FROM usuario WHERE '$codigo2'=usuario_cod_usr");
		if (mysqli_num_rows($conexion) > 0)
		{
			if($fila_clave=mysqli_fetch_array($conexion))
			{
			echo $fila_clave["usuario_nombre"];
			}
		}	
}	
$tipo = $row["ingreso_hoja_ruta_tipo"];
?>
</td>
<td align="center" width="10%"><?php echo $row["ingreso_descripcion_clase_corresp"];?></td>
<td align="left" width="10%"><?php echo $row["ingreso_numero_cite"];?></td>
<td align="center" width="3%"><?php echo $row["ingreso_cantidad_hojas"];?></td>
<td align="center" width="3%"><?php echo $row["ingreso_nro_anexos"];?></td>
</tr>
<?php
}   
}
?>
</table>
</center>
</div>
<br />

<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center" >
<INPUT class="boton" TYPE="submit" VALUE="Adicionar" name="adicionar">
<INPUT class="boton" TYPE="submit" VALUE="Despachar" name="despachar" >
<INPUT class="boton" TYPE="submit" VALUE="Modificar" name="modificar" >
<INPUT class="boton" TYPE="submit" VALUE="adjuntar" name="adjuntar" >
<INPUT class="boton" TYPE="submit" VALUE="Cancelar" name="cancelar" >
</td>
</tr>
</table>
</center>
</form>

<?php
include("final.php");
?>