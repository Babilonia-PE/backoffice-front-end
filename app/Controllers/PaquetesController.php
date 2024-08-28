<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class PaquetesController extends Permissions{
    function index(){
        $permissions = $this->getUserPermissions();
        echo view("paquetes", [
            "permissions" => $permissions,
            "currentPage" => "PaquetesController"
         ]);
    }
}
?>