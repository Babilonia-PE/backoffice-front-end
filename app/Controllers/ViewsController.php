<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ViewsController extends Permissions{

    function index(){
        echo view("views", [
            "currentPage" => "ViewsController"
         ]);
    }
}
?>