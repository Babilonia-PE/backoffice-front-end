<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class AutomaticReportsController extends Permissions{

    function index(){
        echo view("automatics-reports", [
            "currentPage" => "AutomaticReportsController"
         ]);
    }
}
?>