<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ClientesController extends Permissions{

    function index(){
        echo view("clientes", [
            "currentPage" => "ClientesController"
         ]);
    }
}
?>