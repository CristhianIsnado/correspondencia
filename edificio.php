<?php
include("filtro.php");
include("conecta.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("inicio.php");
$conn=Conectarse();
$instituto=$_SESSION["institucion"];
$ssql="SELECT * FROM edificio where edificio_cod_institucion='$instituto' order by edificio_descripcion_ed";
$rss=mysqli_query($conn, $ssql);
?>

<?php
//esto es lo nuevo para los botones
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="edificioadiciona.php"
			</script>
		<?php
}
$var=$_POST['cod_dep'];
$sel_inst1=$var[0];//para ver si con modificaciones no seleccionamos nada
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="edificioeditar.php?sel_inst=<?php echo cifrar($var[0]);?>"
			</script>
		<?php
}
//eliminacion de registros
if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++)
{
mysqli_query($conn, "DELETE FROM edificio WHERE edificio_cod_edificio='$var2[$i]'") or die("El Registro no Existe");
}
		?>
			<script language='JavaScript'> 
				window.self.location="edificio.php"
			</script>
		<?php
}
?>

<!DOCTYPE html>
<html>
<body>
	
<center>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" HEIGHT="10" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER><BR>ADMINISTRACION DE LOS EDIFICIOS DE LAS INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE EDIFICIOS</B><BR>
    </TD> 
  </TR>
  <TR>

    <TD HEIGHT="10" COLSPAN="3" bgcolor="#d3daed" align="top">

<FORM NAME="lista" METHOD="POST">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" ALIGN="center">
  <TR>
    <TD WIDTH="5%" bgcolor="#eeeeee" align="left">
	<INPUT class="boton1" NAME="BOTON" TYPE="reset" VALUE="*">
   </TD> 
    <TD WIDTH="5%"  bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>C&Oacute;DIGO</CENTER></B></TD>
	<TD WIDTH="20%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>SIGLA</CENTER></B></TD> 
	<TD WIDTH="20%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>EDIFICIO</CENTER></B></TD> 
	<TD WIDTH="20%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>INSTITUCI&Oacute;N</CENTER></B></TD> 
	<TD WIDTH="10%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>CIUDAD</CENTER></B></TD> 
	    
  </TR>
</table>

<div style="overflow:auto; width:100%; align-self:left;">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">

<?php
$resaltador=0;
if(!empty($rss))
{
while($row = mysqli_fetch_array($rss)) {

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
    
    <TD WIDTH="5%" align="center">
	<INPUT TYPE="checkbox" value="<?php echo $row["edificio_cod_edificio"];?>" name="cod_dep[]">
	</TD>
	<TD WIDTH="5%"  align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_cod_edificio"];?>
	</TD> 
	<TD WIDTH="20%"  align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_sigla_ed"];?>
	</TD> 
	<TD WIDTH="20%"  >
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_descripcion_ed"];?>
	</TD> 
    <TD WIDTH="20%">
	<?php
	$var=$row["edificio_cod_institucion"];
	$resp=mysqli_query($conn, "Select * from instituciones where instituciones_cod_institucion='$var'");
	if ($insti=mysqli_fetch_array($resp)) 
	{
	?>
    <P class="parrafo_normal"><SPAN class="fuente_normal">
    		<?php echo $insti["instituciones_descripcion_inst"];?>
	<?php
	}
	?>
	</TD>
    <TD WIDTH="10%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
		<?php echo $row["edificio_ciudad"];?>
	</TD> 

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
	<INPUT class="boton" TYPE="submit"  VALUE="Adicionar" name="adicionar">
	<INPUT class="boton" TYPE="submit"  VALUE="Modificar" name="modificar">
	<INPUT class="boton" TYPE="submit"  VALUE="Eliminar" name="eliminar">
   </TD>
</FORM>
  </TR>
</TABLE>
</center>

</body>
</html>

<?php
include("final.php");
?>
