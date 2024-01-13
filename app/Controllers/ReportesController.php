<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ReportesController extends Permissions{

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