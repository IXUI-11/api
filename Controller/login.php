<?php
require_once "../Config/bdd.php";

//  php:// input pour récupérer excatement les donné envoyer par le client (le front) et json_decode pour les convertir en tableau associatif


/*
 code fait ça :

Reçoit un JSON du front
Lit email + mot de passe
Cherche dans la base si un utilisateur correspond
Récupère l’utilisateur s’il existe
*/


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$donnes = json_decode(file_get_contents("php://input"), true);
$email = $donnes['email'] ;
$mot_de_passe = $donnes['mot_de_passe'] ;
$req = Bdd::getConnection()->prepare("SELECT * FROM utilisateur WHERE email = :email");
$req->execute([':email' => $email]);
$utilisateur = $req->fetch(PDO::FETCH_ASSOC);

if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
    echo json_encode([
        "success" => true,
        "role" => $utilisateur['id_role'],
        "id_benevole" => $utilisateur['id_benevole']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Email ou mot de passe incorrect"
    ]);
}
