<?php

require_once "../Config/bdd.php";
require_once "../Cmetiers/mission.php";
require_once "../Cservices/missions.php";


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$bdd = Bdd::getConnection();
$missionService = new MissionService($bdd);

$action = $_GET['action'] ?? 'all';

if ($action === 'MissionRecent') {
    $missions = $missionService->getMissionRecent();
    echo json_encode($missions);
} else if ($action === 'ajouterMission') {
    $donnes = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->ajouterMission(
        $donnes['titre'],
        $donnes['lieu'],
        $donnes['description'],
        $donnes['date_mission']
    );
    echo json_encode($resultat);
} else if ($action === 'supprimerMission') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->supprimerMission($donnees['id']);
    echo json_encode($resultat);
} else if ($action === 'modifierMission') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->modifierMission(
        $donnees['id'],
        $donnees['titre'],
        $donnees['lieu'],
        $donnees['description'],
        $donnees['date_mission']
    );
    echo json_encode($resultat);
} else if ($action === 'missionsPassees') {
    $id_benevole = $_GET['id_benevole'] ?? null;
    $missions = $missionService->getMissionsPasseesParBenevole($id_benevole);
    echo json_encode($missions);
} else if ($action === 'changerStatut') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->changerStatutMission($donnees['id'], $donnees['actif']);
    echo json_encode($resultat);
} else {
    $missions = $missionService->getToutLesMissions();
    echo json_encode($missions);
}
?>
