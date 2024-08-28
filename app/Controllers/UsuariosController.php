<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class UsuariosController extends Permissions{

    function index(){
        $permissions = $this->getUserPermissions();
        echo view("usuarios", [
            "permissions" => $permissions,
            "currentPage" => "UsuariosController"
         ]);
    }
}
?>