<?php
include("filtro.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("conecta.php");
$conn=Conectarse();
$variable=descifrar($_GET['sel_usuario']);

if(!is_numeric($variable))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACI&Oacute;N DE DATOS !!!!</b></center>";
    exit();
}
$error=0;

$respiaux=mysqli_query($conn, "select * from usuario where usuario_cod_usr='$variable'");
if ($rowaux=mysqli_fetch_array($respiaux))
{
$uno=$rowaux["usuario_username"];
$dos=$rowaux["usuario_ocupacion"];
$tres=$rowaux["usuario_active"]; 
}
?>

<?php
if (isset($_POST['guardar']))
{
	       //echo "nuevo".$_POST['username'];exit();
			 $result=mysqli_query($conn, "SELECT * FROM usuario where usuario_username='$_POST[username]' AND usuario_active='1'");
			/* if ($rowaux2=mysql_fetch_array($result))
			 {
			 	$one=$rowaux2["usuario_username"];
			 }
			 $lista=mysql_num_rows($result);
			 $text=$_POST['username'];

		    $valor=alfanumerico($text);
			 
			 if($lista > 1 OR $valor==0 OR $uno==$text)
			 {
			  $error=1;
			  $alert_duplicado=1;
			 }*/
			
$text=$_POST['username'];
$valor=alfanumerico($text);			
if ($valor == "" )
{	
$error=1;
$alert_duplicado=1;
} 
 else {
         if($uno != $_POST['username'])
	   { 
             if(mysqli_num_rows($result) == 1)
	     {
	       $error=1;
               $alert_duplicado=1;
	     }
	   } 
      }

		
		  $text2=$_POST['nombre']; 
		  $valor2=alfanumerico($text2);
		  if ($valor2==0)
			{
			  $error=1;
			  $alert_nombre=1;
			}

			if(empty($_POST['numero_edificio']))
			{
			  $error=1;
			  $alert_numedificio=1;
			}
			
			if(empty($_POST['Cod_Departamento']))
			{
			  $error=1;
			  $alert_coddepartamento=1;
			}
			
			if(empty($_POST['ocupacion']))
			{
			  $error=1;
			  $alert_ocupacion=1;
			}
	                if(Val_numeros($_POST['ci']) == 1)
	                {
	                $error=1;
	                $alert_ci=1;
  	                }			
			
     	  $text1=$_POST['Titulo'];
		  $valor1=alfanumerico($text1);
		  if ($valor1==0)
			{
			  $error=1;
			  $alert_titulo=1;
			}			

    if ($error == 0) 
	  { $ssqlm= "UPDATE usuario SET 
		usuario_nombre='$_POST[nombre]',
		usuario_username='$_POST[username]',
		usuario_cargo='$_POST[car_codigo]',
		usuario_cod_departamento='$_POST[Cod_Departamento]',
		usuario_carnet='$_POST[ci]',
		usuario_carnet_ciudad='$_POST[ci_ciudad]',
		usuario_ocupacion='$_POST[ocupacion]',
		usuario_active='1',
		usuario_titulo='$_POST[Titulo]' WHERE usuario_cod_usr='$variable'";
		mysqli_query($conn, $ssqlm);
		
mysqli_query($conn, "UPDATE miderivacion SET miderivacion_estado='1' WHERE miderivacion_su_codigo='$_POST[ocupacion]'") or die("No se Guardo el Registro");	
mysqli_query($conn, "UPDATE asignar SET asignar_estado='1' WHERE asignar_su_codigo='$_POST[ocupacion]'") or die("No se Guardo el Registro");	
			
?>
	<script language="JavaScript">
        window.self.location="adminusuarios.php";
        </script>
   <?php	
   }
}

    if(isset($_POST['cancelar']))
	{
	?>
	<script language="JavaScript">
		window.self.location="adminusuarios.php";
	</script>
	<?php
	}
	
	$ssqlm = "SELECT * FROM usuario WHERE '$variable'=usuario_cod_usr";
	$rssm = mysqli_query($conn, $ssqlm);
	if($rowm=mysqli_fetch_array($rssm))
	{
	  $_POST['username']=$rowm["usuario_username"];
	  $_POST['nombre']=$rowm["usuario_nombre"];
	  $_POST['ci']=$rowm["usuario_carnet"];
	  $_POST['ci_ciudad']=$rowm["usuario_carnet_ciudad"];
	  $_POST['titulo']=$rowm["usuario_titulo"];
	  $_POST['cargo']=$rowm["usuario_cargo"];
	  $ocupaciondir=$rowm["usuario_ocupacion"];	  
    } 

	$ssqlc = "SELECT * FROM cargos WHERE cargos_id='$ocupaciondir'";
	$rssc = mysqli_query($conn, $ssqlc);
	if($rowc=mysqli_fetch_array($rssc))
	{
		$insti=$rowc["cargos_cod_institucion"];
		$ocupacion=$rowc["cargos_id"];
		$Cod_Departamento=$rowc["cargos_cod_depto"];
		$numero_edificio=$rowc["cargos_edificio"];
    }
?>

<!DOCTYPE html>
<html>
<body>
	
<center>
<br />
<form  method="POST" name="enviar">
 <table width="60%" align="center" cellspacing="2" cellpadding="2" border="0">
     <TR class="truno">
    <TD height="10" colspan="6" align="center">
      <B><P class="parrafo_titulo"><SPAN class="fuente_normal"><CENTER><BR>EDITAR USUARIOS</CENTER></B>
      
		<?php
		if ($error != '0')
        {
        echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
        }
	    ?>
      
    </TD> 
  </TR> 
    <TR class="truno">
    <TD width="150">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Edificio al que Pertenece:</B>    
    </TD>
    <td>
	<?php 
if (!isset($_POST['numero_edificio']))
{
?>
    <select name="numero_edificio" class="caja_texto" onChange="this.form.submit()">
     <option value="">Seleccione un Edificio</option>
     <?php
				
				$ssqlcinco="SELECT * FROM edificio where edificio_cod_institucion='$_SESSION[institucion]'";
				$rsscinco = mysqli_query($conn, $ssqlcinco);
				while ($rowcinco=mysqli_fetch_array($rsscinco))
					 {
                        
						if($numero_edificio==$rowcinco["edificio_cod_edificio"])
							{
     ?>
     <option value="<?php echo $rowcinco["edificio_cod_edificio"];?>" selected>
     <?php
									echo $rowcinco["edificio_descripcion_ed"];
								?>
     </option>
     <?php 
					  	    }
							
						  else
							{
							?>
     <option value="<?php echo $rowcinco["edificio_cod_edificio"];?>">
     <?php
								echo $rowcinco["edificio_descripcion_ed"];
							?>
     </option>
     <?php
						    }
					 } 

					?>
   </select>
 <?php
}
else
{
?>
    <select name="numero_edificio" class="caja_texto" onChange="this.form.submit()">
     <option value="">Seleccione un Edificio</option>
     <?php
				
				$ssqlcinco="SELECT * FROM edificio where edificio_cod_institucion='$_SESSION[institucion]'";
				$rsscinco = mysqli_query($conn, $ssqlcinco);
				while ($rowcinco=mysqli_fetch_array($rsscinco))
					 {
     					if($_POST['numero_edificio']==$rowcinco["edificio_cod_edificio"])
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
   <?php
}
	?>
<?php Alert($alert_numedificio); 
?>     
     </td>
   </TR>
   
 <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Departamento que Pertenece:</B>    </TD>
   <!--INICIO nuevo para departamento -->  
   <td >
   
	<?php 
if (!isset($_POST['Cod_Departamento']))
{
?>
   <select name="Cod_Departamento" class="caja_texto" onChange="this.form.submit()">
     <option value="">Seleccione un Departamento</option>
     <?php
				$ssqlcinco="SELECT * FROM departamento where departamento_cod_institucion='$_SESSION[institucion]' AND departamento_cod_edificio='$numero_edificio'";
				$rsscinco = mysqli_query($conn, $ssqlcinco);
				while ($rowcinco=mysqli_fetch_array($rsscinco))
					 {
						if($Cod_Departamento==$rowcinco["departamento_cod_departamento"])
							{
     ?>
     <option value="<?php echo $rowcinco["departamento_cod_departamento"];?>" selected>
     <?php
									echo $rowcinco["departamento_descripcion_dep"];
								?>
     </option>
     <?php 
					  	    }
						  else
							{
							?>
     <option value="<?php echo $rowcinco["departamento_cod_departamento"];?>">
     <?php
								echo $rowcinco["departamento_descripcion_dep"];
							?>
     </option>
     <?php
						    }
					 } 

					?>
   </select>
<?php   
}
else
{
?>
   <select name="Cod_Departamento" class="caja_texto" onChange="this.form.submit()">
     <option value="">Seleccione un Departamento</option>
     <?php
				$ssqlcinco="SELECT * FROM departamento where departamento_cod_institucion='$_SESSION[institucion]' AND departamento_cod_edificio='$_POST[numero_edificio]'";
				$rsscinco = mysqli_query($conn, $ssqlcinco);
				while ($rowcinco=mysqli_fetch_array($rsscinco))
					 {
						if($_POST['Cod_Departamento']==$rowcinco["departamento_cod_departamento"])
							{
     ?>
     <option value="<?php echo $rowcinco["departamento_cod_departamento"]?>" selected>
     <?php
									echo $rowcinco["departamento_descripcion_dep"];
								?>
     </option>
     <?php 
					  	    }
						  else
							{
							?>
     <option value="<?php echo $rowcinco["departamento_cod_departamento"]?>">
     <?php
								echo $rowcinco["departamento_descripcion_dep"];
							?>
     </option>
     <?php
						    }
					 } 

					?>
   </select>
<?php
}
?>
  <?php Alert($alert_coddepartamento); ?>     
  </td>
 <!--FIN para nuevo para departamento -->  
  </TR>   
   

<TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Cargo que Ocupa:</B>    </TD>
    <!--inicio de cargo -->
    <td>
    
<?php
if (!isset($_POST['ocupacion']))
{  
?>
    	<select name="ocupacion" class="caja_texto" onChange="this.form.submit()">
				<option value="">Cargos Disponibles</option>
				<?php
					$ssql="SELECT * FROM cargos WHERE cargos_cod_depto='$Cod_Departamento'";
				    $rss = mysqli_query($conn, $ssql);
				   if (mysqli_num_rows($rss) > 0) 
					 {
						while($row=mysqli_fetch_array($rss))
							{  
							   $cargo1=$row["cargos_id"];
							   $depto=$Cod_Departamento;//para actualizar
							   $buscar="SELECT * FROM usuario WHERE usuario_ocupacion=$cargo1 AND usuario_cod_departamento=$depto";
            				   $rssaux = mysqli_query($conn, $buscar);
		                     if (mysqli_num_rows($rssaux) > 0)
							 {
						
								        if ($ocupacion==$row["cargos_id"])
						  				{ 
			    ?>
											<option value="<?php echo $row["cargos_id"];?>" selected>
									         <?php echo $row["cargos_cargo"];
									         echo "</option>";
					       				} 
						
							}
							else
							{
	                         ?>
						  		<option value="<?php echo $row["cargos_id"];?>">
									  <?php 
											echo $row["cargos_cargo"];
										   	echo "</option>";
							}
								
						    } // while  
				}
				
			    echo "</select>";
}
else
{
?>
    	<select name="ocupacion" class="caja_texto" onChange="this.form.submit()">
				<option value="">Cargos Disponibles</option>
				<?php
				echo $_POST['Cod_Departamento'];
					$ssql="SELECT * FROM cargos WHERE cargos_cod_depto='$_POST[Cod_Departamento]'";
				    $rss = mysqli_query($conn, $ssql);
				   if (mysqli_num_rows($rss) > 0) 
					 {
						while($row=mysqli_fetch_array($rss))
							{  
							   $cargo1=$row["cargos_id"];
							   $depto=$_POST["Cod_Departamento"];
							   $buscar="SELECT * FROM usuario WHERE usuario_ocupacion=$cargo1 AND usuario_cod_departamento=$depto";
            				   $rssaux = mysqli_query($conn, $buscar);
		
								if(!$row1=mysqli_fetch_array($rssaux))
								{ //cargos disponibles
																
								if (isset($_POST['ocupacion'])) 
									{
								        if ($_POST['ocupacion']==$row["cargos_id"])
						  				{ 
			    ?>
											<option value="<?php echo $row["cargos_id"];?>" selected >
									         <?php echo $row["cargos_cargo"];
									         echo "</option>";
					       				} 
									   else 
									    {
									   ?>
									   		<option value="<?php echo $row["cargos_id"];?>" >
									           <?php echo $row["cargos_cargo"];
								           echo "</option>"; 	   
						   				}  
				   					}
								   else
									{
									  ?>
									  		<option value="<?php echo $row["cargos_id"];?>">
									  <?php 
											echo $row["cargos_cargo"];
										   	echo "</option>";
				   					} //end if isset
								}//end cargos disponibles
								
						    } // while  
				}
				
			    echo "</select>";
}
 	Alert($alert_ocupacion); 
?>  
    
 
    </td>
   <!--fin de cargo -->
   </tr>
   
   <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nombre de Usuario:</B></TD> 
    <TD width="100" height="10" colspan="1">
    <input class="fuente_caja_texto" name="username" type="text" SIZE="40" value="<?php echo $_POST['username'];?>">
    <?php Alert($alert_username); ?>  
    <?php 
	if (isset($alert_duplicado))
	{
	Alert($alert_duplicado);
	echo "<i class='fuente_normal_rojo'> USERNAME "."<b>".$_POST['Username']."</b>"." EXISTENTE</i>";
	}
	?>
    </TD>
  </TR>  
	        
  <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nombres y Apellidos:</B></TD> 
    <TD width="100" height="10" colspan="1">
    <input class="fuente_caja_texto" name="nombre" type="text" SIZE="40" value="<?php echo $_POST['nombre'];?>">
    <?php Alert($alert_nombre); ?> 
    </TD>
  </TR>
  
   <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nivel al que Pertenece:</B></TD> 
    <TD width="100" height="10" colspan="1">
    	<select class="fuente_caja_texto" name="car_codigo">
        <option value="">Seleccione Nivel Usuario</option>
        <option value="Personal" <?php if($_POST['cargo']=='Personal') { echo "selected";}?>>Personal</option>
        <option value="Ventanilla" <?php if($_POST['cargo']=='Ventanilla') { echo "selected";}?>>Ventanilla</option>
        <option value="Secretaria" <?php if($_POST['cargo']=='Secretaria') { echo "selected";}?>>Secretaria</option>
        </select>
    </TD>
  </TR>  
  

  
   <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Carnet de Identidad:</B></TD> 
    <TD width="150" height="10" colspan="1">
   <input class="fuente_caja_texto" name="ci" type="text" SIZE="10" value="<?php echo $_POST['ci'];?>">
   <?php Alert($alert_ci);?>
   <select class="fuente_caja_texto" name="ci_ciudad">
   <option value="">Seleccione CI</option>
        <option value="LP" <?php if($_POST['ci_ciudad']=='LP') { echo "selected";}?>>LP</option>
        <option value="CBBA" <?php if($_POST['ci_ciudad']=='CBBA') { echo "selected";}?>>CBBA</option>
        <option value="SC" <?php if($_POST['ci_ciudad']=='SC') { echo "selected";}?>>SC</option>
        <option value="OR" <?php if($_POST['ci_ciudad']=='OR') { echo "selected";}?>>OR</option>
        <option value="BE" <?php if($_POST['ci_ciudad']=='BE') { echo "selected";}?>>BE</option>
        <option value="PA" <?php if($_POST['ci_ciudad']=='PA') { echo "selected";}?>>PA</option>
        <option value="EA" <?php if($_POST['ci_ciudad']=='EA') { echo "selected";}?>>EA</option>
        <option value="CHU" <?php if($_POST['ci_ciudad']=='CHU') { echo "selected";}?>>CHU</option>
        <option value="PO" <?php if($_POST['ci_ciudad']=='PO') { echo "selected";}?>>PO</option>
        <option value="TJ" <?php if($_POST['ci_ciudad']=='TJ') { echo "selected";}?>>TJ</option>
   </select>
     </TD>
  </TR>

     <TR class="truno">
       <TD width="150" height="10" colspan="1">
       <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Titulo:</B></TD>
       <TD width="100" height="10" colspan="1">
        <input class="fuente_caja_texto" name="Titulo" type="text" SIZE="10" value="<?php echo $_POST['titulo'];?>">
         <?php Alert($alert_titulo);?>
        </TD>
      </TR>

</TABLE>
<center>
<input type="submit" class="boton" name="guardar"  VALUE="Guardar">
<input type="submit" class="boton" name="cancelar"  VALUE="Cancelar">
</center>
</form>
<br />
</center>
<br />

</body>	
</html>

<?php
include("final.php");
?>
