<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ConfigurationMenuController extends Permissions{

    public $dbUser = "menustore";
    public function __construct(){
        $this->currentPage = "ConfigurationMenuController";
    }
    public function index(){     
                
        echo view("configuracion-menu", [
            "currentPage" => $this->currentPage
        ]);
    }

    public function post(){

        $post_menu = isset($_POST["menu"]) ? $_POST["menu"] : '[]';
        $post_menu = json_decode($post_menu);
        
        Store::updateDb($this->dbUser, $post_menu);
        
        echo view("configuracion-menu", [
            "currentPage" => $this->currentPage
        ]);
    }
}
?>