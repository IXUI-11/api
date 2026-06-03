<?php
require_once "../Config/bdd.php";
require_once "../Cmetiers/participation.php";

class ParticipationService {
    
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Inscrire un bénévole à une mission
    public function inscrireBenevole(int $id_benevole, int $id_mission) {
        $req = $this->pdo->prepare("INSERT INTO participation (id_benevole, id_mission, date_inscription) VALUES (:id_benevole, :id_mission, NOW())");
        $req->execute([
            ':id_benevole' => $id_benevole,
            ':id_mission' => $id_mission
        ]);
        return ["success" => true, "message" => "Participation réussie"];
    }

    // Récupère les participations d'un bénévole
    // j'ai modifer le 31/05/26 a avoir
    public function getParticipationParBenevole(int $id_benevole) {
        $req = $this->pdo->prepare("
            SELECT participation.*, mission.titre, mission.lieu, mission.date_mission 
            FROM participation 
            JOIN mission ON participation.id_mission = mission.id
            WHERE participation.id_benevole = :id_benevole 
            AND participation.statut = 'active'
            ORDER BY mission.date_mission ASC
        ");
        $req->execute([':id_benevole' => $id_benevole]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    // Annuler une participation
    public function annulerParticipation(int $id) {
        $req = $this->pdo->prepare("UPDATE participation SET statut = 'annulée', date_annulation = NOW(), annule_par = 'benevole' WHERE id = :id");
        $req->execute([':id' => $id]);
        return ["success" => true, "message" => "Participation annulée"];
    }

    // récupérer les participations passées
    public function getHistorique(int $id_benevole) {
        try {
            $req = $this->pdo->prepare("
                SELECT participation.*, mission.titre, mission.lieu, mission.date_mission 
                FROM participation 
                JOIN mission ON participation.id_mission = mission.id
                WHERE participation.id_benevole = :id_benevole 
                AND participation.statut = 'annulée'
                ORDER BY participation.date_inscription DESC
            ");
            $req->execute([':id_benevole' => $id_benevole]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            http_response_code(500);
            return ["Les participations n'ont pas été récupérées" => $e->getMessage()];
        }
    }

    // annuler par l'admin 
    public function annulerParticipationAdmin(int $id) {
        $req = $this->pdo->prepare("UPDATE participation SET statut = 'annulée', date_annulation = NOW(), annule_par = 'admin' WHERE id = :id");
        $req->execute([':id' => $id]);
        return ["success" => true, "message" => "Participation annulée par l'admin"];
    }

    // les missions à venir du bénévole
    public function getMissionsAVenir(int $id_benevole) {
        $req = $this->pdo->prepare("
            SELECT participation.*, mission.titre, mission.lieu, mission.date_mission 
            FROM participation 
            JOIN mission ON participation.id_mission = mission.id
            WHERE participation.id_benevole = :id_benevole 
            AND participation.statut = 'active'
            AND mission.date_mission >= CURDATE()            
            ORDER BY mission.date_mission ASC
        ");
        $req->execute([':id_benevole' => $id_benevole]);
        $rows = $req->fetchAll(PDO::FETCH_ASSOC);

        $liste = [];
        foreach ($rows as $row) {
            $liste[] = new Participation(
                $row['id'],
                $row['id_benevole'],
                $row['id_mission'],
                $row['date_inscription'],
                $row['date_annulation'] ?? "",
                $row['statut'] ?? "",
                $row['titre'] ?? "",
                $row['lieu'] ?? "",
                $row['date_mission'] ?? "",
                $row['annule_par'] ?? ""
            );
        }
        return $liste;
    }

    // mission effectuer d'un bénévole
    public function getMissionsEffectuees(int $id_benevole) {
        $req = $this->pdo->prepare("
            SELECT participation.*, mission.titre, mission.lieu, mission.date_mission 
            FROM participation 
            JOIN mission ON participation.id_mission = mission.id
            WHERE participation.id_benevole = :id_benevole 
            AND participation.statut = 'active'
            AND mission.date_mission < CURDATE()
            ORDER BY mission.date_mission DESC
        ");
        $req->execute([':id_benevole' => $id_benevole]);
        $rows = $req->fetchAll(PDO::FETCH_ASSOC);

        $liste = [];
        foreach ($rows as $row) {
            $liste[] = new Participation(
                $row['id'],
                $row['id_benevole'],
                $row['id_mission'],
                $row['date_inscription'],
                $row['date_annulation'] ?? "",
                $row['statut'] ?? "",
                $row['titre'] ?? "",
                $row['lieu'] ?? "",
                $row['date_mission'] ?? "",
                $row['annule_par'] ?? ""
            );
        }
        return $liste;
    }
}
?>