<?php

require_once "../Config/bdd.php";
require_once "../Cmetiers/Participation.php";
require_once "../Cservices/participations.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, DELETE");

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
