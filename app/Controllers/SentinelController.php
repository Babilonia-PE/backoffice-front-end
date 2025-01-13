<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class SentinelController extends Permissions{

    function index(){
        $permissions = $this->getUserPermissions();
        echo view("sentinel", [
            "permissions" => $permissions,
            "currentPage" => "SentinelController"
         ]);
    }
}
?>