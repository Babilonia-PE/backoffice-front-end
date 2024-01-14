<?php
namespace App\Controllers;

use App\Services\SesionService;
use App\Controllers\ConfigurationPermissionsController;

class ConfigurationUsersController{
    public function __construct(){
        $this->currentPage = "ConfigurationUsersController";                
        $this->data = $this->getStore() ?? [];

        $usersAdmin = env("APP_USERS_IDENTIFY");
        $usersAdmin = isset($usersAdmin) && $usersAdmin!=null ? explode(",", $usersAdmin) : [];
        $this->usersAdmin = $usersAdmin;
        $this->cUsers = new ConfigurationPermissionsController();
    }
    public function index(){        
        
        $userStore = $this->formatUserResults($this->data) ?? [];

        echo view("configuracion-usuarios", [
            "currentPage" => $this->currentPage,
            "data" => $userStore
        ]);
    }
    public function post(){
        
        $id = trim($_POST["id"]??'');
        $type = trim($_POST["type"]??'');

        $username = trim($_POST["username"]??'');
        $permission = $_POST["permission"]??0;
        $state = isset($_POST["state"]) && $_POST["state"] == 'on' ? true:false;
        $authDisabled = (isset($_POST["2fa"]) && $_POST["2fa"] == "1") ? true : false;
        $userStore = $this->data ?? [];
        
        $userSession = SesionService::leer("correoUsuario");
        $userSession_dni = $userSession["dni"]??'';

        switch ($type) {
            case 'delete':
                foreach($userStore as $key => $item){
                    $_username = $item["username"] ?? '';
                    if($_username == $username){
                        unset($userStore[$key]);
                    }
                }        
                $this->saveStore($userStore);
            break;
            
            case 'update':        
                foreach($userStore as $key => $item){
                    $_dni = $item["dni"] ?? '';
                    if($_dni == $id){

                        $userStore[$key]["auth-disabled"] = $authDisabled;
                        $userStore[$key]["state"] = $state;
                        $userStore[$key]["permissions"] = $permission;                                                                        
                    }

                }        
                $this->saveStore($userStore);

                if($state == 0 && $userSession_dni == $id){
                    SesionService::destruir();
                    redirect("login");
                }  
                
            break;
        }

        $userStore = $this->formatUserResults($userStore) ?? [];

        echo view("configuracion-usuarios", [
            "currentPage" => $this->currentPage,
            "data" => $userStore
        ]);
    }

    public function delete(){        
    }

    public function saveStore($data){
        $db = URL_ROOT. "db/userstore.json";
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($db)){
            file_put_contents($db, json_encode($data));
            chmod($db, 0777);
        }else{
            file_put_contents($db, json_encode($data));
        }
    }
    public function getStore(){
        if(file_exists(URL_ROOT."db/userstore.json")){
            $store = file_get_contents(URL_ROOT."db/userstore.json");
        }else{
            $store = "[]";
        }

        return json_decode($store, true)??[];
    }


    public function userDetail ($id = null){
        $userStore = $this->data;
        $user = null;
        foreach($userStore as $key => $item){
            $_dni = $item["dni"]??'';
            if(in_array($_dni, $this->usersAdmin)) $userStore[$key]["permissions"] = 777;
            if($_dni == $id) $user = $userStore[$key] ?? null;
        }

        if($user == null) return redirect();


        $permissions = $this->cUsers->readPermissionStore();
        if(count($permissions) > 0) $user["permissionsList"] = $permissions;

        echo view("configuracion-usuarios-detalle", [
            "currentPage" => "configuration-usuarios-detalle",
            "data" => $user
        ]);
    }

    public function formatUserResults ($users = []) {
        $userStore = $users;
        $permisionsLevel = $this->cUsers->readPermissionStore();

        foreach($userStore as $key => $item){
            $permissions = $item["permissions"] ?? 0;
            $dni = $item["dni"] ?? "";
            $auth = $item["auth-disabled"] ?? false;
            $secret = $item["secret"] ?? "";
            $state = $item["state"] ?? false;

            if(in_array($dni, $this->usersAdmin)){
                $userPermissionsvalue = "Super Admin";
                $userStore[$key]["permissions"] = 777;
                
            }else{
                $userPermissionsvalue = $permisionsLevel[$permissions]["name"] ?? 'No asignado';
            }

            if($secret == ''){
                $authValue = 'No registrado';
                $clase = "btn-secondary";
            }else{
                $authValue = ($auth) ? 'Desactivado' : 'Activado';
                $clase = "btn-primary";
            }

            $userStore[$key]["permissionsValue"] = $userPermissionsvalue;
            $userStore[$key]["authValue"] = $authValue;
            $userStore[$key]["authClase"] = $clase;
            $userStore[$key]["stateValue"] = $state ? 'Activo' : 'Desactivo';
            $userStore[$key]["stateClase"] = $state ? 'btn-success' : 'btn-danger';
        }

        return $userStore;
    }
}
?>