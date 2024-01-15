<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class PaquetesController extends Permissions{

    function index(){
        echo view("paquetes", [
            "currentPage" => "PaquetesController"
         ]);
    }
}
?>