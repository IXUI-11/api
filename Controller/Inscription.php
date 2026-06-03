<?php
// Importation de la connexion à la base de données
require_once "../Config/bdd.php";

// Importation du service bénévole (logique métier)
require_once "../Cservices/benevoles.php";

// Importation du modèle métier bénévole (classe Benevole)
require_once "../Cmetiers/beneovle.php";

// Gestion de la requête préliminaire CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Lecture et décodage du corps de la requête JSON envoyée par le frontend
$donnees = json_decode(file_get_contents("php://input"), true);

// Extraction et nettoyage des données reçues
$nom = $donnees['nom'];
$prenom = $donnees['prenom'];
$email = $donnees['email'];

// Hashage du mot de passe avant stockage en base (sécurité)
$mot_de_passe = password_hash($donnees['mot_de_passe'], PASSWORD_DEFAULT);

// Champs optionnels avec valeur par défaut si absents
$adresse = $donnees['adresse'] ?? "";
$code_postal = $donnees['code_postal'] ?? "";

// Date de naissance avec valeur par défaut si vide
$date_naissance = !empty($donnees['date_naissance']) ? $donnees['date_naissance'] : "2000-01-01";

// Connexion à la base de données
$pdo = Bdd::getConnection();

// Instanciation du service bénévole
$service = new BenevoleService($pdo);

// Appel du service pour insérer le nouveau bénévole en base
$resultat = $service->ajouterBenevole(
    $nom,
    $prenom,
    $email,
    $mot_de_passe,
    $adresse,
    $code_postal,
    $date_naissance
);

// Retour du résultat en JSON au frontend
echo json_encode($resultat);
?>