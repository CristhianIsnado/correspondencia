<?php

function encryto($cadena){
	$rar = mt_rand(0,10000000);
	$one = base64_encode($cadena."-".$rar);
	return($one);
}	


function descryto($cadena1){	
	$cadena2 = base64_decode($cadena1);
	$trees = explode("-", $cadena2);
	return ($trees[0]);
}

?>