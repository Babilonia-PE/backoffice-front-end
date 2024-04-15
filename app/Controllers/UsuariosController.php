<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class UsuariosController extends Permissions{

    function index(){
        echo view("usuarios", [
            "currentPage" => "UsuariosController"
         ]);
    }
}
?>