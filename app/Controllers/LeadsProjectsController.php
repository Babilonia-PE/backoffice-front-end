<?php
namespace App\Controllers;

class LeadsProjectsController{

    function index(){
        echo view("leads", [
            "currentPage" => "LeadsProjectsController"
         ]);
    }
}
?>