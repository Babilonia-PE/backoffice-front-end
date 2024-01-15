<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class LeadsController extends Permissions{

    function index(){
        echo view("leads", [
            "currentPage" => "LeadsController"
         ]);
    }
}
?>