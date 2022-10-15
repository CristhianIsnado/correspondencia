<?php
include("../filtro.php");
include("inicio.php");
include("script/functions.php");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$clase=descifrar($_GET['valor']);
$conn=Conectarse();
?>

<?php
$respi=mysqli_query($conn, "SELECT * FROM correspondenciacopia,ingreso
                    WHERE correspondenciacopia.correspondenciacopia_remitente='$cargo_unico'
                    AND correspondenciacopia.correspondenciacopia_cod_institucion='$cod_institucion'
                    AND ingreso.ingreso_nro_registro=correspondenciacopia.correspondenciacopia_nro_registro
                    AND ingreso.ingreso_cod_institucion='$cod_institucion'");	
$contador200=mysqli_num_rows($respi);				
?>

<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>

<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>DERIVACI&Oacute;N DE CORRESPONDENCIA/COPIA</b></center></p></center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="10%" align="center"><span class="fuente_normal">Hoja Ruta</td>
<td width="14%" align="center"><span class="fuente_normal">Entidad Remitente</td>
<td width="15%" align="center"><span class="fuente_normal">Remitente</td>
<td width="7%" align="center"><span class="fuente_normal">Tipo</td>
<td width="5%" align="center"><span class="fuente_normal">Fecha de Ingreso</td>
<td width="15%" align="center"><span class="fuente_normal">Referencia</td>
<td width="8%" align="center"><span class="fuente_normal">Para</td>
<td width="8%" align="center"><span class="fuente_normal">Accion</td>
</tr>
</table>
<div style="overflow:auto; width:100%; height:210px; align-self:left;">
<center>
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<?php
$resaltador=0;
 while($row=mysqli_fetch_array($respi))
{
	if ($resaltador==0)
		  {
		       echo "<tr class=truno>";
			   $resaltador=1;
	      }
		  else
		  {
			   echo "<tr class=trdos>";
		   	   $resaltador=0;
		  }
?>
<td align="center" width="10%">
	<?php 
		echo $row["ingreso_hoja_ruta"];
		
	?>
</td>
<?php
$nro_registro=$row["ingreso_nro_registro"];
$ssql2 = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro and ingreso_cod_institucion='$cod_institucion'";
$rss2 = mysqli_query($conn, $ssql2);
$row2=mysqli_fetch_array($rss2);

$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
  echo "<td align=\"left\" width=\"14%\">";

if ($hoja_ruta_tipo == "e") {
  echo $row2["ingreso_entidad_remite"];
  $tipo_hoja = "Externo";
} else {
  $tipo_hoja = "Interno";
  $depart = $row2["ingreso_cod_departamento"];
  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
  $rssnew = mysqli_query($conn, $ssqlnew);
  $rownew = mysqli_fetch_array($rssnew);
  echo $rownew["departamento_descripcion_dep"];
  mysqli_free_result($rssnew);
}
echo "</td>";
?>
</td>
<td align="left" width="15%">
<?php 
if ($clase == "por_funcionariop" OR $clase == "por_departamento" OR $clase == "por_funcionariot")
{
	$valor_clave=$row["correspondenciacopia_destinatario"];
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
  
} else 
{  
 if ($hoja_ruta_tipo=="i")
 { 
	$valor_clave=$row["ingreso_remitente"];
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
 }
else
  { echo $row["ingreso_remitente"];
  }	
} 
 
?></td>
<td align="center" width="7%"><?php echo $tipo_hoja;?></td>
<td align="center" width="5%"><?php echo $row2["ingreso_fecha_ingreso"];?></td>
<?php mysqli_free_result($rss2);?>
<td align="left" width="15%">
<?php 
	echo $row["ingreso_referencia"];
	$historia = cifrar($row["ingreso_nro_registro"]);
?>
</td>

<td align="left" width="8%">
<?php 
	$destino=$row["correspondenciacopia_destinatario"];
	$conexiond = mysqli_query($conn, "SELECT * FROM cargos WHERE cargos_id='$destino'");
	if($fila_claved=mysqli_fetch_array($conexiond))
	{
		$valor_cargod=$fila_claved["cargos_id"];
		$conexion2d = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario_ocupacion='$valor_cargod'");
		if($fila_cargod=mysqli_fetch_array($conexion2d))
		{
		echo $fila_cargod["usuario_nombre"]."<br>";
		echo $fila_claved["cargos_cargo"];
		}
	}
?>
</td>
<td width="8%" align="center">
<a href="historia.php?historia=<?php echo $historia; ?>" class="botonte">&nbsp;Ver&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<?php
}   
mysqli_close($conn);
?>
</table>
</div>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<form action="principal.php" method="get">
<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</form>
</td>
</tr>
</table>

<?php
include("../final.php");
?>