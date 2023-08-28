<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Services\SesionService;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

use App\Middlewares\Authentication;
use App\Controllers\HomeController;
use App\Controllers\ListasController;
use App\Controllers\LoginController;

$router = new RouteCollector();

$router->filter("logueado", [Authentication::class, "auth"]);

$router->filter("no-logueado", [Authentication::class, "noauth"]);

// vistas privadas
$router
    ->group(["before" => "logueado"], function ($enrutadorVistasPrivadas) {
        $enrutadorVistasPrivadas
            ->get("/", [HomeController::class, "index"])
            ->get("/listas", [ListasController::class, "index"])
            ->get("/logout", [LoginController::class, "logout"]);            
    });

// vistas publicas
$router
    ->group(["before" => "no-logueado"], function ($enrutadorVistasPublicas) {
        $enrutadorVistasPublicas
        ->get("/login", [LoginController::class, "index"])
        ->post("/login", [LoginController::class, "login"]);
        
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