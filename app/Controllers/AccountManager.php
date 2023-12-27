<?php
namespace App\Controllers;

use App\Services\SesionService;

class AccountManager {
    function __construct(){
        self::init();
    }

    static function verifySecondAuthSaved($usernameSession = ""){

        self::init();
        if($usernameSession == ""){

            $userSession = SesionService::leer("correoUsuario");
            $usernameSession = $userSession["username"]??'';
        }

        $db = URL_ROOT. "db/userstore.json";
        $userdb = file_get_contents($db);
        $userdb = json_decode($userdb, true) ?? [];
        $usuario = [];

        foreach($userdb as $key => $item){
            $username = $item["username"]??'';
            $secret = $item["secret"]??'';

            if($username == $usernameSession){
                array_push($usuario, $userdb[$key]);
            }
        }

        $username = $usuario[0]["username"]??'';
        $secret_key = $usuario[0]["secret"]??'';

        return $secret_key;
    }
    static function saveSecretKey($get_secret){

        self::init();
        $userSession = SesionService::leer("correoUsuario");
        $usernameSession = $userSession["username"]??'';
        $dniSession = $userSession["dni"]??'';

        $db = URL_ROOT. "db/userstore.json";
        
        $userdb = file_get_contents($db);
        $userdb = json_decode($userdb, true)  ?? [];
        $usuario = [];
        
        foreach($userdb as $key => $item){
            $username = $item["username"]??'';
            $secret = $item["secret"]??'';

            if($username == $usernameSession){
                $userdb[$key]["secret"] = $get_secret;
                array_push($usuario, $userdb[$key]);
            }
        }
        
        if(count($usuario) == 0){
            $usuario = [
                "username" => $usernameSession,
                "dni" => $dniSession,
                "secret" => $get_secret
            ];

            array_push($userdb, $usuario);
        }
        
        $userJson = json_encode($userdb);
        file_put_contents($db, $userJson);
    }

    static function init(){

        $db = URL_ROOT. "db/userstore.json";
        
        if(!is_dir(URL_ROOT. "db")){ mkdir(URL_ROOT. "db", 0777, true);} 

        if(!file_exists($db)){
            file_put_contents($db, json_encode([]));
            chmod($db, 0777);
        }
    }
}
?>