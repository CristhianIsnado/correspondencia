<?php 
include("conecta.php");
$conn = Conectarse();
$usuario= mysqli_real_escape_string($conn, $_POST['username']);
$password= mysqli_real_escape_string($conn, $_POST['clave']);
session_start();

$consulta = "SELECT * FROM usuario WHERE usuario_username='$usuario' AND usuario_active='1'";
$ssql =mysqli_query($conn, $consulta);
$nr = mysqli_num_rows($ssql);
	
if (mysqli_num_rows($ssql) == 1)
{ 
	if ($row = mysqli_fetch_array($ssql)) 
  	{
    	//if ($row["usuario_password"]== md5($password))
		if (($row["usuario_password"]== md5($password) ))
     	{ 
			$_SESSION["autentificado"]="SI";
			$_SESSION["username"]= $row["usuario_username"];
			$_SESSION["codigo"]=$row["usuario_cod_usr"];
			$_SESSION["institucion"]=$row["usuario_cod_institucion"];
			$_SESSION["password"]=$row["usuario_password"];	
			$_SESSION["nivel"]=$row["usuario_cod_nivel"];
			$_SESSION["departamento"]=$row["usuario_cod_departamento"];		
			$_SESSION["cargo"]=$row["usuario_cargo"];
			$_SESSION["cargo_asignado"]=$row["usuario_ocupacion"];//PARA CARGO	
			$_SESSION["nivel_usr"]= $row["usuario_nivel_usuario"];
			unset($_SESSION['tmptxt']);

			function get_client_ip() {
				$ipaddress = '';
				if (getenv('HTTP_CLIENT_IP'))
					$ipaddress = getenv('HTTP_CLIENT_IP');
				else if(getenv('HTTP_X_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
				else if(getenv('HTTP_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_FORWARDED_FOR');
				else if(getenv('HTTP_FORWARDED'))
				   $ipaddress = getenv('HTTP_FORWARDED');
				else if(getenv('REMOTE_ADDR'))
					$ipaddress = getenv('REMOTE_ADDR');
				else
					$ipaddress = 'UNKNOWN';
				return $ipaddress;
			}

			$login_cod_usr = $row["usuario_cod_usr"];
			$fecha_ingreso = date("Y-m-d");
			$hora_ingreso = date("H:i:s");
			$ip_usuario = get_client_ip();
			if ($row["usuario_cod_nivel"]== 3) 
           	{
				$_SESSION["adminvirtual"]="adminvirtual";
				mysqli_query($conn, "insert into login(login_cod_usr,login_fecha_ingreso,login_hora_ingreso,login_ip_computer)
				values ('$login_cod_usr','$fecha_ingreso','$hora_ingreso','$ip_usuario')");
				$_SESSION["login_id"] = mysqli_insert_id($conn);
?>
				<script language='JavaScript'> 
					window.self.location="menu.php"
				</script>
				<?php
				exit;
			}
			else if ($row["usuario_cod_nivel"]== 2)
			{
				$_SESSION["adminvirtual"]="adminlocal";
				mysqli_query($conn, "insert into login(login_cod_usr,login_fecha_ingreso,login_hora_ingreso,login_ip_computer)
				values ('$login_cod_usr','$fecha_ingreso','$hora_ingreso','$ip_usuario')");
				$_SESSION["login_id"] = mysqli_insert_id($conn);
				?>
				<script language='JavaScript'> 
					window.self.location="menu.php"
				</script>
				<?php
				exit;
			}
			else
			{
				$login_ocupacion = $row["usuario_ocupacion"];
				$login_cod_departamento = $row["usuario_cod_departamento"];
				$login_cod_institucion = $row["usuario_cod_institucion"];				
				mysqli_query($conn, "insert into login(login_cod_usr,login_fecha_ingreso,login_hora_ingreso,login_ip_computer,login_ocupacion,login_cod_departamento,login_cod_institucion)
				values ('$login_cod_usr','$fecha_ingreso','$hora_ingreso','$ip_usuario','$login_ocupacion','$login_cod_departamento','$login_cod_institucion')");
				$_SESSION["login_id"] = mysqli_insert_id($conn);
				?>
				<script language='JavaScript'>
					window.self.location="sicor/menu.php"
				</script>
				<?php
				exit;
			}
			echo	"<script> alert('Usuario logueado.');window.location= 'inicio.php' </script>";
		} 
		else
		{ //contraseña incorrecta
			header("Location:index.php?errorusuario=1");	
		} //fin if else 2   
	} 
	else 
	{
	//si no existe le mando otra vez a la portada
		header("Location:index.php?errorusuario=2");
	}//fin de num rows*/
} 
else
{	/*usuario incorrecto o usuario dado de baja*/
	header("Location:index.php?errorusuario=3");
}
				?>
