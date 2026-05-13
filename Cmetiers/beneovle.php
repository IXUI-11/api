<?php
require_once "../Config/bdd.php";

class Benevole {
    public string  $id;
    public string $nom;
    public string $prenom;
    public string $email;
    public string $mot_de_passe;
    public string $adresse;
    public string $code_postal;
    public string $date_naissance;
    public int $id_role;

    public function __construct( int $id, string $nom, string $prenom, string $email, string $mot_de_passe,string $adresse, string $code_postal,string $date_naissance,int $id_role) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->date_naissance = $date_naissance;
        $this->id_role = $id_role;
    }
}

?>