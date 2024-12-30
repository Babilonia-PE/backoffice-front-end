<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class DocumentosController extends Permissions{

    function index(){
        $permissions = $this->getUserPermissions();
        echo view("documentos", [
            "permissions" => $permissions,
            "currentPage" => "DocumentosController"
         ]);
    }
}
?>