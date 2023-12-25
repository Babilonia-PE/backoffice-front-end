<?php
namespace App\Services;

use App\Services\Helpers;
use eftec\bladeone\BladeOne;

class Blade extends Helpers{

    public function createView($template = "", $parametros = ""){

        if($template == "") return "";

        $blade = new BladeOne(URL_VIEWS, URL_CACHE,BladeOne::MODE_DEBUG);
        if(env("APP_TESTING")) $blade->setIsCompiled(false); 
        $blade->pipeEnable=true;
        $blade->setBaseUrl(URL_WEB);
    
        $userSession = auth();
    
        $dni = $userSession["dni"]??"";
        $name = $userSession["name"]??"";
        $email = $userSession["email"]??"";
        $username = $userSession["username"]??"";
        $role = $userSession["role"]??"";
    
        if($name != '') $blade->setAuth($name, $role);
        
        $currentPage = get_current_view();
        $camelcase = static function($arg=""){ 
            return Helpers::camelcase($arg);
        };
    
        $blade->directive('camelcase', $camelcase);
        $blade->share("currentPage", $currentPage);
    
        return $blade->run($template, $parametros);
    }
}

?>