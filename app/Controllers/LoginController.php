<?php
namespace App\Controllers;

use App\Services\SesionService;

class LoginController{
    
    public function index(){

        $data = [
            'title' => 'Página de inicio',
            'content' => '¡Hola desde el controlador!',
        ];

        // Renderizar la vista
        echo view("login");        
    }

    public function login(){
        
       //script de logueo de usuario
       
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if( $username != "" AND $password != "")
        {
            $ldap_server = env("LDAP_SERVER");
            $ldap_port = env("LDAP_PORT");
            $ldap_domain = env("LDAP_DOMAIN");
            $ldap_basedn = "OU=Babilonia,OU=User,OU=Peru,DC=verticalcapital,DC=io";
            $ldap_username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $ldap_password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
    
            $ldap = ldap_connect($ldap_server . ":" . $ldap_port);
            
            if($ldap){

                ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            
                $bind = @ldap_bind($ldap, $ldap_username . "@" . $ldap_domain, $ldap_password);
            
                if ($bind) {
                    $filter = "(sAMAccountName=$ldap_username)";
                    $result = ldap_search($ldap, $ldap_basedn, $filter);
                    $info = ldap_get_entries($ldap, $result);
    
                    for ($i=0; $i<$info["count"]; $i++) {
                        if($info['count'] > 1) {
                            break;
                        }
    
                        $_dni = $info[$i]['employeeid'][0] ?? 0;
                        $_name = strtoupper($info[$i]['cn'][0]) ?? '';
                        $_email = strtoupper($info[$i]['mail'][0]) ?? '';
                        $_username = $info[$i]['samaccountname'][0] ?? '';
    
                        $_SESSION['DNI'] = $_dni;
                        $_SESSION['NAME'] = $_name;
                        $_SESSION['EMAIL'] = $_email;
                        $_SESSION['USERNAME'] = $_username;
    
                        $session_usuario = [
                            "dni" =>$_dni,
                            "name" =>$_name,
                            "email" =>$_email,
                            "username" =>$_username,
                            "role" => ""
                        ];
    
                        SesionService::escribir("correoUsuario", $session_usuario);
                        
                        redirect();
                    }
    
                    @ldap_close($ldap);
                    
                }

                echo view("login", ["message"=> "El usuario o la contraseña no coinciden"]);
            }

            echo view("login", ["message"=> "No se pudo establecer conexion con el servidor"]);

        }
        else
        {
            echo view("login", ["message"=> "Porfavor complete su usuario y contraseña"]);
        }
        /*
        //!VALIDACION DE EMAIL SIN CONTRASEÑA
        else if (isset($_POST['email']) AND $_POST['email'] != "") 
        {
            //! script desconocido
            $key_environment = "dev";
            $key_data = "internal";
            #require '/var/www/resources/php/globalCredential.php';

            $global_variable = "variable";
            #require '/var/www/resources/php/globalVariable.php';

            #require '/var/www/resources/php/f_encryptDecrypt.php';

            $encrypted_email = htmlspecialchars(encrypt_decrypt('encrypt', $_POST['email']), ENT_QUOTES,'UTF-8');

            $message = new stdClass();
            $message->request = "reset";
            $message->email = $encrypted_email;

            $message = json_encode($message);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url_services . "/me/backoffice",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $message,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: " . $token_backoffice,
                    "Accept-Language: " . $lang
                ),
            ));
            $answer_ok = curl_exec($curl);
            $answer_error = curl_error($curl);
            curl_close($curl);

            if ($answer_error) {
                header("HTTP/1.1 400 Bad Request");
        
                $error = array (
                    "data" => array (
                        "errors" => array (array (
                            "key" => "unknow",
                            "message" => $answer_error,
                            "payload" => array (
                                "code" => "unknow",
                            ),
                            "type" => "custom",
                        ))
                    )
                );
                
                echo json_encode($error, true);
            }
            else {
                $answer_ok = json_decode($answer_ok);
            }

            echo 2;
        }
        */
       
        
       //script de logueo de usuario
    }

    public function logout(){
        SesionService::destruir();
        redirect("login");
    }
}

?>