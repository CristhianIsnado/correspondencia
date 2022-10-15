<?php
include("../filtro.php");
include("inicio.php");
include("../conecta.php");
$codigo_aux_a=$_SESSION["cargo_asignado"];
?>

<?php
$error=0;
if (isset($_POST['enviar']))
{
                $conn=Conectarse();
                $ssql = "SELECT * FROM usuario WHERE usuario_ocupacion='$codigo_aux_a'";
                $rsdos = mysqli_query($conn, $ssql);
                if ($rowdos = mysqli_fetch_array($rsdos))
                 {
                    if ( md5($_POST['actual']) != $rowdos["usuario_password"])
                     {
                       $error=1;
                     }
                 }
                 if ($_POST['nueva'] != $_POST['renueva'])
                     {
                       $error=2;
                     }
                if (empty($_POST['nueva']))
                {
                  $error = 3;
                }
                 if ($error==0)
                 {
                   mysqli_query($conn, "update usuario set usuario_password=md5('$_POST[nueva]') where usuario_ocupacion='$codigo_aux_a'");
?>
<br><br>
<div align="center">
<span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #0C5386; font-weight: bold">CAMBIO REALIZADO SATISFACTORIAMENTE</span>
  </p>
</div>
  <p align="center"><img src="images/pass.jpg" width="50px";border="0" /><br /><br />
   <span style="font-weight: bold"><a href="menu.php">[CONTINUAR..]</a></span>
   <br />                                         
<?php
 exit;
}
}

if(isset($_POST['cancelar']))
{
?>
</span>
   <script language='JavaScript'>
   window.self.location="usuarioperfil.php"
   </script>
<?php
}
?>
 </p>
 </div>

 <div align="center">
 <br>
 <br>
   <b class="Estilo57"> MODIFICACI&Oacute;N DE CONTRASE&Ntilde;A</b>
 <br>
 <br>

<?php
  if ($error==1)
  {
       echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! CONTRASE&Ntilde;A ACTUAL NO VALIDA !!!</b></div></p>";
  }
  else
  {
        if ($error==2)
        {
	echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! CONTRASE&Ntilde;AS NUEVAS NO COINCIDEN !!!</b></div></p>";
        }
        if ($error==3)
        {
	echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! LA CONTRASE&Ntilde;A NUEVA NO DEBE SER VACIA !!!</b></div></p>";
        }
  }
?>
<form method="post">
<TABLE WIDTH="40%" BORDER="0" CELLSPACING="1" CELLPADDING="0" HEIGHT="10" ALIGN="center">
  <tr class="truno">
  <td width="50%" class="border_tr2">
  <span class="fuente_normal"><b>Contrase&ntilde;a Actual:</b></span>
  </td>
  <td width="50%">
  <input name="actual" type="password" id="actual">
  </td>
  </tr>
  
  <tr class="truno">
  <td class="border_tr2">
  <span class="fuente_normal"><b>Nueva Contrase&ntilde;a:</b></span>
  </td>
  <td><input name="nueva" type="password" id="nueva"></td>
  </tr>
  
  <tr class="truno">
  <td class="border_tr2">
  <span class="fuente_normal"><b>Repetir Nueva Contrase&ntilde;a</b></span>
  </td>
  <td><input name="renueva" type="password" id="renueva"></td>
  </tr>
  
  <tr>
  <td colspan="2" align="center">
  <input name="enviar" type="submit" class="boton" id="enviar" value="Enviar">
  <input name="cancelar" type="submit" class="boton" id="cancelar" value="Cancelar">
  </td>
    </tr>
</table>
</form>
</div>
<?php
include("final.php");
?>
