<?php
include("filtro_adm.php");
include("inicio.php");
include("conecta.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
$conn = Conectarse();
$ssql = "SELECT * FROM clasecorrespondencia";
$rss = mysqli_query($conn, $ssql);
?>
<?php
if(isset($_POST['adicionar']))
{
?>
<script language="javascript">
window.self.location="tipo_nuevo.php";
</script>
<?php
}

$var=$_POST['sel_corresp'];
$sel_inst1=$var[0];//para ver si con modificaciones no seleccionamos nada
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="tipo_documentoedita.php?sel_inst=<?php echo cifrar($var[0]);?>"
			</script>
		<?php
}


if (isset($_POST['eliminar']))
{
$var=$_POST['sel_corresp'];
$elementos = count($var);
for($i=0; $i< $elementos; $i++){
mysqli_query($conn, "DELETE FROM clasecorrespondencia WHERE clasecorrespondencia_codigo_clase_corresp='$var[$i]'"); 
}
?>
<script language="javascript">
window.self.location="tipo_documento.php";
</script>
<?php
}

if (isset($_POST['cancelar']))
{
?>
<script language="javascript">
window.self.location="menu.php";
</script>
<?php
}
?>

	
<br>
<center>
<table border="0" cellpadding="2" cellspacing="1" width="50%">
<form method="POST" name="tipo_documento">
<tr class="border_tr2">
<td align="center" width="5%">*</td>
<td align="center" width="10%">CODIGO</td>
<td align="center" width="65%">TIPO DOCUMENTO</td></tr>
<?php
$resaltador=0;
while($row=mysqli_fetch_array($rss))
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

	
    echo "<td class=\"border_tr\" align=center><input type=\"checkbox\" name=\"sel_corresp[]\" value=".$row["clasecorrespondencia_codigo_clase_corresp"]."></td>";
	echo "<td class=\"border_tr\">".$row["clasecorrespondencia_codigo_clase_corresp"]."</td>";
	echo "<td class=\"border_tr\">".$row["clasecorrespondencia_descripcion_clase_corresp"]."</td>";
	echo "</tr>";
} // while
?>
<tr><td colspan="3" align="center">
<input type="submit" name="adicionar" value="adicionar" class="boton"  />
<input type="submit" name="eliminar" value="eliminar" class="boton" />
<INPUT class="boton" TYPE="submit"  VALUE="modificar" name="modificar">
<input type="submit" name="cancelar" value="cancelar" class="boton" />
</td></tr>
</table>
</form>
</center>

<?php
include("final.php");
?>