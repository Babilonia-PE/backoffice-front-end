<?php
namespace App\Middlewares;

use App\Services\SesionService;
use App\Controllers\HelpersController;

class Authentication{

    function __construct(){
        $this->session_usuario = SesionService::leer("correoUsuario");
        $this->approved = $this->session_usuario["approved"]??false;
        $this->verifyAccountrFind = str_contains($_SERVER['REQUEST_URI'], "verify-account") ?? false;

        HelpersController::tracer();
    }
    public function auth(){        
        if ($this->verifyAccountrFind == false && ($this->approved==false || empty($this->session_usuario))) {
            SesionService::destruir();
            return redirect("login"); 
        }else if($this->verifyAccountrFind == true && empty($this->session_usuario)){
            return redirect("login");
        }
    }

    public function noauth(){
        if (!empty($this->session_usuario) && $this->approved==true && $this->verifyAccountrFind==false) {
            return redirect();
        }
    }
}
?>