<?php

require_once "../Config/bdd.php";
require_once "../Cmetiers/mission.php";
require_once "../Cservices/missions.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$bdd = Bdd::getConnection();
$missionService = new MissionService($bdd);

$action = $_GET['action'] ?? 'all';


// Récupérer les missions en fonction de l'action demandée
if ($action === 'MissionRecent') {
    $missions = $missionService->getMissionRecent();
} else {
    $missions = $missionService->getToutLesMissions();
}

echo json_encode($missions);


?>