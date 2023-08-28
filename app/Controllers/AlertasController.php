<?php
namespace App\Controllers;

use App\Services\Helpers;

class AlertasController extends Helpers{

    function index(){
        echo view("alertas");
    }
}
?>