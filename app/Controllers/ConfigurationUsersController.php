<?php
namespace App\Controllers;
class ConfigurationUsersController{
    public function __construct(){
        $this->currentPage = "configuration-usuarios";                
        $this->data = $this->getStore() ?? [];
    }
    public function index(){        
        $userStore = $this->data;
        $permisionsLevel = [];

        $usersAdmin = env("APP_USERS_IDENTIFY");
        $usersAdmin = isset($usersAdmin) && $usersAdmin!=null ? explode(",", $usersAdmin) : [];

        foreach($userStore as $key => $item){
            $permissions = $item["permissions"] ?? 0;
            $dni = $item["dni"] ?? "";
            $auth = $item["auth-disabled"] ?? false;
            $secret = $item["secret"] ?? "";

            if(in_array($dni, $usersAdmin)){
                $userPermissionsvalue = "Super Admin";
            }else{
                $userPermissionsvalue = $permisionsLevel[$permissions] ?? 'No asignado';
            }

            if($secret == ''){
                $authValue = 'No registrado';
                $clase = "btn-secondary";
            }else{
                $authValue = ($auth) ? 'Habilitado' : 'Deshabilitado';
                $clase = "btn-primary";
            }

            $userStore[$key]["permissionsValue"] = $userPermissionsvalue;
            $userStore[$key]["authValue"] = $authValue;
            $userStore[$key]["authClase"] = $clase;
        }

        echo view("configuracion-usuarios", [
            "currentPage" => $this->currentPage,
            "data" => $userStore
        ]);
    }
    public function post(){
        
        $type = trim($_POST["type"]??'');
        $id = trim($_POST["id"]??'');
        $username = trim($_POST["username"]??'');
        $permission = trim($_POST["permission"]??false);
        $authDisabled = trim($_POST["auth-disabled"]??false);
        $data = $this->data ?? [];

        switch ($type) {
            case 'delete':
                foreach($data as $key => $item){
                    $_username = $item["username"] ?? '';
                    if($_username == $username){
                        unset($data[$key]);
                    }
                }        
                $this->saveStore($data);
            break;
            
            default:
                $data = $this->data ?? [];
        
                foreach($data as $key => $item){
                    $_username = $item["username"] ?? '';
                    $_auth_disabled = $item["auth-disabled"] ?? false;
                    if($username == $_username){
                        $data[$key]["auth-disabled"] = $_auth_disabled ? false : true;
                    }
                }        
                $this->saveStore($data);
            break;
        }

        echo view("configuracion-usuarios", [
            "currentPage" => $this->currentPage,
            "data" => $data
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
            if($_dni == $id) $user = $userStore[$key] ?? null;
        }

        if($user == null) return redirect();

        echo view("configuracion-usuarios-detalle", [
            "currentPage" => "configuration-usuarios-detalle",
            "data" => $user
        ]);
    }
}
?>