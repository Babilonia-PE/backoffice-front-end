<?php
namespace App\Controllers;

class HomeController{

    public function index(){        
        echo view("home", [
            "currentPage" => "home"
        ]);        
    }
}
?>