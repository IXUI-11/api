<?php
// Importation de la connexion à la base de données
require_once "../Config/bdd.php";

// Importation du modèle métier participation (classe Participation)
require_once "../Cmetiers/participation.php";

// Importation du service participation (logique métier)
require_once "../Cservices/participations.php";

// Gestion de la requête préliminaire CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Connexion à la base de données et instanciation du service participation
$pdo = Bdd::getConnection();
$service = new ParticipationService($pdo);

// Récupération du paramètre "action" dans l'URL, avec "inscrire" comme valeur par défaut
$action = $_GET['action'] ?? 'inscrire';

// Inscription d'un bénévole à une mission
if ($action === 'inscrire') {
    // Lecture et décodage du corps de la requête JSON
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->inscrireBenevole($donnees['id_benevole'], $donnees['id_mission']);
    echo json_encode($resultat);

// Récupération de toutes les participations d'un bénévole
} else if ($action === 'mesParticipations') {
    // L'ID du bénévole est passé directement en paramètre GET
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getParticipationParBenevole($id_benevole);
    echo json_encode($resultat);

// Annulation d'une participation par le bénévole lui-même
} else if ($action === 'annuler') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->annulerParticipation($donnees['id']);
    echo json_encode($resultat);

// Récupération de l'historique des participations d'un bénévole
} else if ($action === 'historique') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getHistorique($id_benevole);
    echo json_encode($resultat);

// Annulation d'une participation par un administrateur
} else if ($action === 'annulerAdmin') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->annulerParticipationAdmin($donnees['id']);
    echo json_encode($resultat);

// Récupération des missions à venir d'un bénévole
} else if ($action === 'missionsAVenir') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getMissionsAVenir($id_benevole);
    echo json_encode($resultat);

// Récupération des missions déjà effectuées par un bénévole
} else if ($action === 'missionsEffectuees') {
    $id_benevole = $_GET['id_benevole'];
    $resultat = $service->getMissionsEffectuees($id_benevole);
    echo json_encode($resultat);
}
?>