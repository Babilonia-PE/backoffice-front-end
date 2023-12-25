<?php
use App\Services\Blade;
use App\Services\Helpers;
use eftec\bladeone\BladeOne;
use App\Services\SesionService;

if (!file_exists(URL_LOGS)) {
    mkdir(URL_LOGS);
}

function redirect($ruta = "")
{
    header("Location: " . URL_WEB . $ruta);
    exit();
}

function dd($string)
{
    echo "<pre>";
        var_dump($string);
    echo "</pre>";
    exit();
}

function env($string = "")
{
    if($string == "") return "";

    return $_SERVER["$string"]??'';
}

function view($template = "", $parametros = []){
    $blade = new Blade();
    return $blade->createView($template, $parametros);
}

function secure_asset($ruta){
    return URL_WEB . "public/". $ruta;
}

function identifyCurrentPage($menu){
    
    $identify = "home";
    
    $request_uri = $_SERVER["REQUEST_URI"]??"";
    $request_uri = explode("/",$request_uri);
    if($request_uri[0]=="") unset($request_uri[0]);
    $request_uri = implode("/",$request_uri);
    
    foreach($menu as $item)
    { 
        $item_id = $item["id"]??0;
        $item_alias = $item["url"]??"";

        if($item_alias == $request_uri){
            $identify = $item_id;
        }
    }
    
    return trim($identify);
}

function auth($param = ""){
    
    $userSession = SesionService::leer("correoUsuario") ?? [];

    return $userSession[$param] ?? '';
}

function deteleFiltesAndDirectory($carpeta) {
    
    if (is_dir($carpeta) && file_exists($carpeta)) {
        // Obtener el contenido de la carpeta
        $archivos = glob($carpeta . '/*');
        
        // Eliminar todos los archivos dentro de la carpeta
        foreach ($archivos as $archivo) {
            if (is_file($archivo)) {
                unlink($archivo);
            }
        }
        
        // Eliminar la carpeta vacía
        rmdir($carpeta);        
    }
}

function menu($currentPage){
        
    $menu = [];
    $template = "";
    /*
    $menu[0]["controller"] = "";
    $menu[0]["url"] = "configuracion";
    $menu[0]["label"] = "Configuración";
    $menu[0]["icon"] = "nav-icon fa fa-cog";

    $menu[0]["children"] = [];
    
    $menu[0]["children"][0]["controller"] = "ConfigurationMenuController";
    $menu[0]["children"][0]["url"] = "menu";
    $menu[0]["children"][0]["label"] = "Menú";
    $menu[0]["children"][0]["icon"] = "far fa-circle nav-icon";
    */
    if(file_exists(URL_ROOT."db/menustore.json")){
        $menudb = file_get_contents(URL_ROOT."db/menustore.json");
    }else{
        $menudb = "[]";
    }
    $menuStore = json_decode($menudb, true)??[];

    $menu = array_merge($menu, $menuStore);
    
    foreach($menu as $key=>$item)
    {
        $template.=menu_item($item, $currentPage);
    }

    return $template;
}
function menu_drag_sort(){
        
    $menu = [];
    $template = "";
    /*
    $menu[0]["controller"] = "";
    $menu[0]["url"] = "configuracion";
    $menu[0]["label"] = "Configuración";
    $menu[0]["icon"] = "nav-icon fa fa-cog";

    $menu[0]["children"] = [];
    
    $menu[0]["children"][0]["controller"] = "ConfigurationMenuController";
    $menu[0]["children"][0]["url"] = "menu";
    $menu[0]["children"][0]["label"] = "Menú";
    $menu[0]["children"][0]["icon"] = "far fa-circle nav-icon";
    */
    if(file_exists(URL_ROOT."db/menustore.json")){
        $menudb = file_get_contents(URL_ROOT."db/menustore.json");
    }else{
        $menudb = "[]";
    }
    $menuStore = json_decode($menudb, true)??[];

    $menu = array_merge($menu, $menuStore);
    
    foreach($menu as $key=>$item)
    {
        $template.= "<div class='dd' id='nestable'>";
            $template.= "<ol class='dd-list'>";
                $template.=menu_item_drag_sort($key, $item);
            $template.= "</ol>";
        $template.= "</div>";
    }

    return $template;
}
function menu_item_drag_sort($key = 0, $array = []){

    $_controller = $array["controller"] ?? '';
    $_url = $array["url"] ?? '#';
    $_name = $array["label"] ?? '';
    $_icon = $array["icon"] ?? 'nav-icon fas fa-chart-pie';
    $_menu = $array["children"] ?? [];
    $_disabled = ($_controller == "ConfigurationMenuController" || $_controller == "ConfigurationController") ? true : false;

    $template = "<li class='dd-item dd3-item' data-id='$key' data-label='$_name' data-url='$_url' data-controller='$_controller' data-icon='$_icon' style='". ($_disabled ? "pointer-events: none;":"")."'>
                    <div class='dd-handle dd3-handle'>Drag</div>
                    <div class='dd3-content'>
                        <span>$_name</span>
                        <div class='item-edit'>Edit</div>
                    </div>

                    <div class='item-settings d-none'>
                        <p><label for=''>Navigation Label<br><input type='text' name='navigation_label' value='$_name'></label></p>
                        <p><label for=''>Navigation Url<br><input type='text' name='navigation_url' value='$_url'></label></p>
                        <p><label for=''>Navigation Controller<br><input type='text' name='navigation_controller' value='$_controller'></label></p>
                        <p><label for=''>Navigation Icono<br><input type='text' name='navigation_icon' value='$_icon'></label></p>
                        <p><a class='item-delete' href='javascript:;'>Remove</a> |
                        <a class='item-close' href='javascript:;'>Close</a></p>
                    </div>

                    ";
                    if(count($_menu)>0)
                    {
                        $template.="<ol class='dd-list'>";
                        foreach($_menu as $k => $item)
                        {
                            $template.=menu_item_drag_sort($k, $item);
                        }
                        $template.="</ol>";
                    }
    $template.="</li>";

    return $template;
}
function menu_item($array = [], $currentPage = ""){

    $_id = $array["controller"] ?? '';
    $_url = $array["url"] ?? '#';
    $_name = $array["label"] ?? '';
    $_icon = $array["icon"] ?? 'nav-icon fas fa-chart-pie';
    $_menu = $array["children"] ?? [];
    $_active = ($_id ==  $currentPage) ? 'active':'';

    $template = "<li class='nav-item'>
                    <a href='$_url' class='nav-link $_active'>
                        <i class='$_icon'></i>
                        <p>$_name";
                        $template .= (count($_menu)>0) ? '<i class="fas fa-angle-left right"></i>' : '';
                        $template.="</p>
                    </a>";
                    if(count($_menu)>0)
                    {
                        $template.="<ul class='nav nav-treeview'>";
                        foreach($_menu as $item)
                        {
                            $template.=menu_item($item, $currentPage);
                        }
                        $template.="</ul>";
                    }
    $template.="</li>";

    return $template;
}
function get_current_view(){
    $key = array_search(__FUNCTION__, array_column(debug_backtrace(), 'function'));
    $controller = debug_backtrace()[2]["file"] ?? '';
    $array = explode('/', $controller);
    $file_name = $array[count($array) - 1] ?? '';
    $file_name_without_ext = preg_replace('/\.\w+$/', '', $file_name);    
    return $file_name_without_ext;
}
?>