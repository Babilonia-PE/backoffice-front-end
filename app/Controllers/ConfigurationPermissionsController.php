<?php
namespace App\Controllers;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use App\Services\SesionService;

class ConfigurationPermissionsController{

    public $actions = [];
    public $dbPermission = URL_ROOT. "db/permissionsstore.json";

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
        $type = trim($_POST["type"]??'');
        $id = trim($_POST["id"]??'');
        $id = ($type == "new" && $id == "") ? time() : $id;

        $name = trim($_POST["nombrePermisos"]??'');
        $form = $_POST["form"]??[];
        
        if($id == '') redirect("/permisos");
        if($type == '') redirect("/permisos/$id/permiso");

        $store = $this->readPermissionStore();
        
        switch ($type) {
            case 'new':
            case 'edit':
                $form = $this->updateStateActions($form);
                
                $store[$id] = [
                    "permissions" => $form,
                    "name" => $name
                ];

            break;
            
            case 'delete':

                unset($store[$id]);
                
            break;            
        }
        
        $store = $this->savePermissionStore($store);
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
        $permissionsdb = $this->readPermissionStore();
        $permissionsdb = $permissionsdb[$id]["permissions"] ?? [];
        $permissionsName = $permissionsdb[$id]["name"] ?? '';

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

        $menu = array_merge($permissionsdb, $menu);
        
        return [
            $permissionsName,
            $menu
        ];
    }

    public function savePermissionStore($store){
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($this->dbPermission)){
            file_put_contents($this->dbPermission, json_encode($store));
            chmod($this->dbPermission, 0777);
        }else{
            file_put_contents($this->dbPermission, json_encode($store));
        }

        return $store;
    }

    public function readPermissionStore(){

        $permissionsdb = "[]";

        if(file_exists($this->dbPermission)) $permissionsdb = file_get_contents($this->dbPermission);

        return json_decode($permissionsdb, true)??[];
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