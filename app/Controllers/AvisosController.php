<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class AvisosController extends Permissions{

    function index(){
        echo view("avisos", [
            "currentPage" => "AvisosController"
         ]);
    }
}
?>