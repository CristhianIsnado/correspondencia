function cdd_menu40940(){//////////////////////////Start Menu Data/////////////////////////////////

//**** NavStudio, (c) 2004, OpenCube Inc.,  -  www.opencube.com ****
//Note: This data file may be manually customized outside of the visual interface.

    //Unique Menu Id
        this.uid = 40940
/**********************************************************************************************
                               Icon Images
**********************************************************************************************/

/**********************************************************************************************
                              Global - Menu Container Settings
**********************************************************************************************/
        this.menu_background_color = "transparent"
        this.menu_border_color = "#000000"
        this.menu_border_width = "0"
        this.menu_padding = "8,4,2,4"
        this.menu_border_style = "solid"
        this.divider_caps = false
        this.divider_width = 1
        this.divider_height = 0
        this.divider_background_color = "#F5F5F5"
        this.divider_border_style = "none"
        this.divider_border_width = 0
        this.divider_border_color = "#000000"
        this.menu_is_horizontal = false
        this.menu_width = "100"
        this.menu_xy = "-80,-2"

/**********************************************************************************************
                              Global - Menu Item Settings
**********************************************************************************************/
        this.menu_items_background_color_roll = "#EBEBEB"
        this.menu_items_text_color = "#225BA8"
        this.menu_items_text_decoration = "none"
        this.menu_items_font_family = "Arial"
        this.menu_items_font_size = "12px"
        this.menu_items_font_style = "normal"
        this.menu_items_font_weight = "normal"
        this.menu_items_text_align = "left"
        this.menu_items_padding = "3,5,2,5"
        this.menu_items_border_style = "solid"
        this.menu_items_border_color = "#DADADA"
        this.menu_items_border_width = "1"
        this.menu_items_width = 90
        this.menu_items_background_color = "#f1f1f5"
/**********************************************************************************************
                              Main Menu Settings
**********************************************************************************************/
        this.menu_items_background_color_main = "transparent"
        this.menu_items_background_color_roll_main = "transparent"
        this.menu_items_text_color_main = "#225BA8"
        this.menu_border_color_main = "#c9cacf"
        this.menu_border_width_main = "1"
        this.menu_padding_main = "0,0,0,0"
        this.menu_gradient_main = "progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr=#FFFFFF, endColorstr=#BBBBBB)"
        this.menu_items_gradient_roll_main = "progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr=#BBBBBB, endColorstr=#FFFFFF)"
        this.menu_is_horizontal_main = true

        this.item0 = "Edificios"
//        this.item3 = "  "
//        this.item3 = "Busqueda"
        this.item1 = "Departamentos"
        this.item2 = "Usuarios"
		this.item3 = "Administracion"
		this.item4 = "Pagina Principal"
        this.item5 = "Salir"
     	this.item6 = "Cargo"

                        
        this.item_width0 = 91
        this.item_width1 = 116
        this.item_width2 = 95
        this.item_width3 = 93
        this.item_width4 = 110
		this.item_width5 = 93

        this.url0 = "edificio.php"
        this.url1 = "departamento.php"
        this.url2 = "adminusuarios.php"
        this.url4 = "menu.php"
        this.url5 = "salir.php"
		this.url6 = "cargos.php"

//Sub Menu 02
        this.menu_xy1 = "-95,-8"
        this.menu_width1 = 154
//Sub Menu 3
        this.menu_xy3 = "-97,-8"
        this.menu_width3 = 130

        this.item3_0 = "Tipo de Documento"
        this.item3_1 = "Intrucciones"
        this.item3_2 = "Logo Institucional"
		this.item3_3 = "Derivaciones"

        this.url3_0 = "tipo_documento.php"
        this.url3_1 = "instrucciones.php"
        this.url3_2 = "config.php"
		this.url3_3 = "usuarioderivacion.php"

    //Sub Menu 6

}///////////////////////// END Menu Data /////////////////////////////////////////

//Document Level Settings

cdd__activate_onclick = false
cdd__showhide_delay = 250
cdd__url_target = "_self"
cdd__url_features = "resizable=1, scrollbars=1, titlebar=1, menubar=1, toolbar=1, location=1, status=1, directories=1, channelmode=0, fullscreen=0"
cdd__display_urls_in_status_bar = true
cdd__default_cursor = "hand"

//NavStudio Code (Warning: Do Not Alter!)
if (window.showHelp){
  b_type = "ie"; 
  if (!window.attachEvent) 
  b_type += "mac";
}
if (document.createElementNS) 
b_type = "dom";
if (navigator.userAgent.indexOf("afari")>-1) 
b_type = "safari";
if (window.opera) 
b_type = "opera"; 
qmap1 = "\<\script language=\"JavaScript\" vqptag='loader_sub' src=\""; 
qmap2 = ".js\">\<\/script\>";;
function iesf(){};;
function vqp_error(val){

}

if (b_type){
document.write(qmap1+cdd__codebase+"pbrowser_"+b_type+qmap2);
document.close();
}

