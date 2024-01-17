<?php
namespace App\Middlewares;

use App\Services\Store;
use App\Services\SesionService;
use App\Middlewares\Authentication;
use App\Controllers\ConfigurationPermissionsController;

class Permissions extends Authentication{
    public $render = true;
    function __construct($render = true){
        $this->render = $render;
        if($this->render === true)
            $this->authPermission();
    }

    public function authPermission($type = "view", $controllerView = null, $redirect = true){


        $userSession = SesionService::leer("correoUsuario");
        $dni = $userSession["dni"] ?? '';
        $role = $userSession["role"] ?? '';

        if($role == USER_ADMIN) return true;

        $user = $this->getUserByDNI($dni);
        $permission = $user["permissions"]??'';

        #redirect
        if(empty($permission) || $permission == ''){
            if($redirect === true) redirect();
            return false;
        }

        $cUsers = new ConfigurationPermissionsController();
        $actions = $cUsers->actions;

        $store = Store::readDb("permissionsstore");
        $userPermissionByStore = $store[$permission] ?? [];

        #redirect
        if(empty($userPermissionByStore) || count($userPermissionByStore) == 0){
            if($redirect === true) redirect();
            return false;
        }

        $userPermission = $userPermissionByStore["permissions"] ?? [];

        #redirect
        if(empty($userPermission) || count($userPermission) == 0){
            if($redirect === true) redirect();
            return false;
        }

        $controllerName = $controllerView;
        if($controllerView == null){
            $nombreClaseHija = get_called_class();
            $partes = explode('\\', $nombreClaseHija);
            $controllerName = end($partes);
        }

        $permissionFind = null;
        foreach($userPermission as $k => $i){
            $_controller = $i["controller"] ?? '';
            if($_controller == $controllerName) {
                $permissionFind = $userPermission[$k];
                continue;
            }
        }

        #redirect
        if($permissionFind == null || $permissionFind[$type] === false){
            if($redirect === true) redirect();
            return false;
        }
    }
}

?>