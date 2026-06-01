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

public function getBenevoleParlId(int $id){
    $req = $this->pdo->prepare("SELECT * FROM benevole WHERE id = :id" );
    $req->execute(['id' => $id]);
    $row = $req->fetch(PDO::FETCH_ASSOC);
    if (!$row) return null;
    return new Benevole(
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



public function ajouterBenevole(string $nom , string $prenom , string $email , string $mot_de_passe , string $adresse , string $code_postal , string $date_naissance) {      
    try{
        $req = $this->pdo->prepare("INSERT INTO benevole(nom , prenom , email, mot_de_passe , adresse , code_postal , date_naissance ,id_role) VALUES (:nom , :prenom , :email, :mot_de_passe , :adresse , :code_postal , :date_naissance ,1)");
        $req->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe,
            ':adresse' => $adresse,
            ':code_postal' => $code_postal,
            ':date_naissance' => $date_naissance,
        ]);

        // récupéer l'id du bénevole creé $
        $id_benevole = $this->pdo->lastInsertId();

        // insérer dans utlisateur

        $req2 = $this->pdo->prepare("INSERT INTO utilisateur (email , mot_de_passe, id_benevole,id_role)  VALUES (:email , :mot_de_passe, :id_benevole,1)");
        $req2->execute([
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe,
            ':id_benevole' => $id_benevole,
        ]);

        return ["message" => "Bénévole ajouté avec succès"];
    }

    catch(Exception $MessageErreur){
            http_response_code(500);

    return ["Les benevoles ne peuvent pas etre ajoutés" => $MessageErreur->getMessage()];
    }
}


public function supprimerBenevole(int $id) {

    try{
    // supprimer d'abord les particaption liés
    $req = $this->pdo->prepare("DELETE FROM participation WHERE id_benevole = :id");
    $req->execute([':id' => $id]);

    // supprimer le compte utilisateur lié
    $req2 = $this->pdo->prepare("DELETE FROM utilisateur WHERE id_benevole = :id");
    $req2->execute([':id' => $id]);

    // supprimer le bénévole
    $req3 = $this->pdo->prepare("DELETE FROM benevole WHERE id = :id");
    $req3->execute([':id' => $id]);

    return ["message" => "Bénévole supprimé avec succès"];

    }
    catch(Exception $e){
        http_response_code(500);
        return ["Les benevoles ne peuvent pas etre supprimés" => $e->getMessage()];
    }  
}

public function getParticipationsParBenevole(int $id) {
    $req = $this->pdo->prepare("
        SELECT participation.*, mission.titre, mission.lieu, mission.date_mission
        FROM participation
        JOIN mission ON participation.id_mission = mission.id
        WHERE participation.id_benevole = :id
        ORDER BY mission.date_mission ASC
    ");
    $req->execute([':id' => $id]);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    $liste = [];
    foreach ($data as $row) {
        $liste[] = new Participation(
            $row['id'],
            $row['id_benevole'],
            $row['id_mission'],
            $row['date_inscription'],
            $row['date_annulation'] ?? "",
            $row['statut'],
            $row['titre'],
            $row['lieu'],
            $row['date_mission']
        );
    }
    return $liste;
}

}


?>