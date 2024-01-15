<?php
namespace App\Controllers;

use App\Services\Helpers;
use App\Middlewares\Permissions;

class AlertasController extends Permissions{

    function index(){
        echo view("alertas", [
           "currentPage" => "AlertasController"
        ]);
    }
}
?>