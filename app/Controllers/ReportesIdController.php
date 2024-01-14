<?php
namespace App\Controllers;
class ReportesIdController{

    public function index(){
        echo view("reportes", [
            "currentPage" => "ReportesIdController"
         ]);
    }
    public function post()
    {

    }
}
?>