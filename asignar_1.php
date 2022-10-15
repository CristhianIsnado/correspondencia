<?php
include("filtro_adm.php");
include("inicio.php");
include("conecta.php");
$conn=Conectarse();
?>

<?php
$codigo=$_SESSION["codigo_miderivacion"];
$institucion=$_SESSION["institucion"];

$ssql="SELECT * from cargos where cargos_cod_institucion='$institucion' and cargos_id <>'$codigo' ORDER BY cargos_cod_depto";
$ssqll="SELECT * from asignar where asignar_mi_codigo='$codigo'";

if (isset($_POST['enviar']))
{
$var=$_POST['cod_usuario'];
$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	$respu=mysqli_query($conn, "select * from asignar where asignar_mi_codigo='$codigo'and asignar_su_codigo='$var[$i]'");
	$Lista=mysqli_fetch_row($respu);
	if($Lista[0])
	{
		echo " ";
	}
	else
	{
	$compro=mysqli_query($conn, "select * from usuario where usuario_ocupacion='$var[$i]' and usuario_active='1'");
	if (mysqli_num_rows($compro) > 0)
	{
	mysqli_query($conn, "insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado)values('$codigo','$var[$i]','1')") or die("El Registro no Existe");
	
	}
	else
	{
	mysqli_query($conn, "insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado)values('$codigo','$var[$i]','0')") or die("El Registro no Existe");
	
	}
	
	}
   } //end for

?>
<script>
        window.self.location="asignar_1.php";
</script>
<?php
}//fin enviar


 if (isset($_POST['regresar']))
 {  $var=$_POST['cod_usuario'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	mysqli_query($conn, "delete from asignar where asignar_mi_codigo='$codigo'and asignar_su_codigo='$var[$i]'") or die("El Registro no Existe");
	}
	?>
	<script>
			window.self.location="asignar_1.php";
	</script>
	<?php
  }//fin regresar
?>

<br>
<B><P class="fuente_titulo_principal"><span class="fuente_normal">
<CENTER> SELECCION DE CARGOS A LAS QUE PUEDE ASIGNAR ARCHIVOS
</CENTER></B><br />
<div align="center" class="fuente_subtitulo">

<?php
 $valor_clave=$_SESSION["codigo_miderivacion"];
	$conexion = mysqli_query($conn, "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
		    $valor_clave1=$fila_clave["cargos_edificio"];
			$conexion1 = mysqli_query($conn, "SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio");
			if($fila_clave1=mysqli_fetch_array($conexion1))
			{
			echo "EDIFICIO:  ".strtoupper($fila_clave1["edificio_descripcion_ed"]);echo "<br>";
			}		

		    $valor_clave2=$fila_clave["cargos_cod_depto"];
			$conexion2 = mysqli_query($conn, "SELECT * FROM departamento WHERE '$valor_clave2'=departamento_cod_departamento");
			if($fila_clave2=mysqli_fetch_array($conexion2))
			{
		    echo "DEPARTAMENTO:  "."<b class='fuente_normal_rojo'>".strtoupper($fila_clave2["departamento_descripcion_dep"])."</b>";echo "<br>";
			}			
			echo "DERIVACI&Oacute;N DE:  "."<b class='fuente_normal_rojo'>".strtoupper($fila_clave["cargos_cargo"])."</b>";echo "<br>";
	}
?>
</div>
<BR>
<center>
<table border=1 width="80%">
<tr>
<td width="50%" align="left">
<center><span class="fuente_subtitulo">LISTADO TOTAL DE CARGOS</span></center>
<?php
$resulta=mysqli_query($conn, $ssql); // resulta=RS
?>

<form name="enviar" method="post">
<div style="overflow:auto; width:500; height:350px; align-self:left;">
<table boder=1>
<tr>
<td bgcolor="#c7c7cc"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
<td bgcolor="#c7c7cc"><span class="fuente_subtitulo">CARGO</span></td>
<td bgcolor="#c7c7cc"><span class="fuente_subtitulo">DEPARTAMENTO</span></td>
<td bgcolor="#c7c7cc"><span class="fuente_subtitulo">EDIFICIO</span></td>
</tr>
<?php
$resaltador=0;
while ($row=mysqli_fetch_array($resulta))
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
<td>
<input type="checkbox" value="<?php echo $row["cargos_id"];?>" name="cod_usuario[]">
</td>
<?php
echo "<td ><span class=fuente_normal>".$row["cargos_cargo"]."</span></td>";
$valor_clave=$row["cargos_cod_depto"];
$conexion = mysqli_query($conn, "SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento and departamento_cod_institucion='$institucion'");
	if($fila_clave=mysqli_fetch_array($conexion))
	{
	echo "<td><span class=fuente_normal>".$fila_clave["departamento_descripcion_dep"]."</span></td>";
	        
			$valor_clave1=$fila_clave["departamento_cod_edificio"];
			$conexion1 = mysqli_query($conn, "SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio");
			if($fila_clave1=mysqli_fetch_array($conexion1))
			{
			echo "<td><span class=fuente_normal>".$fila_clave1["edificio_sigla_ed"]."</span></td>";
			}		
	
	}
}
?>
        
</table>
</div>
<center>
<input class="boton" type="submit" name="enviar" value="Adicionar">
<br /><br />
</center>
<input class="boton" type="button"  value="Marcar Todo" onclick="javascript:seleccionar_todo()" >
<input class="boton" type="button"  value="Desmarcar Todo" onclick="javascript:deseleccionar_todo()" >
</form>
<?php
/**************************************************************************************************
                                          PERSONAL SELECCIONADO
**************************************************************************************************/
?>

</td>
<td width="50%" align="left">
<center><span class="fuente_subtitulo">CARGOS SELECCIONADOS</span></center>
<form name="regresar" method="post">
<div style="overflow:auto; width:500; height:350px; align-self:left;">
<table boder=1 width="100%">
<tr>
<td bgcolor="#eeeeee"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
<td bgcolor="#c7c7cc"><span class="fuente_subtitulo">CARGO</span></td>
<td bgcolor="#c7c7cc"><span class="fuente_subtitulo">DEPARTAMENTO</span></td>
<td bgcolor="#c7c7cc"><span class="fuente_subtitulo">EDIFICIO</span></td>

</tr>
<?php
$resaltador=0;
$resu=mysqli_query($conn, $ssqll);// resulta=RS
while ($rows=mysqli_fetch_array($resu))
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
<td>
<?php
if($rows["asignar_original"]=='1')
{
?>
 <input  type="checkbox" value="<?php echo $rows["asignar_su_codigo"];?>" name="cod_usuario[]" disabled="disabled">

 <?php
 }
 else
 {
 ?>
 <input  type="checkbox" value="<?php echo $rows["asignar_su_codigo"];?>" name="cod_usuario[]">

 <?php
 }
 ?>
</td>
<?php
$result=mysqli_query($conn, "SELECT * FROM cargos,departamento where cargos.cargos_id='$rows[asignar_su_codigo]' and cargos.cargos_cod_depto=departamento.departamento_cod_departamento");

	if ($row=mysqli_fetch_array($result))
	{
	$varia=$row["cargos_cargo"];
	$cargito=$row["departamento_descripcion_dep"];
	    $valor_clave1=$row["cargos_edificio"];
		$conexion1 = mysqli_query($conn, "SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio");
		if($fila_clave1=mysqli_fetch_array($conexion1))
		{
		$edificio=$fila_clave1["edificio_sigla_ed"];
		}		
	}
	
echo "<td> <span class=fuente_normal>".$varia."</span></td>";
echo "<td> <span class=fuente_normal>".$cargito."</span></td>";
echo "<td> <span class=fuente_normal>".$edificio."</span></td>";
}
?>
</table>
</div>
<center>
<input class="boton" type="submit" name="regresar" value="Quitar">
<br /><br />
</center>
<input class="boton" type="button"  value="Marcar Todo" onclick="javascript:seleccionar_todo2()" >
<input class="boton" type="button"  value="Desmarcar Todo" onclick="javascript:deseleccionar_todo2()" >

</form>


</td>
</tr>
</table>
<br>
<form method="get" action="asignar.php">
<input type="submit" value="Cancelar" class="boton">
</form> 
<br>
</center>

<?php
include("final.php");
?>		