<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ChatController extends Permissions{
    function  __consctructor(){        
    }

    public function index(){
        echo view("chat", [
            "currentPage" => "ChatController"
        ]);
    }
}
?>