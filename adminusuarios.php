<?php
include("filtro.php");
include("conecta.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("inicio.php");
?>

<?php
if (isset($_SESSION["adminvirtual"])) 
{
	$institucion = $_SESSION["institucion"];
$conn=Conectarse();
if ($_SESSION["adminvirtual"]=="adminvirtual") {
	$ssql="SELECT * FROM usuario order by usuario_cod_usr";    
}
else
{
    $ssql="SELECT * FROM usuario WHERE usuario_cod_nivel!='3' and usuario_cargo <> '' and usuario_cod_institucion='$institucion' order by usuario_cod_usr";
}
$rss=mysqli_query($conn, $ssql);
?>
<?php
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="usuarionuevo.php"
			</script>
		<?php
}

$var=$_POST['cod_usuario'];
$sel_inst1=$var[0];
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="usuarioeditar.php?sel_usuario=<?php echo cifrar($var[0]);?>"
			</script>
		<?php
}

$var=$_POST['cod_usuario'];
$sel_inst1=$var[0];
if(isset($_POST['liberar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="liberarusuario.php?sel_usuario=<?php echo encryto($var[0]);?>"
			</script>
		<?php
}


if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_usuario'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++)
{
   $ssqlm = "SELECT * FROM usuario WHERE '$var2[$i]'=usuario_cod_usr";
	$rssm = mysqli_query($conn, $ssqlm);
	if (mysqli_num_rows($rssm)>0)
	{ 
		if($rowm=mysqli_fetch_array($rssm))
		{
		$ocupacion=$rowm["usuario_ocupacion"];
	mysqli_query($conn, "UPDATE miderivacion SET miderivacion_estado='0' WHERE miderivacion_su_codigo='$ocupacion'") or die("No se Guardo el Registro");	
	mysqli_query($conn, "UPDATE asignar SET asignar_estado='0' WHERE asignar_su_codigo='$ocupacion'") or die("No se Guardo el Registro");	
	    }
	}
   mysqli_query($conn, "DELETE FROM usuario WHERE usuario_cod_usr='$var2[$i]'") or die("El Registro no Existe");
 	
} 
		?>
			<script language='JavaScript'> 
				window.self.location="adminusuarios.php"
			</script>
		<?php
}
?>
	
<center>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER>ADMINISTRACION DE USUARIOS DE LAS INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE USUARIOS</B><BR>
    </TD> 
  </TR>

  <TR>
    <TD COLSPAN="3" bgcolor="#d3daed" align="top">
    
<form name="lista" method="POST">
<TABLE width="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0">
  <tr>
    <td width="3%" bgcolor="#eeeeee" align="center"><CENTER>*</CENTER></td> 
    <td width="5%" bgcolor="#eeeeee"><span class="fuente_subtitulo"><b><center>C&Oacute;DIGO</center></b></td>
	<td width="15%" bgcolor="#eeeeee"><span class="fuente_subtitulo"><B><CENTER>NOMBRE Y APELLIDO</CENTER></B></td> 
    <td width="12%" bgcolor="#eeeeee"><span class="fuente_subtitulo"><B><CENTER>EDIFICIO</CENTER></B></td>     
    <td width="20%" bgcolor="#eeeeee"><span class="fuente_subtitulo"><B><CENTER>CARGO</CENTER></B></td>
	<td width="15%" bgcolor="#eeeeee"><span class="fuente_subtitulo"><B><CENTER>USUARIO</CENTER></B></td> 
	<td width="15%" bgcolor="#eeeeee"><span class="fuente_subtitulo"><B><CENTER>CORREO ELECTR&Oacute;NICO</CENTER></B></td> 
	 </TR>
</TABLE> 

<div style="overflow:auto; width:100%; height:200px; ">

<TABLE width="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
<?php
$resaltador=0;
if (!empty($rss))
{
while($row = mysqli_fetch_array($rss)) 
 {
 		  if ($resaltador==0)
			  {
				   echo "<tr class=trdos>";
				   $resaltador=1;
			  }
			  else
			  {
				   echo "<tr class=truno>";
				   $resaltador=0;
			  }
?>
    <td width="3%" align="center">
<?php
if($row["usuario_active"] == 1)
{    
?>    
<input type="checkbox" value="<?php echo $row["usuario_cod_usr"];?>" name="cod_usuario[]">
<?php
}
?>
	</td>
    
    <td width="5%" align="center">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_cod_usr"];?>
	</td> 
    
    <td width="15%">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_nombre"];?>	
	</td>
    
    <td width="12%" align="center">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php
	$rss_ingreso = mysqli_query($conn, "SELECT * FROM edificio, departamento WHERE departamento.departamento_cod_departamento='$row[usuario_cod_departamento]' AND departamento.departamento_cod_edificio=edificio.edificio_cod_edificio");
	 if (mysqli_num_rows($rss_ingreso) > 0)
	 {
		  if ($row_ingreso = mysqli_fetch_array($rss_ingreso))
		  {
		   echo "<b>".$row_ingreso["edificio_sigla_ed"]."</b>";
		  }
	 }
	?>	
	</td>
    
       <td width="20%">
    <P class="parrafo_normal"><span class="fuente_normal">
		
	<?php
if ($_SESSION["adminvirtual"]=="adminvirtual")
{
echo "Administrador del Sistema";
}	  
else
{		$valor_clave=$row["usuario_ocupacion"];
		if($valor_clave=='0')
		{
			echo "<span class=fuente_alerta> USUARIO LIBERADO</span>";
		}
		else
		{
			$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
			if($fila_clave=mysqli_fetch_array($conexion))
			{
			echo $fila_clave["cargos_cargo"];
			}
		}
	
}	
	?>
	</td>
    <td width="15%" align="center">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_username"];?>
	</td>
	<td width="15%">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_email"];?>
	</td> 

 </TR>
<?php
} // fin while  

} // fin empty
mysqli_close($conn);
?>
</TABLE>
</div>
</CENTER>

<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0">
<TR>
	<td align="center">
<?php
if($_SESSION["nivel"]=='3')
{
?>
   <input class="boton" type="submit" value="Adicionar" name="adicionar" >
	
<?php 
}
else
{
?>
	<input class="boton" type="submit" value="Adicionar" name="adicionar">
	<input class="boton" type="submit" value="Modificar" name="modificar">
   <input class="boton" type="submit" value="Liberar" name="liberar" onclick="return window.confirm('Est&aacute; Seguro(a) de LIBERAR &eacute;ste Registro?')">
	<input class="boton" type="submit" value="Eliminar" name="eliminar" onclick="return window.confirm('Est&aacute; Seguro(a) de ELIMINAR &eacute;ste Registro?')">

<?php
}
?>	
    </td>
</TR>
</TABLE>

<?php
}
include("final.php");
?>
