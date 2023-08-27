<?php
namespace App\Middlewares;

use App\Services\SesionService;

class Authentication{

    public function auth(){
        if (empty(SesionService::leer("correoUsuario"))) {
            return redirect("login");
        }
    }

    public function noauth(){
        if (!empty(SesionService::leer("correoUsuario"))) {
            return redirect();
        }
    }
    
}
?>