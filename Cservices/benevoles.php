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

    // Récupération de tous les bénévoles en base de données
    public function getToutLesBenevoles()
    {
        $req = $this->pdo->query("SELECT * FROM benevole");
        $benovle = $req->fetchAll(PDO::FETCH_ASSOC);

        try {
            $benevoles = [];

            // Conversion de chaque ligne en objet Benevole
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
            http_response_code(500);
            return ["Erreur de la base de données" => $MessageErreur->getMessage()];
        }
    }

    // Récupération d'un seul bénévole par son ID
    public function getBenevoleParlId(int $id)
    {
        // Requête préparée pour éviter les injections SQL
        $req = $this->pdo->prepare("SELECT * FROM benevole WHERE id = :id");
        $req->execute(['id' => $id]);
        $row = $req->fetch(PDO::FETCH_ASSOC);

        // Retourne null si aucun bénévole trouvé
        if (!$row) return null;

        // Retourne un objet Benevole construit depuis les données de la base
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

    // Ajout d'un nouveau bénévole et création de son compte utilisateur
    public function ajouterBenevole(string $nom, string $prenom, string $email, string $mot_de_passe, string $adresse, string $code_postal, string $date_naissance)
    {
        try {
            // Insertion du bénévole dans la table benevole (id_role = 2 = bénévole)
            $req = $this->pdo->prepare("INSERT INTO benevole(nom, prenom, email, mot_de_passe, adresse, code_postal, date_naissance, id_role) VALUES (:nom, :prenom, :email, :mot_de_passe, :adresse, :code_postal, :date_naissance, 2)");
            $req->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe,
                ':adresse' => $adresse,
                ':code_postal' => $code_postal,
                ':date_naissance' => $date_naissance,
            ]);

            // Récupération de l'ID du bénévole qui vient d'être inséré
            $id_benevole = $this->pdo->lastInsertId();

            // Création du compte utilisateur lié au bénévole (même email/mot de passe)
            $req2 = $this->pdo->prepare("INSERT INTO utilisateur (email, mot_de_passe, id_benevole, id_role) VALUES (:email, :mot_de_passe, :id_benevole, 2)");
            $req2->execute([
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe,
                ':id_benevole' => $id_benevole,
            ]);

            return ["message" => "Bénévole ajouté avec succès"];
        }
        catch (Exception $MessageErreur) {
            http_response_code(500);
            return ["Les benevoles ne peuvent pas etre ajoutés" => $MessageErreur->getMessage()];
        }
    }

    // Suppression d'un bénévole et de toutes ses données liées
    public function supprimerBenevole(int $id)
    {
        try {
            // Suppression des participations du bénévole en premier (contrainte de clé étrangère)
            $req = $this->pdo->prepare("DELETE FROM participation WHERE id_benevole = :id");
            $req->execute([':id' => $id]);

            // Suppression du compte utilisateur lié au bénévole
            $req2 = $this->pdo->prepare("DELETE FROM utilisateur WHERE id_benevole = :id");
            $req2->execute([':id' => $id]);

            // Suppression du bénévole lui-même
            $req3 = $this->pdo->prepare("DELETE FROM benevole WHERE id = :id");
            $req3->execute([':id' => $id]);

            return ["message" => "Bénévole supprimé avec succès"];
        }
        catch (Exception $e) {
            http_response_code(500);
            return ["Les benevoles ne peuvent pas etre supprimés" => $e->getMessage()];
        }
    }

    // Récupération des participations d'un bénévole avec les détails de chaque mission
    public function getParticipationsParBenevole(int $id)
    {
        // Jointure entre participation et mission pour récupérer les infos complètes
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

        // Conversion de chaque ligne en objet Participation
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