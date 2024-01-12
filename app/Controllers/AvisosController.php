<?php
namespace App\Controllers;

class AvisosController{

    function index(){
        echo view("avisos", [
            "currentPage" => "AvisosController"
         ]);
    }
}
?>