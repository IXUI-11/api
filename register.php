<?php

require_once __DIR__ . "/db.php";
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") { http_response_code(200); exit; }

require_once __DIR__ . "/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$nom = trim($data["nom"] ?? "");
$prenom = trim($data["prenom"] ?? "");
$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";
$telephone = trim($data["telephone"] ?? "");

if ($nom === "" || $prenom === "" || $email === "" || $password === "" || $telephone === "") {
  http_response_code(400);
  echo json_encode(["error" => "Champs manquants"]);
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(["error" => "Email invalide"]);
  exit;
}

if (strlen($password) < 6) {
  http_response_code(400);
  echo json_encode(["error" => "Mot de passe trop court (min 6)"]);
  exit;
}

// Vérifier si email existe déjà
$check = $pdo->prepare("SELECT id_benevole FROM benevole WHERE email = :email LIMIT 1");
$check->execute(["email" => $email]);
if ($check->fetch()) {
  http_response_code(409);
  echo json_encode(["error" => "Email déjà utilisé"]);
  exit;
}

// Hash du mot de passe
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insertion
$stmt = $pdo->prepare("
  INSERT INTO benevole (nom, prenom, email, telephone, mot_de_passe_hash, role, actif, date_creation)
  VALUES (:nom, :prenom, :email, :telephone, :hash, 'BENEVOLE', 1, NOW())
");
$stmt->execute([
  "nom" => $nom,
  "prenom" => $prenom,
  "email" => $email,
  "telephone" => $telephone,
  "hash" => $hash
]);

echo json_encode([
  "success" => true,
  "id_benevole" => (int)$pdo->lastInsertId()
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
