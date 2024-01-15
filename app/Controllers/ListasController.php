<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ListasController extends Permissions{

    public function index(){        
        echo view("listas");        
    }
}
?>