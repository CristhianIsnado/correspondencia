<?php
include("filtro.php");
include("inicio.php");
include("conecta.php");
$codigo_aux_a=$_SESSION["codigo"];
$error=0;
if (isset($_POST['enviar']))
{
                $conn=Conectarse();
                $ssql = "SELECT * FROM usuario WHERE '$codigo_aux_a'=usuario_cod_usr";
                $rsdos = mysqli_query($conn, $ssql);
                if ($rowdos = mysqli_fetch_array($rsdos))
                        {
                            
                                if ( md5($_POST['actual']) != $rowdos["usuario_password"])
                                    {
                                            $error=1;
                                    }
                        }

                        if ($_POST['nueva'] != $_POST['renueva'] )
                        {
                                $error=2;
                        }

                        if ($error==0)
                                {

                                        mysqli_query($conn, "update usuario set usuario_password=md5('$_POST[nueva]') where '$codigo_aux_a'=usuario_cod_usr");
                                ?>
                                        <br><br>
                                        <div align="center"><span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #0C5386;; font-weight: bold">Cambio realizado Satisfactoriamente</span>
                                            </p>
  </div>
                                  <p align="center"><img src="sicor/images/pass.jpg" border="0" /><br /><br />
                                        <span style="font-weight: bold"><a href="menu.php">[Continuar..]</a>
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
                                    <div align="center"><br>
                <br>

                <b class="Estilo57"> Modificaci&oacute;n de Contrase&ntilde;a </b>
                <br>
                <br>
<?php
  if ($error==1)
  {
        echo "<center>Contrase&ntilde;a Actual No Valida</center><br>";
  }
  else
  {
        if ($error==2)
        {
                echo "<center>Contrase&ntilde;as Nuevas No Coinciden</center><br>";
        }
  }

?>
</div>
<form method="post">
<TABLE WIDTH="50%" BORDER="0" CELLSPACING="1" CELLPADDING="0" HEIGHT="10" ALIGN="center">
  <tr bgcolor="#EFEBE3">
    <td width="70%"><P class="parrafo_normal"><SPAN class="fuente_normal"><b>Contrase&ntilde;a Actual: </td>
    <td width="30%"><label>
      <input name="actual" type="password" id="actual">
      <input name="codigo_aux_a" type="hidden" value="<?php echo $codigo_aux_a?>">
    </label></td>
  </tr>
  <tr bgcolor="#EFEBE3">
    <td><P class="parrafo_normal"><SPAN class="fuente_normal"><b>Nueva Contrase&ntilde;a: </td>
    <td><input name="nueva" type="password" id="nueva"></td>
  </tr>
  <tr bgcolor="#EFEBE3">
    <td><P class="parrafo_normal"><SPAN class="fuente_normal"><b>Repetir Nueva Contrase&ntilde;a </td>
    <td><input name="renueva" type="password" id="renueva"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<br>
	<label>
      <input name="enviar" type="submit" class="boton" id="enviar" value="Enviar">
      <input name="cancelar" type="submit" class="boton" id="cancelar" value="Cancelar">
    </label></td>
    </tr>
</table>
</form>

<?php
include("final.php");
?>
