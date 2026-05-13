<?php

class Mission {
    public int $id;
    public string $titre;
    public string $lieu;
    public string $description;
    public string $date_mission;
    public int $actif;

    public function __construct(int $id, string $titre, string $lieu, string $description, string $date_mission, int $actif) {
        $this->id = $id;
        $this->titre = $titre;
        $this->lieu = $lieu;
        $this->description = $description;
        $this->date_mission = $date_mission;
        $this->actif = $actif;
    }
}

?>