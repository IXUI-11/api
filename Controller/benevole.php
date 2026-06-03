<?php
// Importation de la connexion à la base de données
require_once "../Config/bdd.php";

// Importation du modèle métier bénévole (classe Benevole)
require_once "../Cmetiers/beneovle.php";

// Importation du service bénévole (logique métier)
require_once "../Cservices/benevoles.php";

// Importation du modèle métier participation
require_once "../Cmetiers/participation.php";


// Gestion de la requête préliminaire CORS (envoyée par le navigateur avant certaines requêtes)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Connexion à la base de données via le singleton Bdd
$pdo = Bdd::getConnection();

// Instanciation du service qui contient toute la logique métier des bénévoles
$service = new BenevoleService($pdo);

// Récupération du paramètre "action" dans l'URL, avec "all" comme valeur par défaut
$action = $_GET['action'] ?? 'all';

// Ajout d'un nouveau bénévole
if ($action === 'ajouterBenevole') {

    // Lecture et décodage du corps de la requête JSON
    $donnees = json_decode(file_get_contents("php://input"), true);

    // Appel du service avec les données reçues
    $resultat = $service->ajouterBenevole(
        $donnees['nom'],
        $donnees['prenom'],
        $donnees['email'],
        $donnees['mot_de_passe'],
        $donnees['adresse'],
        $donnees['code_postal'],
        $donnees['date_naissance']
    );

    // Retour du résultat en JSON
    echo json_encode($resultat);

// Suppression d'un bénévole par son ID
} else if ($action === 'supprimerBenevole') {

    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->supprimerBenevole($donnees['id']);
    echo json_encode($resultat);

// Récupération des participations d'un bénévole spécifique
} else if ($action === 'getParticipations') {

    // L'ID du bénévole est passé directement en paramètre GET
    $id = $_GET['id'];
    $resultat = $service->getParticipationsParBenevole($id);
    echo json_encode($resultat);

// Action par défaut : récupération de tous les bénévoles
} else {
    $benevoles = $service->getToutLesBenevoles();
    echo json_encode($benevoles);
}
?>