<?php
namespace App\Controllers;

class PaquetesController{

    function index(){
        echo view("paquetes", [
            "currentPage" => "PaquetesController"
         ]);
    }
}
?>