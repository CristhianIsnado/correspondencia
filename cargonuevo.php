<?php
include("filtro.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("conecta.php");
$conn=Conectarse();
?>

<?php
$error=0;
if (isset($_POST['enviar']))
{ 
	  $result=mysqli_query($conn, "SELECT * FROM cargos where cargos_cargo='$_POST[carguito]' AND cargos_cod_institucion='$_SESSION[institucion]' AND cargos_cod_depto='$_POST[departamentito]' AND cargos_edificio='$_POST[edificito]'");
	  $lista=mysqli_num_rows($result);
	  if($lista >0)
	  {
	  $error=1;
	  $alert_duplicado=1;
	  }
	  
	  $text1=$_POST['carguito'];
	  $valor1=alfanumerico($text1);
	  if ($valor1==0)
	  {
	  $error=1;
	  $alert_carguito=1;
	  }	
	  
	  if(empty($_POST['departamentito']))
	  {
	  $error=1;
	  $alert_departamentito=1;
	  }	
	  
	  if(empty($_POST['edificito']))
	  {
	  $error=1;
	  $alert_edificito=1;
	  }
	
	  /*if(empty($_POST['dependencia']))
	  {
	  $error=1;
	  $alert_dependencia=1;
	  }*/
	
  if ($error==0)
  {
$rs1 = mysqli_query($conn, "SELECT * from cargos where cargos_edificio='$_POST[edificito]'");
if (mysqli_num_rows($rs1) > 0) 
{
mysqli_query($conn, "insert into cargos(cargos_cargo, cargos_cod_institucion, cargos_cod_depto, cargos_edificio,cargos_dependencia)values('$_POST[carguito]','$_SESSION[institucion]','$_POST[departamentito]','$_POST[edificito]','$_POST[dependencia]')");
//desde aqui
$rs = mysqli_query($conn, "SELECT max(cargos_id) from cargos where cargos_edificio='$_POST[edificito]'");
	  if ($numero = mysqli_fetch_row($rs)) 
	  {
	  $numero1=$numero[0];
	  }
 //DIRECTA		
mysqli_query($conn, "insert into miderivacion (miderivacion_mi_codigo,miderivacion_su_codigo,miderivacion_estado,miderivacion_original)values('$_POST[dependencia]','$numero1','0','1')") or die("El Registro no Existe");		
mysqli_query($conn, "insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado,asignar_original)values('$_POST[dependencia]','$numero1','0','1')") or die("El Registro no Existe");
 //INVERSA 
mysqli_query($conn, "insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado,asignar_original)values('$numero1','$_POST[dependencia]','0','1')") or die("El Registro no Existe");
}
else
{
mysqli_query($conn, "insert into cargos(cargos_cargo, cargos_cod_institucion, cargos_cod_depto, cargos_edificio, cargos_dependencia)values('$_POST[carguito]','$_SESSION[institucion]','$_POST[departamentito]','$_POST[edificito]','$_POST[dependencia]') ");
}
//hasta aqui		
     ?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
     <?php
    }
}
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
<?php
}
?>

	
<center>
<br>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
ADICION DE CARGOS
</P>
<?php
        if ($error != '0')
        {
        echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
        }
		
	if (isset($alert_duplicado))
	{
	echo "<i class='fuente_normal_rojo'>ESTE CARGO YA EXISTE EN LA BASE DE DATOS</i>";
	}
?>
<table>
<form method="post">
<tr class="truno">
<td><SPAN class="fuente_subtitulo">EDIFICIO PERTENENCIA:</td>
<td>
          <select name="edificito" class="fuente_caja_texto" onChange="this.form.submit()">
            <option value="">Selecione un Edificio</option>
			<?php
				$ssqlcinco="SELECT * FROM edificio WHERE '$_SESSION[institucion]'=edificio_cod_institucion order by edificio_descripcion_ed ";
				$rsscinco = mysqli_query($conn, $ssqlcinco);
				while ($rowcinco=mysqli_fetch_array($rsscinco))
					 {
						if($_POST['edificito']==$rowcinco["edificio_cod_edificio"])
							{
			?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>" selected>
								<?php
									echo $rowcinco["edificio_descripcion_ed"];
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>">
							<?php
								echo $rowcinco["edificio_descripcion_ed"];
							?>
                                                    
								</option>
					<?php
						    }
					 } 

					?>
			</select>
                  <?php Alert($alert_edificito);?>

</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_subtitulo">DEPARTAMENTO:</td>
<td>
        <select name="departamentito" class="fuente_caja_texto" onChange="this.form.submit()">
				<option value="">Selecione un Departamento</option>
				<?php
					$ssql="SELECT * FROM departamento WHERE '$_SESSION[institucion]'=departamento_cod_institucion and departamento_cod_edificio='$_POST[edificito]' order by departamento_descripcion_dep ";
					$rss = mysqli_query($conn, $ssql);
				   if (mysqli_num_rows($rss) > 0) 
					 {
						while($row=mysqli_fetch_array($rss))
							{
								if (isset($_POST['departamentito'])) 
									{
								      if ($_POST['departamentito']==$row["departamento_cod_departamento"])
						  				{
			    ?>
											<option value="<?php echo $row["departamento_cod_departamento"];?>" selected >
									         <?php echo $row["departamento_descripcion_dep"];
									         echo "</option>";
					       				} 
									   else 
									    {
									   ?>
									   		<option value="<?php echo $row["departamento_cod_departamento"];?>" >
									           <?php echo $row["departamento_descripcion_dep"];
								           echo "</option>"; 	   
						   				}  
				   					}
								   else
									{
									  ?>
									  		<option value="<?php echo $row["departamento_cod_departamento"];?>">
									  <?php 
												  echo $row["departamento_descripcion_dep"];
										   	echo "</option>";
				   					} //end if isset
						  } // while  
						  
				}
				
			 echo "</select>";
			 ?>
               <?php Alert($alert_departamentito);?>
           

</td>
</tr>
<tr class="truno">
<td ><SPAN class="fuente_subtitulo">DESCRIPCION CARGO:</td>
<td><input class="fuente_caja_texto" type="text" name="carguito" value="<?php echo $_POST['carguito'];?>" size="40">
<?php Alert($alert_carguito); ?>
</td>
</tr>

<?php
        if ($_POST['departamentito'])
        {
        ?>
        <tr class="truno" >
        <td><span class="fuente_normal" >Dependencia</td>
		<td >
			<select name="dependencia" class="caja_texto"  >
    		<?php
						  $ssql2="SELECT * FROM cargos WHERE cargos_cod_institucion='$_SESSION[institucion]' AND  cargos_edificio='$_POST[edificito]' order by cargos_id";
						  $rss2 = mysqli_query($conn, $ssql2);
						  if (mysqli_num_rows($rss2) > 0) 
							{
							 while($row2=mysqli_fetch_array($rss2))
							  {
								if ($_POST['dependencia']==$row2["cargos_id"])
								 {
			 ?>  					     <option value="<?php echo $row2["cargos_id"];?>" class="botonde" selected="selected">
										   <?php echo $row2["cargos_cargo"]; 
									echo "</option>";	
								 }
								 else
								 {
								 ?>
								    <option value="<?php echo $row2["cargos_id"];?>" class="botonde">
										   <?php echo $row2["cargos_cargo"]; 
									echo "</option>";
								 }
							  }	// End while 
								    
							}
						   else
							{
							echo "<option value='0'>No hay registros para este Item </option>"; 
							} //isset
					
							 
							
						echo "</select>";
				
				    if (isset($alert_dependencia)) 
					{
					  //echo "<img src=\"images/eliminar.gif\" border=0 >";  
					}
		?>
		</td>
        </tr>
        <?php
        }
		?>



<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="Adicionar" >
<input class="boton" type="submit" name="cancelar" value="Cancelar" ></td>
</tr>
</form>
</table>
<br>
</center>

<?php
include("final.php");
?>
