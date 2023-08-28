<?php
namespace App\Services;

class Helpers{
    public static function camelcase($string, $capitalizeFirstCharacter = false){

        $str = ucwords(str_replace(" ", " ", strtolower($string)));
    
        return $str;
    }
}

?>