<?php
namespace App\Controllers;

use App\Services\SesionService;
use App\Middlewares\Permissions;
use PragmaRX\Google2FA\Google2FA;
use App\Controllers\AccountManager;
use App\Middlewares\Authentication;

class AccountController extends Permissions{

    public function viewUpdate2fa(){

        $image_url = self::generateCodeImage();

        echo view("login-2fa-qr",[
            "image" => $image_url
        ]);
        die();        
    }
    public function postUpdate2fa($request=null){
        
        $user_provided_code = trim($_POST["code"]??'');
        $user_provided_code = str_replace(" ", "", $user_provided_code);
        $secret_key = SesionService::leer("secretKeyUsuario");
        
        $google2fa = new Google2FA();
        try {
            $response = $google2fa->verifyKey($secret_key, $user_provided_code);
            if ($response) {
                AccountManager::saveSecretKey($secret_key);
                redirect();
            } else {
                $image_url = self::generateCodeImage();
                
                echo view("login-2fa-qr",[
                    "image" => $image_url,
                    "message" => "El codigo no es valido"
                ]);            
            }    
        } catch (\Throwable $th) {
   
            $image_url = self::generateCodeImage();
    
            echo view("login-2fa-qr",[
                "image" => $image_url,
                "message" => $th->getMessage()
            ]);  
        }
        
    }

    public static function generateCodeImage(){

        $google2fa = new Google2FA();

        $userSession = SesionService::leer("correoUsuario");
        $secret_key = AccountManager::verifySecondAuthSaved();
        $username = $userSession["username"]??'';

        if($secret_key == ""){
            $secret_key = $google2fa->generateSecretKey();
        }

        $app_name = env("APP_NAME")??'Babilonia';

        $text = $google2fa->getQRCodeUrl(
            $app_name,
            $username,
            $secret_key
        );

        SesionService::escribir("secretKeyUsuario", $secret_key, true);
        $image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$text;

        return $image_url;
    }

    public function verifyAccountPost(){

        $user_provided_code = trim($_POST["code"]??'');
        $user_provided_code = str_replace(" ", "", $user_provided_code);
        $secret_key = AccountManager::verifySecondAuthSaved();
        
        $google2fa = new Google2FA();
        try {
            $response = $google2fa->verifyKey($secret_key, $user_provided_code);
            if ($response) {

                $userSession = SesionService::leer("correoUsuario");
                $userSession["approved"] = true;
                
                SesionService::escribir("correoUsuario", $userSession, true);
                //dd(SesionService::leer("correoUsuario"));
                redirect();
            } else {
               
                echo view("login-2fa",[                    
                    "message" => "El codigo no es valido"
                ]);            
            }    
        } catch (\Throwable $th) {
       
            echo view("login-2fa",[
                "message" => $th->getMessage()
            ]);  
        }
    }

    public function viewEditAccount(){
        echo view("account");
    }
}
?>