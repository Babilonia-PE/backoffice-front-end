<?php
namespace App\Controllers;
class Configuration2faController{
    public function __construct(){
        $this->currentPage = "configuration-2fa";
    }
    public function index(){

        echo view("configuracion-2fa", [
            "currentPage" => $this->currentPage
        ]);
    }
}
?>