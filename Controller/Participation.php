<?php

require_once "../Config/bdd.php";
require_once "../Cmetiers/participation.php";
require_once "../Cservices/participations.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$pdo = Bdd::getConnection();
$service = new ParticipationService($pdo);

$action = $_GET['action'] ?? 'inscrire';

if ($action === 'inscrire') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->inscrireBenevole($donnees['id_benevole'], $donnees['id_mission']);
    echo json_encode($resultat);
} else if ($action === 'mesParticipations') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getParticipationParBenevole($id_benevole);
    echo json_encode($resultat);
} else if ($action === 'annuler') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->annulerParticipation($donnees['id']);
    echo json_encode($resultat);
} else if ($action === 'historique') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getHistorique($id_benevole);
    echo json_encode($resultat);
} else if ($action === 'annulerAdmin') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->annulerParticipationAdmin($donnees['id']);
    echo json_encode($resultat);
}
else if ($action === 'missionsAVenir') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getMissionsAVenir($id_benevole);
    echo json_encode($resultat);
} else if ($action === 'missionsEffectuees') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getMissionsEffectuees($id_benevole);
    echo json_encode($resultat);
}
