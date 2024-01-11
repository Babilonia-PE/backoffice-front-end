<?php
namespace App\Middlewares;

use App\Services\Helpers;
use App\Services\SesionService;
use App\Controllers\AccountManager;
use App\Controllers\ConfigurationUsersController;
use App\Controllers\ConfigurationPermissionsController;


class Authentication{

    function __construct(){
        $this->session_usuario = SesionService::leer("correoUsuario");
        $this->approved = $this->session_usuario["approved"]??false;
        $this->verifyAccountrFind = Helpers::getConstainsRequestURI("verify-account");
        $this->updateAccountFind = Helpers::getConstainsRequestURI("update-account-2fa");
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->keyAuth2Store = AccountManager::verifySecondAuthSaved();
        $this->authDisabled = $this->session_usuario["2fa-disabled"]??false;

        Helpers::tracer();

    }
    /*si se intenta acceder con usuario sin sesion*/
    public function auth(){                
        if(empty($this->session_usuario)){
            SesionService::destruir();
            return redirect("login");
        }
    }
    /*si esta verificado e intentas acceder a una ruta publica*/
    public function noauth(){
        if (!empty($this->session_usuario) && $this->approved==true && $this->verifyAccountrFind==false) {
            return redirect();
        }
    }
    /*si se intenta acceder a ruta protegida sin tener una keysecret guardada*/
    public function verified(){
        if((!$this->approved && !empty($this->session_usuario)) || 
           ($this->approved && $this->keyAuth2Store=="" && $this->authDisabled == false) ){
            return redirect("update-account-2fa");
        }
    }
    /*si se tiene una keysecret guardada*/
    public function VerifiedSaved(){        
        if($this->keyAuth2Store!="" && $this->authDisabled == false){
            return redirect("verify-account");
        }
    }
    /*
    1: si no existe sesion previa -> login
    2: si keysecret esta vacio con sesion approved (temporalmente) -> guardar secret key
    3: si keysecret no esta vacio y sesion approved es true -> home dashboard
    */
    public function VerifiedNoSaved(){
        if(empty($this->session_usuario)){
            return redirect("login");
        }
        else if($this->keyAuth2Store=="" && $this->approved==true){
            return redirect("update-account-2fa");
        }else if($this->keyAuth2Store!="" && $this->approved==true){
            return redirect();
        }
    }

    #verificar privilegios para super admin
    public function verifyPrivileges(){
        $validateUser = $this->findUserByDNI();
        if(!$validateUser) return redirect();
    }

    #verificar permisos para vista, lectura, escritura, edicion, etc.
    public function verifyPermissions(){
        $userSession = SesionService::leer("correoUsuario");
        $dni = $userSession["dni"] ?? '';

        $this->cUsers = new ConfigurationPermissionsController();
        $this->cUsers->actions;

        $user = $this->getUserByDNI($dni);
        $permission = $user["permissions"]??0;

        dd($permission);
    }

    public static function findUserByDNI(){
        $users = env("APP_USERS_IDENTIFY");
        $users = isset($users) && $users!=null ? explode(",", $users) : [];
        
        $userSession = SesionService::leer("correoUsuario");
        $dni = $userSession["dni"] ?? '';
        $validateUser = in_array($dni, $users);
        return $validateUser;
    }

    public static function getUserByDNI($dni){

        $new2fa = new ConfigurationUsersController();
        $store = $new2fa->getStore();
        $response = null;
        if(count($store) > 0){
            foreach($store as $k => $item){
                $_dni = $item["dni"] ?? '';
                if($_dni == $dni){
                    $response = $store[$k];
                    continue;
                }
            }
        }

        return $response;
    }
}
?>