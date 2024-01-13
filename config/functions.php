<?php
use App\Services\Blade;
use App\Services\Helpers;
use eftec\bladeone\BladeOne;
use App\Services\SesionService;
use App\Middlewares\Permissions;
use App\Middlewares\Authentication;

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
function dump($string)
{
    echo "<pre>";
        var_dump($string);
    echo "</pre>";
}

function env($string = "", $default = "")
{
    if($string == "") return "";

    return $_SERVER["$string"]??$default;
}

function view($template = "", $parametros = []){
    $blade = new Blade();
    return $blade->createView($template, $parametros);
}

function secure_asset($ruta){
    return URL_WEB . "public/". $ruta;
}

function unsetArray($array = [], $n = 0, $condition = true){
    $num = 0;
    $data = $array;
    if(count($data) > 0){
        foreach($data as $k => $item){
            if($num == $n && $condition) unset($data[$k]);        
            $num++;
        }
    }
    return $data;
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

    $validateUser = Authentication::findUserByDNI();

    if(file_exists(URL_ROOT."db/menustore.json")){
        $menudb = file_get_contents(URL_ROOT."db/menustore.json");
    }else{
        $menudb = "[]";
    }
    $menuStore = json_decode($menudb, true)??[];

    $menu = array_merge($menu, $menuStore);
    
    foreach($menu as $key=>$item)
    {
        $_controller = $item["controller"] ?? '';

        if($_controller == "configuracion" && $validateUser){
            $template.=menu_item($item, $currentPage);
        }else if($_controller != "configuracion"){
            $template.=menu_item($item, $currentPage);
        }

    }

    return $template;
}
function menu_drag_sort(){
        
    $menu = [];
    $template = "";

    if(file_exists(URL_ROOT."db/menustore.json")){
        $menudb = file_get_contents(URL_ROOT."db/menustore.json");
    }else{
        $menudb = "[]";
    }
    $menuStore = json_decode($menudb, true)??[];

    $menu = array_merge($menu, $menuStore);

        $template.= "<div class='dd' id='nestable'>";
            $template.= "<ol class='dd-list'>";

                foreach($menu as $key=>$item)
                {
                    $template.=menu_item_drag_sort($key, $item);
                }

            $template.= "</ol>";
        $template.= "</div>";

    return $template;
}
function menu_item_drag_sort($key = 0, $array = []){

    $_id = $array["id"] ?? time();
    $_controller = $array["controller"] ?? '';
    $_url = $array["url"] ?? '#';
    $_name = $array["label"] ?? '';
    $_icon = $array["icon"] ?? 'nav-icon fas fa-chart-pie';
    $_state = $array["state"] ?? "off";
    $_menu = $array["children"] ?? [];
    $_disabled = false; #($_controller == "configuracion" || $_controller == "configuracion-menu") ? true : false;
    $_state_badge = ($_state == "on") ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-danger">Desactivado</span>';
    $template = "<li class='dd-item dd3-item' data-id='$_id' data-label='$_name' data-url='$_url' data-controller='$_controller' data-icon='$_icon' data-state='$_state' style='". ($_disabled ? "pointer-events: none;":"")."'>
                    <div class='dd-handle dd3-handle'>Drag</div>
                    <div class='dd3-content'>
                        <div class='d-inline w-auto'>
                            <span>$_name</span>
                            <div class='dd-state d-inline'>$_state_badge</div>
                        </div>
                        <div class='item-edit'>Edit</div>
                    </div>

                    <div class='item-settings d-none'>
                        <p><label for=''>Navigation Label<br><input type='text' name='navigation_label' value='$_name'></label></p>
                        <p><label for=''>Navigation Url<br><input type='text' name='navigation_url' value='$_url'></label></p>
                        <p><label for=''>Navigation ID<br><input type='text' name='navigation_controller' value='$_controller'></label></p>
                        <p><label for=''>Navigation Icono<br><input type='text' name='navigation_icon' value='$_icon'></label></p>
                        <p><label for=''>Navigation Estado<br>
                            <select name='navigation_state'>
                                <option value='on' ".($_state=="on"?'selected':'').">Visible</option>
                                <option value='off' ".($_state=="off"?'selected':'').">Invisble</option>
                            </select>	
                        </p>
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
    $_state = $array["state"] ?? "off";
    $_active = ($_id ==  $currentPage) ? 'active':'';

    $newPermission = new Permissions(false);
    $authPermission = $newPermission->authPermission("view", $_id, false);

    if($authPermission === false) return '';

    $template = "";
    if($_state == "on"){
    $template .= "<li class='nav-item'>
                    <a href='$_url' class='nav-link $_active'>
                        <i class='$_icon'></i>
                        <p>$_name";
                        $template .= (count($_menu)>0) ? '<i class="fas fa-angle-right right"></i>' : '';
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
    }
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