<?php
namespace App\Middlewares;

use App\Services\SesionService;
use App\Controllers\HelpersController;

class Authentication{

    function __construct(){
        $this->session_usuario = SesionService::leer("correoUsuario");
        $this->approved = $this->session_usuario["approved"]??false;
        $this->verifyAccountrFind = HelpersController::getConstainsRequestURI("verify-account");
        $this->updateAccountFind = HelpersController::getConstainsRequestURI("update-account-2fa");
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        HelpersController::tracer();
    }
    public function auth(){        
        
        if($this->method=="GET" && $this->updateAccountFind==true && $this->approved==true && !empty($this->session_usuario) ){
            redirect();
            return false;
        }

        if (!$this->verifyAccountrFind && 
            !$this->updateAccountFind &&
            (!$this->approved || empty($this->session_usuario))) {
            SesionService::destruir();
            return redirect("login"); 
        }else if(!$this->verifyAccountrFind && empty($this->session_usuario)){
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