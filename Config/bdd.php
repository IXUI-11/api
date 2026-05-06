<?php

class Bdd{
    private $hote = "localhost";
    private $utilisateur = "root";
    private $mot_de_passe = "";
    private $base_de_donnees = "benovaide";

    public function getConnection(){
        try {
            $pdo = new PDO("mysql:host=$this->hote;dbname=$this->base_de_donnees", $this->utilisateur, $this->mot_de_passe);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            return null;
        }
    }
}
