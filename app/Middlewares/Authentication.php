<?php
namespace App\Middlewares;

use App\Services\Helpers;
use App\Services\SesionService;
use App\Controllers\AccountManager;


class Authentication{

    function __construct(){
        $this->session_usuario = SesionService::leer("correoUsuario");
        $this->approved = $this->session_usuario["approved"]??false;
        $this->verifyAccountrFind = Helpers::getConstainsRequestURI("verify-account");
        $this->updateAccountFind = Helpers::getConstainsRequestURI("update-account-2fa");
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->keyAuth2Store = AccountManager::verifySecondAuthSaved();

        Helpers::tracer();

    }
    public function auth(){                
        if(empty($this->session_usuario) && $this->keyAuth2Store==""){
            SesionService::destruir();
            return redirect("login");
        }
    }

    public function noauth(){
        if (!empty($this->session_usuario) && $this->approved==true && $this->verifyAccountrFind==false) {
            return redirect();
        }
    }

    public function verified(){
        if((!$this->approved && !empty($this->session_usuario)) || $this->keyAuth2Store==""){
            return redirect("update-account-2fa");
        }
    }

    public function VerifiedSaved(){        
        if($this->keyAuth2Store!=""){
            return redirect("verify-account");
        }
    }

    public function VerifiedNoSaved(){
        if(empty($this->session_usuario)){
            return redirect("login");
        }
        else if($this->keyAuth2Store==""){
            return redirect("update-account-2fa");
        }else if($this->keyAuth2Store!="" && $this->approved==true){
            return redirect();
        }
    }
}
?>