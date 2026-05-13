<?php
require_once "../Config/bdd.php";
require_once "../Cmetiers/beneovle.php";
require_once "../Cservices/benevoles.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$pdo = Bdd::getConnection();
$service = new BenevoleService($pdo);

echo json_encode($service->getToutLesBenevoles());
?>