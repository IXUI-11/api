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
}