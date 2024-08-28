<?php
namespace App\Controllers;

use App\Middlewares\Permissions;

class AutomaticReportsController extends Permissions{

    function index(){

        $data = $this->getReports();
        echo view("automatics-reports", [
            "currentPage" => "AutomaticReportsController",
            "data" => $data
         ]);
    }

    function getReports () {
        $data = [];
        $url_web = env('URL_WEB');
        array_push($data, [
            "id" => 1,
            "reporte" => "Agentes pago vs Distritos",
            "descripcion" => "Reporte con la relación de leads y agentes con paquetes pagados vs Distritos de sus inmuebles",
            "periodo" => "60 días atras",
            "url" => $url_web . "assets/reports/agentsLeadsDitricts.xlsx"
        ]);
        array_push($data, [
            "id" => 2,
            "reporte" => "Leads avisos: Agentes vs Distritos",
            "descripcion" => "Reporte con la relación de avisos de agentes con paquetes pagados vs Leads y visitas generados",
            "periodo" => "Mes anterior",
            "url" => $url_web . "assets/reports/agentsBuyedListingsLeads.xlsx"
        ]);
        array_push($data, [
            "id" => 3,
            "reporte" => "Leads proyectos: Agentes vs Distritos",
            "descripcion" => "Reporte con la relación de proyectos de agentes con paquetes pagados vs Leads y visitas generados",
            "periodo" => "Mes anterior",
            "url" => $url_web . "assets/reports/agentsBuyedProjectsLeads.xlsx"
        ]);
        array_push($data, [
            "id" => 3,
            "reporte" => "Impresiones por distritos",
            "descripcion" => "Reporte de impresiones por distritos",
            "periodo" => "Mes anterior",
            "url" => $url_web . "assets/reports/topImpressionesByDistricts.xlsx"
        ]);

        return $data;
    }
}
?>