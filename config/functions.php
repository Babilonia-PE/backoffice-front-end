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
    exit;
}

function dd($string)
{
    echo "<pre>";
        var_dump($string);
    echo "</pre>";
    exit;
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

function menu(){
        
    $menu = [];

    $menu[0]["id"] = "alertas";
    $menu[0]["url"] = "alertas";
    $menu[0]["name"] = "Alertas";
    $menu[0]["icon"] = "nav-icon fas fa-chart-pie";

    $menu[1]["id"] = "avisos";
    $menu[1]["url"] = "avisos";
    $menu[1]["name"] = "Avisos";
    $menu[1]["icon"] = "nav-icon fas fa-chart-pie";

    $menu[2]["id"] = "clientes";
    $menu[2]["url"] = "clientes";
    $menu[2]["name"] = "Clientes";
    $menu[2]["icon"] = "nav-icon fas fa-users";

    $menu[3]["id"] = "leads";
    $menu[3]["url"] = "leads";
    $menu[3]["name"] = "Leads";
    $menu[3]["icon"] = "nav-icon fas fa-chart-pie";

    
    $menu[4]["id"] = "views";
    $menu[4]["url"] = "vistas";
    $menu[4]["name"] = "Views";
    $menu[4]["icon"] = "nav-icon fas fa-chart-pie";
    
    $menu[5]["id"] = "paquetes";
    $menu[5]["url"] = "paquetes";
    $menu[5]["name"] = "Paquetes";
    $menu[5]["icon"] = "nav-icon fas fa-chart-pie";
    
    $menu[6]["id"] = "reportes";
    $menu[6]["url"] = "reportes";
    $menu[6]["name"] = "Reportes";
    $menu[6]["icon"] = "nav-icon fas fa-chart-pie";

    $id = identifyCurrentPage($menu);

    foreach($menu as $key=>$item)
    {
        $_id = $item["id"]??'';
        
        $menu[$key]["active"] = ($_id == $id) ? true : false;
    }

    return $menu;
}
?>