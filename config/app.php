<?php
session_start();

define("URL_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("URL_APP", URL_ROOT . "app");
define("URL_WEB", "https://backoffice.localhost/");
define("URL_LOGS", URL_ROOT. "logs/");
define("URL_PUBLIC", URL_ROOT . "public/");
define("URL_ASSETS", URL_ROOT . "public/assets/");
define("URL_API", URL_ROOT . "api/");
define("URL_VIEWS", URL_ROOT. "views/");
define("URL_CACHE", URL_ROOT. "cache/");
define("NOMBRE_APLICACION", "");
define("AUTOR", "");

ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", URL_LOGS . "errors/" . date("Y-m-d") . ".log");

?>