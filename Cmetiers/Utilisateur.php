<?php
class Utilisateur{
    public int $id;
    public string $email;
    public string $mot_de_passe;
    public int $id_role;
    public string $id_benevole;

    public function __construct(int $id , string $email , string $mot_de_passe, int $id_role , int  $id_benevole  ) {
        $this->id = $id;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->id_role = $id_role;
        $this->id_benevole = $id_benevole;
}


}



?>