<?php
// Importation de la connexion à la base de données
require_once "../Config/bdd.php";

// Gestion de la requête préliminaire CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Lecture et décodage du corps de la requête JSON envoyée par le frontend
// php://input permet de récupérer exactement les données brutes envoyées par le client
// json_decode les convertit en tableau associatif PHP
$donnes = json_decode(file_get_contents("php://input"), true);

// Extraction des identifiants envoyés par le formulaire de connexion
$email = $donnes['email'];
$mot_de_passe = $donnes['mot_de_passe'];

// Recherche de l'utilisateur en base de données par son email
//  requête préparée pour éviter les injections SQL
$req = Bdd::getConnection()->prepare("SELECT * FROM utilisateur WHERE email = :email");
$req->execute([':email' => $email]);

// Récupération de l'utilisateur sous forme de tableau associatif
$utilisateur = $req->fetch(PDO::FETCH_ASSOC);

// Vérification : l'utilisateur existe ET le mot de passe correspond au hash en base
// password_verify compare le mot de passe en clair avec le hash stocké
if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {

    // Connexion réussie : on renvoie le rôle et l'id du bénévole au frontend
    echo json_encode([
        "success" => true,
        "role" => $utilisateur['id_role'],
        "id_benevole" => $utilisateur['id_benevole']
    ]);

} else {

    // Échec de connexion : email ou mot de passe incorrect
    echo json_encode([
        "success" => false,
        "message" => "Email ou mot de passe incorrect"
    ]);
}