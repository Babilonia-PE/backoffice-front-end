<?php
namespace App\Controllers;

class ClientesController{

    function index(){
        echo view("clientes", [
            "currentPage" => "clientes"
         ]);
    }
}
?>