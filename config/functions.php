<?php
use eftec\bladeone\BladeOne;

$dotenv = Dotenv\Dotenv::createImmutable(URL_ROOT);
$dotenv->load();

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
    
    if($template == "") return "";

    $blade = new BladeOne(URL_VIEWS, URL_CACHE,BladeOne::MODE_DEBUG);
    
    return $blade->run($template, $parametros);   
}

function secure_asset($ruta){
    return URL_WEB . "public/". $ruta;
}
?>