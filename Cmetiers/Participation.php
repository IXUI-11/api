<?php

class Participation {

    public int $id;
    public int $id_benevole;
    public int $id_mission;
    public string $date_inscription;
    public string $date_annulation;
    public string $statut;
    public string $titre;
    public string $lieu;
    public string $date_mission;
    public string $annule_par;

    public function __construct(
        int $id,
        int $id_benevole,
        int $id_mission,
        string $date_inscription,
        // class Mission
        string $date_annulation = "",
        string $statut = "",
        string $titre = "",
        string $lieu = "",
        string $date_mission = "",
        string $annule_par = "",
    ) {
        $this->id = $id;
        $this->id_benevole = $id_benevole;
        $this->id_mission = $id_mission;
        $this->date_inscription = $date_inscription;
        $this->date_annulation = $date_annulation;
        $this->statut = $statut;
        $this->titre = $titre;
        $this->lieu = $lieu;
        $this->date_mission = $date_mission;
        $this->annule_par = $annule_par;
    }
}

?>