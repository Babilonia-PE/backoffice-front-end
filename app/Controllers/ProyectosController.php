<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ProyectosController extends Permissions{
    function  __consctructor(){        
    }

    public function index(){
        echo view("proyectos", [
            "currentPage" => "ProyectosController"
        ]);
    }
}
?>