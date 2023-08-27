<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Services\SesionService;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;


$router = new RouteCollector();

$router->filter("logueado", ["App\Middlewares\Authentication", "auth"]);

$router->filter("no-logueado", ["App\Middlewares\Authentication", "noauth"]);

// vistas privadas
$router
    ->group(["before" => "logueado"], function ($enrutadorVistasPrivadas) {
        $enrutadorVistasPrivadas
            ->get("/", ["App\Controllers\HomeController", "index"])
            ->get("/listas", ["App\Controllers\ListasController", "index"])
            ->get("/logout", ["App\Controllers\LoginController", "logout"]);            
    });

// vistas publicas
$router
    ->group(["before" => "no-logueado"], function ($enrutadorVistasPublicas) {
        $enrutadorVistasPublicas
        ->get("/login", ["App\Controllers\LoginController", "index"])
        ->post("/login", ["App\Controllers\LoginController", "login"]);
        
    });


$despachador = new Dispatcher($router->getData());
$rutaCompleta = $_SERVER["REQUEST_URI"];
$metodo = $_SERVER['REQUEST_METHOD'];
$rutaLimpia = processInput($rutaCompleta);

try {
    echo $despachador->dispatch($metodo, $rutaLimpia); # Mandar sólo el método y la ruta limpia
} catch (HttpRouteNotFoundException $e) {
    return redirect();
} catch (HttpMethodNotAllowedException $e) {
    echo "Error: Ruta encontrada pero método no permitido";
}

function processInput($uri)
{
    return $uri;
}
?>