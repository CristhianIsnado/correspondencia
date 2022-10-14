<?php
function formato_imagen($formato){
  switch($formato){
	case "zip":
		echo "<img border=\"0\" src=\"graficos/zip.gif\">";
		break;

	case "rar":
		echo "<img border=\"0\" src=\"graficos/rar.gif\">";
		break;
	
	case "doc":
		echo "<img border=\"0\" src=\"graficos/doc.gif\">";
		break;
	
	case "html":
		echo "<img border=\"0\" src=\"graficos/html.gif\">";
		break;

	case "htm":
		echo "<img border=\"0\" src=\"graficos/html.gif\">";
		break;
    
	case "pdf":
		return("<img border=\"0\" src=\"graficos/pdf.gif\">");
		break;
	case "gz":
		return("<img border=\"0\" src=\"graficos/pdf.gif\">");
		break;
	default:
		echo "<img border=\"0\" src=\"graficos/default.gif\">";
		break;	
  } // end switch
}

function FechaInv($cadena){
$fecha_tem="";
$tok = strtok ($cadena,"-");
$fecha_tem =  $tok .$fecha_tem ;
$tok = strtok ("-");
$fecha_tem =  $tok . "-" .$fecha_tem ;
$tok = strtok ("-");
$fecha_tem =  $tok ."-". $fecha_tem ;
return ($fecha_tem);
}

function Bloquea($recurso){
	while(!@mkdir($recurso,0700));
}

function Desbloquea($recurso){
	rmdir($recurso);
}

function Acentos($archivo){
$nuevo_archivo="";
$temporal = $archivo;
$tamano = strlen($archivo);
for ($j=0; $j < $tamano; $j++){
$caracter = substr($temporal,0,1);
  switch (ord($caracter)) {
    case 225:
	$caracter = "a";
    break;
	case 233:
	$caracter = "e";
    break;
	case 237:
	$caracter = "i";
    break;
    case 243:
	$caracter = "o";
    break;
	case 250:
	$caracter = "u";
    break;
	case 252:
	$caracter = "u";
    break;
	case 241:
	$caracter = "n";
    break;

    case 193:
	$caracter = "A";
    break;
	case 201:
	$caracter = "E";
    break;
	case 205:
	$caracter = "I";
    break;
    case 211:
	$caracter = "O";
    break;
	case 218:
	$caracter = "U";
    break;
	case 220:
	$caracter = "U";
    break;
	case 209:
	$caracter = "N";
    break;
    default:
    break;
 }

$tamano22 = strlen($temporal);
$temporal = substr($temporal,1,($tamano22-1));
$nuevo_archivo = $nuevo_archivo.$caracter;
}
return $nuevo_archivo;
}

?>

