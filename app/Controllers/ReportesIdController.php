<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ReportesIdController extends Permissions{

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