<?php
namespace App\Controllers;

class ConfigurationMenuController{

    public function index(){     
        
        $menudb = file_get_contents(URL_ROOT."db/menustore.json");
        $menu = json_decode($menudb, true)??[];
        
        echo view("configuracion-menu", $menu);
    }
}
?>