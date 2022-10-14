<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Seguimiento de Correspondencia y Tramites</title>
<meta http-equiv="Content-Type" content="text/html; charset=latin-1" />
<link rel="stylesheet" type="text/css" href="script/estilos2.css">
<link rel="stylesheet" type="text/css" href="script/acerca.css">
<link rel="stylesheet" type="text/css" href="script/styles.css">
<script language="JavaScript" src="script/ie.js" type="text/JavaScript"></script>
<script language='javascript' src="popcalendar.js"></script> 
<script language='javascript' src="busquedas.js"></script> 
</head>
<body class="caja_texto">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
</tr>
<tr>
	<td height="51" colspan="3" bgcolor="#FFFFFF" align="right">
		<B style="font:Verdana, Arial, Helvetica, sans-serif; color:#1e5a8c; font-size:24px"> SISTEMA DE CORRESPONDENCIA</B>
		<br>
		<B style="font:Verdana, Arial, Helvetica, sans-serif; color:#1e5a8c; font-size:16px">del Funcionario P&uacute;blico</B>
		
	</td>
</tr>
</tbody>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr class="border_tr">
<td align="left" width="100%" background="images/sera.gif">
<span class="parrafo_izquierda">
<?php
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
        $mes = array(" ","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
        echo $dias[date('w')].", ".date("d")." de ".$mes[date('n')]." de ".date("Y");
?>
&nbsp;
</span>
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
<TD WIDTH="100%" background="images/bg2.gif">
<!-- INICIA MENU -->
<?php
if (empty($_SESSION["cargo"]))
{
?>
<!--vacio -->
<?php    
}
else
{
  if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria"))
  { 
  ?>
  <ul id="navmenu">
  <li><a href="#">CORRESPONDENCIA</a>
    <ul>
      <li><a href="principal.php">BANDEJA PRINCIPAL</a></li>
      <li><a href="ingreso_recepcion.php">REGISTRO Y CLASIFICACION</a></li>
      <li><a href="ingreso_despacho.php">DESPACHO</a></li>
      <li><a href="recepcion_lista.php">RECEPCI&Oacute;N</a></li>
      <li><a href="regularizaciones_lista.php">REGULARIZACIONES</a></li>
      <li><a href="seguimiento.php">SEGUIMIENTO</a></li>
      <li><a href="listado_libro.php">LIBRO DE REGISTRO</a></li>
      <li><a href="reportes.php">REPORTES</a></li>
    </ul>
  </li>
  

  
  <li><a href="#">MANEJO DE ARCHIVOS</a>
  <ul>
    <li><a href="encuentra2.php">GENERADOS</a></li>
   <!--<li><a href="principal_archivo.php">BANDEJA PRINCIPAL</a></li> --> 
    <li><a href="notas_recibidas.php">RECIBIDOS</a></li>
    <li><a href="notas_verificacion.php">VISTO BUENO</a></li>
    <li><a href="listado_gral.php">LISTADO GENERAL</a></li>        
    <li><a href="seguimiento1.php">BUSCAR ARCHIVO</a></li>  
   
  </ul>
  </li>
  
    <li><a href="#">DESPACHO EXTERNO</a>
    <ul>
    <li><a href="bandeja_externa.php">BANDEJA SALIENTES</a></li>    
    <li><a href="seguimiento2.php">BUSQUEDA PERSONALIZADA</a></li>
    <li><a href="busqueda.php">BUSCAR ARCHIVO</a></li>    
   
  </ul>
  </li>
  
    <li><a href="#">CARPERTAS VIRTUALES</a>
    <ul>
    <li><a href="virtuales_adm.php">CARPERTAS CREADAS</a></li>    
    <li><a href="listadocarpetas.php">LISTADO CARPETAS</a></li>    
   
  </ul>
  </li>  
  
  <li><a href="menu.php">INICIO</a></li>

  <li><a href="../salir.php">CERRAR</a></li>
 </ul>
<?php    
 }
 else
 {
?>
  <ul id="navmenu">
  <li><a href="#">CORRESPONDENCIA </a>
    <ul>
  <li><a href="principal.php">BANDEJA PRINCIPAL</a></li>
  <li><a href="recepcion_lista.php">RECEPCION</a></li>
  <li><a href="seguimiento.php">SEGUIMIENTO</a></li>
  <li><a href="listado_libro.php">LIBRO DE REGISTRO</a></li>
  <li><a href="reportes.php">REPORTES</a></li>
    </ul>
  </li>
  
    
  <li><a href="#">MANEJO DE ARCHIVOS</a>
    <ul>
    <li><a href="encuentra2.php">GENERADOS</a></li>
    <li><a href="notas_recibidas.php">RECIBIDOS</a></li>
    <li><a href="notas_verificacion.php">VISTO BUENO</a></li>
    <li><a href="listado_gral.php">LISTADO GENERAL</a></li>         
    <li><a href="seguimiento1.php">BUSCAR ARCHIVO</a></li>        
    </ul>
  </li>
  
    <li><a href="#">CARPERTAS VIRTUALES</a>
    <ul>
    <li><a href="listadocarpetas.php">LISTADO CARPETAS</a></li>    
  </ul>
  </li>   
  
 
  <li><a href="menu.php">INICIO</a></li>
  <li><a href="../salir.php">CERRAR</a></li>
</ul>
<?php
}
}
?>

</TD>
</tr>
<tr>
<TD WIDTH="100%" VALIGN="TOP">
