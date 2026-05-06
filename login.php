<?php
require_once __DIR__ . "/db.php";

header("Content-Type: application/json; charset=UTF-8");

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowed = ['http://localhost:5173', 'http://127.0.0.1:5173'];
header("Access-Control-Allow-Origin: " . (in_array($origin, $allowed, true) ? $origin : 'http://localhost:5173'));
header("Vary: Origin");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") { http_response_code(200); exit; }

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = (string)($data["password"] ?? "");

if ($email === "" || $password === "") {
  http_response_code(400);
  echo json_encode(["error" => "Email et mot de passe requis"]);
  exit;
}

$stmt = $pdo->prepare("
  SELECT b.id_benevole, b.nom, b.prenom, b.email, b.actif, b.mot_de_passe_hash,
         r.code AS role
  FROM benevole b
  INNER JOIN role r ON r.id_role = b.id_role
  WHERE b.email = :email
  LIMIT 1
");
$stmt->execute(["email" => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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

echo json_encode([
  "success" => true,
  "user" => [
    "id_benevole" => (int)$user["id_benevole"],
    "nom" => $user["nom"],
    "prenom" => $user["prenom"],
    "email" => $user["email"],
    "role" => $user["role"] // 'ADMIN' ou 'BENEVOLE'
  ]
], JSON_UNESCAPED_UNICODE);
