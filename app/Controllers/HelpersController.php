<?php
namespace App\Controllers;
class HelpersController{
    public function tracer($file="tracer", $string = ""){
        $tracer = env('APP_TRACER')??false;
        if($tracer){
            date_default_timezone_set('America/Lima');

            $archivo = URL_LOGS. "access/$file.log";

            if(!file_exists($archivo)){
                file_put_contents($archivo, "");
                chmod($archivo, 0777);
            }

            $contenidoActual = file_get_contents($archivo);
            $lineas = explode("\n", $contenidoActual);
            $ultimoIndice = count($lineas);

            //Write action to txt log
            $log = $string.PHP_EOL;
            if($string == ""){
                $username = $session_usuario["name"] ?? 'guest';
                $log  = "Request: ". "[". $_SERVER['REQUEST_METHOD'] ."] '". $_SERVER['REQUEST_URI']."' ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i:s a").PHP_EOL.
                        "User: ".$username.PHP_EOL.
                        "-------------------------".PHP_EOL;
            }
            
            if ($handle = fopen($archivo, 'a')) {
                fwrite($handle, $log);
                fclose($handle);            
            }
        }
    }
    public function getConstainsRequestURI($url){
        return str_contains($_SERVER['REQUEST_URI'], $url) ?? false;      
    }
}
?>