<?php
namespace App\Controllers;

use App\Services\SesionService;

class AccountManager {
    static function verifySecondAuthSaved($usernameSession = ""){

        if($usernameSession == ""){

            $userSession = SesionService::leer("correoUsuario");
            $usernameSession = $userSession["username"]??'';
        }

        $db = URL_ROOT. "db/userstore.json";
        $userdb = file_get_contents($db);
        $userdb = json_decode($userdb, true);
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

        
        $userSession = SesionService::leer("correoUsuario");
        $usernameSession = $userSession["username"]??'';

        $db = URL_ROOT. "db/userstore.json";
        
        $userdb = file_get_contents($db);
        $userdb = json_decode($userdb, true);
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
                "secret" => $get_secret
            ];

            array_push($userdb, $usuario);
        }
        
        $userJson = json_encode($userdb);
        file_put_contents($db, $userJson);
    }
}
?>