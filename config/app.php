<?php
session_start();

$root = $_SERVER["DOCUMENT_ROOT"];
$last_line = end(explode("/", $root));
$last_line = ($last_line == "")? "" : "/";
define("URL_ROOT", $_SERVER["DOCUMENT_ROOT"] . $last_line );

$dotenv = Dotenv\Dotenv::createImmutable(URL_ROOT);
$dotenv->load(); 

define("URL_APP", URL_ROOT . "app");
define("URL_WEB", $_SERVER["URL_WEB"]??"http://localhost/backoffice/");
define("URL_LOGS", URL_ROOT. "logs/");
define("URL_PUBLIC", URL_ROOT . "public/");
define("URL_ASSETS", URL_ROOT . "public/assets/");
define("URL_API", URL_ROOT . "api/");
define("URL_VIEWS", URL_ROOT. "views/");
define("URL_CACHE", URL_ROOT. "cache/");
define("TESTING", $_SERVER["TESTING"]??false);
define("NOMBRE_APLICACION", "");
define("AUTOR", "");

if(!is_dir(URL_CACHE)){ mkdir(URL_CACHE, 0777, true);   } 

if(!is_dir(URL_LOGS. "errors")){ mkdir(URL_LOGS."errors", 0777, true); }

if(!is_dir(URL_LOGS. "access")){ mkdir(URL_LOGS."access", 0777, true); }

ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", URL_LOGS . "errors/" . date("Y-m-d") . ".log");

?>