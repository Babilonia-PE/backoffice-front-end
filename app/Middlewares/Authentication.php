<?php
namespace App\Middlewares;

use App\Services\SesionService;
use App\Controllers\AccountManager;
use App\Controllers\HelpersController;

class Authentication{

    function __construct(){
        $this->session_usuario = SesionService::leer("correoUsuario");
        $this->approved = $this->session_usuario["approved"]??false;
        $this->verifyAccountrFind = HelpersController::getConstainsRequestURI("verify-account");
        $this->updateAccountFind = HelpersController::getConstainsRequestURI("update-account-2fa");
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->keyAuth2Store = AccountManager::verifySecondAuthSaved();

        HelpersController::tracer();

    }
    public function auth(){        
        /*SI LA VISTA ES REGISTRO DE 2FA SOLO SE MANTENDRA EN ESTA VISTA*/
        /*
        if(!$this->updateAccountFind && $_SERVER['REQUEST_URI'] != "/logout" && $this->keyAuth2Store == ""){
            redirect("update-account-2fa");
            return false;
        }

        if($this->method=="GET" && $this->updateAccountFind==true && $this->approved==true && !empty($this->session_usuario) && $this->keyAuth2Store!="" ){
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
        */
        if(empty($this->session_usuario)){
            return redirect("login");
        }
    }

    public function noauth(){
        if (!empty($this->session_usuario) && $this->approved==true && $this->verifyAccountrFind==false) {
            return redirect();
        }
    }

    public function verified(){
        if(!$this->approved && !empty($this->session_usuario)){
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
        }
    }
}
?>