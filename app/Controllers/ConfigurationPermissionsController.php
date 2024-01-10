<?php
namespace App\Controllers;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
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

    public function permissionDetail($id = null){

        $menuFlatten = $this->getPermissions();
        
        dd($menuFlatten);

        echo view("configuracion-permissions-detalle", [
            "currentPage" => $this->currentPage,
            "data" => []
        ]);
    }

    public function getPermissions(){
        
        $GLOBALS["menu"] = [];

        function menu_item($array = []){

            global $menu;

            $children = $array["children"] ?? [];
            
            if(isset($array["children"])) unset($array["children"]);

            array_push($menu, $array);
    
            if(count($children)>0)
            {            
                foreach($children as $item)
                {
                    menu_item($item);                                        
                }
                
            }            
        }
        
        if(file_exists(URL_ROOT."db/menustore.json")){
            $menudb = file_get_contents(URL_ROOT."db/menustore.json");
        }else{
            $menudb = "[]";
        }
        
        $menuStore = json_decode($menudb, true)??[];
        
        foreach($menuStore as $item){
           menu_item($item);            
        }
        
        return $GLOBALS["menu"];
    }


}
?>