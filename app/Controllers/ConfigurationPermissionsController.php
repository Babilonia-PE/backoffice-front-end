<?php
namespace App\Controllers;

use App\Services\SesionService;

class ConfigurationPermissionsController{

    public function __construct(){
        $this->currentPage = "configuration-permisos";                
                
    }

    public function index(){

        echo view("configuracion-permissions", [
            "currentPage" => $this->currentPage,
            "data" => []
        ]);
    }

    public function post(){
        
    }

    public function permissionDetail(){

        echo view("configuracion-permissions-detalle", [
            "currentPage" => $this->currentPage,
            "data" => []
        ]);
    }
}
?>