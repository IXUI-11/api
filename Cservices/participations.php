<?php
require_once "../Config/bdd.php";
require_once "../Cmetiers/participation.php";

class ParticipationService {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Inscription d'un bénévole à une mission (date d'inscription = maintenant)
    public function inscrireBenevole(int $id_benevole, int $id_mission) {
        $req = $this->pdo->prepare("INSERT INTO participation (id_benevole, id_mission, date_inscription) VALUES (:id_benevole, :id_mission, NOW())");
        $req->execute([
            ':id_benevole' => $id_benevole,
            ':id_mission' => $id_mission
        ]);
        return ["success" => true, "message" => "Participation réussie"];
    }

    // Récupération des participations actives d'un bénévole avec les détails de chaque mission
    // Modifié le 31/05/26 : filtre uniquement les participations avec statut 'active'
    public function getParticipationParBenevole(int $id_benevole) {
        // Jointure avec la table mission pour récupérer le titre, lieu et date
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

    // Annulation d'une participation par le bénévole lui-même
    // Met à jour le statut, la date d'annulation et indique qui a annulé
    public function annulerParticipation(int $id) {
        $req = $this->pdo->prepare("UPDATE participation SET statut = 'annulée', date_annulation = NOW(), annule_par = 'benevole' WHERE id = :id");
        $req->execute([':id' => $id]);
        return ["success" => true, "message" => "Participation annulée"];
    }

    // Récupération de l'historique des participations annulées d'un bénévole
    public function getHistorique(int $id_benevole) {
        try {
            // Filtre uniquement les participations avec statut 'annulée', triées par date d'inscription
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

    // Annulation d'une participation par un administrateur
    // Même logique que annulerParticipation() mais annule_par = 'admin'
    public function annulerParticipationAdmin(int $id) {
        $req = $this->pdo->prepare("UPDATE participation SET statut = 'annulée', date_annulation = NOW(), annule_par = 'admin' WHERE id = :id");
        $req->execute([':id' => $id]);
        return ["success" => true, "message" => "Participation annulée par l'admin"];
    }

    // Récupération des missions à venir d'un bénévole
    // Filtre : statut actif + date de mission >= aujourd'hui
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

        // Conversion de chaque ligne en objet Participation
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

    // Récupération des missions déjà effectuées par un bénévole
    // Filtre : statut actif + date de mission < aujourd'hui (mission passée)
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

        // Conversion de chaque ligne en objet Participation
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