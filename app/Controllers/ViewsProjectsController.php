<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ViewsProjectsController extends Permissions{

    function index(){
        echo view("views-projects", [
            "currentPage" => "ViewsProjectsController"
         ]);
    }
}
?>