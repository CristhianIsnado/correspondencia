<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
include("sicor/script/cifrar.php");
$conn=Conectarse();
$instituto=$_SESSION["institucion"];
$ssql="SELECT * FROM instituciones order by instituciones_cod_institucion";
$rss=mysqli_query($conn, $ssql);
?>

<?php

$var=$_POST['cod_dep'];
$sel_inst1=$var[0];
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="institucioneditar.php?sel_inst=<?php echo encryto($var[0]);?>"
			</script>
		<?php
}

if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_dep'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++)
{ 
mysqli_query($conn, "DELETE FROM instituciones WHERE instituciones_cod_institucion='$var2[$i]'") or die("El Registro no Existe");
}
		?>
			<script language='JavaScript'> 
				window.self.location="institucion.php"
			</script>
		<?php
}
?>
<?php
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="institucionnuevo.php"
			</script>
		<?php
}
?>

<!DOCTYPE html>
<html>
<body>
	
<center>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="parrafo_general" >
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER>ADMINISTRACION DE INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_subtitulo"><B>LISTA DE INSTITUCIONES</B><BR>
    </TD> 
  </TR>

  <TR>

    <TD COLSPAN="3" bgcolor="#d3daed" align="top">

<FORM NAME="lista" METHOD="POST">
<TABLE width="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0">
  <TR>

    <TD WIDTH="10%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>C&Oacute;DIGO</CENTER></B></TD>
	<TD WIDTH="30%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>DESCRIPCI&Oacute;N</CENTER></B></TD> 
	<TD WIDTH="30%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>SIGLA</CENTER></B></TD>
	<TD WIDTH="30%" bgcolor="#eeeeee"><SPAN class="fuente_subtitulo"><B><CENTER>DOMINIO</CENTER></B></TD>     
	    
  </TR>
</table>

<div style="overflow:auto; width:100%; height:100px; align-self:left;">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0" >

<?php
$resaltador=0;
if(!empty($rss))
{

while($row = mysqli_fetch_array($rss)) 
{
 		  if ($resaltador==0)
			  {
				   echo "<tr class=trdos >";
				   $resaltador=1;
			  }
			  else
			  {
				   echo "<tr class=truno >";
				   $resaltador=0;
			  }
?>

    <TD WIDTH="10%" align="center">
	<INPUT TYPE="checkbox" value="<?php echo $row["instituciones_cod_institucion"];?>" name="cod_dep[]">
	</TD>
	<TD WIDTH="30%">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["instituciones_descripcion_inst"];?>
	</TD> 
	<TD WIDTH="30%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["instituciones_sigla_inst"];?>
	</TD>
	<TD WIDTH="30%" align="center">
    <P class="parrafo_normal"><SPAN class="fuente_normal">
<?php echo $row["instituciones_dominio"];?>
	</TD>     
	
  </TR>
<?php
 }  // fin while

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
