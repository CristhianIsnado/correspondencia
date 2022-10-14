<?php
function FechaInv($fecha){
  //se cambio todos los slit por explode
  list($a,$b,$c)=explode("-",$fecha); 
  $fecha = "$c-$b-$a";
  return $fecha;
}

function FechaHora($fhora){
  //se cambio todos los slit por explode
  list($fecha,$hora)=explode(" ",$fhora);
  $fechad=FechaInv($fecha)." ".$hora;
  return $fechad;
}

function FechaHoy(){
  $fechahoy = strftime("%Y")."-". strftime("%m")."-".strftime("%d");
  return $fechahoy;
}

function HoraActual(){
    $horaactual = strftime("%H").":". date("i").":".date("s");  
	return $horaactual;
}

function Val_fechas($fecha){
  //se cambio todos los ereg por preg_match
  if (preg_match ('([0-9]{4})-([0-9]{1,2})-([0-3]{1})([0-9]{1})', $fecha)) {
    //se cambio todos los slit por explode
    list($anio,$mes,$dia) = explode("-",$fecha);
    if (checkdate($mes,$dia,$anio)) {
       return 0;
    } else {
      return 1;
    }
  } else { return 1; }
}

function Val_numeros($numero){
if (preg_match("/^[0-9]+$/", $numero)) {
     return 0;
  } else {
     return 1;
  }
}

function sinespacios($nombre)
{
if (!preg_match("/^[a-zA-Z]+$/",$nombre))
 {
return 0;
 }
else
 {
 return 1;
 }
}

function solocadenas($nombre)
{
if (preg_match("/^[a-zA-Z]+$/",$nombre))
{
  return 0;
}
else
{
  return 1;
}
}

function alfanumerico($nombre)
{
   if (!preg_match('/^[a-zA-Z0-9 \/\-]+$/',$nombre))
   {
     return 0;
   }
   else
   {
     return 1;
   }
}

function val_alfanum($nombre)
{
    if(!preg_match('/^[a-zA-Z0-9 �����A������\.,]+$/',$nombre))
    {
      return 0;
    }
    else
    {
      return 1;
    }
}

function Validacion($campo,$mensaje){
  if (empty($campo)) {
      include("inicio.php");
      echo "<br><br><center><p>";
      echo $mensaje;
      echo "<br><br><a href=\"javascript:history.back(-1)\">Retornar</a>";
	  echo "</p></center>";
      include("final.php");
	  exit();
  }
}

function Alert($campo)
{
 if ($campo == 1) {
   echo "<img src=\"images/eliminar.gif\" border=0 align=center/>";
 }
}


function MesLiteral($fecha){
  //se cambio todos los slit por explode
   list( $anio, $mes, $dia ) = explode("-",$fecha ); 
   $numero = mktime(0,0,0,$mes,$dia,$anio);
   // $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
	$mes = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha_literal = date("d",$numero)." de ".$mes[date('n',$numero)]." de ".date("Y",$numero);
	return $fecha_literal;
}


function leef ($fichero) { 
    $texto = file($fichero); 
    $tamleef = sizeof($texto); 
    for ($n=0;$n<$tamleef;$n++) {$todo= $todo.$texto[$n];} 
    return $todo; 
} 

function cifrar($datos_enviados)
{
   $valor_encryptado = $datos_enviados;
    for($i=1;$i<10;$i++)
    {
        $valor_encryptado = base64_encode($valor_encryptado);
    }

     return $valor_encryptado;
}

function descifrar($datos_enviados)
{
    $valor_encryptado = $datos_enviados;
    for($i=1;$i<10;$i++)
    {
        $valor_encryptado = base64_decode($valor_encryptado);
    }
    return $valor_encryptado;
}
?>