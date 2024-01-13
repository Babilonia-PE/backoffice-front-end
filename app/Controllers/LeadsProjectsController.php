<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class LeadsProjectsController extends Permissions{

    function index(){
        echo view("leads", [
            "currentPage" => "LeadsProjectsController"
         ]);
    }
}
?>