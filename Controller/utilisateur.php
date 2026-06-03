<?php
// Importation de la connexion à la base de données
require_once "../Config/bdd.php";

// Importation du modèle métier bénévole (classe Benevole)
require_once "../Cmetiers/beneovle.php";

// Importation du service bénévole (logique métier)
require_once "../Cservices/benevoles.php";

// Connexion à la base de données et instanciation du service bénévole
$pdo = Bdd::getConnection();
$service = new BenevoleService($pdo);

// Récupération de l'ID du bénévole passé en paramètre GET dans l'URL
$id = $_GET['id'];

// Recherche du bénévole en base de données par son ID
$benevole = $service->getBenevoleParlId($id);

// Retour du résultat en JSON au frontend
echo json_encode($benevole);
?>