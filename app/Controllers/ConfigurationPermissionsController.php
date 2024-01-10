<?php
namespace App\Controllers;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use App\Services\SesionService;

class ConfigurationPermissionsController{

    public $actions = [];

    public function __construct(){
        $this->currentPage = "configuration-permisos";
        $this->actions = [
            "view" => "Ver",
            "create" => "Crear",
            "update" => "Editar",
            "delete" => "Eliminar"
        ];
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

        $Permissions = $this->getPermissions();
        
        echo view("configuracion-permissions-detalle", [
            "currentPage" => $this->currentPage,
            "data" => [
                "permissions" => $Permissions,
                "actions" => $this->actions
            ]
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

        $menu = $GLOBALS["menu"];

        # set nuevo menu a array de permisos

        if(file_exists(URL_ROOT."db/permissionsstore.json")){
            $permissionsdb = file_get_contents(URL_ROOT."db/permissionsstore.json");
        }else{
            $permissionsdb = "[]";
        }

        $permissionsdb = json_decode($permissionsdb, true)??[];

        if(count($menu) > 0){
            foreach($menu as $k2 => $y){
                $m_id = $y["id"] ?? '';
                $stop = false;

                if(count($permissionsdb) > 0){
                    foreach($permissionsdb as $k1 => $x){
                        $p_id = $x["id"] ?? '';
        
                        foreach($this->actions as $ak => $action){
                            if(!isset($permissionsdb[$k1][$ak])) $permissionsdb[$k1][$ak] = null;
                        }

                        if($p_id == $m_id){
                            $stop = true;
                            break;
                        }                            
                    }
                }

                if($stop){
                    unset($menu[$k2]);
                    continue;
                }

                unset($menu[$k2]["icon"]);
                unset($menu[$k2]["state"]);

                foreach($this->actions as $ak => $action){
                    $menu[$k2][$ak] = null;
                }
                
            }
        }

        $menu = array_merge($permissionsdb, $menu);
        
        return $menu;
    }


}
?>