<?php
namespace App\Controllers;

use App\Services\Helpers;
use App\Middlewares\Permissions;

class AlertasProjectsController extends Permissions{

    function index(){
        $newAlertasArray = [];
        foreach(APP_LANG_ALERT_TYPE as $k => $item){
            $name = $item["name"] ?? '';
            $newAlertasArray["$k"] = $name;
        }

        echo view("alertas-projects", [
           "currentPage" => "AlertasProjectsController",
           "data" => [
            "NewLangAlertType" =>$newAlertasArray
           ]
        ]);
    }
}
?>