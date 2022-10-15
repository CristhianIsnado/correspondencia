<?php
include("../filtro.php");
include("inicio.php");
include("cifrar.php");
?>

<script language="JavaScript">

function CopiaValor(objeto)
{
	document.ingreso.selecciona_tipo.value = objeto.value;
}

function Elegir()
{
   if(document.enviar.correspondencia_tipo.value == "Regularizacion")
     {
            miFechaActual = new Date();
            dia = miFechaActual.getDate();
              if(dia < 9)
               {
                   dia = "0" + dia;
               }
            mes = parseInt(miFechaActual.getMonth()) + 1;
             if(mes < 9)
               {
                   mes = "0" + mes;
               }
            ano = miFechaActual.getFullYear();
            fecha_actual = ano + "-" + mes + "-" + dia;

             if(document.enviar.fecha_regularizacion.value < fecha_actual && document.enviar.fecha_regularizacion.value != "")
               {
                  if (document.enviar.tipo[0].checked)
                     {
                        document.enviar.action = "ingreso_adicionar.php";
                        document.enviar.submit();
                     }
                else
                    {
                        document.enviar.action = "ingreso_adicionar_e.php";
                        document.enviar.submit();
                    }
               }
               else
               {
                   alert("Elija una fecha para la REGULARIZACION");
               }
     }
     else
     {
         if (document.enviar.tipo[0].checked)
                     {
                        document.enviar.action="ingreso_adicionar.php";
                        document.enviar.submit();
                     }
                else
                    {
                        document.enviar.action="ingreso_adicionar_e.php";
                        document.enviar.submit();
                    }
     }
}

function Retornar()
{
	document.enviar.action="ingreso_recepcion.php";
	document.enviar.submit();
}

</script>
<br />
<p class="fuente_titulo">
<center><b>Ingreso de correspondencia</b></center>
</p>
<br />
<CENTER>
<form name="enviar" method="POST">
<table>
<tr class="truno">
<td align="center">
            <?php
            if($_POST['tipo'] == 'i')
            {
            ?>
                <INPUT type="RADIO" name="tipo" value="i"  checked />
                <b>CORRESPONDENCIA INTERNA</b>
                <INPUT type="RADIO" name="tipo" value="e"   />
                <b>CORRESPONDENCIA EXTERNA</b>
            <?php
            }
            else
            {
             ?>
                <INPUT type="RADIO" name="tipo" value="i"  />
                <b>CORRESPONDENCIA INTERNA</b>
                <INPUT type="RADIO" name="tipo" value="e" checked />
                <b>CORRESPONDENCIA EXTERNA</b>
            <?php
            }
            ?>

<br />
</tr>
<tr class="truno">
<td align="center">
    <b>CORRESPONDENCIA TIPO</b>
   <select name="correspondencia_tipo" onChange="this.form.submit()">
       <option value="Normal" <?php if($_POST['correspondencia_tipo'] == "Normal") { echo "selected";}?>>Normal</option>
       <option value="Regularizacion" <?php if($_POST['correspondencia_tipo'] == "Regularizacion") { echo "selected";}?>>Regularizacion</option>
   </select>
<br />
      <?php
      if($_POST['correspondencia_tipo'] == "Regularizacion")
      {
        echo "<b>FECHA DE REGULARIZACION: </b>";
        echo "<input type=\"text\" name=\"fecha_regularizacion\"  readonly=\"readonly\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_regularizacion'].">";
        echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
      }
       ?>
</tr>

<tr>
<td colspan="2" align="center">
    <input class="boton" type="submit" name="envia" value="Aceptar" onClick="Elegir();">
    <input type="submit" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton" />
</td>
</tr>
</table>
</form>
</CENTER>

<?php
include("final.php");
?>