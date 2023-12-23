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

    $menu[0]["id"] = "";
    $menu[0]["url"] = "configuracion";
    $menu[0]["name"] = "Configuración";
    $menu[0]["icon"] = "nav-icon fa fa-cog";

    $menu[0]["menu"] = [];
    
    $menu[0]["menu"][0]["id"] = "ConfigurationMenuController";
    $menu[0]["menu"][0]["url"] = "menu";
    $menu[0]["menu"][0]["name"] = "Menú";
    $menu[0]["menu"][0]["icon"] = "far fa-circle nav-icon";

    $menudb = file_get_contents(URL_ROOT."db/menustore.json");
    $menuStore = json_decode($menudb, true)??[];

    $menu = array_merge($menu, $menuStore);
    
    foreach($menu as $key=>$item)
    {
        $template.=menu_item($item, $currentPage);
    }

    return $template;
}
function menu_item($array = [], $currentPage){

    $_id = $array["id"] ?? '';
    $_url = $array["url"] ?? '#';
    $_name = $array["name"] ?? '';
    $_icon = $array["icon"] ?? 'nav-icon fas fa-chart-pie';
    $_menu = $array["menu"] ?? [];
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