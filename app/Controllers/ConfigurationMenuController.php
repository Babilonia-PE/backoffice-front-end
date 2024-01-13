<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ConfigurationMenuController extends Permissions{

    public function __construct(){
        $this->currentPage = "ConfigurationMenuController";
    }
    public function index(){     
        
        if(file_exists(URL_ROOT."db/menustore.json")){
            $menudb = file_get_contents(URL_ROOT."db/menustore.json");
        }else{
            $menudb = "[]";
        }        
        $menu = json_decode($menudb, true)??[];
        
        echo view("configuracion-menu", [
            "currentPage" => $this->currentPage
        ]);
    }

    public function post(){

        $post_menu = isset($_POST["menu"]) ? $_POST["menu"] : '[]';
        $post_menu = json_decode($post_menu);
        
        $db = URL_ROOT. "db/menustore.json";
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($db)){
            file_put_contents($db, json_encode($post_menu));
            chmod($db, 0777);
        }else{
            file_put_contents($db, json_encode($post_menu));
        }

        echo view("configuracion-menu", [
            "currentPage" => $this->currentPage
        ]);
    }
}
?>