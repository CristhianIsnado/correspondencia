<?php
include("../filtro.php");
include("inicio.php");
include("../conecta.php");
$conn=Conectarse();
//$codigo=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
$tiempo = time();
$cc=date("j", $tiempo);
$bb=date("n", $tiempo);
$aa=date("Y", $tiempo);
$fecha_hoy=$aa."-".$bb."-".$cc;
?>
<?php
$ssql = "SELECT * FROM usuario WHERE usuario_ocupacion='$codigo'";
$rs = mysqli_query($conn, $ssql);
if ($row = mysqli_fetch_array($rs)) 
{ $nombre=$row["usuario_nombre"];
}
?>

<center>
<br /><br /><br />
<table width="100%">
<tr>
<td valign="top" align="center">
                <table width="60%"  border="1" align="center" bgcolor="#ffffff" cellpadding="5" cellspacing="0" bordercolor="#006699">
                <tr>
                <td> <img src="images/tablita.gif" alt="" border="0" />
                </td>
                </tr>
                
                <tr >
                <td background="images/fondo1.gif">
                <div align="left">         
                <span class="fuente_normal_imp">
                <p align="justify">
                Sr(a): <?php echo "<b>".strtoupper($nombre)."</b>";?> al <b>SISTEMA de CORRESPONDENCIA</b> del funcionario p&uacute;blico. En este sitio usted encontrar&aacute; herramientas digitales que contribuir&aacute;n a impulsar eficazmente el desarrollo integral de la sociedad de la informaci&oacute;n en nuestro pa&iacute;s.
                </p>
                <p align="justify">
                El <b>SISTEMA DE CORRESPONDENCIA</b> representa una apuesta clara y decidida de la Agencia para el Desarrollo de la Sociedad de la Informaci&oacute;n en Bolivia - ADSIB, para coadyuvar al Estado en la construcci&oacute;n y la aplicaci&oacute;n de nuevas tecnolog&iacute;as de informaci&oacute;n en Bolivia.
                </p>
                </span>
                
                <br />
                <br />
                        <div align="center">
                        <form  method="post" action="usuarioperfil.php">
                        <?php echo "<input type=\"submit\" value=\"ACTUALIZACI&Oacute;N DE DATOS\" class=\"boton\"/>";?>
                        </form>
                        </div>
                
                </div>
                </td> 
                </tr>
                </table>
              
</td>
</tr>
</table>
</center>

<?php
include("final.php");
?>
