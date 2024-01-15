<?php
namespace App\Controllers;

use App\Services\Store;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use App\Services\SesionService;
use App\Middlewares\Permissions;

class ConfigurationPermissionsController extends Permissions{

    public $actions = [];
    public $dbPermission = "permissionsstore";
    public $dbUser = "menustore";

    public function __construct(){
        $this->currentPage = "ConfigurationPermissionsController";
        $this->actions = [
            "view" => "Ver",
            "create" => "Crear",
            "update" => "Editar",
            "delete" => "Eliminar"
        ];
    }

    public function index(){

        $store = Store::readDb($this->dbPermission);

        echo view("configuracion-permissions", [
            "currentPage" => $this->currentPage,
            "data" => $store
        ]);
    }

    public function post(){
        $type = trim($_POST["type"]??'');
        $id = trim($_POST["id"]??'');
        $id = ($type == "new" && $id == "") ? time() : $id;

        $name = trim($_POST["nombrePermisos"]??'');
        $form = $_POST["form"]??[];
        
        if($id == '') redirect("/permisos");
        if($type == '') redirect("/permisos/$id/permiso");

        $store = Store::readDb($this->dbPermission);
        
        switch ($type) {
            case 'new':
            case 'edit':
                $form = $this->updateStateActions($form);
                
                $store[$id] = [
                    "permissions" => $form,
                    "name" => $name
                ];

                Store::updateDb($this->dbPermission,$store);

            break;
            
            case 'delete':

                unset($store[$id]);
                $store = Store::updateDb($this->dbPermission,$store);
                echo view("configuracion-permissions", [
                    "currentPage" => $this->currentPage,
                    "data" => $store
                ]);
                die();
                
            break;            
        }
        
        redirect("permisos/$id/permiso");
    }

    public function permissionDetail($id = null){

        $array = $this->getPermissions($id);
        $name = $array[0]??"";
        $permissions = $array[1]??[];
        $title = ($id == null || $id == 'new') ? 'Nuevo Permiso' : $name;
        
        echo view("configuracion-permissions-detalle", [
            "currentPage" => $this->currentPage,
            "data" => [
                "title" => $title,
                "name" => $name,
                "permissions" => $permissions,
                "actions" => $this->actions,
                "id" => ($id == "new") ? "" : $id,
                "type" => ($id == "new") ? "new" : "edit"
            ]
        ]);
    }

    public function getPermissions($id = null){
        
        if($id == null) return [];

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
        
        $menuStore = Store::readDb($this->dbUser);
        
        foreach($menuStore as $item){
           menu_item($item);            
        }

        $menu = $GLOBALS["menu"];

        # set nuevo menu a array de permisos        
        $permissionsStore = Store::readDb($this->dbPermission);
        $permissionsdb = $permissionsStore[$id]["permissions"] ?? [];
        $permissionsName = $permissionsStore[$id]["name"] ?? '';
        
        if(count($menu) > 0){
            foreach($menu as $k2 => $y){
                $m_id = $y["id"] ?? '';
                $stop = false;

                if(count($permissionsdb) > 0){
                    foreach($permissionsdb as $k1 => $x){
                        $p_id = $x["id"] ?? '';
        
                        foreach($this->actions as $ak => $action){
                            if(!isset($permissionsdb[$k1][$ak])) $permissionsdb[$k1][$ak] = false;
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
                    $menu[$k2][$ak] = false;
                }
                
            }
        }
        //dd($menu);
        $menu = array_merge($permissionsdb, $menu);
        
        return [
            $permissionsName,
            $menu
        ];
    }

    public function updateStateActions($form = []){
        foreach($form as $k => $item){
            foreach($this->actions as $y => $action){
                $form[$k][$y] = isset($form[$k][$y]) && $form[$k][$y] == "on" ? true : false;
            }
        }
        return $form;
    }

}
?>