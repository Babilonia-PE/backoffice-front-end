<?php
namespace App\Controllers;

use App\Services\Store;
use App\Services\SesionService;
use App\Middlewares\Permissions;

class AccountManager  extends Permissions{
    function __construct(){
        Store::initStore("userstore");
    }

    static function verifySecondAuthSaved($usernameSession = ""){

        Store::initStore("userstore");
        if($usernameSession == ""){

            $userSession = SesionService::leer("correoUsuario");
            $usernameSession = $userSession["username"]??'';
        }

        $userdb =  Store::readDb("userstore");
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

        Store::initStore("userstore");
        $userSession = SesionService::leer("correoUsuario");
        $usernameSession = $userSession["username"]??'';
        $dniSession = $userSession["dni"]??'';

        $userdb = Store::readDb("userstore");        
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
}
?>