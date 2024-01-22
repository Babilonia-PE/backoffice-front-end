<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class ContactsController extends Permissions{

    function index(){
        echo view("contactos", [
            "currentPage" => "ContactsController"
         ]);
    }
}
?>