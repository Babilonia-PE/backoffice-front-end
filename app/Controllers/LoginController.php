<?php
namespace App\Controllers;

use App\Services\SesionService;
use PragmaRX\Google2FA\Google2FA;
use App\Controllers\AccountManager;
use App\Middlewares\Authentication;
use App\Controllers\Configuration2faController;

class LoginController{
    
    public function index(){

        //SesionService::destruir();
        
        $data = [
            'title' => 'Página de inicio',
            'content' => '¡Hola desde el controlador!',
        ];

        // Renderizar la vista
        echo view("login");
        die();        
    }

    public function login(){
        
       //script de logueo de usuario

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        #VERIFICAMOS EXISTENCIA DE LIBRERIA LDAP EN PHP
        if (!function_exists('ldap_connect')) {
            echo view("login", ["message"=> "La extensión LDAP no está habilitada en PHP.", "type"=>"danger"]);;
            die();
        }
       
        #VERIFICAMOS EXISTENCIA DE CRENDENCIALES
        if( $username == "" AND $password == ""){
            echo view("login", ["message"=> "Porfavor complete su usuario y contraseña"]);
            die();
        }

        $ldap_server = env("LDAP_SERVER");
        $ldap_port = env("LDAP_PORT");
        $ldap_domain = env("LDAP_DOMAIN");
        $ldap_basedn = "OU=Babilonia,OU=User,OU=Peru,DC=verticalcapital,DC=io";
        $ldap_username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $ldap_password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

        $ldap = ldap_connect($ldap_server . ":" . $ldap_port);
        
        #VERIFICAMOS CONEXION AL SERVICIO
        if($ldap === false){
            echo view("login", ["message"=> "No se pudo establecer conexion con el servidor"]);
            die();
        }
        
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
    
        $bind = @ldap_bind($ldap, $ldap_username . "@" . $ldap_domain, $ldap_password);

        #VERIFICAMOS CREDENCIALES DE USUARIOS
        if($bind === false){
            echo view("login", ["message"=> "El usuario o la contraseña no coinciden"]);
            die();
        }
    
        $filter = "(sAMAccountName=$ldap_username)";
        $result = ldap_search($ldap, $ldap_basedn, $filter);
        $info = ldap_get_entries($ldap, $result);

        for ($i=0; $i<$info["count"]; $i++) {
            if($info['count'] > 1) {
                break;
            }

            $_dni = $info[$i]['employeeid'][0] ?? 0;
            $_name = $info[$i]['cn'][0] ?? '';
            $_email = $info[$i]['mail'][0] ?? '';
            $_username = $info[$i]['samaccountname'][0] ?? '';
            
            $secret_key = AccountManager::verifySecondAuthSaved($_username);

            $usersStore = Authentication::getUserByDNI($_dni);
            $usersfind = ($usersStore == null) ? false : true;
            $usersAuthDisable = $usersfind && $usersStore["auth-disabled"] == true ? true : false;
            $session_usuario = [
                "dni" =>$_dni,
                "name" =>$_name,
                "email" =>$_email,
                "username" =>$_username,
                "role" => "",
                "approved" => false,
            ];

            if($usersAuthDisable == true){
                $session_usuario["approved"] = true;

                SesionService::escribir("correoUsuario", $session_usuario);

                redirect();
            }else{
                if($secret_key == ''){
                    
                    $session_usuario["approved"] = true;

                    SesionService::escribir("correoUsuario", $session_usuario);
                
                    redirect("update-account-2fa");

                }else{

                    SesionService::escribir("correoUsuario", $session_usuario);

                    redirect("verify-account");
                }
            }
        }

        @ldap_close($ldap);


       //script de logueo de usuario
    }

    public function verifyAccount(){

        echo view("login-2fa");
    }

    public function logout(){
        SesionService::destruir();
        redirect("login");
    }
}

?>