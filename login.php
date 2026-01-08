<?php

require_once __DIR__ . "/db.php";
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") { http_response_code(200); exit; }

require_once __DIR__ . "/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

if ($email === "" || $password === "") {
  http_response_code(400);
  echo json_encode(["error" => "Email et mot de passe requis"]);
  exit;
}

// Récupérer user
$stmt = $pdo->prepare("
  SELECT id_benevole, nom, prenom, email, role, actif, mot_de_passe_hash
  FROM benevole
  WHERE email = :email
  LIMIT 1
");
$stmt->execute(["email" => $email]);
$user = $stmt->fetch();

if (!$user) {
  http_response_code(401);
  echo json_encode(["error" => "Identifiants invalides"]);
  exit;
}

if ((int)$user["actif"] !== 1) {
  http_response_code(403);
  echo json_encode(["error" => "Compte désactivé"]);
  exit;
}

if (!password_verify($password, $user["mot_de_passe_hash"])) {
  http_response_code(401);
  echo json_encode(["error" => "Identifiants invalides"]);
  exit;
}

// Réponse sans hash
echo json_encode([
  "success" => true,
  "user" => [
    "id_benevole" => (int)$user["id_benevole"],
    "nom" => $user["nom"],
    "prenom" => $user["prenom"],
    "email" => $user["email"],
    "role" => $user["role"]
  ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
