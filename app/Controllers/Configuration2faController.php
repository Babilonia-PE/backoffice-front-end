<?php
namespace App\Controllers;
class Configuration2faController{
    public function __construct(){
        $this->currentPage = "configuration-2fa";                
        $this->data = $this->getStore();
    }
    public function index(){        
        echo view("configuracion-2fa", [
            "currentPage" => $this->currentPage,
            "data" => $this->data
        ]);
    }
    public function post(){
        
        $username = trim($_POST["username"]??'');
        $data = $this->data ?? [];

        foreach($data as $key => $item){
            $_username = $item["username"] ?? '';
            $_auth_disabled = $item["auth-disabled"] ?? false;
            if($username == $_username){
                $data[$key]["auth-disabled"] = $_auth_disabled ? false : true;
            }
        }

        $this->saveStore($data);

        echo view("configuracion-2fa", [
            "currentPage" => $this->currentPage,
            "data" => $data
        ]);
    }

    public function delete(){
        $username = trim($_POST["username"]??'');
        $data = $this->data ?? [];

        foreach($data as $key => $item){
            $_username = $item["username"] ?? '';
            if($_username == $username){
                unset($data[$key]);
            }
        }

        $this->saveStore($data);

        echo view("configuracion-2fa", [
            "currentPage" => $this->currentPage,
            "data" => $data
        ]);
    }

    public function saveStore($data){
        $db = URL_ROOT. "db/userstore.json";
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($db)){
            file_put_contents($db, json_encode($data));
            chmod($db, 0777);
        }else{
            file_put_contents($db, json_encode($data));
        }
    }
    public function getStore(){
        if(file_exists(URL_ROOT."db/userstore.json")){
            $store = file_get_contents(URL_ROOT."db/userstore.json");
        }else{
            $store = "[]";
        }

        return json_decode($store, true)??[];
    }

    public function findUser($username){
        
        $store = $this->getStore();
        $response = null;
        if(count($store) > 0){
            foreach($store as $k => $item){
                $_username = $item["username"] ?? '';
                if($_username == $username){
                    $response = $store[$k];
                    continue;
                }
            }
        }

        return $response;
    }
}
?>