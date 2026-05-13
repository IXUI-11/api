<?php

require_once "../Config/bdd.php";
require_once "../Cmetiers/beneovle.php";
class BenevoleService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getToutLesBenevoles()
    {
        $req = $this->pdo->query("SELECT * FROM benevole");
        $benovle = $req->fetchAll(PDO::FETCH_ASSOC);
        try {
            $benevoles = [];
            foreach ($benovle as $row) {
                $benevoles[] = new Benevole(
                    $row['id'],
                    $row['nom'],
                    $row['prenom'],
                    $row['email'],
                    $row['mot_de_passe'],
                    $row['adresse'],
                    $row['code_postal'],
                    $row['date_naissance'],
                    $row['id_role']
                );
            }
            return $benevoles;
        }
        catch (Exception $MessageErreur) {
            // réponse d'erreur en cas de problème avec la base de données
            http_response_code(500);
        return ["Erruer de la base de données" => $MessageErreur->getMessage()];

    }
}
}


?>