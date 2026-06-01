<?php

require_once "../Config/bdd.php";
require_once "../Cmetiers/mission.php";

class MissionService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    // récupérer toutes les missions
    public function getToutLesMissions()
    {
        try {
            $req = $this->pdo->query("SELECT * FROM mission");
            $missions = $req->fetchAll(PDO::FETCH_ASSOC);

            $missionsList = [];

            foreach ($missions as $tableau) {
                $missionsList[] = new Mission(
                    $tableau['id'],
                    $tableau['titre'],
                    $tableau['lieu'],
                    $tableau['description'],
                    $tableau['date_mission'],
                    $tableau['actif']
                );
            }

            return $missionsList;
        } catch (Exception $e) {
            http_response_code(500);

            return ["Erreur de la base de données" => $e->getMessage()];
        }
    }

    // récupérer les 5 dernières missions
    public function getMissionRecent()
    {
        try {
            $req = $this->pdo->query("SELECT * FROM mission ORDER BY date_mission DESC LIMIT 5");
            $missions = $req->fetchAll(PDO::FETCH_ASSOC);

            $missionsList = [];

            foreach ($missions as $tableau) {
                $missionsList[] = new Mission(
                    $tableau['id'],
                    $tableau['titre'],
                    $tableau['lieu'],
                    $tableau['description'],
                    $tableau['date_mission'],
                    $tableau['actif']
                );
            }

            return $missionsList;
        } catch (Exception $e) {
            http_response_code(500);

            return ["Erreur de la base de données" => $e->getMessage()];
        }
    }

    // ajouter une mission
    public function ajouterMission(string $titre, string $lieu, string $description, string $date_mission): array
    {
        try {
            $req = $this->pdo->prepare("INSERT INTO mission (titre , lieu , description , date_mission , actif)  VALUES (:titre , :lieu , :description , :date_mission , 1)");
            $req->execute([
                ':titre' => $titre,
                ':lieu' => $lieu,
                ':description' => $description,
                ':date_mission' => $date_mission,
            ]);

            return ["success" => true, "message" => "Mission ajoutée avec succès"];
        } catch (Exception $e) {
            http_response_code(500);
            return ["Les mission ne peuvent pas etre ajoutées" => $e->getMessage()];
        }
    }

    // supprimer une mission
    public function supprimerMission(int $id)
    {

        try {
            // Supprimer d'abord les participations liées à la mission
            $req = $this->pdo->prepare("DELETE FROM participation WHERE id_mission = :id");
            $req->execute([':id' => $id]);
            // supprimer Mission
            $req = $this->pdo->prepare("DELETE FROM mission WHERE id = :id");
            $req->execute([':id' => $id]);
            return ["success" => true, "message" => "Mission supprimée avec succès"];
        } catch (Exception $e) {
            http_response_code(500);
            return ["Les missions n'ont pas été supprimées" => $e->getMessage()];
        }
    }

    // modifier une mission
    public function modifierMission(int $id, string $titre, string $lieu, string $description, string $date_mission)
    {
        try {
            $req = $this->pdo->prepare("UPDATE mission SET titre = :titre, lieu = :lieu, description = :description, date_mission = :date_mission WHERE id = :id");
            $req->execute([
                ':id' => $id,
                ':titre' => $titre,
                ':lieu' => $lieu,
                ':description' => $description,
                ':date_mission' => $date_mission
            ]);
            return ["success" => true, "message" => "Mission modifiée avec succès"];
        } catch (Exception $e) {
            http_response_code(500);
            return ["Les missions n'ont pas été modifiées" => $e->getMessage()];
        }
    }


    // récupérer les missions passées d'un utlisateur 
    public function getMissionsPasseesParBenevole(int $id_benevole)
    {
        try {
            $req = $this->pdo->prepare("
        SELECT DISTINCT m.* FROM mission m
JOIN participation p ON m.id = p.id_mission
WHERE p.id_benevole = :id_benevole
AND m.date_mission < CURDATE()
ORDER BY m.date_mission DESC
    ");
            $req->execute([':id_benevole' => $id_benevole]);
            $rows = $req->fetchAll(PDO::FETCH_ASSOC);
            $missionsList = [];
            foreach ($rows as $tableau) {
                $missionsList[] = new Mission(
                    $tableau['id'],
                    $tableau['titre'],
                    $tableau['lieu'],
                    $tableau['description'],
                    $tableau['date_mission'],
                    $tableau['actif']
                );
            }
            return $missionsList;
        } catch (Exception $e) {
            http_response_code(500);
            return ["Les missions n'ont pas été récupérées" => $e->getMessage()];
        }
    }

    // changer le statut d'une mission (actif ou inactif)
    public function changerStatutMission(int $id, int $actif)
    {
        $req = $this->pdo->prepare("UPDATE mission SET actif = :actif WHERE id = :id");
        $req->execute([
            ':id' => $id,
            ':actif' => $actif
        ]);
        return ["success" => true, "message" => "Statut de la mission mis à jour"];
    }
}
