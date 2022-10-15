<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
$conn=Conectarse();
$ssql="SELECT * FROM cargos where cargos_cod_institucion='$_SESSION[institucion]' ORDER BY cargos_cod_depto ";
$rss=mysqli_query($conn, $ssql);
?>
<?php
if(isset($_POST['Adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="cargonuevo.php"
			</script>
		<?php
}
$var=$_POST['cod_dep'];
$sel_inst1=$var[0];
if(isset($_POST['Modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="cargoeditar.php?sel_inst=<?php echo cifrar($var[0]);?>"
			</script>
		<?php
}
//eliminacion de registros
if(isset($_POST['Eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++){
mysqli_query($conn, "DELETE FROM cargos WHERE cargos_id='$var2[$i]'");

mysqli_query($conn, "DELETE FROM miderivacion WHERE miderivacion_mi_codigo='$var2[$i]'");
mysqli_query($conn, "DELETE FROM asignar WHERE asignar_mi_codigo='$var2[$i]'");

mysqli_query($conn, "DELETE FROM miderivacion WHERE miderivacion_su_codigo='$var2[$i]'");
mysqli_query($conn, "DELETE FROM asignar WHERE asignar_su_codigo='$var2[$i]'");

mysqli_query($conn, "DELETE FROM documentocargo WHERE documentocargo_doc='$var[$i]'"); 

mysqli_query($conn, "DELETE FROM usuario WHERE usuario_ocupacion='$var[$i]'"); 

}
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
	
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="0"  align="center" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER>ADMINISTRACION DE CARGOS DE LAS INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE CARGOS</B><BR>
    </TD> 
  </TR>
  <TR>
 
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#d3daed" align="top">

<FORM NAME="lista" METHOD="POST">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" HEIGHT="10" ALIGN="center">
  <TR>
    <TD WIDTH="2%" HEIGHT="10" COLSPAN="1" bgcolor="#eeeeee">
	<CENTER>*</CENTER>
    </TD> 
	<TD WIDTH="30%" bgcolor="#eeeeee" align="center"><SPAN class="fuente_subtitulo"><B><CENTER>DESCRIPCI&Oacute;N</CENTER></B></TD> 
	<TD WIDTH="30%"  bgcolor="#eeeeee" align="center"><SPAN class="fuente_subtitulo"><B><CENTER>DEPARTAMENTO</CENTER></B></TD> 
	<TD WIDTH="10%" bgcolor="#eeeeee" align="center"><SPAN class="fuente_subtitulo"><B><CENTER>INSITTUCIONES</CENTER></B></TD> 
    <TD WIDTH="20%" bgcolor="#eeeeee" align="center"><SPAN class="fuente_subtitulo"><B><CENTER>EDIFICIO</CENTER></B></TD> 
       
  </TR>
</table>

<div style="overflow:auto; width:100%; height:200px; align-self:left;">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" align="center">

<?php
$resaltador=0;
if(!empty($rss)){

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
   
    <TD WIDTH="2%">
	<INPUT TYPE="checkbox" value="<?php echo $row["cargos_id"];?>" name="cod_dep[]">
     </TD>
	<TD WIDTH="30%" align="left">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $row["cargos_cargo"];?>
	</TD> 
    <?php
    $nombre_dep=$row["cargos_cod_depto"];
	$consulta1="SELECT * FROM departamento where departamento_cod_departamento='$nombre_dep'";
    $rss1=mysqli_query($conn, $consulta1);
	if ($filas = mysqli_fetch_array($rss1))
	{
	?>
	<TD WIDTH="30%" align="left">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $filas["departamento_descripcion_dep"];?>
	</TD>
    <?php
	}
	?>
     
     <?php
    $nombre_dep=$row["cargos_cod_institucion"];
	$consulta3="SELECT * FROM instituciones where  instituciones_cod_institucion ='$nombre_dep'";
    $rss3=mysqli_query($conn, $consulta3);
	if ($filas3 = mysqli_fetch_array($rss3))
	{
	?>
	<TD WIDTH="10%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $filas3["instituciones_sigla_inst"];?>
	</TD>
    <?php
	}
	?>
     <?php
    $nombre_dep=$row["cargos_edificio"];
	$consulta2="SELECT * FROM edificio where  edificio_cod_edificio ='$nombre_dep'";
    $rss2=mysqli_query($conn, $consulta2);
	if ($filas2 = mysqli_fetch_array($rss2))
	{
	?>
	<TD WIDTH="20%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $filas2["edificio_sigla_ed"];?>
	</TD>
    <?php
	}
	?>
    
   </TR>
<?php
}  // fin while
mysqli_free_result($rss);
} //fin empty
mysqli_close($conn);
?>
</TABLE>
<div>
    </TD> 
  </TR>
  <TR>
	<TD align="center" COLSPAN="5">
	<INPUT class="boton" TYPE="submit" VALUE="Adicionar" name="Adicionar">
	<INPUT class="boton" TYPE="submit" VALUE="Modificar" name="Modificar" >
	<INPUT class="boton" TYPE="submit" VALUE="Eliminar" name="Eliminar" >
</TD>
</FORM>
  </TR>
</TABLE>

</body>	
</html>

<?php
include("final.php");
?>
