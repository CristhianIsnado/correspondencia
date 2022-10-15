<?php
include("filtro.php");
include("inicio.php");
include("sicor/script/functions.php");
include("sicor/script/cifrar.php");
include("conecta.php");
$institucion=$_SESSION["institucion"];
$conn=Conectarse();

?>
<?php
$error=0;
if(isset($_POST['enviar']))
{

    $text=$_POST['Username'];
    $valor=alfanumerico($text);
    if ($valor==0)
    {
    $error=1;
    $alert_username=1;
    }
    
    $result=mysqli_query($conn, "SELECT * FROM usuario where usuario_username='$_POST[Username]' AND usuario_active='1'");
    $lista=mysqli_num_rows($result);
    if($lista >0)
    {
    $error=1;
    $alert_duplicado=1;
    }
    
    
    $text2=$_POST['Nombre'];
    $valor2=alfanumerico($text2);
    if ($valor2==0)
    {
    $error=1;
    $alert_nombre=1;
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
    
    if(empty($_POST['Cod_Institucion']) and $_SESSION["adminvirtual"]=='adminvirtual')
    {
    $error=1;
    $alert_institucion=1;
    }
    
    if(empty($_POST['ci_ciudad']))
    {
    $error=1;
    $alert_ciudad=1; 
    }
		
    if (($_SESSION["adminvirtual"])=="adminlocal")
    {
    $Cod_Institucion = $_SESSION["institucion"];
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
    }
    else
    {
       $Cod_Institucion = $_POST["Cod_Institucion"];
    }
	    
    if ($error=='0')
    {
	
$dominio=$_POST['Dominio'];	
$inst="SELECT * FROM instituciones WHERE instituciones_cod_institucion='$_SESSION[institucion]'";
$rsdomi = mysqli_query($conn, $inst);

if($rowdomi=mysqli_fetch_array($rsdomi))
{
$dominio=$rowdomi["instituciones_dominio"];
}
$User2=$_POST['Username']."/";
$Email=$_POST['Username']."@".$dominio;
mysqli_query($conn, "insert into usuario (usuario_cod_departamento,usuario_nombre,usuario_titulo,usuario_email,usuario_username,usuario_dominio,usuario_cod_nivel,usuario_password,usuario_cod_institucion,usuario_cargo,usuario_maildir,usuario_ocupacion,usuario_carnet,usuario_carnet_ciudad)
VALUES ('$_POST[Cod_Departamento]','$_POST[Nombre]', '$_POST[Titulo]','$Email','$_POST[Username]','$dominio','$_POST[Cod_Nivel]',MD5('$_POST[Username]'),'$Cod_Institucion', '$_POST[car_codigo]','$User2','$_POST[ocupacion]','$_POST[ci]','$_POST[ci_ciudad]')") or die ("No se Guardo el archivo");


/*Asignar mi Codigo*/
$rsaux1 = mysqli_query($conn, "SELECT * FROM asignar WHERE asignar_mi_codigo='$_POST[ocupacion]'");
   while($rowaux1 = mysqli_fetch_array($rsaux1)) 
   {
       		$sucodigo=$rowaux1["asignar_su_codigo"];
       		$rsaux2 = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario_ocupacion='$sucodigo'");
       		if (mysqli_num_rows($rsaux2) > 0)
       		{
  	mysqli_query($conn, "UPDATE asignar SET asignar_estado='1' WHERE asignar_mi_codigo='$_POST[ocupacion]' and asignar_su_codigo='$sucodigo'") or die("No se Guardo el Registro");	     			
       		}
   }	

/*Asignar su Codigo*/
$rsaux3 = mysqli_query($conn, "SELECT * FROM asignar WHERE asignar_su_codigo='$_POST[ocupacion]'");
   while($rowaux3 = mysqli_fetch_array($rsaux3)) 
   {
       		$micodigo=$rowaux3["asignar_mi_codigo"];
       		$rsaux4 = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario_ocupacion='$micodigo'");
       		if (mysqli_num_rows($rsaux4) > 0)
       		{
mysqli_query($conn, "UPDATE asignar SET asignar_estado='1' WHERE asignar_su_codigo='$_POST[ocupacion]' and asignar_mi_codigo='$micodigo'") or die("No se Guardo el Registro");	     			       			
       		}
   }	

mysqli_query($conn, "UPDATE miderivacion SET miderivacion_estado='1' WHERE miderivacion_su_codigo='$_POST[ocupacion]'") or die("No se Guardo el Registro");	

mysqli_free_result($rsaux1);
mysqli_free_result($rsaux3);
		?>
			<script language='JavaScript'> 
				window.self.location="adminusuarios.php"
			</script>
		<?php
	}
}
?>

<form  method="POST">
 <table width="60%" align="center" cellspacing="2" cellpadding="2" border="0">
  <TR>
    <TD height="10" colspan="6" align="center">
	<?php
	if ($_SESSION["adminvirtual"] == "adminvirtual")
	{
	?>
        <B><P class="parrafo_titulo"><SPAN class="fuente_normal"><CENTER><BR>ADICIONAR USUARIOS ADMINISTRADORES DEL SISTEMA</CENTER><BR></B>
	
	<?php
	}
	else
	{
	?>
       <B><P class="parrafo_titulo"><SPAN class="fuente_normal"><CENTER><BR>ADICIONAR USUARIOS DEL SISTEMA</CENTER><BR></B>
	<?php    
	}
	
	?>

	<?php
        if ($error != '0')
        {
        echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
        }
        ?>
      
    </TD> 
  </TR>

 	<?php
    if ($_SESSION["nivel"]==3)
    {
    ?>
    <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Institucion:</B></TD>
    <TD width="100" height="10" colspan="1">
        <select class="fuente_caja_texto" name="Cod_Institucion" onChange="this.form.submit()">
        <option value="">Seleccione una Instituci&oacute;n</option>
        <?php
        $resp=mysqli_query($conn, "select * from instituciones");
        while($row=mysqli_fetch_array($resp))
        {
			if ($_POST['Cod_Institucion']==$row["instituciones_cod_institucion"])
			{	
			?>
			<option value=<?php echo $row["instituciones_cod_institucion"];?> selected="selected">
			<?php
			echo $row["instituciones_descripcion_inst"];
			?>
			</option>
			<?php
			}
			else
			{
			?>
			<option value=<?php echo $row["instituciones_cod_institucion"];?>>
			<?php
			echo $row["instituciones_descripcion_inst"];
			?>
			</option>
			<?php
			}
		}
        ?>
        </select>   
        <?php Alert($alert_institucion); ?>
        </TD>
   </TR>

  <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nivel:</B>    </TD>
    <TD width="100" height="10" colspan="1">
        <SELECT width="80" class="fuente_caja_texto" name="Cod_Nivel">
        <OPTION value="2">Administrador</OPTION>
        <OPTION value="3">Super Administrador</OPTION>
        </SELECT>    </TD>
  </TR>

	<?php
    }
    else
    {
    ?>
    <TR class="truno">
    <TD width="150">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Departamento del Edificio:</B>    
    </TD>
   <td>
   <select name="numero_edificio" class="caja_texto" onchange="this.form.submit()">
     <option value="">Seleccione un Edificio</option>
     <?php
				$ssqlcinco="SELECT * FROM edificio where edificio_cod_institucion='$institucion'";
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
     <?php Alert($alert_numedificio); ?>     
     </td>
   </TR>
    
    
    
    
   <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Departamento que Pertenece:</B>    </TD>
   <!--INICIO nuevo para departamento -->  
   <td >
   <select name="Cod_Departamento" class="caja_texto" onchange="this.form.submit()">
     <option value="">Seleccione un Departamento</option>
     <?php
				$ssqlcinco="SELECT * FROM departamento where departamento_cod_institucion='$institucion' AND departamento_cod_edificio='$_POST[numero_edificio]'";
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
     <?php Alert($alert_coddepartamento); ?>     </td>
 <!--FIN para nuevo para departamento -->  
  </TR>
    
    <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Cargo que Ocupa:</B>    </TD>
    <!--inicio de cargo -->
    <td>
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
				else 
				mysqli_free_result($rss);
			    echo "</select>";
				Alert($alert_ocupacion); 
			?>
    </td>
   <!--fin de cargo -->
   </TR>
		<?php
        }
        ?>
<?php 
if (($_SESSION["adminvirtual"])=="adminlocal")
{
?>        
<TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nivel al que Pertenece:</B>
    </TD>
    <TD width="100" height="10" colspan="1">
		<select class="fuente_caja_texto" name="car_codigo">
        <option value="Personal">Personal</option>
        <option value="Ventanilla">Ventanilla</option>
        <option value="Secretaria">Secretaria</option>
        </select>
    </TD>
   </TR>        
<?php
}
?>   
<TR class="truno">
    <TD width="150">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nombre de Usuario:</B>    </TD>
    <TD width="160" >
    <input class="fuente_caja_texto" name="Username" type="text" SIZE="20" value="<?php echo $_POST['Username']?>">
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
    
 <?php
 if(isset($_POST['Cod_Institucion']))
{  
 if ($_POST['Cod_Institucion']!='')
  {
	?>
    <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Dominio:</B></TD>
    <TD width="100" height="10" colspan="1">
 
    <?php

	$institu="SELECT * FROM instituciones WHERE instituciones_cod_institucion='$_POST[Cod_Institucion]'";
	$rsinst = mysqli_query($conn, $institu);
	
	if($rowins=mysqli_fetch_array($rsinst))
	{
	echo "<input class='fuente_caja_texto' readonly='readonly'  name='Dominio' type='text' value=".$rowins["instituciones_dominio"].">";
	}
	?>
     </TD>
  </TR>
<?php 
  }
}
?>

  <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Nombre(s) y Apellidos:</B></TD> 
    <TD width="350" height="10" colspan="1">
    <input class="fuente_caja_texto" name="Nombre" type="text" SIZE="40" value="<?php echo $_POST['Nombre']?>">
     <?php Alert($alert_nombre); ?>    </TD>
  </TR>
  
   <TR class="truno">
    <TD width="150" height="10" colspan="1">
    <P class="parrafo_normal">
    <SPAN class="fuente_normal"><B>Carnet de Identidad:</B></SPAN></TD> 
    <TD width="250" height="10" colspan="1">
   <input class="fuente_caja_texto" name="ci" type="text" SIZE="10" value="<?php echo $_POST['ci']?>">
   <?php Alert($alert_ci); ?> 
   <select class="fuente_caja_texto" name="ci_ciudad">
   <option value="">Seleccione Procedencia CI</option>
  <?php
  if ($_POST['ci_ciudad']=='LP')
  {
  echo "<option value='LP' selected='selected'>LP</option>";
  }
  else
  {
	  if ($_POST['ci_ciudad']=='CBBA')
	  {
	  echo "<option value='CBBA' selected='selected'>CBBA</option>";
	  }
	  else
	  {
		  if ($_POST['ci_ciudad']=='SC')
		  {
		  echo "<option value='SC' selected='selected'>SC</option>";
		  }
		  else
		  {
			  if ($_POST['ci_ciudad']=='OR')
			  {
			  echo "<option value='OR' selected='selected'>OR</option>";
			  }
			  else
			  {
				  if ($_POST['ci_ciudad']=='BE')
				  {
				  echo "<option value='BE' selected='selected'>BE</option>";
				  }
				  else
				  {
					  if ($_POST['ci_ciudad']=='PA')
					  {
					  echo "<option value='PA' selected='selected'>PA</option>";
					  }
					  else
					  {
						  if ($_POST['ci_ciudad']=='CHU')
						  {
						  echo "<option value='CHU' selected='selected'>CHU</option>";
						  }
						  else
						  {
							  if ($_POST['ci_ciudad']=='PO')
							  {
							  echo "<option value='PO' selected='selected'>PO</option>";
							  }
							  else
							  {
								  if ($_POST['ci_ciudad']=='TJ')
								  {
								  echo "<option value='TJ' selected='selected'>TJ</option>";
								  }									  
							  }							  
						  }						  						  
					  }
				  }
			  }
		  
     	  }
	  } 
  }
   echo "<option value='LP'>LP</option>";
   echo "<option value='CBBA'>CBBA</option>";
   echo "<option value='OR'>OR</option>";
   echo "<option value='BE'>BE</option>";
   echo "<option value='PA'>PA</option>";
   echo "<option value='CHU'>CHU</option>";
   echo "<option value='PO'>PO</option>";
   echo "<option value='TJ'>TJ</option>";               
   echo "<option value='SC'>SC</option>";
   ?>
  </select>
     <?php Alert($alert_ciudad);?>  
    </TD>
  </TR>

     <TR class="truno">
       <TD width="150" height="10" colspan="1">
       <P class="parrafo_normal"><SPAN class="fuente_normal"><B>Titulo:</B></TD>
       <TD width="100" height="10" colspan="1">
        <input class="fuente_caja_texto" name="Titulo" type="text" SIZE="10" value="<?php echo $_POST['Titulo']?>">
         <?php Alert($alert_titulo);?></TD>
      </TR>
</TABLE>
<CENTER>
<input class="boton" name="enviar" type="submit" VALUE="Guardar">
<input class="boton" name="BOTON_A" type="reset" VALUE="Limpiar">
</CENTER>
</form>

<br />
<div align="center">
<a href="adminusuarios.php"><img src="images/atras.gif" border="0"></a><br>
</div>	

<?php
include("final.php");
?>

