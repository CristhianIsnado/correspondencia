<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
  <TITLE>escritorio virtual</TITLE>
  <link rel="stylesheet" type="text/css" href="sicor/script/estilos2.css" title="estilos2" />
  <meta http-equiv="Content-Type" content="text/html; ISO-8859-1">
  <META NAME="DC.Language" SCHEME="RFC1766" CONTENT="Spanish">
  <meta name="author" content="Cristhian Isnado" >
  <META NAME="REPLY-TO" CONTENT="cristhian.albert.isnado@gmail.com">
  <LINK REV="made" href="mailto:cristhian.albert.isnado@gmail.com">
  <META NAME="DESCRIPTION" CONTENT="Escritorio virtual del funcionario publico">
  <META NAME="KEYWORDS" CONTENT="Escritorio virtual funcionario publico">
  <META NAME="Resource-type" CONTENT="Document">
  <META NAME="DateCreated" CONTENT="10-10-2022">
  <META NAME="Revisit-after" CONTENT="15 days">
  <META NAME="robots" content="NOFOLLOW">
  <LINK  href="script/qstyle.css" rel=stylesheet type=text/css>
  <link rel="stylesheet" type="text/css" href="sicor/script/acerca.css">
  <LINK  href="sicor/script/styles.css" rel=stylesheet type=text/css>
  <script language="JavaScript" src="sicor/script/ie.js" type="text/JavaScript"></script>
  
  <script>
  function seleccionar_todo()
  {//Funcion que permite seleccionar todos los checkbox
  form = document.forms["enviar"]
    for (i=0;i<form.elements.length;i++)
    {
      if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
    }
  } 

  function deseleccionar_todo()
  {//Funcion que permite deseleccionar todos los checkbox
  form = document.forms["enviar"]
    for (i=0;i<form.elements.length;i++)
    {
      if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
    }
  }

  function seleccionar_todo2()
  {//Funcion que permite seleccionar todos los checkbox
  form = document.forms["regresar"]
    for (i=0;i<form.elements.length;i++)
    {
      if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
    }regresar
  } 

  function deseleccionar_todo2()
  {//Funcion que permite deseleccionar todos los checkbox
  form = document.forms["regresar"]
    for (i=0;i<form.elements.length;i++)
    {
      if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
    }
  }

  </script>
</HEAD>

<body>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
	  
  </tr>
  <tr>
  	<td height="51" colspan="3" align="right">
		<B style="font:Verdana, Arial, Helvetica, sans-serif; color:#1e5a8c; font-size:24px"> SISTEMA DE CORRESPONDENCIA</B>
		<br>
		<B style="font:Verdana, Arial, Helvetica, sans-serif; color:#1e5a8c; font-size:16px">del Funcionario P&uacute;blico</B>	
	  </td>
  </tr>
  </tbody>
  </table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <TR class="border_tr">
    <TD align="left" width="100%" background="images/sera.gif">
    <SPAN class="parrafo_izquierda">
<?php
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $mes = array(" ","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
    echo $dias[date('w')].", ".date("d")." de ".$mes[date('n')]." de ".date("Y");
?>
&nbsp;
    </SPAN>
<?php
    echo "<font size=2pt><b>Usuario: ".$_SESSION["username"]."</b></font>";
?>
    </td>

    
  </tr>

  <tr>
    <td height="30" width="100%" colspan="3"  align="left" background="images/ala2.jpg" bgcolor="#1e5a8c">
    <!-- poner imagen --><p align="center" style="font-size:10px; color:#FFFFFF;">Gobierno Autonomo Municipal de la Guardia</p>
    </td>
  </tr>
  </table>


  <TABLE width="100%" cellspacing="0" cellpadding="0" BORDER="0" class="border_table">
  <TR>
<?php
  if ($_SESSION["nivel"]=='3')
  {
?>
    <TD WIDTH="100%" background="images/bg2.gif">
    <ul id="navmenu">
    <li><a href="menu.php">INICIO</a></li>
    <li><a href="institucion.php">INSTITUCIONES</a></li>
    <li><a href="adminusuarios.php">USUARIO ADMINISTRADOR</a></li>
    <!-- <li><a href="#">CAMBIO DE GESTI&Oacute;N</a>
    <ul>
      <li><a href="crearbd.php">MIGRAR BASE DE DATOS</a></li>
     </ul> 
    </li>-->    
    <li><a href="salir.php">SALIR</a></li>
    </ul>
    </TD>
<?php
  }
  else
  {
?>
    <TD WIDTH="100%" background="images/bg2.gif">
    <ul id="navmenu">
    <li><a href="menu.php">INICIO</a></li>
    <li><a href="edificio.php">EDIFICIOS</a></li>
    <li><a href="departamento.php">DEPARTAMENTOS</a></li>
    <li><a href="cargos.php">CARGOS</a></li>
    <li><a href="adminusuarios.php">USUARIOS</a></li>
    <li><a href="#">ADMINISTRACION</a>
      <ul>
        <li><a href="tipo_documento.php">TIPO DE DOCUMENTO</a></li>
        <li><a href="instrucciones.php">INSTRUCCIONES</a></li>
        <li><a href="config.php">LOGO INSTITUCIONAL</a></li>
        <li><a href="usuarioderivacion.php">DERIVACIONES</a></li>
      </ul>
    </li>
    <li><a href="#">ADM. ARCHIVOS</a>
      <ul>
        <li><a href="archivo.php">CREAR ARCHIVOS</a></li>
        <li><a href="asignar.php">ASIGNAR USUARIO</a></li>
        <li><a href="asignar2.php">ASIGNAR TIPO DOC</a></li>
      </ul>
    </li> 
    <li><a href="salir.php">SALIR</a></li>
      </ul>
    </TD>
<?php
  }
?>
  </TR>
  </table>
</body>
</HTML>