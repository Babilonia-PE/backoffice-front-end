<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ClaimsController extends Permissions{

    function index(){
        echo view("reclamos", [
            "currentPage" => "ClaimsController"
         ]);
    }
}
?>