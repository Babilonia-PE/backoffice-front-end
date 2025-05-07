<?php
session_start();

$root = $_SERVER["DOCUMENT_ROOT"];
$parts = explode("/", $root);
$last_line = end($parts);
$last_line = ($last_line == "")? "" : "/";
define("URL_ROOT", $_SERVER["DOCUMENT_ROOT"] . $last_line );

$dotenv = Dotenv\Dotenv::createImmutable(URL_ROOT);
$dotenv->load(); 

define("USER_ADMIN", "administrator");
define("URL_APP", URL_ROOT . "app");
define("APP_BASE_EP", $_SERVER["APP_BASE_EP"]??"https://services-testing.babilonia.pe/");
define("URL_WEB", $_SERVER["URL_WEB"]??"https://app-testing.babilonia.pe/");
define("URL_LOGS", URL_ROOT. "logs/");
define("URL_PUBLIC", URL_ROOT . "public/");
define("URL_ASSETS", URL_ROOT . "public/assets/");
define("URL_API", URL_ROOT . "api/");
define("URL_VIEWS", URL_ROOT. "views/");
define("URL_CACHE", URL_ROOT. "cache/");
define("TESTING", $_SERVER["APP_TESTING"]??false);
define("NOMBRE_APLICACION", "");
define("AUTOR", "");

if(!is_dir(URL_CACHE)){ mkdir(URL_CACHE, 0777, true);   }

if(!is_dir(URL_LOGS. "errors")){ mkdir(URL_LOGS."errors", 0777, true); }

if(!is_dir(URL_LOGS. "access")){ mkdir(URL_LOGS."access", 0777, true); }

ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", URL_LOGS . "errors/" . date("Y-m-d") . ".log");

$app_lang_project_type = [
    "all" => "Todos",
    "residential" => "Residenciales",
    "beach_house" => "Casa de playa",
    "cottage" => "Casa de campo",
    "offices" => "Oficinas",
    "both" => "Mixto"
];
$app_lang_project_stage = [
    "all" => "Todas",
    "plans" => "En planos",
    "in_construction" => "En construcción",
    "soon" => "Proxima entrega",
    "ready" => "Entrega inmediata"
];
$app_lang_listing_type = [
    "all" => "Todos",
    "sale" => "Venta",
    "rent" => "Alquiler"
];
$app_lang_property_type = [
    "all" => 'Todos',
    "apartment" => 'Departamento',
    "house" =>  'Casa',
    "commercial" =>  'Local comercial',
    "office" => 'Oficinas',
    "land" =>  'Terreno',
    "local_industrial" =>  'Local Industrial',
    "land_agricultural" =>  'Terreno Agrícola',
    "land_industrial" =>  'Terreno Industrial',
    "land_commercial" =>  'Terreno Comercial',
    "cottage" =>  'Casa de Campo',
    "beach_house" =>  'Casa de Playa',
    "building" =>  'Edificio',
    "hotel" =>  'Hotel',
    "deposit" =>  'Depósito',
    "parking" =>  'Estacionamiento',
    "airs" =>  'Aires',
    "room" =>  'Habitación'  
];
$app_lang_alert_type = [
    "lead" => [
        "name" => "Lead",
        "description" => "Autogenerado al generar un lead"
    ],
    "similar" => [
        "name" => "Similar",
        "description" => "Creado desde la opción de [Quiero que me envíen inmuebles similares]"
    ],
    "alert" => [
        "name" =>"Alert",
        "description" => "Creado desde formulario de alertas"
    ]
];
$app_lang_alert_state = [
    "Desactivado",
    "Activado"
];
$app_lang_state = [
    "published" => "Publicado",
    "not_published" => "No publicado",
    "unpublished" => "Despublicado",
    "expired" => "Expirado",
    "deleted" => "Eliminado"
];
$app_lang_user_state = [
    "standby" => "Suspendido",
    "incomplete" => "Incompleto",
    "active" => "Activo",
    "locked" => "Bloqueado",
    "banned" => "Baneado",
    "deleted" => "Eliminado"
];
$app_document_type = [
    "1" => "DNI",
    "4" => "Pasaporte",
    "3" => "RUC"
];
$app_lang_leads_keys = [
    "phone_view" => 'Telefono',
    "email_view" => 'Email',
    "whatsapp_view" => 'Whatsapp',
    "visit_request" => 'Visita'
];
$app_lang_leads_keys = [
    "phone_view" => 'Telefono',
    "email_view" => 'Email',
    "whatsapp_view" => 'Whatsapp',
    "visit_request" => 'Visita'
];
$app_lang_ads_type = [
    "listing" => "Avisos",
    "project" => "Proyectos"
];
$app_lang_source = [
    "web" => "web",
    "backoffice" => "backoffice"
];
$app_lang_package_category = [
    "essentials" => "Essentials",
    "pro" => "Pro",
    "prestige" => "Prestige"
];
$app_lang_clients_state = [
    1 => 'Activo',
    2 => 'Bloqueado',
    3 => 'Baneado',
    5 => 'Eliminado'
];
$app_lang_claims_state = [
    "all" => "Todos",
    "received" => "Recibido",
    "answered" => "Contestado",
    "returned" => "Devuelto",
    "ended" => "Terminado"
];
$filtersParamsTypes = [
    'USER'=> 'user',
    'DATE'=> 'date',
    'CHECKBOX'=> 'checkbox'
];
define("APP_LANG_PROJECT_TYPE", $app_lang_project_type);
define("APP_LANG_PROJECT_STAGE", $app_lang_project_stage);
define("APP_VERSION", $_SERVER["VERSION"]??time());
define("APP_LANG_LISTING_TYPE", $app_lang_listing_type);
define("APP_LANG_PROPERTY_TYPE", $app_lang_property_type);
define("APP_LANG_ALERT_TYPE", $app_lang_alert_type);
define("APP_LANG_ALERT_STATE", $app_lang_alert_state);
define("APP_LANG_STATE", $app_lang_state);
define("APP_LANG_USER_STATE", $app_lang_user_state);
define("APP_DOCUMENT_TYPE", $app_document_type);
define("APP_LANG_LEADS_KEYS", $app_lang_leads_keys);
define("APP_LANG_ADS_TYPE", $app_lang_ads_type);
define("APP_LANG_SOURCE", $app_lang_source);
define("APP_LANG_PACKAGE_CATEGORY", $app_lang_package_category);
define("APP_LANG_CLIENTS_STATE", $app_lang_clients_state);
define("APP_LANG_CLAIMS_STATE", $app_lang_claims_state);
define("APP_LANG", $_SERVER["APP_LANG"]??"");
define("FILTERSPARAMSTYPES", $filtersParamsTypes);

?>