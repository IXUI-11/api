<?php
require_once "../Config/bdd.php";
require_once "../Cservices/benevoles.php";
require_once "../Cmetiers/beneovle.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$donnees = json_decode(file_get_contents("php://input"), true);

$nom = $donnees['nom'];
$prenom = $donnees['prenom'];
$email = $donnees['email'];
$mot_de_passe = password_hash($donnees['mot_de_passe'], PASSWORD_DEFAULT);
$adresse = $donnees['adresse'] ?? "";
$code_postal = $donnees['code_postal'] ?? "";
$date_naissance = !empty($donnees['date_naissance']) ? $donnees['date_naissance'] : "2000-01-01";

$pdo = Bdd::getConnection();
$service = new BenevoleService($pdo);

$resultat = $service->ajouterBenevole(
    $nom,
    $prenom,
    $email,
    $mot_de_passe,
    $adresse,
    $code_postal,
    $date_naissance
);

echo json_encode($resultat);
?>