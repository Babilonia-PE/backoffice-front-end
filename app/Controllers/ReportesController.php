<?php
namespace App\Controllers;
class ReportesController{

    public function index(){
        echo view("reportes", [
            "currentPage" => "reportes"
         ]);
    }
    public function post()
    {

    }
}
?>