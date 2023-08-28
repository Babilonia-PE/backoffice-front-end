<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Services\SesionService;
use App\Services\Helpers;
use Phroute\Phroute\Dispatcher;
use App\Controllers\HomeController;
use App\Middlewares\Authentication;
use Phroute\Phroute\RouteCollector;

use App\Controllers\LeadsController;
use App\Controllers\LoginController;
use App\Controllers\ViewsController;
use App\Controllers\AvisosController;
use App\Controllers\ListasController;
use App\Controllers\AlertasController;
use App\Controllers\ClientesController;
use App\Controllers\PaquetesController;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

$router = new RouteCollector();

$router->filter("logueado", [Authentication::class, "auth"]);

$router->filter("no-logueado", [Authentication::class, "noauth"]);

// vistas privadas
$router
    ->group(["before" => "logueado"], function ($enrutadorVistasPrivadas) {
        $enrutadorVistasPrivadas
            ->get("/", [HomeController::class, "index"])
            ->get("/logout", [LoginController::class, "logout"])
            
            ->get("/alertas", [AlertasController::class, "index"])
            ->get("/avisos", [AvisosController::class, "index"])
            ->get("/clientes", [ClientesController::class, "index"])
            ->get("/leads", [LeadsController::class, "index"])
            ->get("/paquetes", [PaquetesController::class, "index"])
            ->get("/vistas", [ViewsController::class, "index"]);      
            
            
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