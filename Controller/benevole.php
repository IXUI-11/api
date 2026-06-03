<?php
require_once "../Config/bdd.php";
require_once "../Cmetiers/beneovle.php";
require_once "../Cservices/benevoles.php";
require_once "../Cmetiers/participation.php";


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$pdo = Bdd::getConnection();
$service = new BenevoleService($pdo);

$action = $_GET['action'] ?? 'all';

if ($action === 'ajouterBenevole') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->ajouterBenevole(
        $donnees['nom'],
        $donnees['prenom'],
        $donnees['email'],
        $donnees['mot_de_passe'],
        $donnees['adresse'],
        $donnees['code_postal'],
        $donnees['date_naissance']
    );
    echo json_encode($resultat);
} else if ($action === 'supprimerBenevole') {
    $donnees = json_decode(file_get_contents("php://input"), true);
    $resultat = $service->supprimerBenevole($donnees['id']);
    echo json_encode($resultat);
} else if ($action === 'getParticipations') {
    $id = $_GET['id'];
    $resultat = $service->getParticipationsParBenevole($id);
    echo json_encode($resultat);
} else {
    $benevoles = $service->getToutLesBenevoles();
    echo json_encode($benevoles);
}
?>
