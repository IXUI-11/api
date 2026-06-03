<?php
// Importation de la connexion à la base de données
require_once "../Config/bdd.php";

// Importation du modèle métier mission (classe Mission)
require_once "../Cmetiers/mission.php";

// Importation du service mission (logique métier)
require_once "../Cservices/missions.php";

// Gestion de la requête préliminaire CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Connexion à la base de données et instanciation du service mission
$bdd = Bdd::getConnection();
$missionService = new MissionService($bdd);

// Récupération du paramètre "action" dans l'URL, avec "all" comme valeur par défaut
$action = $_GET['action'] ?? 'all';

// Récupération des missions les plus récentes
if ($action === 'MissionRecent') {
    $missions = $missionService->getMissionRecent();
    echo json_encode($missions);

// Ajout d'une nouvelle mission
} else if ($action === 'ajouterMission') {
    // Lecture et décodage du corps de la requête JSON
    $donnes = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->ajouterMission(
        $donnes['titre'],
        $donnes['lieu'],
        $donnes['description'],
        $donnes['date_mission']
    );
    echo json_encode($resultat);

// Suppression d'une mission par son ID
} else if ($action === 'supprimerMission') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->supprimerMission($donnees['id']);
    echo json_encode($resultat);

// Modification d'une mission existante
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

// Récupération des missions passées d'un bénévole spécifique
} else if ($action === 'missionsPassees') {
    // L'ID du bénévole est passé directement en paramètre GET
    $id_benevole = $_GET['id_benevole'] ?? null;
    $missions = $missionService->getMissionsPasseesParBenevole($id_benevole);
    echo json_encode($missions);

// Changement du statut actif/inactif d'une mission
} else if ($action === 'changerStatut') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $missionService->changerStatutMission($donnees['id'], $donnees['actif']);
    echo json_encode($resultat);

// Action par défaut : récupération de toutes les missions
} else {
    $missions = $missionService->getToutLesMissions();
    echo json_encode($missions);
}
?>