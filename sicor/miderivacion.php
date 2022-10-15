<?php
include("../filtro.php");
include("inicio.php");
include("script/functions.php");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$conn=Conectarse();
?>

<?php
$respi=mysqli_query($conn, "SELECT * FROM seguimiento,ingreso
                    WHERE seguimiento.seguimiento_destinatario='$cargo_unico'
                    AND seguimiento.seguimiento_cod_institucion='$cod_institucion'
                    AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
                    AND ingreso.ingreso_cod_institucion='$cod_institucion'
                    AND seguimiento.seguimiento_tipo='D' order by seguimiento_codigo_seguimiento DESC");
?>
<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>

<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>CORRESPONDENCIA DERIVADA o FINALIZADA</b></center></p></center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="10%" align="center"><span class="fuente_normal">Hoja Ruta</td>
<td width="17%" align="center"><span class="fuente_normal">Entidad Remitente</td>
<td width="15%" align="center"><span class="fuente_normal">Remitente</td>
<td width="7%" align="center"><span class="fuente_normal">Tipo</td>
<td width="10%" align="center"><span class="fuente_normal">Fecha de Ingreso</td>
<td width="15%" align="center"><span class="fuente_normal">Referencia</td>
<td width="8%" align="center"><span class="fuente_normal">Accion</td>
</tr>
</table>
<div style="overflow:auto; width:100%; height:210px; align-self:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
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
$ssql2 = "SELECT * FROM ingreso WHERE ingreso_nro_registro='$nro_registro' and ingreso_cod_institucion='$cod_institucion'";
$rss2 = mysqli_query($conn, $ssql2);
$row2=mysqli_fetch_array($rss2);

$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
  echo "<td align=\"left\" width=\"20%\">";

 if ($hoja_ruta_tipo == "e")  {
  echo $row2["ingreso_entidad_remite"];
  $tipo_hoja = "Externo";
 } else  {
  $tipo_hoja = "Interno";
  $depart = $row2["ingreso_cod_departamento"];
  $ssqlnew = "SELECT * FROM departamento WHERE departamento_cod_departamento='$depart'";  
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
	$valor_clave=$row["seguimiento_destinatario"];
	$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE cargos_id='$valor_clave'");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
		$valor_cargo=$fila_clave["cargos_id"];
		$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario_ocupacion='$valor_cargo'");
		if($fila_cargo=mysqli_fetch_array($conexion2))
		{
		echo $fila_cargo["usuario_nombre"];
		}
	}  
  
} else 
{  
 if ($hoja_ruta_tipo=="i")
 { 
    	$codigo2=$row["ingreso_codigor"];
		$conexion2 = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario_cod_usr='$codigo2'");
		if($fila_cargo=mysqli_fetch_array($conexion2))
		{
		echo $fila_cargo["usuario_nombre"];
		}

  }
else
  { echo $row["ingreso_remitente"];
  }	
} 

?></td>
<td align="center" width="7%"><?php echo $tipo_hoja;?></td>
<td align="center" width="10%"><?php echo $row2["ingreso_fecha_ingreso"];?></td>
<?php mysqli_free_result($rss2);?>
<td align="left" width="15%">
<?php 
	echo $row["ingreso_referencia"];
	$historia = cifrar($row["ingreso_nro_registro"]);
?>
</td>
<td width="8%" align="center">
<a href="historia.php?historia=<?php echo $historia; ?>" class="botonte">&nbsp;Ver&nbsp;</a>
<?php   
   $historia100 = $row["ingreso_nro_registro"];
	$conexion100c=mysqli_query($conn, "SELECT * FROM correspondenciacopia WHERE correspondenciacopia_remitente='$_SESSION[cargo_asignado]' and correspondenciacopia_nro_registro='$historia100'");
	$seguic= mysqli_num_rows($conexion100c);
	$c=0;

	while($row100c=mysqli_fetch_array($conexion100c))
	{   if ($row100c["correspondenciacopia_tipo"]=='A')
		{
		$c=$c+1;
		}
	}

	$conexion100x = mysqli_query($conn, "SELECT * FROM seguimiento WHERE seguimiento_nro_registro='$historia100'");
	$cantidadx=mysqli_num_rows($conexion100x);
	
	if ($cantidadx == '2' and $c==$seguic)
	{
		$k=0; $total=array();
		while($row100x=mysqli_fetch_array($conexion100x))
		{
		$total[$k]=$row100x["seguimiento_codigo_seguimiento"];
		$k=$k+1;
		}
	}
	else
	{
		$k=0;$total=array();
		while($row100x=mysqli_fetch_array($conexion100x))
		{
		$total[$k]=$row100x["seguimiento_codigo_seguimiento"];
		$k=$k+1;
		}
		$rca=count($total)-2;
		$rca22=$total[$rca];
	}

	
	$conexion100 = mysqli_query($conn, "SELECT * FROM seguimiento WHERE seguimiento_nro_registro='$historia100' and seguimiento_tipo='D' and seguimiento_destinatario='$cargo_unico'");
	$cantidad=mysqli_num_rows($conexion100);
 if ($cantidad > 0)
 {
    if($row100=mysqli_fetch_array($conexion100))
    {
	$valoranterior=$row100['seguimiento_codigo_seguimiento']; 
	$conexion300 = mysqli_query($conn, "SELECT * FROM seguimiento WHERE seguimiento_nro_registro='$historia100' order by seguimiento_codigo_seguimiento DESC limit 1");
	if($row300=mysqli_fetch_array($conexion300))
	 {
	  $valorultimo=$row300["seguimiento_codigo_seguimiento"];
	  $valortipo=$row300["seguimiento_tipo"];

	 if ($cantidadx == '2' and  $c==$seguic)
	 { 
	   if ($valortipo=='A')
  	      {
		   ?>
		    <a href="restaurar.php?historia=<?php echo $historia;?>" class="botonte">Restaurar</a>
		   <?php
		  }	 	
	 }
	 else
	 {	
	      if ($valortipo=='A' and $rca22==$valoranterior and $c==$seguic)
  	      {
		   ?>
		    <a href="restaurar.php?historia=<?php echo $historia;?>" class="botonte">Restaurar</a>
		   <?php
		  }
	 }	  
		  
	  }
	} 
 }//end if cantidad > 0
?>
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


