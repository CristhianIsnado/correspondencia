<?php
function Conectarse(){
        if(!($link=mysqli_connect("localhost", "root", "","bd_correspondencia")))
        {
        echo "Error Conectando a la Base de Datos";
        exit(); 
        }
        if(!mysqli_select_db($link, "bd_correspondencia"))
        { echo "Error Selecionando BD";
          exit();         
        }
        return $link;
}
?>
