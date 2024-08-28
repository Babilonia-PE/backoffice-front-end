<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class EquiposController extends Permissions{

    function index(){
        echo view("equipos", [
            "currentPage" => "EquiposController"
         ]);
    }
}
?>