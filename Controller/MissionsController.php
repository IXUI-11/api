<?php

require_once "../Config/bdd.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$bdd = new Bdd();
$pdo = $bdd->getConnection();



$afficherMissions = $pdo->query("SELECT * FROM mission");
$missions = $afficherMissions->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($missions);


?>