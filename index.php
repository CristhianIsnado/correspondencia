<!DOCTYPE html>
<html>
<HEAD>
  <TITLE>SISTEMA DE CORRESPONDENCIA DEL FUNCIONARIO PUBLICO</TITLE>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <META NAME="DC.Language" SCHEME="RFC1766" CONTENT="Spanish">
  <meta name="author" content="Diplomado UAGRM" >
  <META NAME="REPLY-TO" CONTENT="cristhian.albert.isnado@gmail.com">
  <META NAME="DESCRIPTION" CONTENT="Escritorio Virtual del Funcionario P�blico">
  <META NAME="KEYWORDS" CONTENT="1, a, UAGRM, uagrm, Diplomado, Bolivia, Santa Cruz">
  <META NAME="Resource-type" CONTENT="Document">
  <META NAME="DateCreated" CONTENT="11-10-2022">
  <META NAME="Revisit-after" CONTENT="15 days">
  <META NAME="robots" content="ALL">
  <link rel="stylesheet" type="text/css" href="sicor/script/estilos2.css" title="estilos2" />
</HEAD>

<BODY>
  <center>
  <br><br>
  <form method="post" action="control.php">
  <table width="780" border="0" align="center">
    <tr>
    <td width="100%"  valign="top" colspan="3" background="images/bg.gif">&nbsp;
    </td>
    </tr>
    
    <tr>
    <td width="30">&nbsp;</td>
    <td width="718"><br>
	  <div align="center" class="subtitulo" style="font-size: 18px;">      
      <br>
      <b>SISTEMA DE  SEGUIMIENTO Y CONTROL DE CORRESPONDENCIA</b>
    </div>

	  <br>
    <table width="200" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
      <?php
			  if(empty($_REQUEST['errorusuario']))
			  {  
			?>
			<td colspan="2" class="border_tr2"><div align="center" style="font-size: 12px;">Bienvenido al Sistema</div></td>
			<?php
			  }
			  else if ($_REQUEST['errorusuario'] == 1)
			  {
			?>
			    <td colspan="2" class="border_tr2"><div align="center" style="font-size: 12px;">!! ERROR EN EL INGRESO !! CONTRASEÑA INCORRECTA</div></td>
			<?php
			  }
        else if ($_REQUEST['errorusuario'] == 3)
        {
      ?>
          <td colspan="2" class="border_tr2"><div align="center" style="font-size: 12px;">!! ERROR EN EL INGRESO !! USUARIO INCORRECTO</div></td>
      <?php    
        }
		  ?>
		
      </tr>

	    <tr>
        <td width="75" class="border_tr2" style="font-size: 12px;">Usuario:</td>
        <td width="109">
        <input type="text" name="username"></td>
      </tr>
      <tr>
        <td class="border_tr2" style="font-size: 12px;">Clave:</td>
        <td><input type="password" name="clave"></td>
      </tr>
      
      <tr>
        <td colspan="2" class="">
		    <div align="center">
		    <input type="submit" value="Enviar" name="enviar">
		    </div>
        </td>
      </tr>    
    
    </table>
    </td>
    <td width="20">&nbsp;</td>
    </tr>

    <tr>
      <td>&nbsp;&nbsp;</td>
    </tr>

    <tr>
      <td width="100%"  valign="top" colspan="3" background="images/bg.gif">&nbsp;</td>
    </tr>
  </table>
  </form>
  </center>
</BODY>
</HTML>
