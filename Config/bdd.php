<?php

class Bdd{
    private  static $hote = "localhost";
    private  static $utilisateur = "benovaide";
    private  static $mot_de_passe = "Soso@123";
    private  static $base_de_donnees = "benovaide";

    public static function getConnection(){
        try {
            $pdo = new PDO("mysql:host="  . self::$hote  . ";dbname=" . self::$base_de_donnees, self::$utilisateur, self::$mot_de_passe);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $erreur) {
            
            throw new Exception("Erreur de connexion à la base de données : " . $erreur->getMessage());
            
        }
        

    }
}
