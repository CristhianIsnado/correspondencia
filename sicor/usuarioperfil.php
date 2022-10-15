<?php
include("../filtro.php");
include("inicio.php");
include("script/functions.php");
include("script/cifrar.php");
include("../conecta.php");
$conn = Conectarse();
$codigo=$_SESSION["cargo_asignado"];
?>

<?php
$error=0;
if(isset($_POST['cambiar']))
{
     	$text1=$_POST['titulo'];
	$valor1=alfanumerico($text1);
	if ($valor1==0)
	{
	  $error=1;
	  $alert_titulo=1;
	}
     	
	$text=$_POST['nombre'];
	$valor=alfanumerico($text);
	if ($valor==0)
	{
	  $error=1;
	  $alert_nombre=1;
	}
	
	if(Val_numeros($_POST['ci']) == 1)
	{
	$error=1;
	$alert_ci=1;
	}		
	if ($error==0)
	{	
mysqli_query($conn, "UPDATE usuario SET usuario_titulo='$_POST[titulo]', usuario_nombre='$_POST[nombre]', usuario_carnet='$_POST[ci]', usuario_carnet_ciudad='$_POST[ci_ciudad]' WHERE  usuario_ocupacion='$codigo'");
?>       
<script language="javascript">
	window.self.location="menu.php";
</script>
<?php
	}
}

if(isset($_POST['password']))
{
?>
<script language="javascript">
window.self.location="usuariopassword.php";
</script>
<?php
}

if(isset($_POST['cancelar']))
{
?>
<script language="javascript">
window.self.location="menu.php";
</script>
<?php
}
 
$ssql = "SELECT * FROM  usuario WHERE usuario_ocupacion='$codigo'";
$rss=mysqli_query($conn, $ssql);
if($row=mysqli_fetch_array($rss))
{
?>

<B><span class="fuente_normal"><CENTER><BR />DATOS PERSONALES DEL USUARIO
	</CENTER><BR /></span></B>

  <form method="POST" name="actual">
<TABLE WIDTH="50%" BORDER="0" CELLSPACING="1" CELLPADDING="0" ALIGN="center">
   <tr class="truno">
    <td class="border_tr2"><p class="parrafo_normal"><span class="fuente_normal">Cargo</span></p></td>
    <td><p class="parrafo_normal"><span class="fuente_normal"><?php echo $row["usuario_cargo"];?></span></p></td>
  </tr>
  <tr class="truno">
    <td class="border_tr2"><p class="parrafo_normal"><span class="fuente_normal">Email</span></p></td>
    <td><p class="parrafo_normal"><span class="fuente_normal"><?php echo $row["usuario_email"];?></span></p></td>
  </tr>
  <tr class="truno">
    <td class="border_tr2"><p class="parrafo_normal"><span class="fuente_normal">Username</span></p></td>
    <td><p class="parrafo_normal"><span class="fuente_normal"><?php echo $row["usuario_username"];?></span></p></td>
  </tr>
  
   <TR class="truno">
    <TD width="40%" class="border_tr2"><p class="parrafo_normal"><span class="fuente_normal">Titulo</span></p></TD>
    <TD width="60%">
       <input class="fuente_caja_texto" name="titulo" type="text" size="30" value="<?php echo $row["usuario_titulo"];?>">
         <?php Alert($alert_titulo);?>
	
    </TD>
  </TR>
  
   <TR class="truno">
    <TD class="border_tr2"><p class="parrafo_normal"><span class="fuente_normal">Nombre</span></p></TD>
   <TD>
	<INPUT class="fuente_caja_texto" NAME="nombre" TYPE="text" SIZE="30" value="<?php echo $row["usuario_nombre"];?>">
       <?php Alert($alert_nombre); ?> 
   </TD>
  </tr>
  
   <TR class="truno">
    <TD class="border_tr2"><p class="parrafo_normal"><span class="fuente_normal">Carnet de Identidad</span></p></TD>
   <TD ><INPUT class="fuente_caja_texto" NAME="ci" TYPE="text" SIZE="15" value="<?php echo $row["usuario_carnet"];?>">
   <?php Alert($alert_ci); ?> 
  <b style="font-size: 10px;">
  <?php echo $row["usuario_carnet_ciudad"];?>
  </b>
  <i style="font-size: 9px;">&nbsp;&nbsp;&nbsp; Si desea cambiar la procedencia del CI seleccione aqui</i> -->
  <select class="fuente_caja_texto" name="ci_ciudad">
        <option value="LP">LP</option>
        <option value="CBBA">CBBA</option>
        <option value="SC">SC</option>
        <option value="OR">OR</option>
        <option value="BE">BE</option>
        <option value="PA">PA</option>
        <option value="EA">EA</option>
        <option value="CHU">CHU</option>
        <option value="PO">PO</option>
        <option value="TA">TJ</option>
   </select>

 
   </TD>
  </tr>
    
 </table>
<p><center>
<input class="boton" type="submit" value="Guardar Cambios" name="cambiar">
<input class="boton" type="submit" value="Cambiar Password" name="password">
<input class="boton" type="submit" value="Cancelar" name="cancelar">
</center></p>
</form>

<?php
}
include("final.php");
?>
