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

    // Récupération de toutes les missions en base de données
    public function getToutLesMissions()
    {
        try {
            $req = $this->pdo->query("SELECT * FROM mission");
            $missions = $req->fetchAll(PDO::FETCH_ASSOC);

            $missionsList = [];

            // Conversion de chaque ligne en objet Mission
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

    // Récupération des 5 missions les plus récentes (triées par date décroissante)
    public function getMissionRecent()
    {
        try {
            $req = $this->pdo->query("SELECT * FROM mission ORDER BY date_mission DESC LIMIT 5");
            $missions = $req->fetchAll(PDO::FETCH_ASSOC);

            $missionsList = [];

            // Conversion de chaque ligne en objet Mission
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

    // Ajout d'une nouvelle mission (actif = 1 par défaut à la création)
    public function ajouterMission(string $titre, string $lieu, string $description, string $date_mission): array
    {
        try {
            // Requête préparée pour éviter les injections SQL
            $req = $this->pdo->prepare("INSERT INTO mission (titre, lieu, description, date_mission, actif) VALUES (:titre, :lieu, :description, :date_mission, 1)");
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

    // Suppression d'une mission et de toutes ses participations liées
    public function supprimerMission(int $id)
    {
        try {
            // Suppression des participations liées en premier (contrainte de clé étrangère)
            $req = $this->pdo->prepare("DELETE FROM participation WHERE id_mission = :id");
            $req->execute([':id' => $id]);

            // Suppression de la mission elle-même
            $req = $this->pdo->prepare("DELETE FROM mission WHERE id = :id");
            $req->execute([':id' => $id]);

            return ["success" => true, "message" => "Mission supprimée avec succès"];
        } catch (Exception $e) {
            http_response_code(500);
            return ["Les missions n'ont pas été supprimées" => $e->getMessage()];
        }
    }

    // Modification des informations d'une mission existante
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

    // Récupération des missions passées d'un bénévole (date antérieure à aujourd'hui)
    public function getMissionsPasseesParBenevole(int $id_benevole)
    {
        try {
            // Jointure entre mission et participation pour filtrer par bénévole
            // DISTINCT pour éviter les doublons si le bénévole a plusieurs participations à la même mission
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

            // Conversion de chaque ligne en objet Mission
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

    // Changement du statut actif/inactif d'une mission (1 = actif, 0 = inactif)
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