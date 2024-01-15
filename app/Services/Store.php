<?php
namespace App\Services;
class Store{
    function __constructor(){}
    static function readDb($store = ""){
        if($store == "") return [];

        if(file_exists(URL_ROOT."db/$store.json")){
            $store = file_get_contents(URL_ROOT."db/$store.json");
        }else{
            $store = "[]";
        }
        return json_decode($store, true)??[];
    }
    static function updateDb($store = "", $data = []){
        if($store == "") return [];

        $db = URL_ROOT. "db/$store.json";
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($db)){
            file_put_contents($db, json_encode($data));
            chmod($db, 0777);
        }else{
            file_put_contents($db, json_encode($data));
        }

        return $data;
    }
    static function initStore($name = ""){
        if($name == "") return false;

        $db = URL_ROOT. "db/$name.json";
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($db)){
            file_put_contents($db, json_encode([]));
            chmod($db, 0777);
        }
    }
}
?>